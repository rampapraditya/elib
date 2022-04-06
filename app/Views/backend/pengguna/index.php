<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/siswa/ajaxlist",
            ordering: false
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah peneliti');
        $('[name="nrp"]').attr("readonly", false);
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var email = document.getElementById('email').value;
        var korps = document.getElementById('korps').value;
        var pangkat = document.getElementById('pangkat').value;
        var pass = document.getElementById('pass').value;
        var foto = $('#foto').prop('files')[0];
        
        if (nrp === '') {
            alert("NRP tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama peneliti tidak boleh kosong");
        }else if(email === ""){
            alert("Email tidak boleh kosong");
        }else if(korps === "-"){
            alert("Pilih korps terlebih dahulu");
        }else if(pangkat === "-"){
            alert("Pilih pangkat terlebih dahulu");
        } else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/siswa/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/siswa/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nrp', nrp);
            form_data.append('nama', nama);
            form_data.append('email', email);
            form_data.append('korps', korps);
            form_data.append('pangkat', pangkat);
            form_data.append('file', foto);
            form_data.append('pass', pass);
            
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
                    $('#modal_form').modal('hide');
                    reload();
                    
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled',false);

                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus peneliti " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/siswa/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti peneliti');
        $('[name="nrp"]').attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url(); ?>/siswa/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsiswa);
                $('[name="nrp"]').val(data.nrp);
                $('[name="nama"]').val(data.nama);
                $('[name="email"]').val(data.email);
                $('[name="pangkat"]').val(data.idpangkat);
                $('[name="korps"]').val(data.idkorps);
                $('[name="angkatan"]').val(data.angkatan);
                $('[name="pass"]').val(data.pass);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MASTER PENGGUNA / USER</h4>
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NRP</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>KORPS</th>
                                    <th>PASSWORD</th>
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
                        <label>NRP</label>
                        <input id="nrp" name="nrp" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>PASSWORD</label>
                        <input id="pass" name="pass" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>NAMA PERSONIL</label>
                        <input id="nama" name="nama" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input id="email" name="email" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>KORPS</label>
                        <select id="korps" name="korps" class="form-control">
                            <option value="-">- Pilih Korps -</option>
                            <?php
                            foreach ($korps->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>PANGKAT</label>
                        <select id="pangkat" name="pangkat" class="form-control">
                            <option value="-">- Pilih Pangkat -</option>
                            <?php
                            foreach ($pangkat->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>FOTO</label>
                        <input id="foto" name="foto" class="form-control" type="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closemodal();">Close</button>
            </div>
        </div>
    </div>
</div>