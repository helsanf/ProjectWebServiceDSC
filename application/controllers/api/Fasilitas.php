<?php
require APPPATH . 'libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Fasilitas extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_fasilitas = $this->get('id_fasilitas');
        $sql = 'select * from gambar_fasilitas where id_fasilitas = ? ';
        $return = $this->db->query($sql,array($id_fasilitas))->result();
        

        if ($id_fasilitas == '') {
            # code...
            $sql = "select id_gambar_fasilitas,fasilitas.id_fasilitas , nama_fasilitas , image from fasilitas inner join gambar_fasilitas on fasilitas.id_fasilitas = gambar_fasilitas.id_fasilitas group by gambar_fasilitas.id_fasilitas order by id_gambar_fasilitas desc";
            $query = $this->db->query($sql);
            $fasilitas['result']=$query->result();
 
            
        }else {
            $this->db->select("id_gambar_fasilitas,fasilitas.id_fasilitas , nama_fasilitas , image");
            $this->db->group_by('gambar_fasilitas.id_fasilitas'); 
            $this->db->order_by('id_gambar_fasilitas', 'desc'); 
            $this->db->from("fasilitas");
            $this->db->join("gambar_fasilitas","fasilitas.id_fasilitas = gambar_fasilitas.id_fasilitas");
            $this->db->where('fasilitas.id_fasilitas',$id_fasilitas);
            $data = array(
                'result' =>  $fasilitas=$this->db->get()->row(),
                'gambar' => $return
            );
            $fasilitas=$data;
        }
        $this->response($fasilitas,REST_Controller::HTTP_OK);
    }

    function get_gambar_get(){
        $id_fasilitas = $this->get('id_fasilitas');        
        $sql = 'select * from gambar_fasilitas where id_fasilitas = ? ';
        $return = $this->db->query($sql,array($id_fasilitas))->result();
        $data = array(
            // 'result' =>  $fasilitas=$this->db->get()->row(),
            'gambar' => $return
        );
        $this->response($data,REST_Controller::HTTP_OK);
        
    }
}
     
 
?>