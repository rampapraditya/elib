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
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>E-Library</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <link href="<?php echo $logo; ?>" rel="icon">
        <link href="<?php echo base_url(); ?>/assets/front/img/apple-touch-icon.png" rel="apple-touch-icon">
        <link href="<?php echo base_url(); ?>/assets/front/css/font.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/aos/aos.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/front/css/style.css" rel="stylesheet">
    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="100">
        <header id="header" class="header fixed-top">
            <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
                <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">
                    <img src="<?php echo $logo; ?>" alt="" style="margin-top: -10px;">
                    <span>E-Library</span>
                </a>
                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link" href="<?php echo base_url(); ?>/home">Home</a></li>
                        <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>/home#about">Special Book</a></li>
                        <li><a class="nav-link" href="<?php echo base_url(); ?>/listpenelitian">Research</a></li>
                        <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>/home#recent-blog-posts">News</a></li>
                        <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>/home#contact">Contact</a></li>
                        <?php
                        if($native_ses->get('logged_in')){
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>/login/logout">Log Out</a></li>
                            <?php
                        }else if($native_ses->get('logged_siswa')){
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>/login/logoutsiswa">Log Out</a></li>
                            <?php
                        }else{
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>/login">Log In</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>

        <main id="main">
            <section class="breadcrumbs">
                <div class="container">
                    <ol style="margin-top: 12px;">
                        <li><a href="<?php echo base_url(); ?>welcome">Home</a></li>
                        <li>News</li>
                    </ol>
                </div>
            </section>
            <section id="blog" class="blog">
                <div class="container" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-8 entries">
                            <article class="entry entry-single">
                                <div class="entry-img">
                                    <img src="<?php echo $thumb; ?>" alt="" class="img-fluid">
                                </div>
                                <h2 class="entry-title"><?php echo $judul; ?></h2>
                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <?php echo $penulis; ?></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <?php echo $tanggal; ?></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <?php echo $jml_komentar." Comments" ?></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <?php echo $konten; ?>
                                </div>
                            </article>
                            <div class="blog-comments">
                                <h4 class="comments-count"><?php echo $jml_komentar; ?> Comments</h4>
                                <div class="comment" id="div_komentar">
                                    
                                </div>

                                <div class="reply-form">
                                    <h4>Leave a Reply</h4>
                                    <p>Your email address will not be published. Required fields are marked * </p>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>" readonly>
                                                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama*">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input id="email" name="email" type="text" class="form-control" placeholder="Email*">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col form-group">
                                                <textarea id="komentar" name="komentar" class="form-control" placeholder="Komentar*"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col form-group">
                                                <div id="pesan"></div>
                                            </div>
                                        </div>
                                        <button id="btnKomentar" type="button" class="btn btn-primary" onclick="simpan_komentar()">Kirim Komentar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="sidebar">
                                <h3 class="sidebar-title">Recent Posts</h3>
                                <div class="sidebar-item recent-posts">
                                    <?php
                                    foreach ($beritalain->getResult() as $row) {
                                        $defthumb = base_url().'/assets/img/noimg.jpg';
                                        if(strlen($row->thumb) > 0){
                                            if(file_exists($row->thumb)){
                                                $defthumb = base_url().substr($row->thumb, 1);
                                            }
                                        }
                                        ?>
                                    <div class="post-item clearfix">
                                        <img src="<?php echo $defthumb; ?>" alt="">
                                        <h4><a href="<?php echo base_url(); ?>/blogsingle/index/<?php echo $modul->enkrip_url($row->idblog); ?>"><?php echo $row->judul; ?></a></h4>
                                        <time><?php echo $row->tgl; ?></time>
                                    </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">

            <div class="footer-top">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-5 col-md-12 footer-info">
                            <a href="<?php echo base_url(); ?>/home" class="logo d-flex align-items-center">
                                <img src="<?php echo $logo; ?>" alt="">
                                <span>E-Library Korps Marinir</span>
                            </a>
                            <p><?php echo $tentang; ?></p>
                            <div class="social-links mt-3">
                                <a href="<?php echo $tw; ?>" target="_blank" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="<?php echo $fb; ?>" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="<?php echo $ig; ?>" target="_blank" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
                                <a href="<?php echo $lk; ?>" target="_blank" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-6 footer-links">

                        </div>

                        <div class="col-lg-2 col-6 footer-links">

                        </div>

                        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                            <h4>Kontak Kami</h4>
                            <p>
                                <?php echo $alamat; ?><br><br>
                                <strong>Telepon :</strong> <?php echo $tlp; ?><br>
                                <strong>Email   :</strong> <?php echo $email; ?><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span><?php echo date('Y'); ?></span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                     Created by @Disinfolahta Kormar
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="<?php echo base_url(); ?>/assets/js/jquery-3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/aos/aos.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/php-email-form/validate.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/purecounter/purecounter.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/front/js/main.js"></script>
        <script type="text/javascript">
            
            $(document).ready(function (){
                load_komentar();
                
                $('#nama').keypress(function (e){
                    var key = e.which;
                    if(key === 13){
                        $('#email').focus();
                        $('#email').select();
                    }
                });
                
                $('#email').keypress(function (e){
                    var key = e.which;
                    if(key === 13){
                        $('#komentar').focus();
                        $('#komentar').select();
                    }
                });
                
                $('#komentar').keypress(function (e){
                    var key = e.which;
                    if(key === 13){
                        simpan_komentar();
                    }
                });
                
            });
            
            function load_komentar(){
                $.ajax({
                    url: "<?php echo base_url(); ?>/blogsingle/ajax_komentar/<?php echo $kode; ?>",
                    type: "POST",
                    dataType: "TEXT",
                    success: function (data) {
                        $('#div_komentar').html(data);
                        
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error load komentar');
                    }
                });
            }
            
            function simpan_komentar(){
                var kode = document.getElementById('kode').value;
                var nama = document.getElementById('nama').value;
                var email = document.getElementById('email').value;
                var komentar = document.getElementById('komentar').value;

                if(nama === ""){
                    $('#pesan').text("Nama tidak boleh kosong");
                }else if(email === ""){
                    $('#pesan').text("Email tidak boleh kosong");
                }else if(komentar === ""){
                    $('#pesan').text("Komentar tidak boleh kosong");
                }else{
                    $('#btnKomentar').html(' Loading... ');
                    $('#btnKomentar').attr('disabled',true);

                    var form_data = new FormData();
                    form_data.append('kode', kode);
                    form_data.append('nama', nama);
                    form_data.append('email', email);
                    form_data.append('komentar', komentar);

                    $.ajax({
                        url: "<?php echo base_url(); ?>/blogsingle/proseskomentar",
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            $('#pesan').text(response.status);

                            $('#btnKomentar').html(' Kirim Komentar ');
                            $('#btnKomentar').attr('disabled',false);
                            
                            if(response.status === "Komentar tersimpan"){
                                document.getElementById('nama').value = "";
                                document.getElementById('email').value = "";
                                document.getElementById('komentar').value = "";
                                
                                load_komentar();
                            }

                        },error: function (response) {
                            $('#pesan').text(response.status);

                            $('#btnKomentar').html(' Kirim Komentar ');
                            $('#btnKomentar').attr('disabled',false);
                        }
                    });
                }
            }
        </script>
    </body>
</html>