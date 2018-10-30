<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:login.php'); die();
    }
?>

<div class="page-wrapper">
<div class="page-breadcrumb">
<div class="row">
    <div class="col-5 align-self-center">
        <h2 class="page-title">Bank Medium - Network Tools System</h2>
    </div>
    <div class="col-7 align-self-center">
        <div class="d-flex align-items-center justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                </ol>
            </nav>
        </div>
    </div>
</div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <h3 class="card-title">Your IP Address is <?= $_SERVER['REMOTE_ADDR'] ?></h3>
            </div>
        </div>
      </div>
    </div>
</div>
