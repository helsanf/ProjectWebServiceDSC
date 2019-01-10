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
        $foto = $this->upload_foto();
        $judul =  $this->input->post('judul_berita',TRUE);
        $topics = "helsan";
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'judul_berita' => $this->input->post('judul_berita',TRUE),
		'isi_berita' => $this->input->post('isi_berita',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'image' => $foto['file_name'],
	    );

          $id_berita = (string)$this->Berita_model->insert($data);
        $this->firebase($judul,$topics,$id_berita);
        $this->session->set_flashdata('message', 'Create Record Success 2');
        redirect(site_url('berita'));
        }
    }

    public function firebase($judul,$topics,$id_berita){
        $res = array();
        $data = array();        
        $data['body'] = $judul;
        $data['click_action'] = 'BERITAACTIVITY';
       $data['id_berita'] = $id_berita;
        
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
        $foto = $this->upload_foto();
        

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_berita', TRUE));
        }
        if(!empty($_FILES['image']['name'])){
            foreach ($this->Berita_model->get_gambar($this->input->post('id_berita')) as $get){
                if(file_exists('uploads/berita/'.$get->image)){
                unlink('uploads/berita/'.$get->image);
                }
            }
            $data = array(
                'judul_berita' => $this->input->post('judul_berita',TRUE),
                'isi_berita' => $this->input->post('isi_berita',TRUE),
                'tanggal' => $this->input->post('tanggal',TRUE),
                'image' =>  $foto['file_name'],
            );
        
            $this->Berita_model->update($this->input->post('id_berita', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('berita'));
        } else {
            $data = array(
            'judul_berita' => $this->input->post('judul_berita',TRUE),
            'isi_berita' => $this->input->post('isi_berita',TRUE),
            'tanggal' => $this->input->post('tanggal',TRUE),
            // 'image' => $this->input->post('image',TRUE),
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
            unlink('uploads/berita/'.$row->image);
            
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
	// $this->form_validation->set_rules('image', 'image', 'trim|required');

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

    function upload_foto(){
        $config['upload_path']          = 'uploads/berita/';
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
