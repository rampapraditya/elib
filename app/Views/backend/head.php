<?php
use App\Libraries\Nativesession;
use App\Libraries\Modul;
use App\Models\Mcustom;

// library
$native_ses = new Nativesession();
$modul = new Modul();

// model
$model = new Mcustom();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>E-Library</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/vendors/feather/feather.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/js/select.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/back/css/vertical-layout-light/style.css">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/back/images/favicon.png" />
        <script src="<?php echo base_url(); ?>/assets/js/jquery-3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>/tinymce/tinymce.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/fancy/jquery.fancybox.pack.js" ></script>
        
        <script type="text/javascript">
            
            function back(){
                window.history.back();
            }
            
            function hanyaAngka(e, decimal) {
                var key;
                var keychar;
                if (window.event) {
                    key = window.event.keyCode;
                } else if (e) {
                    key = e.which;
                } else {
                    return true;
                }
                keychar = String.fromCharCode(key);
                if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                    return true;
                } else if ((("0123456789").indexOf(keychar) > -1)) {
                    return true;
                } else if (decimal && (keychar == ".")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function batas_angka(input, batas) {
                if (input.value < 0){ input.value = 0;}
                if (input.value > batas) {input.value = batas;}
            }
        </script>
        
    </head>
    <body>
        <div class="container-scroller">
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo mr-5" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/img/marinir.png" class="mr-2" alt="logo"/> E Library </a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                    <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item nav-search d-none d-lg-block">
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <?php
                                $def = base_url().'/assets/img/marinir.png';
                                $foto = $model->getAllQR("select foto from users where idusers = '".$idusers."';")->foto;
                                if(strlen($foto) > 0){
                                    if(file_exists($foto)){
                                        $def = base_url().substr($foto, 1);
                                    }
                                }
                                ?>
                                <img src="<?php echo $def; ?>" alt="profile"/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a href="<?php echo base_url(); ?>/profile" class="dropdown-item"><i class="ti-settings text-primary"></i>Profile</a>
                                <a href="<?php echo base_url(); ?>/login/logout" class="dropdown-item"><i class="ti-power-off text-primary"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="icon-menu"></span>
                    </button>
                </div>
            </nav>