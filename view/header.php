<?php
include_once ("view/conf.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?=BASE_URL?>">
<title><?php
if(isset($title)){
  echo "$title | ";
}
?>Sistem Penyewaan Sepeda</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/jquery-ui-1.10.1.custom.min.css">
<link rel="stylesheet" href="css/style.css">

</head>
<Body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sistem Penyewaan Sepeda</a>
    </div>

    <?php
    $active = isset($menu) ? $menu : 1;
    ?>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li <?php if($active == 1 ){echo "class='active'";}?>><a href="<?=BASE_URL?>">Data Member</a></li>
        <li class="dropdown <?php if($active == 3 || $active == 2 ){echo "active";}?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Transaksi<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li <?php if($active == 2 ){echo "class='active'";}?> ><a href="<?=base_url("peminjaman.php")?>">Peminjaman Sepeda</a></li>
            <li <?php if($active == 3 ){echo "class='active'";}?>><a href="<?=base_url("pengembalian.php")?>">Pengembalian Sepeda</a></li>
          </ul>
        </li>
        <li <?php if($active == 4 ){echo "class='active'";}?>><a href="<?=base_url("laporan.php")?>">Laporan</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
      	<li>
      		<a href="<?=base_url("logout.php")?>">
	      	<button class="btn btn-danger btn-xs">Log Out</button>
      		</a>
      	</li>
      </ul>
    </div>
  </div>
</nav>

<main>
	<div class="container">
  <?=msghandling()?>