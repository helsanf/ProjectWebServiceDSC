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
class Kalender extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_kalender = $this->get('id_kalender');

        if ($id_kalender == '') {
            # code...
            $kalender['result']=$this->db->get('kalender')->result();
        }else {
            
            $this->db->where('id_kalender',$id_kalender);
            $kalender['result']=$this->db->get('kalender')->result();
        }
        $this->response($kalender,REST_Controller::HTTP_OK);
    }

    function akademik_get(){
        
        
        $sql = "select id_kalender , nama_bulan , tanggal , nama_kalender  from tbl_kalender inner join tbl_bulan on tbl_kalender.id_bulan = tbl_bulan.id_bulan where YEAR(tanggal) = year(now()) order by tanggal asc ";
        $query = $this->db->query($sql)->result();
        $data = array();
        foreach($this->bulan_get() as $bulan ){
             foreach($query as $kegiatan){
                if($bulan == $kegiatan->nama_bulan){
                    $data[$bulan][] = $kegiatan;
                }
             }
        }
        $this->response($data,REST_Controller::HTTP_OK);


    }

    private function bulan_get(){
        $sql = "select nama_bulan from tbl_bulan order by id_bulan asc";
        $query = $this->db->query($sql)->result();
        $data = array();
        foreach($query as $bulan){
            $data[] = $bulan->nama_bulan;
        }
        return $data;
    }
}
     
 
?>