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
                <?= form_open(); ?>
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s'); ?>">
                <div class="form-group">
                    <label for="namaObat">Nama Obat</label>
                    <input value="<?= set_value('namaObat', $obat->namaObat); ?>" type="text" name="namaObat" id="namaObat" class="form-control" placeholder="Nama Obat">
                    <?= form_error('namaObat'); ?>
                </div>
                <div class="form-group">
                    <label for="harga">Harga Obat</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input value="<?= set_value('harga', $obat->harga); ?>" type="text" name="harga" id="harga" class="form-control" placeholder="Harga Obat">
                    </div>
                    <?= form_error('harga'); ?>
                </div>
                <div class="form-group">
                    <label for="stok">Stok Obat</label>
                    <input value="<?= set_value('stok', $obat->stok); ?>" type="text" name="stok" id="stok" class="form-control" placeholder="Stok Obat">
                    <?= form_error('stok'); ?>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="4" class="form-control" placeholder="Keterangan"><?= set_value('keterangan', $obat->keterangan); ?></textarea>
                    <?= form_error('keterangan'); ?>
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