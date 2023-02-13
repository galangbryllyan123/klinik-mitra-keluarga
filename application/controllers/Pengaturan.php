<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
        $this->form_validation->set_message('numeric', 'Kolom {field} hanya bisa diisi oleh angka');
    }

    public function index()
    {
        is_role(1, true);
        $data['title'] = "Pengaturan";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        $data['pengaturan'] = $this->MainModel->get('pengaturan');
        template_view('pengaturan/data', $data);
    }


    private function _validasi()
    {
        is_role(1, true);
        $this->form_validation->set_rules('site_title', 'Site Title', 'required|trim');
        $this->form_validation->set_rules('nama_rs', 'Nama RS/Klinik', 'required|trim');
    }
 
    public function edit($sId)
    {
        is_role(1, true);
        $id = encode_php_tags($sId);
        $data['title'] = "Edit Pengaturan";
        $data['dataPengaturan'] = $this->MainModel->get_where('pengaturan', ['idPengaturan' => $id]);
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));

        $this->_validasi(false);
        if ($this->form_validation->run() == false) {
            template_view('pengaturan/edit', $data);
        } else {
            if(!empty($_FILES['file_path']['name'])){
                $config = array(
                    'upload_path' => 'assets/images',
                    'allowed_types' => 'png|jpg',
                    'file_name' => $_FILES['file_path']['name'],
                    'remove_space' => TRUE,
                    'max_size' => 50000,
                );
    
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('file_path')){
                    
                    $file = $this->upload->data();

                    //$input = $this->input->post(null, true);
                    $input = array(
                        'site_title' => $this->input->post('site_title'),
                        'site_background' => $config['upload_path']."/".$file['file_name'],
                        'nama_rs' => $this->input->post('nama_rs'),
                        'alamat_rs' => $this->input->post('alamat_rs')
                    );

                    $edit = $this->MainModel->update('pengaturan', $input, ['idPengaturan' => $id]);
                    if ($edit) {
                        msgBox('edit');
                        redirect('pengaturan');
                    } else {
                        msgBox('edit', false);
                        redirect('pengaturan/edit/' . $id);
                    }
                } else {
                    msgBox('edit');
                    redirect('pengaturan');
                }
            } else {
                $input = $this->input->post(null, true);
                $edit = $this->MainModel->update('pengaturan', $input, ['idPengaturan' => $id]);
                if ($edit) {
                    msgBox('edit');
                    redirect('pengaturan');
                } else {
                    msgBox('edit', false);
                    redirect('pengaturan/edit/' . $id);
                }
            }
        }
    }

}
