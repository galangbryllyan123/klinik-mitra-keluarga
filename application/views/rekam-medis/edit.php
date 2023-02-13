<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form <?= $title; ?></h3>

                <div class="card-tools">
                    <a href="<?= base_url('rekammedis') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('', '', ['userId' => userdata('idUser')]); ?>
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="form-group">
                    <label for="idRekamMedis">No. Rekam Medis</label>
                    <input readonly value="<?= set_value('idRekamMedis', $rekam_medis->idRekamMedis); ?>" type="text" id="idRekamMedis" class="form-control" placeholder="No. Rekam Medis">
                </div>
                <div class="form-group">
                    <label for="kodePasien">Kode Pasien</label>
                    <input readonly value="<?= $kode->kode ?>" type="text" id="kodePasien" name="kodePasien" class="form-control">
                </div>
                <div class="form-group">
                    <label for="pasienId">Pasien</label>
                    <select name="pasienId" id="pasienId" class="form-control select2">
                        <option value="" selected disabled>Pilih Pasien</option>
                        <?php foreach ($data['pasien'] as $pasien) : ?>
                            <option <?= $rekam_medis->pasienId == $pasien->idPasien ? "selected" : ""; ?> value="<?= $pasien->idPasien ?>"><?= $pasien->namaPasien ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('pasienId'); ?>
                </div>
                <div class="form-group">
                    <label for="keluhan">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" rows="2" class="form-control" placeholder="Keluhan"><?= set_value('keluhan', $rekam_medis->keluhan); ?></textarea>
                    <?= form_error('keluhan'); ?>
                </div>
                <div class="form-group">
                    <label for="dokterNip">Dokter</label>
                    <select name="dokterNip" id="dokterNip" class="form-control select2">
                        <option value="" selected disabled>Pilih Dokter</option>
                        <?php foreach ($data['dokter'] as $dokter) : ?>
                            <option <?= $rekam_medis->dokterNip == $dokter->nip ? "selected" : ""; ?> value="<?= $dokter->nip ?>"><?= $dokter->nip; ?> | <?= $dokter->namaDokter; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('dokterNip'); ?>
                </div>
                <div class="form-group">
                    <label for="diagnosa">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" rows="2" class="form-control" placeholder="Diagnosa"><?= set_value('diagnosa', $rekam_medis->diagnosa); ?></textarea>
                    <?= form_error('diagnosa'); ?>
                </div>
                <div class="form-group">
                    <label for="terapi">Terapi</label>
                    <textarea name="terapi" id="terapi" rows="2" class="form-control" placeholder="Terapi"><?= set_value('terapi', $rekam_medis->terapi); ?></textarea>
                    <?= form_error('terapi'); ?>
                </div>
                <div class="form-group">
                    <label for="idObat">Obat</label>
                    <select multiple name="idObat[]" id="idObat" class="form-control select2">
                        <?php foreach ($data['obat'] as $obat) : ?>
                            <option <?= in_array($obat->idObat, $rm_obat) ? "selected" : ""; ?> value="<?= $obat->idObat ?>"><?= $obat->namaObat; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('idObat'); ?>
                </div>
                <div class="form-group">
                    <label for="poliklinikId">Poliklinik</label>
                    <select name="poliklinikId" id="poliklinikId" class="form-control select2">
                        <option value="" selected disabled>Pilih Poliklinik</option>
                        <?php foreach ($data['poliklinik'] as $poliklinik) : ?>
                            <option <?= $rekam_medis->poliklinikId == $poliklinik->idPoliklinik ? "selected" : ""; ?> value="<?= $poliklinik->idPoliklinik ?>"><?= $poliklinik->namaPoliklinik; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('poliklinikId'); ?>
                </div>
                <div class="form-group">
                    <label for="tglPeriksa">Tanggal Periksa</label>
                    <input value="<?= set_value('tglPeriksa', $rekam_medis->tglPeriksa); ?>" type="text" name="tglPeriksa" id="tglPeriksa" class="form-control gijgo" placeholder="Tanggal Periksa">
                    <?= form_error('tglPeriksa'); ?>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-default bg-gradient-light">Reset</button>
                    <button type="submit" class="btn btn-info bg-gradient-info">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<script>
    $('#pasienId').on('change', function() {
        $.ajax({
            method: 'POST',
            url: '<?= base_url('pasien/getById') ?>',
            dataType: 'json',
            data: {
                id: $(this).val()
            },
            success: function(data) {
                $('#kodePasien').val(data.kode);
            }
        })
    })
</script>