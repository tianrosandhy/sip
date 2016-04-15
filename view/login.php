<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sistem Penyewaan Sepeda - Log In</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">

</head>
<Body class="loginBody">


<div id="loginBox">
	<form class="form-horizontal" method="post" action="process/login.php">
	  <fieldset>
	    <legend>Admin Log In</legend>

		<?=msghandling()?>

	    <div class="form-group">
	      <label for="inputEmail" class="col-lg-2 control-label">Username</label>
	      <div class="col-lg-10">
	        <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="username">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
	      <div class="col-lg-10">
	        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
	      </div>
	    </div>
	    <div class="form-group">
	      <div class="col-lg-10 col-lg-offset-2">
	        <button name="btn" type="submit" class="btn btn-primary"><span class="fa fa-key"></span> Log In</button>
	      </div>
	    </div>
	  </fieldset>
	</form>
</div>


<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
<script type="text/javascript">
$(function(){
	
});
</script>
</Body>
</html>