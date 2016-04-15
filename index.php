<?php
include_once("view/conf.php");

if(cek_login()){
	$title = "Data Member";
	/*
	1	: Data Member
	2	: Transaksi Peminjaman
	3 	: Transaksi Pengembalian
	4	: Laporan
	*/
	$menu = 1;
	include "view/header.php";
?>
<h1>Data Member</h1>
<button type="button" class="btn btn-primary hide_on_print" data-toggle="modal" data-target="#addData">Tambah Data</button>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Nama</th>
			<th>Kitas</th>
			<th>Jenis</th>
			<th>Telepon</th>
			<th class="hide_on_print"></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$data = $db->query("SELECT * FROM sip_member WHERE status <> 9 ORDER BY nama");
		$no = 1;
		$jenis = array("","KTP","SIM","KTM");
		foreach($data as $row){
			if($row['status'] == 0){
				$pj = "<span class='label label-info'>Sedang Meminjam</span>";
				$del = "<a class='btn btn-danger btn-sm disabled'><span class='fa fa-close'></span> Hapus</a>";
			}
			else{
				$pj = "";
				$del = "<a href='process/delete.php?tp=member&id=$row[id]' class='btn btn-danger btn-sm action_prompt'><span class=\"fa fa-close\"></span> Hapus</a>";
			}

			$n = $row['tipe'];
			echo "
			<tr>
				<td>$no</td>
				<td>$row[nama] <span class='hide_on_print'>$pj</span></td>
				<td>$row[kitas]</td>
				<td>$jenis[$n]</td>
				<td>$row[telp]</td>
				<td class='hide_on_print' align='right'>$del</td>
			</tr>
			";
			$no++;
		}
		?>
	</tbody>
</table>

<button class="btn btn-default btn-sm print"><span class="fa fa-print"></span> Print</button>


<div id="addData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content Add Data-->
    <form action="process/add-data.php?id=member" method="post">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Tambah Data Member</h4>
	      </div>
	      <div class="modal-body">
			<fieldset>
		    <div class="form-group">
		      <label for="inputNama" class="col-lg-2 control-label">Nama</label>
		      <div class="col-lg-10">
		        <input type="text" name="nama" class="form-control" id="inputNama" placeholder="Nama Lengkap">
		      </div>
		    </div>
			
			<div class="form-group">
		      <label for="select" class="col-lg-2 control-label">Jenis KITAS</label>
		      <div class="col-lg-10">
		        <select class="form-control" name="tipe" id="select">
		          <option value="1">KTP</option>
		          <option value="2">SIM</option>
		          <option value="3">KTM</option>
		        </select>
		      </div>
		    </div>

			<div class="form-group">
		      <label for="inputKitas" class="col-lg-2 control-label">KITAS</label>
		      <div class="col-lg-10">
		        <input type="text" name="kitas" class="form-control" id="inputKitas" placeholder="Nomor Kartu Identitas">
		      </div>
		    </div>
			
			<div class="form-group">
		      <label for="inputTelp" class="col-lg-2 control-label">Telepon</label>
		      <div class="col-lg-10">
		        <input type="text" name="telp" class="form-control" id="inputTelp" placeholder="No Telepon">
		      </div>
		    </div>
		    </fieldset>
			
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
	        <button type="submit" name="btn" class="btn btn-primary btn-sm">
	        	<span class="fa fa-save"></span> Simpan
	        </button>
	      </div>
	    </div>
	</form>
  </div>
</div>


<?php
include "view/footer.php";
?>


<?php
}
/*AUTOMATIC GO TO LOGIN IF DONT HAVE AUTH*/
else{
	include "view/login.php";
}

?>

