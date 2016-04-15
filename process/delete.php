<?php
include "../view/conf.php";
$tp = $_GET['tp'];
$id = intval($_GET['id']);

switch($tp){
	case "member":
		$cek = $db->query("SELECT * FROM sip_member WHERE id = ".quote($id)." AND status = 1");
		if($cek->rowCount()==1){
			//hapus
			$del = $db->query("UPDATE  sip_member SET status = 9 WHERE id = ".quote($id)." AND status = 1");
			pesan("success","Berhasil menghapus data member","../index.php");
		}
		else{
			pesan("error","Data member tidak ditemukan.","../index.php");
		}

	break;
}