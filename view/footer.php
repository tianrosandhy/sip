	</div>
</main>

<footer>
	<div class="container">
		<div class="copyright">
			&copy; 2016
		</div>
	</div>
</footer>

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="js/jquery.ui.core.min.js"></script>
<script src="js/jquery.ui.widget.min.js"></script>
<script src="js/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
<script type="text/javascript">
$.fn.exists = function() { return this.length > 0; };
$(function(){



	$("select#inputMb").change(function(){
		var data = {"action" : "load"};
		data = $(this).serialize() + "&" + $.param(data);
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "view/loadmember.php",
			data : data,
			success : function(data){
				//input auto value
				$(".tgl_pinjam").text(data["tgl_seo"]);
				$("#tgl_pinjam").val(data["tanggal"]);

				$("#jam_pinjam").val(data["jam"]);
				$("#jam_pinjam2").val(data["menit"]);
				$(".jam_pinjam").text(data["jam"]);
				$(".jam_pinjam2").text(data["menit"]);

				$("#jml_spd").val(data["jumlah"]);

				var time1 = $("#tgl_pinjam").val() + " " + $("#jam_pinjam").val() + ":" + $("#jam_pinjam2").val();
				var time2 = $("#tgl_kembali").val() + " " + $(".jam_kembali").text() + ":" + $(".jam_kembali2").text();

				var time_a = new Date(time1);
				var time_b = new Date(time2);
				var selisih = new Date(time_b - time_a);
				//penentuan harga
				var harga = Math.ceil(selisih / 1000 / 3600);
				var harga_out = harga * $("#tarif").val() * $("#jml_spd").val();

				$("#totharga").val(harga_out);

			}
		}).done(sel,atur_kembalian);

	});

	$("#bayar").keyup(atur_kembalian);



	if( $("form#form_kembali").exists()){
		var data = {"action" : "load"};
		$.ajax({
			type : "POST",
			dataType : "json",
			url : "view/loadtime.php",
			data : data,
			success : function(data){
				$(".jam_kembali").text(data["H"]);
				$(".jam_kembali2").text(data["i"]);
				$(".jk1").val(data["H"]);
				$(".jk2").val(data["i"]);
			}
		});
	}


	function atur_kembalian(){
		var x = $("#bayar").val();
		var tot = $("#totharga").val();
		var selisih = x - tot;
		$("#kembalian").val(selisih);
	}

	function sel(){
		$("#bayar").val($("#totharga").val());
		$("#bayar").focus().select();
	}

	function timeToSeconds(time) {
	    time = time.split(/:/);
	    return time[0] * 3600 + time[1] * 60;
	}


	$(function() {
		$( ".datepicker" ).datepicker();
	});

	$(".print").click(function(){
		window.print();
	});
});
</script>
</Body>
</html>