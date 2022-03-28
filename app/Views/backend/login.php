<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>E-Library</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/vendors/feather/feather.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/vertical-layout-light/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0" style="background-image: url('<?php echo base_url(); ?>assets/img/kapal.jpg'); background-position: center top; background-size: 100% 100%;">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto" >
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5" style="background-color: #fff; background-color: rgba(255,255,255, 0.9);">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url(); ?>assets/img/marinir.png" alt="logo" style="width: 70px;">
                                </div>
                                <h4>E Library</h4>
                                <h6 class="font-weight-light">Login untuk melanjutkan.</h6>
                                <div class="pt-3">
                                    <form id="form">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" id="nrp" name="nrp" placeholder="NRP" autocomplete="off" autofocus="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" id="pass" name="pass" placeholder="Password">
                                        </div>
                                    </form>
                                    <div class="mt-3">
                                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" onclick="login();">SIGN IN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/vendors/js/vendor.bundle.base.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/js/off-canvas.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/js/hoverable-collapse.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/js/template.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/js/settings.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/js/todolist.js"></script>
        
        <script type="text/javascript">
            
            $(document).ready(function (){
                $('#nrp').keypress(function (e){
                    var key = e.which;
                    if(key === 13){
                        $('#pass').focus();
                        $('#pass').select();
                    }
                });
                
                $('#pass').keypress(function (e){
                    var key = e.which;
                    if(key === 13){
                        login();
                    }
                });
            });

            function login() {
                var nrp = document.getElementById('nrp').value;
                var pass = document.getElementById('pass').value;
                if (nrp === '') {
                    alert("NRP tidak boleh kosong");
                } else if (pass === '') {
                    alert("Password tidak boleh kosong");
                } else {
                    $.ajax({
                        url: "<?php echo base_url(); ?>login/proses",
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status === "ok") {
                                window.location.href = "<?php echo base_url(); ?>beranda";
                            }else if(data.status === "ok_siswa"){
                                window.location.href = "<?php echo base_url(); ?>welcome";
                            } else {
                                alert(data.status);
                            }
                        }, error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error json " + errorThrown);
                        }
                    });
                }
            }

        </script>
        
    </body>
</html>
