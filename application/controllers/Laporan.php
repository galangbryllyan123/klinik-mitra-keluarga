<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('pdf');

        // Jika bukan admin block
        is_role(2, true);
    }

    public function index()
    {
        $data['title'] = "Cetak Laporan Rekam Medis";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya bisa diisi oleh angka');

        if ($this->form_validation->run() == false) {
            template_view('laporan/index', $data);
        } else {
            $input  = $this->input->post(null, true);
            $tgl    = explode(' - ', $input['tanggal']);
            $tgl1   = date('Y-m-d', strtotime($tgl[0]));
            $tgl2   = date('Y-m-d', strtotime(end($tgl)));

            $this->rekammedis($tgl1, $tgl2);
        }
    }

    public function pasien()
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 14);
        // mencetak string 
        $pdf->Cell(190, 7, 'Data Pasien', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'Nama Pasien', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jenis Kelamin', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Email', 1, 0, 'C');
        $pdf->Cell(20, 6, 'No Telpon', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Alamat', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Tgl Daftar', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 9);
        $pasien = $this->MainModel->get('pasien');
        foreach ($pasien as $row) {
            $pdf->Cell(30, 6, ellipsis($row->namaPasien, 18), 1, 0, 'L');
            $pdf->Cell(30, 6, $row->jenisKelamin, 1, 0, 'L');
            $pdf->Cell(40, 6, ellipsis($row->email, 25), 1, 0, 'L');
            $pdf->Cell(20, 6, $row->noTelp, 1, 0, 'C');
            $pdf->Cell(30, 6, ellipsis($row->alamat, 18), 1, 0, 'L');
            $pdf->Cell(30, 6, date('d-m-Y', strtotime($row->created_at)), 1, 1, 'C');
        }
        $pdf->Output();
    }

    public function dokter()
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'Data Dokter', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 6, 'NIP', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama Dokter', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Spesialis', 1, 0, 'C');
        $pdf->Cell(30, 6, 'No Telpon', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Alamat', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $dokter = $this->MainModel->get('dokter');
        foreach ($dokter as $row) {
            $pdf->Cell(40, 6, $row->nip, 1, 0, 'C');
            $pdf->Cell(50, 6, ellipsis($row->namaDokter, 25), 1, 0, 'L');
            $pdf->Cell(35, 6, $row->spesialis, 1, 0, 'L');
            $pdf->Cell(30, 6, $row->noTelp, 1, 0, 'C');
            $pdf->Cell(35, 6, ellipsis($row->alamat, 15), 1, 1, 'L');
        }
        $pdf->Output();
    }

    public function obat()
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'Data Obat', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 6, 'Nama Obat', 1, 0, 'C');
        $pdf->Cell(90, 6, 'Keterangan', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Harga', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $obat = $this->MainModel->get('obat');
        foreach ($obat as $row) {
            $pdf->Cell(50, 6, $row->namaObat, 1, 0, 'L');
            $pdf->Cell(90, 6, ellipsis($row->keterangan, 40), 1, 0, 'L');
            $pdf->Cell(50, 6, "Rp. " . number_format($row->harga, 0, ',', '.'), 1, 1, 'R');
        }
        $pdf->Output();
    }

    public function poliklinik()
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'Data Poliklinik', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(120, 6, 'Nama Poliklinik', 1, 0, 'C');
        $pdf->Cell(70, 6, 'Gedung', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $poliklinik = $this->MainModel->get('poliklinik');
        foreach ($poliklinik as $row) {
            $pdf->Cell(120, 6, $row->namaPoliklinik, 1, 0, 'L');
            $pdf->Cell(70, 6, $row->gedung, 1, 1, 'L');
        }
        $pdf->Output();
    }

    public function rekammedis($tgl1 = null, $tgl2 = null)
    {
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(0, 7, 'Data Rekam Medis', 0, 1, 'C');
        // Periode
        if ($tgl1 != null && $tgl2 != null) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, indo_date($tgl1) . ' - ' . indo_date($tgl2), 0, 1, 'C');
        } else {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, "Semua Data", 0, 1, 'C');
        }

        $pdf->SetFont('Arial', 'B', 12);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(33, 7, 'No. RM', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Nama Pasien', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Keluhan', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Diagnosis', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Terapi', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Nama Dokter', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Tgl. Periksa', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $this->db->select('*');
        $this->db->from('rekam_medis');
        $this->db->join('pasien', 'pasien.idPasien=rekam_medis.pasienId');
        $this->db->join('dokter', 'dokter.nip=rekam_medis.dokterNip');
        if ($tgl1 != null && $tgl2 != null) {
            $this->db->where('tglPeriksa' . ' >=', $tgl1);
            $this->db->where('tglPeriksa' . ' <=', $tgl2);
        }
        $rekam_medis = $this->db->get()->result();
        foreach ($rekam_medis as $row) {
            $pdf->Cell(33, 7, $row->idRekamMedis, 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis($row->namaPasien, 20), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis($row->keluhan, 22), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis($row->diagnosa, 22), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis($row->terapi, 22), 1, 0, 'L');
            $pdf->Cell(40, 7, ellipsis($row->namaDokter, 25), 1, 0, 'L');
            $pdf->Cell(25, 7, custom_date('d-m-Y', $row->tglPeriksa), 1, 1, 'C');
        }
        $pdf->Output();
    }

    public function transaksi()
    {
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(0, 7, 'Data Transaksi', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 7, 'Tgl. Periksa', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Nama Pasien', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Nama Dokter', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Biaya Dokter', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Obat', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Biaya Obat', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $this->db->select('*');
        $this->db->from('rekam_medis');
        $this->db->join('pasien', 'pasien.idPasien=rekam_medis.pasienId');
        $this->db->join('dokter', 'dokter.nip=rekam_medis.dokterNip');
        $rekam_medis = $this->db->get()->result();
        foreach ($rekam_medis as $row) {
            $str = '';
            $biaya_obat = 0;
            $this->db->join('obat o', 'o.idObat=ro.idObat');
            $obat = $this->db->get_where('rm_obat ro', ['ro.idRekamMedis' => $row->idRekamMedis])->result();
            foreach ($obat as $o) {
                $str .= $o->namaObat . ', ';
                $biaya_obat += $o->harga;
            }
            $pdf->Cell(25, 7, custom_date('d-m-Y', $row->tglPeriksa), 1, 0, 'L');
            $pdf->Cell(30, 7, ellipsis($row->namaPasien, 20), 1, 0, 'L');
            $pdf->Cell(55, 7, ellipsis($row->namaDokter, 25), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis('Rp. ' . number_format($row->biayaDokter, 0, ',', '.'), 22), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis(rtrim($str, ", "), 22), 1, 0, 'L');
            $pdf->Cell(45, 7, ellipsis('Rp. ' . number_format($biaya_obat, 0, ',', '.'), 22), 1, 0, 'L');
            $pdf->Cell(25, 7, 'Rp. ' . number_format($biaya_obat + $row->biayaDokter, 0, ',', '.'), 1, 1, 'C');
        }
        $pdf->Output();
    }

    public function detail_rm($id)
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'Detail Rekam Medis', 0, 1, 'C');

        $whereId = ['idRekamMedis' => $id];
        $detail = $this->MainModel->getRekamMedis($whereId);
        $obat = $this->MainModel->getObatRM($whereId)->result();

        $pdf->Ln(5);

        $image1 = FCPATH . $detail->foto;
        if ($detail->foto != null && file_exists($image1)) :
            $pdf->Cell(0, 40, $pdf->Image($image1, 92, 22, 25.50), 0, 1, 'C', false);
        endif;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "No. Rekam Medis", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, $detail->idRekamMedis, 1, 0, 'R');
        $pdf->Cell(10, 7, '', 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "Tanggal Periksa", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, indo_date($detail->tglPeriksa), 1, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "Pasien", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, $detail->namaPasien, 1, 0, 'R');
        $pdf->Cell(10, 7, '', 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "Dokter", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, ellipsis($detail->namaDokter, 25), 1, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "Poliklinik", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, $detail->namaPoliklinik . ' - ' . $detail->gedung, 1, 0, 'R');
        $pdf->Cell(10, 7, '', 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 7, "Petugas", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 7, $detail->fullName, 1, 1, 'R');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, "Keluhan", 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(190, 7, $detail->keluhan, 1, 'J');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, "Diagnosa", 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(190, 7, $detail->diagnosa, 1, 'J');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 7, "Rincian Biaya", 0, 1, 'C');

        $pdf->Ln(5);

        $biaya_dokter = $detail->biayaDokter;
        $total_obat = $this->MainModel->sumObat($whereId);
        $total_harga = $biaya_dokter + $total_obat;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(110, 7, "Biaya Dokter", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 7, 'Rp. ' . number_format($biaya_dokter, 2, ',', '.'), 1, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, "Biaya Obat", 1, 1);

        $pdf->SetFont('Arial', '', 10);
        foreach ($obat as $o) {
            $pdf->Cell(110, 7, "+ " . $o->namaObat, 1, 0);
            $pdf->Cell(80, 7, 'Rp. ' . number_format($o->harga, 2, ',', '.'), 1, 1, 'R');
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(110, 7, "Total Harga", 1, 0);
        $pdf->Cell(80, 7, 'Rp. ' . number_format($total_harga, 2, ',', '.'), 1, 1, 'R');

        $pdf->Output();
    }
}
