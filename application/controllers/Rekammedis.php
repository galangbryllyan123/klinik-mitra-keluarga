<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekammedis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya bisa diisi oleh angka');

        // Jika bukan admin block
        is_role(2, true);
    }

    public function index()
    {
        $data['title'] = "Data Rekam Medis";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        $data['rekam_medis'] = $this->MainModel->getRekamMedis();
        template_view('rekam-medis/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('pasienId', 'Pasien', 'required');
        $this->form_validation->set_rules('dokterNip', 'Dokter', 'required');
        $this->form_validation->set_rules('idObat[]', 'Obat', 'required');
        $this->form_validation->set_rules('poliklinikId', 'Poliklinik', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required|trim');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required|trim');
        $this->form_validation->set_rules('tglPeriksa', 'tglPeriksa', 'required|trim');
    }

    private function _generateId()
    {
        // RM2021010100001
        $char = "RM";
        $table = "rekam_medis";
        $field = "idRekamMedis";
        $today = date('Ymd');

        $prefix = $char . $today;

        $lastKode = $this->MainModel->getId($prefix, $table, $field);
        $noUrut = (int) substr($lastKode, -5, 5);
        $noUrut++;

        $newKode = $char . $today . sprintf('%05s', $noUrut);
        return $newKode;
    }

    public function add()
    {
        $data['title'] = "Tambah Rekam Medis";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        $data['idRekamMedis'] = $this->_generateId();

        $data['data'] = [];
        $tables = ['pasien', 'dokter', 'poliklinik'];
        foreach ($tables as $table) {
            $data['data'][$table] = $this->MainModel->get($table);
        }

        $tbObat = ['obat'];
        foreach ($tbObat as $table) {
            $data['data'][$table] = $this->MainModel->getWhere($table, ['stok >' => 0]);
        }

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('rekam-medis/add', $data);
        } else {
            // Simpan ke tabel rekam medis
            $input = $this->input->post(null, true);
            unset($input['idObat']);
            $this->MainModel->insert('rekam_medis', $input);

            // Simpan ke tabel rm_obat
            $id_obat = $this->input->post('idObat', true);
            $obat = [];
            foreach ($id_obat as $id) {
                $obat[] = [
                    'idRekamMedis' => $input['idRekamMedis'],
                    'idObat' => $id
                ];
            }
            $this->MainModel->insert_batch('rm_obat', $obat);
            msgBox('save');
            redirect('rekammedis');
        }
    }

    public function edit($rmId)
    {
        $id = encode_php_tags($rmId);
        $whereId = ['idRekamMedis' => $id];
        $data['title'] = "Edit Rekam Medis";
        $data['rekam_medis'] = $this->MainModel->getRekamMedis($whereId);
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        // Get Selected Obat
        $rm_obat = $this->MainModel->get_where('rm_obat', $whereId, true)->result_array();
        $data['rm_obat'] = [];
        foreach ($rm_obat as $rmo) {
            $data['rm_obat'][] = $rmo['idObat'];
        }

        // Get all master data
        $data['data'] = [];
        $tables = ['pasien', 'dokter', 'obat', 'poliklinik'];
        foreach ($tables as $table) {
            $data['data'][$table] = $this->MainModel->get($table);
        }

        $tbObat = ['obat'];
        foreach ($tbObat as $table) {
            $data['data'][$table] = $this->MainModel->get_where($table, ['stok >' => 0]);
        }


        // Get Kode Pasien
        $data['kode'] = $this->MainModel->get_where('pasien', ['idPasien' => $data['rekam_medis']->pasienId]);

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('rekam-medis/edit', $data);
        } else {
            // Simpan ke tabel rekam medis
            $input = $this->input->post(null, true);
            unset($input['idObat']);

            $this->MainModel->update('rekam_medis', $input, $whereId);

            // Hapus obat rekam medis berdasarkan id rekam medis
            $this->MainModel->delete('rm_obat', $whereId);

            // Simpan ke tabel rm_obat
            $id_obat = $this->input->post('idObat', true);

            // Cari stok obat
            $qstok = $this->db->query('select * from obat where idObat in (' . implode(', ', $id_obat) . ')')->result_array();
            foreach ($qstok as $row) {
                $cstok = $row['stok'];
            }

            $stok = [];
            foreach ($id_obat as $idObat) {
                $jumlah = 1;
                $stok[] = [
                    'idObat' => $idObat,
                    'stok' => $cstok - $jumlah
                ];
            }
            $this->MainModel->update_batch('obat', $stok, 'idObat');

            $obat = [];
            foreach ($id_obat as $idObat) {
                $jumlah = 1;
                $obat[] = [
                    'idRekamMedis' => $id,
                    'idObat' => $idObat,
                    'jumlah' => $jumlah
                ];
            }
            $this->MainModel->insert_batch('rm_obat', $obat);
            msgBox('edit');
            redirect('rekammedis');
        }
    }

    public function delete($rmId)
    {
        $id = encode_php_tags($rmId);
        $del = $this->MainModel->delete('rekam_medis', ['idRekamMedis' => $id]);
        if ($del) {
            msgBox('delete');
        } else {
            msgBox('delete', false);
        }
        redirect('rekammedis');
    }

    public function detail($rmId)
    {
        $id = encode_php_tags($rmId);
        $whereId = ['idRekamMedis' => $id];
        $data['title']  = "Detail Rekam Medis";
        $data['detail'] = $this->MainModel->getRekamMedis($whereId);
        $data['obat']   = $this->MainModel->getObatRM($whereId)->result();
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        // Rincian Biaya
        $data['biaya_dokter'] = $data['detail']->biayaDokter;
        $total_obat = $this->MainModel->sumObat($whereId);
        $data['total_harga'] = $total_obat + $data['biaya_dokter'];

        template_view('rekam-medis/detail', $data);
    }
}
