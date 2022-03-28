<script type="text/javascript">
    
    var table;
    
    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>penelitian/ajaxdokumen/<?php echo $kode; ?>",
            ordering: false
        });
    });
    
    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    
    function add() {
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah dokumen');
    }
    
    function save(){
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var dokumen = $('#dokumen').prop('files')[0];
        
        $('#btnSave').text('Loading...');
        $('#btnSave').attr('disabled',true);

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('judul', judul);
        form_data.append('file', dokumen);

        $.ajax({
            url: "<?php echo base_url(); ?>penelitian/proses_dokumen",
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

                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled',false);

            },error: function (response) {
                alert(response.status);

                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled',false);
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function hapus(id, judul) {
        if (confirm("Apakah anda yakin menghapus dokumen penelitian " + judul + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>penelitian/hapusdokumen/" + id,
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
    
    function unduh(kode){
        window.location.href = "<?php echo base_url(); ?>penelitian/unduhfile/"+kode;
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">LIST DOKUMEN</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>JUDUL</label>
                            <input type="text" class="form-control" autocomplete="off" value="<?php echo $judul; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah Dokumen</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>JUDUL</th>
                                    <th style="text-align: center;">Aksi</th>
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
                    <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                    <div class="form-group">
                        <label>JUDUL DOKUMEN</label>
                        <input id="judul" name="judul" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>DOKUMEN (pdf, doc, docx)</label>
                        <input id="dokumen" name="dokumen" class="form-control" type="file">
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