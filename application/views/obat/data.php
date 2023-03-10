<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col d-flex">
                <h3 class="card-title align-self-center">
                    Tabel <?= $title; ?>
                </h3>
            </div>
            <div class="col text-right">
                <a href="<?= base_url('obat/add'); ?>" class="btn btn-info bg-gradient-info">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <!-- PDF Laporan -->
                <a href="<?= base_url('laporan/obat'); ?>" target="_blank" class="btn btn-default bg-gradient-light">
                    <i class="fas fa-print"></i> Laporan
                </a>
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped table-sm datatable">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama Obat</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (count((array) $obat) > 0) : ?>
                    <?php foreach ($obat as $row) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $row->namaObat ?></td>
                            <td>Rp. <?= number_format($row->harga, '0', ',', '.'); ?></td>
                            <td><?= $row->stok ?></td>
                            <td><?= $row->keterangan ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('obat/edit/') . $row->idObat; ?>" class="btn btn-default btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('obat/delete/') . $row->idObat; ?>" class="btn btn-default btn-sm" onclick="return confirm('Yakin ingin hapus?');">
                                        <i class="fas fa-trash-alt text-danger"></i>
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