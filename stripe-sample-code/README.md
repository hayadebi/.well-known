# Integrate with Connect embedded components

Build a full, working integration using Connect embedded components. Here are some basic
scripts you can use to build and run the application.

## Replace the following variables

Ensure that you have replaced the following placeholders in the downloaded code sample:
- {{CONNECTED_ACCOUNT_ID}}

## Run the sample

1. Build the server

~~~
composer install
~~~

2. Run the server

~~~
php -S 127.0.0.1:4242 --docroot=dist
~~~

3. Build the client app

~~~
npm install
~~~

4. Run the client app

~~~
npm start
~~~

5. Go to [http://localhost:4242/index.html](http://localhost:4242/index.html)