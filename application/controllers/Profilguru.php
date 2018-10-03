<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profilguru extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Profil_guru_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','profilguru/profil_guru_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Profil_guru_model->json();
    }

    public function read($id) 
    {
        $row = $this->Profil_guru_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_guru' => $row->id_guru,
		'nama_guru' => $row->nama_guru,
		'mapel' => $row->mapel,
		'kelas_ajar' => $row->kelas_ajar,
		'jabatan' => $row->jabatan,
		'image' => $row->image,
	    );
            $this->template->load('template','profilguru/profil_guru_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profilguru'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('profilguru/create_action'),
	    'id_guru' => set_value('id_guru'),
	    'nama_guru' => set_value('nama_guru'),
	    'mapel' => set_value('mapel'),
	    'kelas_ajar' => set_value('kelas_ajar'),
	    'jabatan' => set_value('jabatan'),
	    'image' => set_value('image'),
	);
        $this->template->load('template','profilguru/profil_guru_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_guru' => $this->input->post('nama_guru',TRUE),
		'mapel' => $this->input->post('mapel',TRUE),
		'kelas_ajar' => $this->input->post('kelas_ajar',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Profil_guru_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('profilguru'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Profil_guru_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('profilguru/update_action'),
		'id_guru' => set_value('id_guru', $row->id_guru),
		'nama_guru' => set_value('nama_guru', $row->nama_guru),
		'mapel' => set_value('mapel', $row->mapel),
		'kelas_ajar' => set_value('kelas_ajar', $row->kelas_ajar),
		'jabatan' => set_value('jabatan', $row->jabatan),
		'image' => set_value('image', $row->image),
	    );
            $this->template->load('template','profilguru/profil_guru_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profilguru'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_guru', TRUE));
        } else {
            $data = array(
		'nama_guru' => $this->input->post('nama_guru',TRUE),
		'mapel' => $this->input->post('mapel',TRUE),
		'kelas_ajar' => $this->input->post('kelas_ajar',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Profil_guru_model->update($this->input->post('id_guru', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('profilguru'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Profil_guru_model->get_by_id($id);

        if ($row) {
            $this->Profil_guru_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('profilguru'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profilguru'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_guru', 'nama guru', 'trim|required');
	$this->form_validation->set_rules('mapel', 'mapel', 'trim|required');
	$this->form_validation->set_rules('kelas_ajar', 'kelas ajar', 'trim|required');
	$this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
	$this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_guru', 'id_guru', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "profil_guru.xls";
        $judul = "profil_guru";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Guru");
	xlsWriteLabel($tablehead, $kolomhead++, "Mapel");
	xlsWriteLabel($tablehead, $kolomhead++, "Kelas Ajar");
	xlsWriteLabel($tablehead, $kolomhead++, "Jabatan");
	xlsWriteLabel($tablehead, $kolomhead++, "Image");

	foreach ($this->Profil_guru_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_guru);
	    xlsWriteLabel($tablebody, $kolombody++, $data->mapel);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kelas_ajar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jabatan);
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
        header("Content-Disposition: attachment;Filename=profil_guru.doc");

        $data = array(
            'profil_guru_data' => $this->Profil_guru_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('profilguru/profil_guru_doc',$data);
    }

}

