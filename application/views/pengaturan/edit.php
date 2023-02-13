<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form <?= $title; ?></h3>

                <div class="card-tools">
                    <a href="<?= base_url('obat') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open_multipart(); ?>
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="form-group">
                    <label for="site_title">Site Title</label>
                    <input value="<?= set_value('site_title', $dataPengaturan->site_title); ?>" type="text" name="site_title" id="site_title" class="form-control" placeholder="Site Title">
                    <?= form_error('site_title'); ?>
                </div>

                <div class="form-group">
                <label>Site Background</label><br/>
                    <label class="file-upload btn btn-outline-secondary">
                        Cari Berkas... <input type="file" name="file_path">
                    </label>      
                </div>

                <div class="form-group">
                    <label for="nama_rs">Nama RS/Klinik</label>
                    <input value="<?= set_value('nama_rs', $dataPengaturan->nama_rs); ?>" type="text" name="nama_rs" id="nama_rs" class="form-control" placeholder="Nama RS">
                    <?= form_error('nama_rs'); ?>
                </div>

                <div class="form-group">
                    <label for="alamat_rs">Alamat</label>
                    <textarea name="alamat_rs" id="alamat_rs" rows="4" class="form-control" placeholder="Alamat RS/Klinik"><?= set_value('alamat_rs', $dataPengaturan->alamat_rs); ?></textarea>
                    <?= form_error('alamat_rs'); ?>
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