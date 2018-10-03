<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kalenderakademik extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Kalender_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','kalenderakademik/kalender_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Kalender_model->json();
    }

    public function read($id) 
    {
        $row = $this->Kalender_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kalender' => $row->id_kalender,
		'tanggal' => $row->tanggal,
		'nama_acara' => $row->nama_acara,
	    );
            $this->template->load('template','kalenderakademik/kalender_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kalenderakademik'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kalenderakademik/create_action'),
	    'id_kalender' => set_value('id_kalender'),
	    'tanggal' => set_value('tanggal'),
	    'nama_acara' => set_value('nama_acara'),
	);
        $this->template->load('template','kalenderakademik/kalender_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tanggal' => $this->input->post('tanggal',TRUE),
		'nama_acara' => $this->input->post('nama_acara',TRUE),
	    );

            $this->Kalender_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('kalenderakademik'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kalender_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kalenderakademik/update_action'),
		'id_kalender' => set_value('id_kalender', $row->id_kalender),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'nama_acara' => set_value('nama_acara', $row->nama_acara),
	    );
            $this->template->load('template','kalenderakademik/kalender_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kalenderakademik'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kalender', TRUE));
        } else {
            $data = array(
		'tanggal' => $this->input->post('tanggal',TRUE),
		'nama_acara' => $this->input->post('nama_acara',TRUE),
	    );

            $this->Kalender_model->update($this->input->post('id_kalender', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kalenderakademik'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kalender_model->get_by_id($id);

        if ($row) {
            $this->Kalender_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kalenderakademik'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kalenderakademik'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('nama_acara', 'nama acara', 'trim|required');

	$this->form_validation->set_rules('id_kalender', 'id_kalender', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kalender.xls";
        $judul = "kalender";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Acara");

	foreach ($this->Kalender_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_acara);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=kalender.doc");

        $data = array(
            'kalender_data' => $this->Kalender_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('kalenderakademik/kalender_doc',$data);
    }

}

