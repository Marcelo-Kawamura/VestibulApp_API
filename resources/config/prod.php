<?php
//$app['log.level'] = Monolog\Logger::ERROR;

$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;

$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";

/**
 * SQLite database file
 */

/**
 * MySQL
 */
$app['db.options'] = array(
  "driver" => "pdo_mysql",
  "user" => "root",
  "password" => "131187",
  "dbname" => "id4147366_vestapp",
  "host" => "localhost",
    "charset"  => "utf8",
);
