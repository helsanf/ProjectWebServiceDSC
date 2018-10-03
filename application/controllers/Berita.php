<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Berita extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Berita_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','berita/berita_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Berita_model->json();
    }

    public function read($id) 
    {
        $row = $this->Berita_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_berita' => $row->id_berita,
		'judul_berita' => $row->judul_berita,
		'isi_berita' => $row->isi_berita,
		'tanggal' => $row->tanggal,
		'image' => $row->image,
	    );
            $this->template->load('template','berita/berita_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berita'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('berita/create_action'),
	    'id_berita' => set_value('id_berita'),
	    'judul_berita' => set_value('judul_berita'),
	    'isi_berita' => set_value('isi_berita'),
	    'tanggal' => set_value('tanggal'),
	    'image' => set_value('image'),
	);
        $this->template->load('template','berita/berita_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'judul_berita' => $this->input->post('judul_berita',TRUE),
		'isi_berita' => $this->input->post('isi_berita',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Berita_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('berita'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Berita_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('berita/update_action'),
		'id_berita' => set_value('id_berita', $row->id_berita),
		'judul_berita' => set_value('judul_berita', $row->judul_berita),
		'isi_berita' => set_value('isi_berita', $row->isi_berita),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'image' => set_value('image', $row->image),
	    );
            $this->template->load('template','berita/berita_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berita'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_berita', TRUE));
        } else {
            $data = array(
		'judul_berita' => $this->input->post('judul_berita',TRUE),
		'isi_berita' => $this->input->post('isi_berita',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Berita_model->update($this->input->post('id_berita', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('berita'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Berita_model->get_by_id($id);

        if ($row) {
            $this->Berita_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('berita'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berita'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul_berita', 'judul berita', 'trim|required');
	$this->form_validation->set_rules('isi_berita', 'isi berita', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_berita', 'id_berita', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "berita.xls";
        $judul = "berita";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Judul Berita");
	xlsWriteLabel($tablehead, $kolomhead++, "Isi Berita");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Image");

	foreach ($this->Berita_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->judul_berita);
	    xlsWriteLabel($tablebody, $kolombody++, $data->isi_berita);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
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
        header("Content-Disposition: attachment;Filename=berita.doc");

        $data = array(
            'berita_data' => $this->Berita_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('berita/berita_doc',$data);
    }

}
