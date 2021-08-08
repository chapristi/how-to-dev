<?php

use App\app\connect;

session_start();
session_destroy();
connect::redirection($router,"main");
