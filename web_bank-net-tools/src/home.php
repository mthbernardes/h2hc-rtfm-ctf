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
                <h4 class="card-title">Network Tools System, is a application used by the Medium's engineers, to perform network test in a external environment.</h4>
            </div>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/0a/Logo-banco-inter-degrade.png" width="100%" height="100%">
            </div>
        </div>
      </div>
    </div>
</div>
