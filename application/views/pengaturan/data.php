<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col d-flex">
                <h3 class="card-title align-self-center">
                    Tabel <?= $title; ?>
                </h3>
            </div>
            <div class="col text-right">
                
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Site Title</th>
                    <th>Site Background</th>
                    <th>Nama RS</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead> 
            <tbody>
                <?php
                $no = 1;
                if (count((array) $pengaturan) > 0) : ?>
                    <?php foreach ($pengaturan as $row) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $row->site_title ?></td>
                            <td><img src="<?=base_url()?><?= $row->site_background ?>" width="80"></td>
                            <td><?= $row->nama_rs ?></td>
                            <td><?= $row->alamat_rs ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('pengaturan/edit/') . $row->idPengaturan; ?>" class="btn btn-default btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Data Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>