<?php
$koneksi = mysqli_connect("localhost", "root", "", "default_spk_saw");

// Check connection
if (mysqli_connect_errno()) {
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
