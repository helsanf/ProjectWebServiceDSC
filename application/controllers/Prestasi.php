<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prestasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Prestasi_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','prestasi/prestasi_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Prestasi_model->json();
    }

    public function read($id) 
    {
        $row = $this->Prestasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_prestasi' => $row->id_prestasi,
		'nama_prestasi' => $row->nama_prestasi,
		'tanggal' => $row->tanggal,
		'keterangan' => $row->keterangan,
		'image' => $row->image,
	    );
            $this->template->load('template','prestasi/prestasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prestasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('prestasi/create_action'),
	    'id_prestasi' => set_value('id_prestasi'),
	    'nama_prestasi' => set_value('nama_prestasi'),
	    'tanggal' => set_value('tanggal'),
	    'keterangan' => set_value('keterangan'),
	    'image' => set_value('image'),
	);
        $this->template->load('template','prestasi/prestasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_prestasi' => $this->input->post('nama_prestasi',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Prestasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('prestasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Prestasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('prestasi/update_action'),
		'id_prestasi' => set_value('id_prestasi', $row->id_prestasi),
		'nama_prestasi' => set_value('nama_prestasi', $row->nama_prestasi),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'image' => set_value('image', $row->image),
	    );
            $this->template->load('template','prestasi/prestasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prestasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_prestasi', TRUE));
        } else {
            $data = array(
		'nama_prestasi' => $this->input->post('nama_prestasi',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Prestasi_model->update($this->input->post('id_prestasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('prestasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Prestasi_model->get_by_id($id);

        if ($row) {
            $this->Prestasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('prestasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prestasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_prestasi', 'nama prestasi', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_prestasi', 'id_prestasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "prestasi.xls";
        $judul = "prestasi";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Prestasi");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Image");

	foreach ($this->Prestasi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_prestasi);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
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
        header("Content-Disposition: attachment;Filename=prestasi.doc");

        $data = array(
            'prestasi_data' => $this->Prestasi_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('prestasi/prestasi_doc',$data);
    }

}

