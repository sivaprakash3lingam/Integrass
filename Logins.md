#Base Path Setup
Base path file Location : app\Config\App.php (change public $baseURL = 'Your base path';)

#Change Environment (development / production)
file Location : .env (change CI_ENVIRONMENT = development)

#Sample Database sql file
file Location : Integrass.sql

#Database Login Credientiels
Database Confie file Location : app\Config\Database.php
Database Name: integrass
Database Username : your Database username (Default Usename : root)
Database Password :  your db password (Default Password : )


#Demo Admin Login Credientials
Url : http://localhost:8080/admin
Username : siva
Password : 123


#Demo User Login Credientials
Url : http://localhost:8080/user
Username : siva
Password : 123


#Important Note:
Mail Process not implemented due to local host. We may use default mail tag or third party mailer like phpmailer library while in hosting server or after configured smtp in our server.
