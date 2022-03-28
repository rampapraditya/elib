<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var mode = document.getElementById('mode').value;
        var gambar = $('#gambar').prop('files')[0];
        var ket = tinyMCE.get('ket').getContent();
        
        if(kode === ""){
            alert("Kode berita tidak boleh kosong");
        }else if(judul === ""){
            alert("Judul tidak boleh kosong");
        }else{
            $('#btnSave').text('Loading...');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('mode', mode);
            form_data.append('file', gambar);
            form_data.append('konten', ket);
            
            $.ajax({
                url: "<?php echo base_url(); ?>berita/proses",
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
                    
                    if(response.status === "Berita tersimpan"){
                        window.location.href = "<?php echo base_url(); ?>berita";
                    }else if(response.status === "Berita terupdate"){
                        window.location.href = "<?php echo base_url(); ?>berita";
                    }
                    
                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $mode; ?> BERITA</h4>
                    <div class="forms-sample">
                        <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                        <input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>">
                        
                        <div class="form-group">
                            <label>JUDUL</label>
                            <input id="judul" name="judul" type="text" class="form-control" autocomplete="off" value="<?php echo $judul; ?>">
                        </div>
                        <div class="form-group">
                            <label>THUMBNAIL</label>
                            <input id="gambar" name="gambar" type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>BERITA</label>
                            <textarea class="form-control" id="ket" name="ket"><?php echo $berita; ?></textarea>
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