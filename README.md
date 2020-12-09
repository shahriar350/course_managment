**this is a course base management system for university**  
Feature:

-   Credit base course
-   Role base authentication (Student, Teacher, Admin)
-   Student Course enroll system
-   Teacher can evaluate marks of any student by three terms

  
Programming language

-   PHP(Laravel8)
-   Javascript(VueJs2)

How to install:

First you should install Laravel environment in you system. Follow laravel installation system on [laravel](https://laravel.com/docs/8.x/installation) website.  
You have to install [node](https://nodejs.org/en/download/) js in your system for [VueJS](https://vuejs.org/)
Next:

    composer install
 All laravel component will install in your project.
  This is time to make your database setting.
  Goto ***.env.example*** and change it to ***.env*** (remove only *.example*) 

     DB_CONNECTION=mysql  (i use mysql as database)
     DB_HOST=127.0.0.1   
     DB_PORT=3306   
     DB_DATABASE=coursemanagment   (You database name)
     DB_USERNAME=root   (database connection username)
     DB_PASSWORD=	(database connection password)
  

  now push all table to database by writing single command
  

    php artisan migrate

*Create a admin first:*
  To create an admin write a single command
  

    php artisan create:admin
   Follow all instruction and create an admin
   There are three login for three role
   

 - /login (for student)
 - /teacher/login (for teacher)
 - /admin/login (for admin)
Now you are free to run site in your system.

  


