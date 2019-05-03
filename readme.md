## Noticeboard

Is a Laravel,Vue,JWT,Pusher Application

## Note

The is a version specific application and the packages used must be exactly the same for it to function best and without hassle. It has been created in this way to allow quick setup.
I presume you have composer already setup and mysql on your local machine, and that you are on a linux machine and that you have a terminal open where you would like to create the project from.
You should also have an account with https://pusher.com/ (its free for dev purposes), so just create an app call it noticeboard choose jquery on the front end and laravel on the back end and
set cluster to eu, you should also have all the needed packages required here installed https://laravel.com/docs/5.8#installing-laravel see server requirements

## Instructions

* git clone https://github.com/gustav1105/noticeboard.git
* cd noticeboard
* cp .env.example .env
* mysql -u myuser -p
* CREATE DATABASE noticeboard;
* exit;
* sudo nano .env
* replace mysqluser with your user
* replace mysqlpassword with your password
* replace pusherid with the pusher app id from pusher dashboard (server side .env)
* replace pusherkey with pusher app key
* replace pushersecret with pusher app secret
* replace pushercluster with eu
* ctrl x and save
* composer install
* npm install
* php artisan jwt:secret
* php artisan key:generate
* php artisan migrate
* php artisan tinker
* $user = new App\User
* $user->name = "Username"
* $user->password = bcrypt("password")
* $user->email = "email@address.ext"
* $user->save()
* exit
* php artisan make:event SubmitNotice
* cd app/Events
* sudo nano SubmitNotice.php
* Class SubmitNotice implements ShouldBroadcast
* create class variable public $message;
* add parameter to constructor $message
* instantiate $this->message = $message in constructor
* change channnel-name to my-channel in broadcastOn method
* change PrivateChannel to Channel in broadcastOn method
* create method public function broadcastAs() { return 'submit-notice'; }
* ctrl-x and save
* cd ../../
* php artisan config:clear
* php artisan serve
* npm run watch
* goto http://localhost:8000 in your browser

## and enjoy!
