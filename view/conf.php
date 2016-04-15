<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=db_sip;charset=utf8','tianEXE','1sampai9');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

define("BASE_URL","http://localhost/sip/");

date_default_timezone_set("Asia/Makassar");

/*FUNCTIONS START HERE*/
function base_url($url=null){
	if(empty($url))
		return BASE_URL;
	else
		return BASE_URL."$url";
}

function quote($txt){
	global $db;
	return $db->quote($txt);
}


function cek_login(){
	if(isset($_SESSION['login'])){
		return cek_setting("token",$_SESSION['login']);
	}
	return false;
}

/*setting function*/
function cek_setting($param,$value){
	global $db;
	$cek = $db->query("SELECT * FROM sip_setting WHERE param = ".quote($param)." AND value = ".quote($value));
	if($cek->rowCount()==1)
		return true;
	else
		return false;
}
function update_setting($param,$value){
	global $db;
	$upd = $db->query("UPDATE sip_setting SET value = ".quote($value)." WHERE param = ".quote($param));
}
function get_setting($param){
	global $db;
	$cek = $db->query("SELECT * FROM sip_setting WHERE param = ".quote($param));
	foreach($cek as $r)
		return $r['value'];
}



function pesan($tipe,$isi,$header=null){
	$_SESSION[$tipe] = $isi;
	if(!empty($header)){
		header("location:$header");
		exit;
	}
}

function msghandling($arr=array("danger","success","warning")){
	foreach($arr as $r){
		if(isset($_SESSION[$r])){
			echo "
			<div class='alert alert-dismissable alert-$r'>
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
				<strong>$_SESSION[$r]</strong>
			</div>";
			unset($_SESSION[$r]);
		}
	}
}

function date_indo($jam){
	$d = date("d",strtotime($jam));
	$m = date("n",strtotime($jam));
	$y = date("Y",strtotime($jam));

	$ar = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
	return "$d $ar[$m] $y";
}