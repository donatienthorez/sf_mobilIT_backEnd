<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseController extends WebTestCase
{
    protected $client;

    private $token = "g6g2A52mGPPbKaaHmFjz";

    public function getToken()
    {
        return $this->token;
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::loadDatabase();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function setUp()
    {
        $this->client = static::createClient();
        $testDbFile = static::$kernel->getCacheDir() . '/test.db';
        copy($testDbFile.'.bkp', $testDbFile);
    }

    public static function loadDatabase()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $testDbFile = static::$kernel->getCacheDir() . '/test.db';
        $testDbBackupFile = $testDbFile.'.bkp';

        // if the database file doesn't exist we create it
        if(!file_exists($testDbFile)) {
            static::createDatabase();
        }

        // create a backup file for the database and set permissions for database and backup file
        chmod($testDbFile, 0777);
        copy($testDbFile, $testDbFile.'.bkp');
        chmod($testDbBackupFile, 0777);
    }

    private static function createDatabase()
    {
        $application = new Application(static::$kernel);

        // drop the database
        $command = new DropDatabaseDoctrineCommand();
        $application->add($command);
        $input = new ArrayInput(
            array(
                'command' => 'doctrine:database:drop',
                '--force' => true
            )
        );
        $command->run($input, new NullOutput());

        // we have to close the connection after dropping the database
        //  so we don't get "No database selected" error
        $connection = $application
            ->getKernel()
            ->getContainer()
            ->get('doctrine')
            ->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }

        // create the database
        $command = new CreateDatabaseDoctrineCommand();
        $application->add($command);
        $input = new ArrayInput(
            array(
                'command' => 'doctrine:database:create',
            )
        );
        $command->run($input, new NullOutput());

        // create the database
        $command = new CreateSchemaDoctrineCommand();
        $application->add($command);
        $input = new ArrayInput(
            array(
                'command' => 'doctrine:schema:create',
                '--em' => 'default',
            )
        );
        $command->run($input, new NullOutput());

        // get the Entity Manager
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // load fixtures
        $client = static::createClient();
        $loader = new ContainerAwareLoader($client->getContainer());
        $loader->loadFromDirectory(
            static::$kernel
                ->locateResource('@MainBundle/DataFixtures/ORM')
        );
        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
