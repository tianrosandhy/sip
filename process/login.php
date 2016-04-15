<?php
include "../view/conf.php";

$username = $_POST['username'];
$pass = $_POST['password'];

if(cek_setting("username",$username) and cek_setting("password",$pass)){
	//login sukses
	$_SESSION['login'] = sha1(md5(microtime(true)));
	update_setting("token",$_SESSION['login']);
	pesan("success","Log In Success","../index.php");
}
else{
	//login gagal
	pesan("danger","Username atau Password yang Anda masukkan salah","../index.php");
}
?>