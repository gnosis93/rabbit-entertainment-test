# PokerHand Rabbit Entertainment Test

### Installation Instructions
This solution contains a Symphony4 project (using PHP7.2, I love its new typing system :-) ).

In order to run this project, please follow the following steps:

- Make sure you have a proper LAMP stack running on your system manily PHP7 , MySQL. For the server you can use the framework [builtin server by using "serve" command](https://symfony.com/doc/current/setup/symfony_server.html)
- Install Symphony cli on your system
- Create a database for the project
- Set up the proper db connection string in .env file, ex: DATABASE_URL=mysql://root:root@127.0.0.1:3306/poker_hands
- Generate and run the migration (commands below), in the repo you will also find a db.sql file which can be imported directly 
    * php bin/console make:migration
    * php bin/console run:migration

### Comments

I really enjoyed solving this test , it was quite challenging . This is also my first try using Symphony overall I found it familiar to technologies I used before in the past mainly it resembles NestJS in regards to DTOs , Repositories , and Services (dep Injection) , while also being very similar to Laravel in terms of the general structure and code guidelines (PSR, MVC).

The Poker Solution was inspired by : [Mathcs Java Poker](http://www.mathcs.emory.edu/~cheung/Courses/170/Syllabus/10/pokerCheck.html?fbclid=IwAR1RyZJGHrjh9cCzgB0H-WcLjLkAmBoiVCamer6ox0SYmak-vI4Pgnrk8Wc)

### Screenshots 

##### File Listing
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/file_listing.png "File Listing")

##### Uploading File
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/upload_file.png "Upload File")

##### Hand Listing
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/hand_listing.png "Hand Listing")

##### Hand Results @ Bottom of Page
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/hand_results.png "Hand Results")

##### Auth Login
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/login_user.png "Login User")

##### Auth Logout
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/logout.png "Logout User")

##### Auth Register
![alt text](https://raw.githubusercontent.com/aaronscifo/rabbit-entertainment-test/master/Screenshots/register_user.png "Register User")

