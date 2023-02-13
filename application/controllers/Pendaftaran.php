<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaran extends CI_Controller
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

    public function index()
    {
        $data['title'] = "Pendaftaran";
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
                    'kode' => $this->input->post('kode', true),
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
                redirect('pendaftaran');
            }
        }
    }
}
