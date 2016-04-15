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
body{width:6cm; height:6cm; padding:1cm .5cm; box-shadow:0px 0px 5px rgba(0,0,0,0.5); font-family: sans-serif; font-size:12px;}
h2{text-align: center; padding:.3em .6em;}
.clear{clear:both;}
</style>
</head>
<body>
	<h2>Bukti Sewa Sepeda</h2>
		
	<?php
	$q = $db->query("SELECT sip_peminjaman.*, sip_member.nama, sip_member.kitas, sip_member.telp FROM sip_peminjaman, sip_member WHERE kd_transaksi = ".quote($kd));
	foreach($q as $r){
		$id = 100000 + $r['kd_transaksi'];
		$id = "INV".substr($id,-5);


		$tanggal = date_indo($r['tanggal']);
		$jam_pinjam = date("H:i",strtotime($r['jam_pinjam']));
		$jumlah = $r['jumlah'];
		$nama = $r['nama'];
		$kitas = $r['kitas'];
		$telp = $r['telp'];
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
			<th align="left">Jumlah</th>
			<td>:</td>
			<td><?=$jumlah?> pcs</td>
		</tr>
	</table>

<script type="text/javascript">
	window.print();
</script>
</body>
</html>