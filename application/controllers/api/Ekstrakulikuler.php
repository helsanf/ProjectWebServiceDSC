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

 class Ekstrakulikuler extends REST_Controller{
     function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_ekstra = $this->get('id_ekstra');

        if ($id_ekstra == '') {
            # code...
            $ekstra['result']=$this->db->get('ekstrakulikuler')->result();
        }else {
            
            $this->db->where('id_ekstra',$id_ekstra);
            $ekstra['result']=$this->db->get('ekstrakulikuler')->result();
        }
        $this->response($ekstra,REST_Controller::HTTP_OK);
    }
 }
 
?>