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
        $foto = $this->upload_foto();
        $judul =  $this->input->post('nama_prestasi',TRUE);
        $topics = "helsan";
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_prestasi' => $this->input->post('nama_prestasi',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'image' => $foto['file_name'],
	    );

           $id =  $this->Prestasi_model->insert($data);
           $this->firebase($judul,$topics,$id);
        //    print_r( $this->firebase($judul,$topics,$id));
        //    die();
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('prestasi'));
        }
    }

    public function firebase($judul,$topics,$id_prestasi){
        $res = array();
        $data = array();        
        $data['body'] = $judul;
        $data['click_action'] = 'PRESTASIACTIVITY';
       $data['id_prestasi'] = $id_prestasi;
        
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
        $foto = $this->upload_foto();
        
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_prestasi', TRUE));
        } 
        if(!empty($_FILES['image']['name'])){
            foreach ($this->Prestasi_model->get_gambar($this->input->post('id_prestasi')) as $get){
                if(file_exists('uploads/prestasi/'.$get->image)){
                unlink('uploads/prestasi/'.$get->image);
                }
            }
            $data = array(
                'nama_prestasi' => $this->input->post('nama_prestasi',TRUE),
                'tanggal' => $this->input->post('tanggal',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                'image' =>  $foto['file_name'],
            );
        
            $this->Prestasi_model->update($this->input->post('id_prestasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('prestasi'));
        }
        else {
            $data = array(
		'nama_prestasi' => $this->input->post('nama_prestasi',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		
	    );

            $this->Prestasi_model->update($this->input->post('id_prestasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('prestasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Prestasi_model->get_by_id($id);
        print_r($row);
       
        if ($row) {
            unlink('uploads/prestasi/'.$row->image);
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

    function upload_foto(){
        $config['upload_path']          = 'uploads/prestasi/';
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

