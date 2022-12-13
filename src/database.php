<?php

$dbhost = "HOSTNAME";
$dbuser = "USERNAME";
$dbpass = "PASSWORD";
$dbname = "DBNAME";

function get_connection() {
    global $dbhost, $dbuser, $dbpass, $dbname;
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (connection === false) {
        die("Could not connect: " . mysqli_connect_error(connection));
    }
    return $connection;
}

function execute_query($connection, $query) {
    return mysqli_query($connection, $query);
}

function count_rows($connection) {
    return mysqli_affected_rows($connection);
}

function get_error($connection) {
    return mysqli_error($connection);
}

?>
