<?php
include "../view/conf.php";

if(!isset($_POST['btn'])){
	header("location:../index.php");
	exit;
}

switch($_GET['id']){
	case "member":
		$nama = $_POST['nama'];
		$tipe = $_POST['tipe'];
		$kitas = $_POST['kitas'];
		$telp = $_POST['telp'];

		if(empty($nama) or empty($tipe) or empty($kitas) or empty($telp)){
			pesan("danger","Mohon mengisi kolom yang sudah disediakan dengan lengkap.","../index.php");
		}
		//cek dulu di database ada atau tidak
		$cek = $db->query("SELECT * FROM sip_member WHERE kitas = ".quote($kitas)." OR nama = ".quote($nama)." AND status <> 0");
		if($cek->rowCount()<>0){
			pesan("error","Member tersebut sudah ada di database","../index.php");
		}

		//input
		$ins = $db->query("INSERT INTO sip_member VALUES
			(NULL,".quote($nama).", ".quote($kitas).", ".quote($tipe).", ".quote($telp).", 1)");
		pesan("success","Berhasil menginput data member baru.","../index.php");

	break;
	case "peminjaman" :
		$idmember = $_POST['idmember'];
		$spd = $_POST['spd'];
		$tanggal = date("Y-m-d");
		$jam = date("H:i").":00";

		if(empty($idmember) or empty($spd)){
			pesan("danger","Mohon mengisi kolom yang sudah disediakan dengan lengkap.","../peminjaman.php");
		}

		//cek member
		$cek = $db->query("SELECT * FROM sip_member WHERE id = ".quote($idmember)." AND status = 0");
		if($cek->rowCount()<>0){
			pesan("danger","Tidak dapat melanjutkan proses peminjaman. Member tersebut tercatat sedang meminjam sepeda.","../peminjaman.php");
		}

		$ins = $db->query("INSERT INTO sip_peminjaman VALUES (NULL, ".quote($idmember).", '$tanggal', '$jam', ".quote($spd).")");

		//ubah status member
		$ubh = $db->query("UPDATE sip_member SET status = 0 WHERE id = ".quote($idmember));

		//get id
		$getid = $db->query("SELECT kd_transaksi FROM sip_peminjaman WHERE id = ".quote($idmember)." AND tanggal = ".quote($tanggal)." AND jam_pinjam = ".quote($jam)." AND jumlah = ".quote($spd));
		foreach($getid as $gi)
			$idTransaksi = $gi['kd_transaksi'];

		
		pesan("success","Berhasil menyimpan transaksi peminjaman","../peminjaman.php?invoice=$idTransaksi");

	break;

	case "pengembalian" :
		$kd_trans = intval($_POST['kd_trans']);
		$bayar = $_POST['bayar'];

		$tgl_kembali = $_POST['tgl_kbl'];
		$jk_a = $_POST['jk_h'];
		$jk_b = $_POST['jk_m'];

		if(empty($kd_trans) or empty($bayar) or empty($tgl_kembali) or empty($jk_a) or empty($jk_b)){
			pesan("danger","Mohon mengisi kolom yang sudah disediakan dengan lengkap.","../pengembalian.php");
		}

		//hitung ulang untuk validasi
		$now_a = strtotime(date("Y-m-d H:i"));
		$now_b = strtotime($tgl_kembali." $jk_a:$jk_b");


//		$now_a = date("H") * 3600 + date("i") * 60;
//		$jk = $jk_a * 3600 + $jk_b * 60;
		$selisih = ($now_a - $now_b);

		$valid = get_setting("valid_time") * 60;
		if(abs($selisih) > $valid){
			pesan("danger","Transaksi tidak valid karena sudah lebih dari 10 menit. Mohon ulangi transaksi kembali.","../pengembalian.php");
		}

		$cek = $db->query("SELECT sip_peminjaman.*, sip_member.status FROM sip_peminjaman, sip_member WHERE sip_member.id = sip_peminjaman.id AND kd_transaksi = ".quote($kd_trans));
		$price = get_setting("harga");
		foreach($cek as $row){
			$tg_sewa = $row['tanggal'];
			$jam_x = date("H",strtotime($row['jam_pinjam']));
			$jam_y = date("i",strtotime($row['jam_pinjam']));

			$now_old = strtotime($tg_sewa." $jam_x:$jam_y");
			$jam_sewa = ceil(($now_b - $now_old) / 3600);

			$harus_bayar = $jam_sewa * $row['jumlah'] * $price;
			if($harus_bayar > $bayar){
				pesan("danger","Transaksi tidak valid. Jumlah pembayaran tidak sesuai. Silakan diperiksa kembali.","../pengembalian.php");
			}

			//kalau udah oke,, masukkan ke tabel pengembalian
			$tgl = date("Y-m-d");
			$jam_balik = date("H:i:s",strtotime($jk_a.":".$jk_b));
			$ins = $db->query("INSERT INTO sip_pengembalian VALUES(".quote($kd_trans).", '$tgl', '$jam_balik', ".quote($harus_bayar).")");
			$upd = $db->query("UPDATE sip_member SET status = 1 WHERE id = ".quote($row['id']));

			pesan("success","Berhasil menyimpan transaksi pengembalian sepeda","../pengembalian.php?invoice=$kd_trans");
		}


	break;

	default:
		header("location:../index.php");
}