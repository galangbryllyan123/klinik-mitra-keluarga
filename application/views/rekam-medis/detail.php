<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= $title; ?></h3>
                <div class="card-tools">
                    <a href="<?= base_url('rekammedis') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm p-0">
                        <table class="w-100 table table-hover">
                            <tr>
                                <th width="150">No. RM</th>
                                <td><?= $detail->idRekamMedis; ?></td>
                            </tr>
                            <tr>
                                <th width="150">Kode Daftar Pasien</th>
                                <td><?= $detail->kodePasien; ?></td>
                            </tr>
                            <tr>
                                <th width="150">Pasien</th>
                                <td><?= $detail->namaPasien; ?></td>
                            </tr>
                            <tr>
                                <th width="150">Poliklinik</th>
                                <td><?= $detail->namaPoliklinik; ?> - <?= $detail->gedung ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-sm p-0">
                        <table class="w-100 table table-hover">
                            <tr>
                                <th width="150">Tanggal Periksa</th>
                                <td><?= indo_date($detail->tglPeriksa); ?></td>
                            </tr>
                            <tr>
                                <th width="150">Dokter</th>
                                <td><?= $detail->namaDokter; ?></td>
                            </tr>
                            <tr>
                                <th width="150">Spesialis</th>
                                <td><?= $detail->spesialis; ?></td>
                            </tr>
                            <tr>
                                <th width="150">Petugas</th>
                                <td><?= $detail->fullName; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <h5>Keluhan Pasien</h5>
                        <p>
                            <?= $detail->keluhan; ?>
                        </p>
                    </div>
                    <div class="col-sm">
                        <h5>Diagnosa</h5>
                        <p>
                            <?= $detail->diagnosa; ?>
                        </p>
                    </div>
                    <div class="col-sm">
                        <h5>Obat</h5>
                        <?php foreach ($obat as $o) : ?>
                            <p><?= $o->namaObat ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <h5>Terapi</h5>
                <p>
                    <?= $detail->terapi; ?>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-4">
        <div class="card card-outline">
            <div class="card-header">
                <h3 class="card-title"> Rincian Biaya</h3>
            </div>
            <div class="card-body">
                <table class="w-100 table-sm table-hover">
                    <tr>
                        <th>Biaya Dokter</th>
                        <td class="text-right">
                            Rp. <?= number_format($detail->biayaDokter, 2, ',', '.'); ?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2">Biaya Obat</th>
                    </tr>
                    <?php foreach ($obat as $o) : ?>
                        <tr>
                            <td>+ <?= $o->namaObat ?></td>
                            <td class="text-right">
                                Rp. <?= number_format($o->harga, 2, ',', '.'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td class="text-right">
                            Rp. <?= number_format($total_harga, 2, ',', '.'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <a target="_blank" href="<?= base_url('laporan/detail_rm/') . $detail->idRekamMedis; ?>" class="btn btn-default btn-sm">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>
</div>