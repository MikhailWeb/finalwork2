<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    "driver"   => "mysql",
    "host"     => "localhost",
    "database" => "testdb",
    "username" => "mysql",
    "password" => "mysql"
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

define('UPLOAD_DIR', '/www/upload/user/');
