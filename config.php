<?php
/*
this file contain database configuration assuming running the my sql using user "root
and password " "

*/
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');
//try connecting to database server
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
//try to check the connection
if($conn==false)
{
    dir('ERROR: CANNOT CONNECT');

    
}







?>