<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:login.php'); die();
    }
?>

<?php 
if (isset($_POST['ipaddress'])){
$ipaddress = strtolower($_POST['ipaddress']);
$bad_chars = array(";","\\n","\r","php","|","&","!","`","%","{","}","$","[","]");
$ipaddress = str_replace($bad_chars,"replaced",$ipaddress);
$cmd = 'ping -c4 ' . $ipaddress;
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
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Ping Tool</h4>
                            <h5 class="card-subtitle"> Utility to test ping</h5>
                            <form class="form-horizontal m-t-30" data-bitwarden-watching="1" action="index.php?p=ping" method="POST">
                                <div class="form-group">
                                    <label>IP Address</label>
                                    <input name="ipaddress" class="form-control" placeholder="1.1.1.1" maxlength=15 pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Result <?php if(isset($cmd)){echo 'of command : <b>' . $cmd . '</b>'; } ?></label>
                                    <textarea class="form-control" readonly rows="10">
<?php 
if(isset($cmd)){
echo system($cmd);
}

?>
</textarea>
                                </div>
                                  <input type="submit" value="Execute" class="btn btn-success">
                            </form>
                        </div>
                    </div>
                </div>
</div>
