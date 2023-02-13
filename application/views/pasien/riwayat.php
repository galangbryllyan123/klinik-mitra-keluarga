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
        <table class="table table-striped table-sm datatable">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>IdRM</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal</th>
                    <th>Keluhan</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Terapi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (count((array) $riwayat) > 0) : ?>
                    <?php foreach ($riwayat as $row) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><a href="<?= base_url('rekammedis/detail/') . $row->idRekamMedis ?>"><?= $row->idRekamMedis ?></a></td>
                            <td><?= $row->namaPasien ?></td>
                            <td><?= indo_date($row->tglPeriksa) ?></td>
                            <td><?= $row->keluhan ?></td>
                            <td><?= $row->namaDokter ?></td>
                            <td><?= $row->diagnosa ?></td>
                            <td><?= $row->terapi ?></td>
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