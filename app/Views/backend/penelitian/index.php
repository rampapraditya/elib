<script type="text/javascript">

    var table;
    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/penelitian/ajaxlist",
            ordering: false
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function add() {
        window.location.href = "<?php echo base_url(); ?>/penelitian/detil";
    }
    
    function ganti(id) {
        window.location.href = "<?php echo base_url(); ?>/penelitian/detil/" + id;
    }
    
    function doc(id){
        window.location.href = "<?php echo base_url(); ?>/penelitian/dokumen/" + id;
    }

    function hapus(id, judul, nama) {
        if (confirm("Apakah anda yakin menghapus penelitian " + judul + " oleh " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/penelitian/hapus/" + id,
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
    
</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MAINTENANCE BUKU / PENELITIAN</h4>
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>TANGGAL</th>
                                    <th>JUDUL</th>
                                    <th>TAHUN</th>
                                    <th>KATEGORI</th>
                                    <th>SUB KATEGORI</th>
                                    <th>STRATA</th>
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