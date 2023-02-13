<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form <?= $title; ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open(); ?>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <div class="input-group">
                        <input value="<?= set_value('tanggal', date('Y-m-d')); ?>" type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                        </div>
                    </div>
                    <?= form_error('tanggal'); ?>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-default bg-gradient-light">Reset</button>
                    <button type="submit" class="btn btn-info bg-gradient-info">Cetak</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>