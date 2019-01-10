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
        $judul = $this->input->post('nama_acara',TRUE);
        $topics = $this->input->post('helsan',TRUE);
        // $id_acara = $this->input->post('id_acara',TRUE);
        
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
         $id_acara = (string)$this->Acara_model->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success 2');
        $this->firebase($judul,$topics,$id_acara);
        // print_r($this->firebase($judul,$topics,$id_acara));
        // die();
       
        redirect(site_url('acara'));
          
        }
    }

    public function firebase($judul,$topics,$id_acara){
        $res = array();
        $data = array();        
        $data['body'] = $judul;
        $data['click_action'] = 'ACARAACTIVITY';
       $data['id_acara'] = $id_acara;
        
        $fields = array(
            'to' => '/topics/' . $topics,
            // 'notification' => $res,
            'data' => $data
        );
        echo json_encode($fields);
        // die();
           
             // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = "AAAAM0vtV_g:APA91bGiUb7_zSOBNMOeaUzAQ4VuhWSOCZqn35GspgTOD2fPYHYjr1vX6c5Fac_n5bWia_VxQqnnKcZ3LiSUpUKKATNF25tQZTQ2GQYktxrV8yU92Z-iqAGaU3Xp0P0xubSYn_-jhLMR";
        
        $headers = array(
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            echo 'Curl failed: ' . curl_error($ch);
        }
 
        // Close connection
        curl_close($ch);
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
		// 'image' => $this->input->post('image',TRUE),
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
            unlink('uploads/acara/'.$row->image);
            
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

