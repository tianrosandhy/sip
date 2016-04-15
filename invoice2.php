<?php
include "view/conf.php";
$kd = intval($_GET['kd']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title></title>
<style type="text/css">
*{margin:0px auto}
body{width:6cm; min-height:8cm; padding:1cm .5cm; box-shadow:0px 0px 5px rgba(0,0,0,0.5); font-family: sans-serif; font-size:12px;}
h2{text-align: center; padding:.3em .6em;}
.clear{clear:both;}
</style>
</head>
<body>
	<h2>Nota Pembayaran Sewa Sepeda</h2>
		
	<?php
	$q = $db->query("SELECT sip_peminjaman.*, sip_member.nama, sip_member.kitas, sip_member.telp, sip_pengembalian.tanggal_kembali, sip_pengembalian.jam_kembali, sip_pengembalian.biaya FROM sip_peminjaman, sip_member, sip_pengembalian WHERE sip_member.id = sip_peminjaman.id AND sip_peminjaman.kd_transaksi = sip_pengembalian.kd_transaksi AND sip_pengembalian.kd_transaksi = ".quote($kd));
	foreach($q as $r){
		$id = 100000 + $r['kd_transaksi'];
		$id = "INV".substr($id,-5);

		$tg_a = $r['tanggal'];
		$tg_b = $r['tanggal_kembali'];

		$tanggal = date_indo($tg_a);
		$jam_pinjam = date("H:i",strtotime($r['jam_pinjam']));
		$tanggal_kembali = date_indo($tg_b);
		$jam_kembali = date("H:i",strtotime($r['jam_kembali']));

		$x = strtotime(date("$tg_a $jam_pinjam"));
		$y = strtotime(date("$tg_b $jam_kembali"));


		$jumlah = $r['jumlah'];
		$nama = $r['nama'];
		$kitas = $r['kitas'];
		$telp = $r['telp'];
		$harga = $r['biaya'];
	}
	?>
	<table border=0 align="left">
		<tr>
			<th align="left">No Invoice</th>
			<td>:</td>
			<td><?=$id?></td>
		</tr>
		<tr>
			<th align="left" valign="top">Peminjam</th>
			<td>:</td>
			<td><?=$nama?><br><strong><em><?=$kitas?></em></strong></td>
		</tr>
		<tr>
			<th align="left">Telp</th>
			<td>:</td>
			<td><?=$telp?></td>
		</tr>
	</table>
	<div class="clear"></div>
	<br>
	<br>
	<table border=0 align="left">
		<tr>
			<th align="left" valign="top">Jam Pinjam</th>
			<td>:</td>
			<td><?=$tanggal."<br><strong>".$jam_pinjam."</strong>"?></td>
		</tr>
		<tr>
			<th align="left" valign="top">Jam Kembali</th>
			<td>:</td>
			<td><?=$tanggal_kembali."<br><strong>".$jam_kembali."</strong>"?></td>
		</tr>
		<tr>
			<th align="left" valign="top">Durasi</th>
			<td>:</td>
			<td><?php
				$selisih = ($y-$x);
				$dur = floor($selisih/3600);
				$min = floor(($selisih%3600)/60);
				echo "$dur jam $min menit";
			?></td>
		</tr>

		<tr>
			<th align="left">Jumlah</th>
			<td>:</td>
			<td><?=$jumlah?> pcs</td>
		</tr>
		<tr>
			<th align="left" valign="top">Harga Sewa</th>
			<td>:</td>
			<td style="font-size:20px; font-weight:bold;">Rp. <?=number_format($harga,0,",",".")?></td>
		</tr>
	</table>
	<div class="clear"></div>
	<br>
	<br>
	<p align="center">Terima kasih telah menggunakan jasa layanan sewa sepeda kami..</p>

<script type="text/javascript">
//	window.print();
</script>
</body>
</html>