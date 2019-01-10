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

 class Berita extends REST_Controller{
     function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_berita = $this->get('id_berita');

        if ($id_berita == '') {
            # code...
            $query = $this->db->query("select * from berita order by id_berita desc");
            $berita['result']=$query->result();
        }else {
            
            $this->db->where('id_berita',$id_berita);
            $berita['result']=$this->db->get('berita')->result();
        }
        $this->response($berita,REST_Controller::HTTP_OK);
    }
 }
 
?>