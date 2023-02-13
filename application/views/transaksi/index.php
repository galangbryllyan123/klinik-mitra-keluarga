<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col d-flex">
                <h3 class="card-title align-self-center">
                    Tabel <?= $title; ?>
                </h3>
            </div>
            <div class="col text-right">
                <!-- PDF Laporan -->
                <a href="<?= base_url('laporan/transaksi'); ?>" target="_blank" class="btn btn-default">
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
                    <th>Tanggal Periksa</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Biaya Dokter</th>
                    <th>Obat</th>
                    <th>Biaya Obat</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (count((array) $rekam_medis) > 0) : ?>
                    <?php foreach ($rekam_medis as $row) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= indo_date($row->tglPeriksa); ?></td>
                            <td><a href="<?= base_url('pasien/riwayat/') . $row->idPasien; ?>"><?= $row->namaPasien; ?></a></td>
                            <td><?= $row->namaDokter ?></td>
                            <td>Rp. <?= number_format($row->biayaDokter, 2, ',', '.'); ?></td>
                            <td>
                                <?php
                                $str = '';
                                $biaya_obat = 0;
                                $this->db->join('obat o', 'o.idObat=ro.idObat');
                                $obat = $this->db->get_where('rm_obat ro', ['ro.idRekamMedis' => $row->idRekamMedis])->result();
                                foreach ($obat as $o) {
                                    $str .= $o->namaObat . ', ';
                                    $biaya_obat += $o->harga;
                                }
                                echo rtrim($str, ", ");
                                ?>
                            </td>
                            <td>Rp. <?= number_format($biaya_obat, 2, ',', '.'); ?></td>
                            <td>Rp. <?= number_format($biaya_obat + $row->biayaDokter, 2, ',', '.'); ?></td>
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