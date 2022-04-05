<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var tgllahir = document.getElementById('tgllahir').value;
        var agama = document.getElementById('agama').value;
        var kota = document.getElementById('kota').value;
        var satker = document.getElementById('satker').value;
        var korps = document.getElementById('korps').value;
        var pangkat = document.getElementById('pangkat').value;
        
        if(nrp === ""){
            alert("NRP tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else if(korps === "-"){
            alert("Pilih korps terlebih dahulu");
        }else if(pangkat === "-"){
            alert("Pilih pangkat terlebih dahulu");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nrp', nrp);
            form_data.append('nama', nama);
            form_data.append('tgllahir', tgllahir);
            form_data.append('agama', agama);
            form_data.append('kota', kota);
            form_data.append('satker', satker);
            form_data.append('korps', korps);
            form_data.append('pangkat', pangkat);
            
            
            $.ajax({
                url: "<?php echo base_url(); ?>/profile/proses",
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
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">PROFILE</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>NRP</label>
                            <input id="nrp" name="nrp" type="text" class="form-control" autocomplete="off" value="<?php echo $tersimpan->nrp; ?>">
                        </div>
                        <div class="form-group">
                            <label>NAMA PERSONIL</label>
                            <input id="nama" name="nama" type="text" class="form-control" autocomplete="off" value="<?php echo $tersimpan->nama; ?>">
                        </div>
                        <div class="form-group">
                            <label>TANGGAL LAHIR</label>
                            <input id="tgllahir" name="tgllahir" type="date" class="form-control" autocomplete="off" value="<?php echo $tersimpan->tgl_lahir; ?>">
                        </div>
                        <div class="form-group">
                            <label>AGAMA</label>
                            <select id="agama" name="agama" class="form-control">
                                <option value="-">- Pilih Agama -</option>
                                <option <?php if($tersimpan->agama == "Islam"){ echo 'selected'; } ?> value="Islam">Islam</option>
                                <option <?php if($tersimpan->agama == "Kristen"){ echo 'selected'; } ?> value="Kristen">Kristen</option>
                                <option <?php if($tersimpan->agama == "Katholik"){ echo 'selected'; } ?> value="Katholik">Katholik</option>
                                <option <?php if($tersimpan->agama == "Hindu"){ echo 'selected'; } ?> value="Hindu">Hindu</option>
                                <option <?php if($tersimpan->agama == "Budha"){ echo 'selected'; } ?> value="Budha">Budha</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>KOTA ASAL</label>
                            <input type="text" class="form-control" id="kota" name="kota" autocomplete="off" value="<?php echo $tersimpan->kota_asal; ?>">
                        </div>
                        <div class="form-group">
                            <label>SATUAN KERJA</label>
                            <input type="text" class="form-control" id="satker" name="satker" autocomplete="off" value="<?php echo $tersimpan->satuan_kerja; ?>">
                        </div>
                        <div class="form-group">
                            <label>KORPS</label>
                            <select id="korps" name="korps" class="form-control">
                                <option value="-">- Pilih Korps -</option>
                                <?php
                                 foreach ($korps->getResult() as $row) {
                                     ?>
                                <option <?php if($row->idkorps == $tersimpan->idkorps){ echo 'selected'; } ?>  value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
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
                                <option <?php if($row->idpangkat == $tersimpan->idpangkat){ echo 'selected'; } ?>  value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                     <?php
                                 }
                                ?>
                            </select>
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>