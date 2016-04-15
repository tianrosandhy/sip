<?php
include_once("view/conf.php");

if(!cek_login()){
	header("location:index.php");
}

if(isset($_GET['invoice'])){
	$n = intval($_GET['invoice']);
	$url = "invoice2.php?kd=$n";
	echo "
	<script type='text/javascript'>
		window.open('$url', '_blank');
		window.open('pengembalian.php', '_self');
	</script>
	";
}


	$title = "Transaksi Pengembalian";
	/*
	1	: Data Member
	2	: Transaksi Peminjaman
	3 	: Transaksi Pengembalian
	4	: Laporan
	*/
	$menu = 3;
	include "view/header.php";
?>
<h1>Transaksi Pengembalian</h1>


<form action="process/add-data.php?id=pengembalian" method="post" id="form_kembali">
	<fieldset>

	<div class="row">
		<div class="col-sm-2">
	      <label for="inputMb">Member ID</label>
		</div>
		<div class="col-sm-10">
	      	<select name="kd_trans" id="inputMb" class="form-control">
	      		<option value=""></option>
	      		<?php
	      		$list = $db->query("SELECT sip_peminjaman.kd_transaksi, sip_member.* FROM sip_member, sip_peminjaman WHERE sip_peminjaman.id = sip_member.id AND sip_member.status = 0");
	      		foreach($list as $row){
	      			echo "<option value='$row[kd_transaksi]'>$row[nama] ($row[kitas])</option>";
	      		}
	      		?>
	      	</select>
		</div>
	</div>

	<div class="row">

		<div class="col-sm-2">
			<label for="jam_pinjam">Jam Pinjam</label>
		</div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-2">
					<input type="hidden" id="tgl_pinjam">
					<span class="tgl_pinjam"></span>
					<span class="jam_pinjam">00</span> :
					<span class="jam_pinjam2">00</span>
					<input type="hidden" name="jp_h" id="jam_pinjam">
					<input type="hidden" name="jp_m" id="jam_pinjam2">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2">
			<label for="jam_kembali" id="pengembalian">Jam Kembali</label>
		</div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-2">
					<input type="hidden" id="tgl_kembali" name="tgl_kbl" value="<?=date("Y-m-d")?>">
					<span class="tgl_kbl"><?=date_indo(date("Y-m-d"))?></span>
					<span class="jam_kembali">00</span> :
					<span class="jam_kembali2">00</span>
					<input type="hidden" name="jk_h" class="jk1">
					<input type="hidden" name="jk_m" class="jk2">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2">
			<label for="tarif_h">Tarif / Jam</label>
		</div>
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon">Rp</span>	
				<input type="number" id="tarif" name="tarif_h" readonly="readonly" value="<?=get_setting("harga")?>" class="form-control">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2">
			<label for="jml_spd">Jumlah Sepeda</label>
		</div>
		<div class="col-sm-2">
			<input type="number" name="jml_spd" class="form-control" readonly="readonly" id="jml_spd">
		</div>
	</div>


	<div class="row">
		<div class="col-sm-2">
			<label for="totharga">Total Harga</label>
		</div>
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon">Rp</span>
				<input type="number" name="total_harga" id="totharga" class="form-control bold lead" readonly="readonly">
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-2">
			<label for="bayar">Bayar</label>
		</div>
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon">Rp</span>
				<input type="number" name="bayar" id="bayar" class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<label for="kembalian">Kembalian</label>
		</div>
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon">Rp</span>
				<input type="number" name="kembalian" id="kembalian" class="form-control" readonly="readonly">
			</div>
		</div>
	</div>
	
	

	<div class="form-group padd">
      <div class="col-lg-10 col-lg-offset-2">
		<button class="btn btn-primary" name="btn"><span class="fa fa-save"></span> Proses</button>
	  </div>
	</div>

    </fieldset>
	

</form>

<?php
include "view/footer.php";
?>
