<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fasilitas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Fasilitas_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','fasilitas/fasilitas_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Fasilitas_model->json();
    }

    public function read($id) 
    {
        $row = $this->Fasilitas_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_fasilitas' => $row->id_fasilitas,
		'nama_fasilitas' => $row->nama_fasilitas,
	    );
            $this->template->load('template','fasilitas/fasilitas_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fasilitas'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('fasilitas/create_action'),
	    'id_fasilitas' => set_value('id_fasilitas'),
	    'nama_fasilitas' => set_value('nama_fasilitas'),
	);
        $this->template->load('template','fasilitas/fasilitas_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'nama_fasilitas' => $this->input->post('nama_fasilitas',TRUE),
		'id_fasilitas' => $this->input->post('id_fasilitas',TRUE),
        
        );
       $insert_id = $this->Fasilitas_model->insert($data);
        
            $this->upload_gambar($insert_id);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('fasilitas'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Fasilitas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('fasilitas/update_action'),
		'id_fasilitas' => set_value('id_fasilitas', $row->id_fasilitas),
		'nama_fasilitas' => set_value('nama_fasilitas', $row->nama_fasilitas),
	    );
            $this->template->load('template','fasilitas/fasilitas_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fasilitas'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
      $id_fasilitas = $this->input->post('id_fasilitas');
        

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_fasilitas', TRUE));
        } else {
            $data = array(
		'nama_fasilitas' => $this->input->post('nama_fasilitas',TRUE),
        );
        
        //harus ada parameter ke3 0 , karena si userfiles selalu membaca true walaupun tidak
            //ada file yang dipilih
            $this->Fasilitas_model->update($this->input->post('id_fasilitas', TRUE), $data);
            
            // $this->Fasilitas_model->update($id_fasilitas);
            if(!empty($_FILES['userFiles']['name'][0])){
                foreach ($this->Fasilitas_model->get_gambar_by_id($id_fasilitas) as $get){
                    if(file_exists('uploads/files/'.$get->image)){
                    unlink('uploads/files/'.$get->image);
                    $this->Fasilitas_model->delete_gambar('id_fasilitas');
                    }
                }
                $this->Fasilitas_model->delete_gambar($id_fasilitas);
            }
            $this->upload_gambar($id_fasilitas);

            // $this->Fasilitas_model->update($this->input->post('id_fasilitas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('fasilitas'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Fasilitas_model->get_by_id($id);
        // $gambar = $this->Fasilitas_model->get_gambar_by_id($id);
    //    $go = $this->Fasilitas_model->get_gambar_by_id($id);
    //     print_r($go);
    //     die();
        if ($row) {
            // $this->Fasilitas_model->delete_gambar($id);
            foreach ($this->Fasilitas_model->get_gambar_by_id($id) as $get){
                if(file_exists('uploads/files/'.$get->image)){
                unlink('uploads/files/'.$get->image);
                $this->Fasilitas_model->delete_gambar('id_fasilitas');
                }
            }
            $this->Fasilitas_model->delete($id);            
            
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('fasilitas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fasilitas'));
        }
    }

    function upload_gambar($id){
        $data = array();
//        print_r($_FILES['userFiles']['name']);
//        die();
        if(!empty($_FILES['userFiles']['name'])){
//            die();
            $filesCount = count($_FILES['userFiles']['name']);
            $uploadData = [];
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

                $uploadPath = 'uploads/files/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = $fileData['file_name'];
                    $uploadData[$i]['id_fasilitas'] = $id;

//                    $uploadData[$i]['created'] = date("Y-m-d H:i:s");
//                    $uploadData[$i]['modified'] = date("Y-m-d H:i:s");
                }
            }

            if(!empty($uploadData)){
                //Insert file information into the database
                $insert = $this->Fasilitas_model->insert_gambar($uploadData);
                $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
        //Get files data from database
//        $data['files'] = $this->file->getRows();
        //Pass the files data to view
//        $this->load->view('upload_files/index', $data);
        $this->template->load('template','fasilitas/fasilitas_form',$data);

    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_fasilitas', 'nama fasilitas', 'trim|required');

	$this->form_validation->set_rules('id_fasilitas', 'id_fasilitas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "fasilitas.xls";
        $judul = "fasilitas";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Fasilitas");

	foreach ($this->Fasilitas_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_fasilitas);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=fasilitas.doc");

        $data = array(
            'fasilitas_data' => $this->Fasilitas_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('fasilitas/fasilitas_doc',$data);
    }

}
