<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form <?= $title; ?></h3>

                <div class="card-tools">
                    <a href="<?= base_url('dokter') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open_multipart(); ?>
                <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input value="<?= set_value('nip'); ?>" type="text" name="nip" id="nip" class="form-control" placeholder="NIP">
                    <?= form_error('nip'); ?>
                </div>
                <div class="form-group">
                    <label for="namaDokter">Nama Dokter</label>
                    <input value="<?= set_value('namaDokter'); ?>" type="text" name="namaDokter" id="namaDokter" class="form-control" placeholder="Nama Dokter">
                    <?= form_error('namaDokter'); ?>
                </div>
                <div class="form-group">
                    <label>Foto</label><br />
                    <label class="file-upload btn btn-outline-secondary">
                        Cari Berkas... <input type="file" name="file_path">
                    </label>
                </div>
                <div class="form-group">
                    <label for="spesialis">Spesialis</label>
                    <input value="<?= set_value('spesialis'); ?>" type="text" name="spesialis" id="spesialis" class="form-control" placeholder="Spesialis">
                    <?= form_error('spesialis'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="<?= set_value('email'); ?>" type="text" name="email" id="email" class="form-control" placeholder="Email">
                    <?= form_error('email'); ?>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="4" class="form-control" placeholder="Alamat"><?= set_value('alamat'); ?></textarea>
                    <?= form_error('alamat'); ?>
                </div>
                <div class="form-group">
                    <label for="noTelp">Nomor Telepon</label>
                    <input value="<?= set_value('noTelp'); ?>" type="text" name="noTelp" id="noTelp" class="form-control" placeholder="Nomor Telepon">
                    <?= form_error('noTelp'); ?>
                </div>
                <div class="form-group">
                    <label for="biayaDokter">Biaya Dokter</label>
                    <input value="<?= set_value('biayaDokter'); ?>" type="text" name="biayaDokter" id="biayaDokter" class="form-control" placeholder="Biaya Dokter">
                    <?= form_error('biayaDokter'); ?>
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