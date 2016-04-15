<?php
include_once("view/conf.php");

if(!cek_login()){
	header("location:index.php");
}

if(isset($_GET['invoice'])){
	$n = intval($_GET['invoice']);
	$url = "invoice.php?kd=$n";
	echo "
	<script type='text/javascript'>
		window.open('$url', '_blank');
		window.open('peminjaman.php', '_self');
	</script>
	";
}


	$title = "Transaksi Peminjaman";
	/*
	1	: Data Member
	2	: Transaksi Peminjaman
	3 	: Transaksi Pengembalian
	4	: Laporan
	*/
	$menu = 2;
	include "view/header.php";
?>
<h1>Transaksi Peminjaman</h1>


<form action="process/add-data.php?id=peminjaman" method="post">	
	<fieldset>
    <div class="form-group">
      <label for="inputNama" class="col-lg-2 control-label">Member ID</label>
      <div class="col-lg-10">
      	<select name="idmember" id="inputNama" class="form-control">
      		<option value=""></option>
      		<?php
      		$list = $db->query("SELECT * FROM sip_member WHERE status = 1");
      		foreach($list as $row){
      			echo "<option value='$row[id]'>$row[nama] ($row[kitas])</option>";
      		}
      		?>
      	</select>
      </div>
    </div>
	
	<div class="form-group">
      <label for="inputSpd" class="col-lg-2 control-label">Jumlah Sepeda</label>
      <div class="col-lg-10">
        <input type="number" min=1 max=300 name="spd" class="form-control" id="inputSpd" placeholder="Jml Sepeda" style="width:30%">
      </div>
    </div>

	<div class="form-group padd">
      <div class="col-lg-10 col-lg-offset-2">
		<button class="btn btn-primary" name="btn"><span class="fa fa-save"></span> Simpan</button>
	  </div>
	</div>

    </fieldset>
	

</form>

<?php
include "view/footer.php";
?>
