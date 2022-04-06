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
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
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
                        <li><a class="nav-link scrollto" href="#hero">Home</a></li>
                        <li><a class="nav-link scrollto" href="#about">Special Book</a></li>
                        <li><a class="nav-link" href="<?php echo base_url(); ?>/listpenelitian">Research</a></li>
                        <li><a class="nav-link scrollto" href="#recent-blog-posts">News</a></li>
                        <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
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

        <!-- ======= Hero Section ======= -->
        <section id="hero" class="hero d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        
                        <font face="stencil">
                        <h1 data-aos="fade-up" ><font color="grey">ELECTRONIC LIBRARY</font></h1>
                        <h1 data-aos="fade-up" ><font color="grey">KORPS MARINIR</font></h1>
                        <h1 data-aos="fade-up" ><font color="grey">TNI AL</font></h1>
                        </font>
                        
                        <div data-aos="fade-up" data-aos-delay="600">
                            <div class="text-center text-lg-start">
                                <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Get Started</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="<?php echo base_url(); ?>/assets/front/img/logo_marinir.png" class="img-fluid" alt="">
                        <br>
                        <br>
                        <br>
                        <h3 data-aos="fade-up" data-aos-delay="400"><font color="white">Kumpulan Materi publikasi dan produk hukum di lingkungan Korps Marinir TNI AL</font></h3>
                        <h2 data-aos="fade-up" data-aos-delay="400"><font color="white">GATEWAY TO TRANSFORM INTO THE FUTURE AMPHIBIOUS FORCE</font></h2>
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->

        <main id="main">
            <!-- ======= About Section ======= -->
            <section id="about" class="about">
                <div class="container" data-aos="fade-up">
                    <div class="row gx-0">
                        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                            <div class="content">
                                <h1>Daftar buku bacaan wajib prajurit korps marinir :</h1>
                                
                                <h2>Perwira</h2>
                                <h2>Bintara</h2>
                                <h2>Tamtama</h2>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center" style="padding: 20px;">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                    for($i = 0; $i < $jmlslider; $i++){
                                        ?>
                                    <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" <?php if($i == 0){ echo 'class="active"'; } ?>></li>
                                        <?php
                                    }
                                    ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                    $counter = 0;
                                    foreach ($slider->getResult() as $row) {
                                        ?>
                                    <div class="item <?php if($counter == 0){ echo 'active'; } ?>">
                                        <?php
                                        $def = base_url().'/assets/img/noimg.jpg';
                                        if(strlen($row->path) > 0){
                                            if(file_exists(ROOTPATH.'public/uploads/'.$row->path)){
                                                $def = base_url().'/uploads/'.$row->path;
                                            }
                                        }
                                        ?>
                                        <img src="<?php echo $def; ?>" alt="Gambar">
                                        <div class="carousel-caption">
                                            <h3><?php echo $row->judul; ?></h3>
                                            <p><?php echo $row->keterangan; ?></p>
                                        </div>
                                    </div>
                                        <?php
                                        $counter++;
                                    }
                                    ?>
                                    
                                </div>
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </section><!-- End About Section -->

            <section id="counts" class="counts">
                <div class="container" data-aos="fade-up">
                    <div class="row gy-4">
                        <?php
                        foreach ($subkategori->getresult() as $row) {
                            ?>
                        <div class="col-lg-3 col-md-6" >
                            <div class="count-box" style="cursor: pointer;" onclick="showlistpenelitian('<?php echo $modul->enkrip_url($row->idkat_p_sub); ?>');">
                                <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                                <div>
                                    <?php
                                    $jml = $model->getAllQR("SELECT count(*) as jml FROM penelitian where idkat_p_sub = '".$row->idkat_p_sub."';")->jml;
                                    ?>
                                    <span data-purecounter-start="0" data-purecounter-end="<?php echo $jml; ?>" data-purecounter-duration="1" class="purecounter"></span>
                                    <p><?php echo $row->nama_sub_kat; ?></p>
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio">
                <div class="container" data-aos="fade-up">
                    <header class="section-header">
                        <p>Buku Terbaru</p>
                    </header>
                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <ul id="portfolio-flters">
                                <li data-filter="*" class="filter-active">All</li>
                                <?php
                                foreach ($kategori->getResult() as $row) {
                                    ?>
                                <li data-filter=".<?php echo $row->idkategori; ?>"><?php echo $row->nama_kategori; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
                        <?php
                        foreach ($penelitian->getResult() as $row) {
                            $def = base_url().'/assets/img/noimg.jpg';
                            if(strlen($row->thumbnail) > 0){
                                if(file_exists($row->thumbnail)){
                                    $def = base_url().substr($row->thumbnail, 1);
                                }
                            }
                            ?>
                        <div class="col-lg-4 col-md-6 portfolio-item <?php echo $row->idkategori; ?>">
                            <div class="portfolio-wrap">
                                <img src="<?php echo $def; ?>" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4><?php echo $row->judul; ?></h4>
                                    <p></p>
                                    <div class="portfolio-links">
                                        <a href="<?php echo base_url(); ?>singlepenelitian/index/<?php echo $modul->enkrip_url($row->idpenelitian); ?>" title="More Details"><i class="bi bi-link"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section><!-- End Portfolio Section -->


            <!-- ======= Recent Blog Posts Section ======= -->
            <section id="recent-blog-posts" class="recent-blog-posts">
                <div class="container" data-aos="fade-up">
                    <header class="section-header">
                        <p>Sekilas Informasi</p>
                    </header>
                    <div class="row">
                        <?php
                        foreach ($berita->getResult() as $row) {
                            ?>
                        <div class="col-lg-4">
                            <div class="post-box">
                                <div class="post-img">
                                    <?php
                                    $def = base_url().'/assets/img/noimg.jpg';
                                    if(strlen($row->thumb) > 0){
                                        if(file_exists($row->thumb)){
                                            $def = base_url().substr($row->thumb, 1);
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo $def; ?>" class="img-fluid" alt="">
                                </div>
                                <span class="post-date"><?php echo $row->tgl; ?></span>
                                <h3 class="post-title"><?php echo $row->judul ?></h3>
                                <a href="<?php echo base_url(); ?>/blogsingle/index/<?php echo $modul->enkrip_url($row->idblog); ?>" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section><!-- End Recent Blog Posts Section -->

            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <header class="section-header">
                        <h2>Contact</h2>
                        <p>Contact Us</p>
                    </header>
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-geo-alt"></i>
                                        <h3>Alamat</h3>
                                        <p><?php echo $alamat; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-telephone"></i>
                                        <h3>Telepon</h3>
                                        <p><?php echo $tlp; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-envelope"></i>
                                        <h3>Email</h3>
                                        <p><?php echo $email; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="php-email-form">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pengguna">
                                    </div>
                                    <div class="col-md-6 ">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Pengguna">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" id="pesan" name="pesan" rows="6" placeholder="Pesan"></textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="loading" class="loading" style="display: none;">Loading</div>
                                        <div id="pesan_error" class="error-message" style="display: none;">Error Pesan</div>
                                        <div id="pesan_sukses" class="sent-message" style="display: none;">Pesan terkirim. Terima Kasih!</div>
                                        <button id="btnKirimPesan" type="submit" onclick="kirimpesan();">Kirim Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">

            <div class="footer-top">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-5 col-md-12 footer-info">
                            <a href="<?php echo base_url(); ?>welcome" class="logo d-flex align-items-center">
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
        
        <script>
            
            function kirimpesan(){
                var nama = $('#nama').val();
                var email = $('#email').val();
                var judul = $('#judul').val();
                var pesan = $('#pesan').val();
                
                if(nama === ""){
                    $('#pesan_error').html("Nama harus diisi");
                    $('#pesan_error').show();
                }else if(email === ""){
                    $('#pesan_error').html("Email harus diisi");
                    $('#pesan_error').show();
                }else if(judul === ""){
                    $('#pesan_error').html("Judul harus diisi");
                    $('#pesan_error').show();
                }else if(pesan === ""){
                    $('#pesan_error').html("Pesan harus diisi");
                    $('#pesan_error').show();
                }else{
                    $('#pesan_error').html("");
                    $('#pesan_error').hide();
                    
                    $('#loading').show();
                    $('#btnKirimPesan').attr('disabled',true);

                    var form_data = new FormData();
                    form_data.append('nama', nama);
                    form_data.append('email', email);
                    form_data.append('judul', judul);
                    form_data.append('pesan', pesan);

                    $.ajax({
                        url: "<?php echo base_url(); ?>/home/kirimpesan",
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            $('#loading').hide();
                            
                            $('#pesan_sukses').html(response.status);
                            $('#pesan_sukses').show();

                            $('#btnKirimPesan').attr('disabled',false);
                            
                            resetkomponen();

                        },error: function (response) {
                            $('#loading').hide();
                            
                            $('#pesan_error').html(response.status);
                            $('#pesan_error').show();
                            
                            $('#btnKirimPesan').attr('disabled',false);
                        }
                    });
                }
            }
            
            function resetkomponen(){
                $('#nama').val("");
                $('#email').val("");
                $('#judul').val("");
                $('#pesan').val("");
            }
            
            function showlistpenelitian(kode){
                window.location.href = "<?php echo base_url(); ?>/listpenelitian/index/"+kode;
            }
            
        </script>

    </body>

</html>