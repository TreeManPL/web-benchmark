# WebSite Benchmark Tool

Application for comparing page performance using CUrl

## Requirements
 - PHP 7.1+ with CURL ext. 
 - composer.phar
 
## Installation
Navigate to project directory and run command 

    composer.phar install

## Basic use
To benchmark a sites run command

    ./bin/console app:web-benchmark <phonenumber> <email> <reference-site> <compare-sites>
     
Example:
    
    ./bin/console app:web-benchmark +48123123123 test@test.com http://www.google.com https://facebook.com https://www.yahoo.com 
    
Application will benchmark sites and print result on screen. The result is also store in out.txt file in main app directory.

Application send two notification:
 - if reference site is slower then any of compare site then the email is send
 - if reference site is twice slower then any of compare site then the sms is send
 
## Advance use

By default application generate report that includes url name, load time and loading time in comparison. 

To change data scope use reportOptions (-r)

Example:
    
    ./bin/console app:web-benchmark +48123123123 test@test.com http://www.google.com https://facebook.com -r name,loadtime

 
 To change notification option, simply use notificationsOptions (-t)
 
 Example:
 
     ./bin/console app:web-benchmark +48123123123 test@test.com http://www.google.com https://facebook.com -t slowloadtime
    

