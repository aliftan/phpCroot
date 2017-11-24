<?php
/* Database kredensial Dengan asumsi Anda menjalankan MySQL
server dengan setting default (user 'root' tanpa password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'test'); // nama database anda
 
/* Mencoba terhubung ke database MySQL */
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	// Periksa koneksi
	if($mysqli === false){
	    die("KESALAHAN: Tidak dapat terhubung. " . $mysqli->connect_error);
	}
?> 