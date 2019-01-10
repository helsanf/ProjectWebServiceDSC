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
		'email' => $row->email,
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
	    'email' => set_value('email'),
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
        $foto = $this->upload_foto();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_guru' => $this->input->post('nama_guru',TRUE),
		'email' => $this->input->post('email',TRUE),
		'mapel' => $this->input->post('mapel',TRUE),
		'kelas_ajar' => $this->input->post('kelas_ajar',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
		'image' => $foto['file_name'],
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
		'email' => set_value('email', $row->email),
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
        $foto = $this->upload_foto();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_guru', TRUE));
        } if(!empty($_FILES['image']['name'])){
            foreach ($this->Profil_guru_model->get_gambar($this->input->post('id_guru')) as $get){
                if(file_exists('uploads/guru/'.$get->image)){
                unlink('uploads/guru/'.$get->image);
                }
            }
            $data = array(
                'nama_guru' => $this->input->post('nama_guru',TRUE),
                'email' => $this->input->post('email',TRUE),
                'mapel' => $this->input->post('mapel',TRUE),
                'kelas_ajar' => $this->input->post('kelas_ajar',TRUE),
                'jabatan' => $this->input->post('jabatan',TRUE),
                'image' => $foto['file_name'],
                );
        
                    $this->Profil_guru_model->update($this->input->post('id_guru', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('profilguru'));
        }
        
        
        
        else {
            $data = array(
		'nama_guru' => $this->input->post('nama_guru',TRUE),
		'email' => $this->input->post('email',TRUE),
		'mapel' => $this->input->post('mapel',TRUE),
		'kelas_ajar' => $this->input->post('kelas_ajar',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
	
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
            unlink('uploads/guru/'.$row->image);
            
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
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('mapel', 'mapel', 'trim|required');
	$this->form_validation->set_rules('kelas_ajar', 'kelas ajar', 'trim|required');
	$this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
	// $this->form_validation->set_rules('image', 'image', 'trim|required');

	$this->form_validation->set_rules('id_guru', 'id_guru', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    function upload_foto(){
        $config['upload_path']          = 'uploads/guru/';
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
