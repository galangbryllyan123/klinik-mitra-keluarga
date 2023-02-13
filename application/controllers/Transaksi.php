<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        is_role(2, true);
    }

    public function index()
    {
        $data['title'] = "Transaksi";
        $data['setting'] = $this->MainModel->get_where('pengaturan', array('idPengaturan' => '1'));
        $data['rekam_medis'] = $this->MainModel->getRekamMedis();
        template_view('transaksi/index', $data);
    }
}
