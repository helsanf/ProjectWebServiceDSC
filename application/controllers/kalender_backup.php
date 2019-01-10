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
		'upload_kalender' => $row->upload_kalender,
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
	    'upload_kalender' => set_value('upload_kalender'),
	);
        $this->template->load('template','kalenderakademik/kalender_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $kalender = $this->upload_foto();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'upload_kalender' => $kalender['file_name'],
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
		'upload_kalender' => set_value('upload_kalender', $row->upload_kalender),
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
        $kalender = $this->upload_foto();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kalender', TRUE));
        }
        if(!empty($_FILES['upload_kalender']['name'])){
            foreach ($this->Kalender_model->get_kalender($this->input->post('id_kalender')) as $get){
                if(file_exists('uploads/kalender/'.$get->upload_kalender)){
                unlink('uploads/kalender/'.$get->upload_kalender);
                }
            }
            $data = array(
                'upload_kalender' =>$kalender['file_name'],
                );
        
                    $this->Kalender_model->update($this->input->post('id_kalender', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('kalenderakademik'));
        }
        
        else {
        //     $data = array(
		// 'upload_kalender' => $this->input->post('upload_kalender',TRUE),
	    // );

        //     $this->Kalender_model->update($this->input->post('id_kalender', TRUE), $data);
        //     $this->session->set_flashdata('message', 'Update Record Success');
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
	// $this->form_validation->set_rules('upload_kalender', 'upload kalender', 'trim|required');

	$this->form_validation->set_rules('id_kalender', 'id_kalender', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function upload_foto(){
        $config['upload_path']          = 'uploads/kalender/';
        $config['allowed_types']        = '*';
        $config['encrypt_name'] = TRUE;
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('upload_kalender');
        return $this->upload->data();
    }

}
