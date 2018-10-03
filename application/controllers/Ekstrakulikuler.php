<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ekstrakulikuler extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Ekstrakulikuler_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','ekstrakulikuler/ekstrakulikuler_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Ekstrakulikuler_model->json();
    }

    public function read($id) 
    {
        $row = $this->Ekstrakulikuler_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_ekstra' => $row->id_ekstra,
		'nama_ekstra' => $row->nama_ekstra,
		'keterangan' => $row->keterangan,
		'image' => $row->image,
	    );
            $this->template->load('template','ekstrakulikuler/ekstrakulikuler_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ekstrakulikuler'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('ekstrakulikuler/create_action'),
	    'id_ekstra' => set_value('id_ekstra'),
	    'nama_ekstra' => set_value('nama_ekstra'),
	    'keterangan' => set_value('keterangan'),
	    'image' => set_value('image'),
	);
        $this->template->load('template','ekstrakulikuler/ekstrakulikuler_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_ekstra' => $this->input->post('nama_ekstra',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Ekstrakulikuler_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('ekstrakulikuler'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ekstrakulikuler_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('ekstrakulikuler/update_action'),
		'id_ekstra' => set_value('id_ekstra', $row->id_ekstra),
		'nama_ekstra' => set_value('nama_ekstra', $row->nama_ekstra),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'image' => set_value('image', $row->image),
	    );
            $this->template->load('template','ekstrakulikuler/ekstrakulikuler_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ekstrakulikuler'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_ekstra', TRUE));
        } else {
            $data = array(
		'nama_ekstra' => $this->input->post('nama_ekstra',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Ekstrakulikuler_model->update($this->input->post('id_ekstra', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ekstrakulikuler'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Ekstrakulikuler_model->get_by_id($id);

        if ($row) {
            $this->Ekstrakulikuler_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ekstrakulikuler'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ekstrakulikuler'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_ekstra', 'nama ekstra', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_ekstra', 'id_ekstra', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "ekstrakulikuler.xls";
        $judul = "ekstrakulikuler";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Ekstra");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Image");

	foreach ($this->Ekstrakulikuler_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_ekstra);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->image);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=ekstrakulikuler.doc");

        $data = array(
            'ekstrakulikuler_data' => $this->Ekstrakulikuler_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('ekstrakulikuler/ekstrakulikuler_doc',$data);
    }

}

