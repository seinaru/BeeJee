<?php

ini_set('display_errors', 1);
$page = explode('/',$_SERVER['REQUEST_URI']);

if ($page[1]!='dayside') require_once 'application/bootstrap.php';