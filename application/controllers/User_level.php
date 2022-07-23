<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_level extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('User_level_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/user_level/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/user_level/index/';
            $config['first_url'] = base_url() . 'index.php/user_level/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->User_level_model->total_rows($q);
        $user_level = $this->User_level_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user_level_data' => $user_level,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','user_level/user_level_list', $data);
    }

    public function read($id) 
    {
        $row = $this->User_level_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_level' => $row->id_level,
		'nama_user_level' => $row->nama_user_level,
	    );
            $this->template->load('template','user_level/user_level_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_level'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user_level/create_action'),
	    'id_level' => set_value('id_level'),
	    'nama_user_level' => set_value('nama_user_level'),
	);
        $this->template->load('template','user_level/user_level_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_user_level' => $this->input->post('nama_user_level',TRUE),
	    );

            $this->User_level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('user_level'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->User_level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user_level/update_action'),
		'id_level' => set_value('id_level', $row->id_level),
		'nama_user_level' => set_value('nama_user_level', $row->nama_user_level),
	    );
            $this->template->load('template','user_level/user_level_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_level'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_level', TRUE));
        } else {
            $data = array(
		'nama_user_level' => $this->input->post('nama_user_level',TRUE),
	    );

            $this->User_level_model->update($this->input->post('id_level', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user_level'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->User_level_model->get_by_id($id);

        if ($row) {
            $this->User_level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user_level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_level'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_user_level', 'nama user level', 'trim|required');

	$this->form_validation->set_rules('id_level', 'id_level', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "user_level.xls";
        $judul = "user_level";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama User Level");

	foreach ($this->User_level_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_user_level);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=user_level.doc");

        $data = array(
            'user_level_data' => $this->User_level_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('user_level/user_level_doc',$data);
    }

}

/* End of file User_level.php */
/* Location: ./application/controllers/User_level.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 18:40:20 */
/* http://harviacode.com */