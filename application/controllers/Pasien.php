<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya bisa diisi oleh angka');
        $this->form_validation->set_message('valid_email', 'Isi kolom {field} dengan email yang valid');
        $this->form_validation->set_message('is_unique', '%s sudah ada');

        // Jika bukan admin block
        is_role(2, true);
    }

    public function index()
    {
        $data['title'] = "Data Pasien";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        $data['pasien'] = $this->MainModel->get('pasien');
        template_view('pasien/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('namaPasien', 'Nama Pasien', 'required|trim');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('noTelp', 'Nomor Telepon', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('NIK', 'NIK', 'required|is_unique[pasien.NIK]');
        $this->form_validation->set_rules('noBPJS', 'noBPJS', 'required|is_unique[pasien.noBPJS]');
    }

    private function _validasiEdit()
    {
        $id = $this->uri->segment(3);
        $this->form_validation->set_rules('namaPasien', 'Nama Pasien', 'required|trim');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('noTelp', 'Nomor Telepon', 'required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('NIK', 'NIK', 'required|edit_unique[pasien.NIK.idPasien.' . $id . ']');
        $this->form_validation->set_rules('noBPJS', 'noBPJS', 'required|edit_unique[pasien.noBPJS.idPasien.' . $id . ']');
    }

    public function add()
    {
        $data['title'] = "Tambah Data Pasien";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('pasien/add', $data);
        } else {
            $config['upload_path'] = 'assets/images/foto-pasien'; //path folder
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
            $this->upload->initialize($config);
            if (!empty($_FILES['file_path']['name'])) {
                if ($this->upload->do_upload('file_path')) {
                    $file = $this->upload->data();
                    //Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $config['upload_path'] . "/" . $file['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 354;
                    $config['height'] = 472;
                    $config['new_image'] = $config['upload_path'] . "/" . $file['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
                $input = array(
                    'namaPasien' => $this->input->post('namaPasien', true),
                    'foto' => $config['upload_path'] . "/" . $file['file_name'],
                    'NIK' => $this->input->post('NIK', true),
                    'jenisKelamin' => $this->input->post('jenisKelamin', true),
                    'email' => $this->input->post('email', true),
                    'noTelp' => $this->input->post('noTelp', true),
                    'alamat' => $this->input->post('alamat', true),
                    'noBPJS' => $this->input->post('noBPJS', true),
                    'created_at' => date('Y-m-d H:i:s')
                );
            } else {
                $input = $this->input->post(null, true);
            }
            $save = $this->MainModel->insert('pasien', $input);
            if ($save) {
                msgBox('save');
                redirect('pasien');
            } else {
                msgBox('save', false);
                redirect('pasien/add');
            }
        }
    }

    public function edit($pasienId)
    {
        $id = encode_php_tags($pasienId);
        $data['title'] = "Edit Data Pasien";
        $data['pasien'] = $this->MainModel->get_where('pasien', ['idPasien' => $id]);
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        $this->_validasiEdit();
        if ($this->form_validation->run() == false) {
            template_view('pasien/edit', $data);
        } else {
            $config['upload_path'] = 'assets/images/foto-pasien'; //path folder
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
            $this->upload->initialize($config);
            if (!empty($_FILES['file_path']['name'])) {
                if ($this->upload->do_upload('file_path')) {
                    $file = $this->upload->data();
                    //Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $config['upload_path'] . "/" . $file['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 354;
                    $config['height'] = 472;
                    $config['new_image'] = $config['upload_path'] . "/" . $file['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
                $input = array(
                    'namaPasien' => $this->input->post('namaPasien', true),
                    'foto' => $config['upload_path'] . "/" . $file['file_name'],
                    'NIK' => $this->input->post('NIK', true),
                    'jenisKelamin' => $this->input->post('jenisKelamin', true),
                    'email' => $this->input->post('email', true),
                    'noTelp' => $this->input->post('noTelp', true),
                    'alamat' => $this->input->post('alamat', true),
                    'noBPJS' => $this->input->post('noBPJS', true),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            } else {
                $input = $this->input->post(null, true);
            }
            $edit = $this->MainModel->update('pasien', $input, ['idPasien' => $id]);
            if ($edit) {
                msgBox('edit');
                redirect('pasien');
            } else {
                msgBox('edit', false);
                redirect('pasien/edit/' . $pasienId);
            }
        }
    }

    public function delete($pasienId)
    {
        $id = encode_php_tags($pasienId);
        $del = $this->MainModel->delete('pasien', ['idPasien' => $id]);
        if ($del) {
            msgBox('delete');
        } else {
            msgBox('delete', false);
        }
        redirect('pasien');
    }

    public function getById()
    {
        $id = $this->input->post('id');
        $data = $this->MainModel->get_where('pasien', ['idPasien' => $id]);
        echo json_encode($data);
    }

    public function riwayat($pasienId)
    {
        $id = encode_php_tags($pasienId);
        $whereId = ['idPasien' => $id];
        $data['title']  = "Riwayat Rekam Medis";
        $data['riwayat'] = $this->MainModel->getRiwayatMedis($whereId);
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        //var_dump($data);
        //die;
        template_view('pasien/riwayat', $data);
    }
}
