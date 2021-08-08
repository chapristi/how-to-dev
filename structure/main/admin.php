<?php
use App\app\connect;
session_start();

$user = connect::getAuth()->requireRole('Admin');
if($user === false){
    connect::redirection($router,"main");
}

?>

