<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', "");
define('DB_NAME', 'dbrestaurant');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)

        OR die("db connect error: " . mysqli_connect_error());
