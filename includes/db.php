<?php

// $db['db_host'] = "localhost";
// $db['db_user'] = "root";
// $db['db_password'] = "";
// $db['db_name'] = "cms";

// foreach ($db as $key => $value) {
//     define(strtoupper($key),$value);
// }
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "cms");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($connection) {
    
}



?>