<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var tw = document.getElementById('tw').value;
        var ig = document.getElementById('ig').value;
        var fb = document.getElementById('fb').value;
        var lk = document.getElementById('lk').value;
        
        $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
        $('#btnSave').attr('disabled',true);

        var form_data = new FormData();
        form_data.append('tw', tw);
        form_data.append('ig', ig);
        form_data.append('fb', fb);
        form_data.append('lk', lk);

        $.ajax({
            url: "<?php echo base_url(); ?>medsos/proses",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);

                $('#lama').val("");
                $('#baru').val("");

                $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                $('#btnSave').attr('disabled',false);

            },error: function (response) {
                alert(response.status);

                $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                $('#btnSave').attr('disabled',false);
            }
        });
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MEDIA SOSIAL</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>TWITER</label>
                            <input type="text" class="form-control" autocomplete="off" id="tw" name="tw"  value="<?php echo $tw; ?>" >
                        </div>
                        <div class="form-group">
                            <label>INSTAGRAM</label>
                            <input type="text" class="form-control" autocomplete="off" id="ig" name="ig" value="<?php echo $ig; ?>">
                        </div>
                        <div class="form-group">
                            <label>FACEBOOK</label>
                            <input type="text" class="form-control" autocomplete="off" id="fb" name="fb" value="<?php echo $fb; ?>">
                        </div>
                        <div class="form-group">
                            <label>LINKEDIN</label>
                            <input type="text" class="form-control" autocomplete="off" id="lk" name="lk" value="<?php echo $lk; ?>">
                        </div>
                        
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>