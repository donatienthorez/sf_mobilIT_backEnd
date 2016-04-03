# ESN MobilIT Back-End

## What is this back-end for ? 

This tool is used to manage the guide and the notifications of the android application ESN MobilIT available [here](https://play.google.com/store/apps/details?id=org.esn.mobilit&hl=en). You can find the code of the application on  [Github](https://github.com/donatienthorez/ESN_Mobil-IT).

Once you are logged with your galaxy account, you will be able to modify the guide of your section and send notification to your section. As an admin you can modify all the guides and send notifications to all the sections.

The project is available in production [here](http://mobilit.esnlille.fr).

## What technologies and libraries does it use ?

This website is done with Symfony3 for the back-end and API, AngularJS for the front-end part. Some javascript libraries are used like [angular-ui-tree] (https://github.com/angular-ui-tree/angular-ui-tree) for the guide edition and [angular-chose]  (https://github.com/localytics/angular-chosen) for the notification section selector.

# Contribution

## Who should I contact ?

If you want to contribute to the project, please send me a mail or add me to skype at : donatienthorez@gmail.com .  I will add you to the trello board to see what you can do. You can also do a pull request and we will see together if it fits with the application needs (but it is better to contact me first to not develop something already done or in progress).

You will also need a galaxy account to connect to the application.

## How do I install the project ?

Install the project.

1 - Clone the project

2 - Create a local database

3 - Fill the informations to access this database on your parameters.yml file

4 - Install with composer
```
composer install
```

5 - Run doctrine schema update to generate the database
```
bin/console doctrine:schema:update
```

6 - Import countries and sections by running the command 
```
bin/console main:import-countries
bin/console main:import-sections
```
7 - Run assets install and assetic dump
```
bin/console assets:install
bin/console assetic:dump
```

To access to the admin rights inside the application :
```
bin/console fos:user:promote username ROLE_ADMIN
```
If you are already logged, you will need to logout and login again 

## What do I do now ?

Once it is done, you can create a branch that follows master, develop on it, push when it is done and do a pull request.

## Do you have coding standards on this project ?

On the project, we respect the [PSR standards] (http://www.php-fig.org/psr/)

# About the project
This project was at the beginning a school project. After seeing that it could be nice to go further, I started it to rewrite the project on Symfony3 in order to be more stable.

If you see any bugs you want to report or any suggestion to improve the app, please write an email to donatienthorez@gmail.com and speak your mind, I'll answer as fast as I can. 

