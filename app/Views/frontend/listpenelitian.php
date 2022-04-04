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
                        <li><a href="<?php echo base_url(); ?>/welcome">Home</a></li>
                        <li>Data Penelitian</li>
                    </ol>
                </div>
            </section>
            <section class="blog">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 entries">
                            <div class="blog-comments">
                                <div class="reply-form">
                                    <h4>Pencarian Materi</h4>
                                    <form action="<?php echo base_url(); ?>/listpenelitian/cari" method="POST">
                                        <div class="row">
                                            <div class="col-md-6 form-group" style="margin-top: 10px;">
                                                <input id="judul" name="judul" type="text" class="form-control" placeholder="JUDUL PENELITIAN" value="<?php echo $judul; ?>">
                                            </div>
                                            <div class="col-md-6 form-group" style="margin-top: 10px;">
                                                <input id="katakunci" name="katakunci" type="text" class="form-control" placeholder="KATA KUNCI" value="<?php echo $katakunci; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select id="strata" name="strata" class="form-control">
                                                    <option value="Umum" >Umum</option>
                                                    <option value="Perwira">Perwira</option>
                                                    <option value="Bintara">Bintara</option>
                                                    <option value="Tamtama">Tamtama</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select id="kategori" name="kategori" class="form-control">
                                                    <option value="" <?php if($nilaikategori == ""){ echo 'selected'; } ?> >- SEMUA KATEGORI MATERI -</option>
                                                    <?php
                                                    foreach ($kategori->getResult() as $row) {
                                                        ?>
                                                    <option <?php if($nilaikategori == $row->idkategori){ echo 'selected'; } ?> value="<?php echo $row->idkategori; ?>"><?php echo $row->nama_kategori; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Cari</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="portfolio">
                <div class="container">
                    <div class="row gy-4 portfolio-container">
                        <?php
                        foreach ($penelitian->getResult() as $row) {
                            $def = base_url().'/assets/img/noimg.jpg';
                            if(strlen($row->thumbnail) > 0){
                                if(file_exists($row->thumbnail)){
                                    $def = base_url().substr($row->thumbnail, 1);
                                }
                            }
                            ?>
                        <div class="col-lg-4 col-md-6 portfolio-item">
                            <div class="portfolio-wrap">
                                <img src="<?php echo $def; ?>" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4><?php echo $row->judul; ?></h4>
                                    <p></p>
                                    <div class="portfolio-links">
                                        <a href="<?php echo base_url(); ?>/singlepenelitian/index/<?php echo $modul->enkrip_url($row->idpenelitian); ?>" title="More Details"><i class="bi bi-link"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
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
                            <a href="<?php echo base_url(); ?>/welcome" class="logo d-flex align-items-center">
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
            
        </script>
    </body>
</html>