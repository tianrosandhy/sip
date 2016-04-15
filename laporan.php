<?php
include_once("view/conf.php");

if(!cek_login()){
	header("location:index.php");
}

	$title = "Laporan Transaksi";
	/*
	1	: Data Member
	2	: Transaksi Peminjaman
	3 	: Transaksi Pengembalian
	4	: Laporan
	*/
	$menu = 4;
	include "view/header.php";
?>
<h1>Laporan Transaksi</h1>
<div class="show_on_print">
	<?php
	if(isset($_GET['dari']) and isset($_GET['sampai'])){
		if($_GET['dari'] == $_GET['sampai'])
			$out = "Tanggal ".date_indo($_GET['dari']);
		else
			$out = "Dari tanggal ".date_indo($_GET['dari'])." s/d ".date_indo($_GET['sampai']);
	}
	else{
		echo "Tanggal ".date_indo(date("Y-m-d"));
	}
	echo $out;
	?>
</div>
<form action="" method="get" class="hide_on_print">
<div class="row">
	<div class="col-sm-4 col-md-3">
		Dari tanggal : 
		<br>
		<input type="text" name="dari" class="datepicker form-control" value="<?php if(isset($_GET['dari'])){echo $_GET['dari'];}else{echo date("m/d/Y");}?>">
	</div>
	<div class="col-sm-4 col-md-3">
		Sampai tanggal : 
		<br>
		<input type="text" name="sampai" class="datepicker form-control" value="<?php if(isset($_GET['sampai'])){echo $_GET['sampai'];}else{echo date("m/d/Y");}?>">
	</div>
	<div class="col-sm-4 col-md-6">
		<br>
		<button class="btn btn-primary">Proses</button>
	</div>
</div>
<br>
<br>
</form>
<?php
if(isset($_GET['dari']) and isset($_GET['sampai'])){
	$dari = date("Y-m-d",strtotime($_GET['dari']));
	$sampai = date("Y-m-d",strtotime($_GET['sampai']));
	
	if(strtotime($_GET['dari']) > strtotime($_GET['sampai'])){
		$x = $sampai;
		$sampai = $dari;
		$dari = $x;
	}

	$sql = $db->query("
	SELECT 
	a.kd_transaksi, c.id, c.nama, c.kitas, c.tipe, c.telp, c.status, a.tanggal as tanggal_pinjam, a.jam_pinjam, a.jumlah, b.tanggal_kembali, b.jam_kembali, b.biaya
	FROM sip_peminjaman a 
	    INNER JOIN sip_member c ON a.id = c.id
		LEFT JOIN sip_pengembalian b ON a.kd_transaksi = b.kd_transaksi
	WHERE a.tanggal BETWEEN ".quote($dari)." AND ".quote($sampai));
	echo "
	<table class='table'>
		<thead>
			<tr>
			<th>#</th>
			<th>Invoice</th>
			<th>Nama & KITAS</th>
			<th>Pinjam</th>
			<th>Kembali</th>
			<th>Durasi</th>
			<th>Jumlah</th>
			<th>Harga</th>
			</tr>
		</thead>
		<tbody>
	";
	$no = 1;
	$subtotal = 0;
	foreach($sql as $row){
		$inv = "INV".substr(100000 + $row['kd_transaksi'],-5);
		$tgl = date_indo($row['tanggal_pinjam']);
		$biaya = "Rp ".number_format($row['biaya'],0,",",".");
		if(empty($row['jam_kembali'])){
			$trclass="danger";
			$biaya = "-";
			$durasi = "-";
			$hmm = "<span class='label label-danger hide_on_print'>Belum dikembalikan</span>";
		}
		else{
			$trclass="";


			$jam_pinjam = date("H:i",strtotime($row['jam_pinjam']));
			$jam_kembali = date("H:i",strtotime($row['jam_kembali']));

			$x = strtotime(date("$row[tanggal_pinjam] $jam_pinjam"));
			$y = strtotime(date("$row[tanggal_kembali] $jam_kembali"));
			$selisih = ($y-$x);
			$dur = floor($selisih/3600);
			$min = floor(($selisih%3600)/60);

			$durasi = "$dur jam $min menit";
			$hmm = date_indo($row['tanggal_kembali'])." $row[jam_kembali]";

		}
		$subtotal += $row['biaya'];
		echo "
		<tr class='$trclass'>
			<td>$no</td>
			<td>$inv</td>
			<td>$row[nama] - $row[kitas]</td>
			<td>$tgl $row[jam_pinjam]</td>
			<td>$hmm</td>
			<td>$durasi</td>
			<td>$row[jumlah]</td>
			<td align='right'>$biaya</td>
		</tr>
		";
		$no++;
	}

	if($sql->rowCount()==0){
		echo "<tr><td colspan='8' class='danger'>Belum ada data yang dapat ditampilkan</td></tr>";
	}
	else{
		echo "
		<tr>
			<td colspan=7 align='right'>Total Pendapatan</td>
			<td align='right'><strong>Rp ".number_format($subtotal,0,",",".")."</strong></td>
		</tr>
		";
	}

	echo "
		</tbody>
	</table>
	";
}
?>
<button class="print btn btn-default btn-sm hide_on_print"><span class="fa fa-print"></span> Print</button>


<?php
include "view/footer.php";
?>
