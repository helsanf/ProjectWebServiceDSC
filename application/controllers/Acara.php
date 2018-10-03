<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acara extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Acara_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','acara/acara_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Acara_model->json();
    }

    public function read($id) 
    {
        $row = $this->Acara_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_acara' => $row->id_acara,
		'nama_acara' => $row->nama_acara,
		'keterangan' => $row->keterangan,
		'tanggal' => $row->tanggal,
		'image' => $row->image,
	    );
            $this->template->load('template','acara/acara_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('acara'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('acara/create_action'),
	    'id_acara' => set_value('id_acara'),
	    'nama_acara' => set_value('nama_acara'),
	    'keterangan' => set_value('keterangan'),
	    'tanggal' => set_value('tanggal'),
	    'image' => set_value('image'),
	);
        $this->template->load('template','acara/acara_form', $data);
    }
    
    public function create_action() 
    {
        $foto = $this->upload_foto();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_acara' => $this->input->post('nama_acara',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
        'tanggal' => $this->input->post('tanggal',TRUE),
        'image' => $foto['file_name'],
		// 'image' => $this->input->post('image',TRUE),
	    );

            $this->Acara_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('acara'));
        }
    }
    
    public function update($id) 


    {
        $row = $this->Acara_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('acara/update_action'),
		'id_acara' => set_value('id_acara', $row->id_acara),
		'nama_acara' => set_value('nama_acara', $row->nama_acara),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'image' => set_value('image', $row->image),
	    );
            $this->template->load('template','acara/acara_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('acara'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        $foto = $this->upload_foto();


        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_acara', TRUE));
        }
        if(!empty($_FILES['image']['name'])){
            foreach ($this->Acara_model->get_gambar($this->input->post('id_acara')) as $get){
                if(file_exists('uploads/acara/'.$get->image)){
                unlink('uploads/acara/'.$get->image);
                }
            }
            $data = array(
                'nama_acara' => $this->input->post('nama_acara',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                'tanggal' => $this->input->post('tanggal',TRUE),
                'image' =>  $foto['file_name'],
            );
        
            $this->Acara_model->update($this->input->post('id_acara', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('acara'));
        } else  {
            $data = array(
		'nama_acara' => $this->input->post('nama_acara',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'image' => $this->input->post('image',TRUE),
	    );

            $this->Acara_model->update($this->input->post('id_acara', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('acara'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Acara_model->get_by_id($id);

        if ($row) {
            $this->Acara_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('acara'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('acara'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_acara', 'nama acara', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	// $this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_acara', 'id_acara', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function upload_foto(){
        $config['upload_path']          = 'uploads/acara/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('image');
        return $this->upload->data();
    }

}

