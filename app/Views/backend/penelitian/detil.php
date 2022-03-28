<script type="text/javascript">
    
    $(document).ready(function() {
        pilihsubkat();
    });
    
    function save(){
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var tahun = document.getElementById('tahun').value;
        var kategori = document.getElementById('kategori').value;
        var subkat = document.getElementById('subkat').value;
        var strata = document.getElementById('strata').value;
        var gambar = $('#gambar').prop('files')[0];
        var katakunci = document.getElementById('katakunci').value;
        var sandi = document.getElementById('sandi').value;
        var penulis = document.getElementById('penulis').value;
        var penerbit = document.getElementById('penerbit').value;
        var ket = tinyMCE.get('ket').getContent();
        
        if(kode === ""){
            alert("Kode penelitian tidak boleh kosong");
        }else if(judul === ""){
            alert("Judul tidak boleh kosong");
        }else if(kategori === "-"){
            alert("Pilih kategori penelitian");
        }else if(katakunci === ""){
            alert("Kata kunci tidak boleh kosong");
        }else{
            $('#btnSave').text('Loading...');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('tahun', tahun);
            form_data.append('kategori', kategori);
            form_data.append('subkat', subkat);
            form_data.append('strata', strata);
            form_data.append('file', gambar);
            form_data.append('katakunci', katakunci);
            form_data.append('ket', ket);
            form_data.append('sandi', sandi);
            form_data.append('penulis', penulis);
            form_data.append('penerbit', penerbit);
            
            $.ajax({
                url: "<?php echo base_url(); ?>penelitian/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);                    
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled',false);
                    
                    if(response.status === "Data tersimpan"){
                        window.location.href = "<?php echo base_url(); ?>penelitian";
                    }else if(response.status === "Data terupdate"){
                        window.location.href = "<?php echo base_url(); ?>penelitian";
                    }
                    
                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
    function closemodal_siswa(){
        $('#modal_siswa').modal('hide');
    }
    
    function pilihsubkat(){
        var idkat = document.getElementById('kategori').value;
        var kode = document.getElementById('kode').value;
        
        $.ajax({
            url: "<?php echo base_url(); ?>penelitian/getsubkat/" + idkat + "/" + kode,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#subkat').html(data.hasil);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error hapus data');
            }
        });
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MATERI</h4>
                    <div class="forms-sample">
                        <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                        <!--
                        <div class="form-group">
                            <label>PENULIS</label>
                            <div class="input-group">
                                <input type="hidden" id="idsiswa" name="idsiswa" value="<?php //echo $idsiswa; ?>">
                                <input type="text" class="form-control" id="personil" name="personil" readonly autocomplete="off" value="<?php echo $nama_siswa; ?>">
                                <div class="input-group-append">
                                    <button style="margin-left: 3px;" class="btn btn-sm btn-outline-secondary" type="button" onclick="showsiswa();">...</button>
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>JUDUL</label>
                                    <input id="judul" name="judul" type="text" class="form-control" autocomplete="off" value="<?php echo $judul; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>THUMBNAIL</label>
                                    <input id="gambar" name="gambar" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>TAHUN</label>
                                    <input id="tahun" name="tahun" type="text" class="form-control" autocomplete="off" value="<?php echo $tahun; ?>" onkeypress="return hanyaAngka(event,false);">
                                </div>
                                <div class="col-md-6">
                                    <label>PASSWORD DOKUMEN &nbsp;&nbsp;<span style="color: red; font-size: 10px;"> ( Jika bersifat rahasia )</span></label>
                                    <input id="sandi" name="sandi" type="password" class="form-control" autocomplete="off" value="<?php echo $sandi; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>PENULIS</label>
                                    <input id="penulis" name="penulis" type="text" class="form-control" autocomplete="off" value="<?php echo $penulis; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>PENERBIT</label>
                                    <input id="penerbit" name="penerbit" type="text" class="form-control" autocomplete="off" value="<?php echo $penerbit; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>KATEGORI MATERI</label>
                                    <select id="kategori" name="kategori" class="form-control" onchange="pilihsubkat();">
                                        <option value="-">- PILIH KATEGORI -</option>
                                        <?php
                                        foreach ($kategori->result() as $row) {
                                            ?>
                                        <option <?php if($row->idkategori == $idkategori){ echo 'selected'; } ?> value="<?php echo $row->idkategori; ?>"><?php echo $row->nama_kategori; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>SUB KATEGORI</label>
                                    <select id="subkat" name="subkat" class="form-control">
                                        <option value="-">- PILIH SUB KATEGORI -</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>KATA KUNCI</label>
                                    <input id="katakunci" name="katakunci" type="text" class="form-control" autocomplete="off" value="<?php echo $katakunci; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>STRATA</label>
                                    <select id="strata" name="strata" class="form-control">
                                        <option value="Umum">Umum</option>
                                        <option value="Perwira">Perwira</option>
                                        <option value="Bintara">Bintara</option>
                                        <option value="Tamtama">Tamtama</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>SINOPSIS</label>
                            <textarea class="form-control" id="ket" name="ket"><?php echo $sinopsis; ?></textarea>
                            <script type="text/javascript">
                                var BASE_URL = "<?php echo base_url(); ?>";
                                tinymce.init({
                                    selector: "#ket",theme: "modern",height: 250,
                                    plugins: [
                                         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                                         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                                         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
                                   ],
                                   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                                   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
                                   image_advtab: true ,
                                   external_filemanager_path: BASE_URL + "assets/filemanager/",
                                   filemanager_title: "Media Gallery",
                                   relative_urls : false,
                                   remove_script_host : false,
                                   convert_urls : true,
                                   external_plugins: {"filemanager": BASE_URL + "assets/filemanager/plugin.min.js"}
                                });
                            </script>
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

