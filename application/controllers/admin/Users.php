<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->model('user_level_model');
        $this->load->model('Cabang_model');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', true));
        $start = intval($this->uri->segment(3));

        if ($q != '') {
            $config['base_url'] = base_url() . '.php/admin/users/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/admin/users/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/admin/users/index/';
            $config['first_url'] = base_url() . 'index.php/admin/users/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = false;
        $config['total_rows'] = $this->Users_model->total_rows($q);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = [
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        ];
        $this->template->load('template', 'admin/users/users_list', $data);
    }

    public function read($id)
    {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = [
                'id_username' => $row->id_username,
                'username' => $row->username,
                'nama' => $row->nama,
                'email' => $row->email,
                'telepon' => $row->telepon,
                'id_level' => $row->id_level,
                'is_aktive' => $row->is_aktive,
                'create_date' => $row->create_date,
            ];
            $this->template->load('template', 'admin/users/users_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/users'));
        }
    }

    public function create()
    {
        $data = [
            'button' => 'Create',
            'action' => site_url('admin/users/create_action'),
            'id_username' => set_value('id_username'),
            'username' => set_value('username'),
            'password' => set_value('password'),
            'nama' => set_value('nama'),
            'email' => set_value('email'),
            'telepon' => set_value('telepon'),
            'id_level' => set_value('id_level'),
            'is_aktive' => set_value('is_aktive'),
            'create_date' => set_value('create_date'),
        ];
        $data['coba'] = $this->user_level_model->tampil_level();
        $data['cabang'] = $this->Cabang_model->tampil_cabang();
        $this->template->load('template', 'admin/users/users_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = [
                'username' => $this->input->post('username', true),
                // 'password' => $this->input->post('password',TRUE),
                'password' => md5($this->input->post('password', true)),
                'nama' => $this->input->post('nama', true),
                'email' => $this->input->post('email', true),
                'telepon' => $this->input->post('telepon', true),
                'id_level' => $this->input->post('id_level', true),
                'id_cabang' => $this->input->post('id_cabang', true),
                'is_aktive' => $this->input->post('is_aktive', true),
                'create_date' => date('y-m-d H:i:s'),
            ];

            $this->Users_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('admin/users'));
        }
    }

    public function update($id)
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $data = [
                'button' => 'Update',
                'action' => site_url('admin/users/update_action'),
                'id_username' => set_value('id_username', $row->id_username),
                'username' => set_value('username', $row->username),
                'password' => set_value('password', $row->password),
                'nama' => set_value('nama', $row->nama),
                'email' => set_value('email', $row->email),
                'telepon' => set_value('telepon', $row->telepon),
                'id_level' => set_value('id_level', $row->id_level),
                'id_cabang' => set_value('id_cabang', $row->id_cabang),
                'is_aktive' => set_value('is_aktive', $row->is_aktive),
                'create_date' => set_value('create_date', $row->create_date),
            ];
            $data['coba'] = $this->user_level_model->tampil_level();
            $data['data_user'] = $this->Users_model->edit_data($id);
            $data['cabang'] = $this->Cabang_model->tampil_cabang();
            $this->template->load('template', 'admin/users/users_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
        $this->update($this->input->post('id_username', true));
        } else {
            $data = [
                'username' => $this->input->post('username', true),
                // 'password' => $this->input->post('password',TRUE),
                'nama' => $this->input->post('nama', true),
                'email' => $this->input->post('email', true),
                'telepon' => $this->input->post('telepon', true),
                'id_level' => $this->input->post('id_level', true),
                'id_cabang' => $this->input->post('id_cabang', true),
                'is_aktive' => $this->input->post('is_aktive', true),
            ];

            $this->Users_model->update($this->input->post('id_username', true), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/users'));
        }
    }

    public function delete($id)
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
                        $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/users'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/users'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        if ($this->uri->segment(2) == 'create' || $this->uri->segment(2) == 'create_action') {
            $this->form_validation->set_rules('password', 'password', 'trim|required');
        }

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        // $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        // $this->form_validation->set_rules('kota', 'kota', 'trim|required');
        // $this->form_validation->set_rules('provinsi', 'provinsi', 'trim|required');
        $this->form_validation->set_rules('telepon', 'telepon', 'trim|required');
        $this->form_validation->set_rules('id_level', 'id level', 'trim|required');
        $this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

        $this->form_validation->set_rules('id_username', 'id_username', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = 'users.xls';
        $judul = 'users';
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Disposition: attachment;filename=' . $namaFile . '');
        header('Content-Transfer-Encoding: binary ');

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, 'No');
        xlsWriteLabel($tablehead, $kolomhead++, 'Username');
        xlsWriteLabel($tablehead, $kolomhead++, 'Password');
        xlsWriteLabel($tablehead, $kolomhead++, 'Nama');
        xlsWriteLabel($tablehead, $kolomhead++, 'Email');
        xlsWriteLabel($tablehead, $kolomhead++, 'Alamat');
        xlsWriteLabel($tablehead, $kolomhead++, 'Kota');
        xlsWriteLabel($tablehead, $kolomhead++, 'Provinsi');
        xlsWriteLabel($tablehead, $kolomhead++, 'Telepon');
        xlsWriteLabel($tablehead, $kolomhead++, 'Id Level');
        xlsWriteLabel($tablehead, $kolomhead++, 'Is Aktive');
        xlsWriteLabel($tablehead, $kolomhead++, 'Create Date');

        foreach ($this->Users_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->username);
            xlsWriteLabel($tablebody, $kolombody++, $data->password);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama);
            xlsWriteLabel($tablebody, $kolombody++, $data->email);
            xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
            xlsWriteLabel($tablebody, $kolombody++, $data->kota);
            xlsWriteLabel($tablebody, $kolombody++, $data->provinsi);
            xlsWriteLabel($tablebody, $kolombody++, $data->telepon);
            xlsWriteLabel($tablebody, $kolombody++, $data->id_level);
            xlsWriteLabel($tablebody, $kolombody++, $data->is_aktive);
            xlsWriteLabel($tablebody, $kolombody++, $data->create_date);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header('Content-type: application/vnd.ms-word');
        header('Content-Disposition: attachment;Filename=users.doc');

        $data = [
            'users_data' => $this->Users_model->get_all(),
            'start' => 0,
        ];

        $this->load->view('users/users_doc', $data);
    }
}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */