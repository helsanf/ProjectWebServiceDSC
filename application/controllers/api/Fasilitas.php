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

        if ($id_fasilitas == '') {
            # code...
            $fasilitas['result']=$this->db->get('fasilitas')->result();
        }else {
            
            $this->db->where('id_fasilitas',$id_fasilitas);
            $fasilitas['result']=$this->db->get('fasilitas')->result();
        }
        $this->response($fasilitas,REST_Controller::HTTP_OK);
    }
}
     
 
?>