<?php
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB_NAME", "picsel");
define("ASSETS", "./assets/");
define("MAX_PACKET", 1 * 1024 * 1024);

require_once("db/database.php");
$dbh = new DatabaseHelper(HOST, USER, PASSWORD, DB_NAME);
?>