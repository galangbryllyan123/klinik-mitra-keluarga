<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col d-flex">
                <h3 class="card-title align-self-center">
                    Tabel <?= $title; ?>
                </h3>
            </div>
            <div class="col text-right">
                <!-- <a href="<?= base_url('pasien/add'); ?>" class="btn btn-info bg-gradient-info">
                    <i class="fas fa-plus"></i> Tambah Data
                </a> -->
                <!-- PDF Laporan -->
                <a href="<?= base_url('laporan/pasien'); ?>" target="_blank" class="btn btn-default bg-gradient-light">
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
                    <th>Nama Pasien</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>Tgl Daftar</th>
                    <th>No Telp</th>
                    <th>No BPJS</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (count((array) $pasien) > 0) : ?>
                    <?php foreach ($pasien as $row) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><a href="<?= base_url('pasien/riwayat/') . $row->idPasien; ?>"><?= $row->namaPasien; ?></a></td>
                            <td><?= $row->NIK ?></td>
                            <td><?= $row->jenisKelamin ?></td>
                            <td><?= date('d-m-Y', strtotime($row->created_at)) ?></td>
                            <td><?= $row->noTelp ?></td>
                            <td><?= $row->noBPJS ?></td>
                            <td><?= $row->alamat ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('pasien/riwayat/') . $row->idPasien; ?>" class="btn btn-default btn-sm">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="<?= base_url('pasien/edit/') . $row->idPasien; ?>" class="btn btn-default btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('pasien/delete/') . $row->idPasien; ?>" class="btn btn-default btn-sm" onclick="return confirm('Yakin ingin hapus?');">
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