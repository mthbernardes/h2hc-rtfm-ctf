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
            

            <h3 class="card-title">System logs</h3>
<form class="form-horizontal m-t-30" action="index.php?p=logs" method="POST">
  <div class="form-group">
                                    <label>Input Select</label>
                                    <select class="custom-select col-12" name="logfile" id="inlineFormCustomSelect">
                                        <option value="troll.log">dmesg</option>
                                    </select>
                                </div>

<input type="submit" value="Show Log" class="btn btn-success">
</form>
</div>
</div>
</div>
</div>
<?php 
include_once("functions.php");
if(isset($_POST["logfile"])){
$logfile=$_POST["logfile"];
$bad_char=array("/");
$logfile=str_replace($bad_char,"",$logfile);
$logfile='logs/'.$logfile;
if(file_exists($logfile) && get_file_extension($logfile) === "log"){
echo '<div class="row"><div class="col-md-12"><div class="card"><div class="card-body">';
echo '<h3 class="card-title">Log: '. $logfile .'</h3>';
echo '<textarea class="form-control" readonly rows="30">';
include($logfile);
echo '</textarea>';
  }
}
?>

            </div>
        </div>
      </div>
    </div>
</div>
