<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ESN\GalaxyLoginBundle\Entity\GalaxyUser;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends GalaxyUser implements UserInterface
{
    /**
     * @ORM\OneToMany(targetEntity="Notification", cascade="all", mappedBy="sentBy")
     */
    protected $notifications;

    public function __construct()
    {
        parent::__construct();
        $this->notifications = new ArrayCollection();
    }
}
