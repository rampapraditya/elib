<script type="text/javascript">
    
    var tb_slider;
    var save_method = "";
    
    $(document).ready(function() {
        getdata();
        
        tb_slider = $('#tb_slider').DataTable({
            ajax: "<?php echo base_url(); ?>/about/ajaxslider",
            ordering: false
        });
        
    });
    
    function reload_slider() {
        tb_slider.ajax.reload(null, false);
    }
    
    function save(){
        var pesan = document.getElementById('pesan').value;
        
        if(pesan === ""){
            alert("Pesan tidak boleh kosong");
        }else{
            $('#btnSave').text('Loading...');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('pesan', pesan);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/about/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    getdata();
                    
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled',false);

                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
    function getdata(){
        $.ajax({
            url: "<?php echo base_url(); ?>/about/loaddata",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#pesan').val(data.pesan);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function add_slider(){
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah slider');
    }
    
    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti slider');
        $.ajax({
            url: "<?php echo base_url(); ?>/about/showslider/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idslider_tentang);
                $('[name="judul"]').val(data.judul);
                $('[name="keterangan"]').val(data.keterangan);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function save_slider(){
        $('#btnSaveSlider').text('Loading...');
        $('#btnSaveSlider').attr('disabled',true);

        var form_data = new FormData();
        form_data.append('kode', document.getElementById('kode').value);
        form_data.append('file', $('#file').prop('files')[0]);
        form_data.append('judul', document.getElementById('judul').value);
        form_data.append('ket', document.getElementById('keterangan').value);
        
        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>/about/simpan_slider";
        } else {
            url = "<?php echo base_url(); ?>/about/ganti_slider";
        }
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);
                reload_slider();
                $('#modal_form').modal('hide');
                $('#btnSaveSlider').text('Simpan');
                $('#btnSaveSlider').attr('disabled',false);

            },error: function (response) {
                alert(response.status);

                $('#btnSaveSlider').text('Simpan');
                $('#btnSaveSlider').attr('disabled',false);
            }
        });
    }
    
    function hapus(id, no) {
        if (confirm("Apakah anda yakin menghapus slider nomor " + no + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/about/hapusslider/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload_slider();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">ABOUT</h4>
                    <textarea class="form-control" id="pesan" name="pesan" rows="10"></textarea>
                    <button style="margin-top: 20px;" id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                </div>
            </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card" style="margin: 20px;">
                <div class="card-body">
                    <h4 class="card-title">THUMBNAIL</h4>
                    <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            for($i = 0; $i < $jmlslider; $i++){
                                ?>
                            <li data-target="#carousel-example-2" data-slide-to="<?php echo $i; ?>" <?php if($i == 0){ echo 'class="active"'; } ?>></li>
                                <?php
                            }
                            ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $counter = 0;
                            foreach ($slider->getResult() as $row) {
                                ?>
                            <div class="carousel-item <?php if($counter == 0){ echo 'active'; } ?>">
                                <div class="view">
                                    <img class="d-block w-100" src="<?php echo base_url().substr($row->path, 2) ?>" alt="Slide">
                                    <div class="mask rgba-black-light"></div>
                                </div>
                                <div class="carousel-caption">
                                    <h3 class="h3-responsive" style="color: black;"><?php echo $row->judul; ?></h3>
                                    <p style="color: black;"><?php echo $row->keterangan; ?></p>
                                </div>
                            </div>
                                <?php
                                $counter++;
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" onclick="add_slider();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload_slider();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb_slider" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>GAMBAR</th>
                                    <th>JUDUL</th>
                                    <th>KETERANGAN</th>
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="kode" id="kode">
                    <div class="form-group">
                        <label>File</label>
                        <input id="file" name="file" class="form-control" type="file" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" id="judul" name="judul" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSaveSlider" type="button" class="btn btn-primary" onclick="save_slider();">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closemodal();">Close</button>
            </div>
        </div>
    </div>
</div>