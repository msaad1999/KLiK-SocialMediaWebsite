<?php

$serverName = $_ENV["MYSQL_HOSTNAME"]; //mydb.local
$dBUsername = $_ENV["DATABASE_USER"]; //root
$dBPassword = $_ENV["DATABASE_PASSWORD"]; //"eldererajinMenji99";
$dBName = "klik_database"; //klik_database

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3307);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}


