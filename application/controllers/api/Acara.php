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
class Acara extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_acara = $this->get('id_acara');

        if ($id_acara == '') {
            # code...
            $acara['result']=$this->db->get('acara')->result();
        }else {
            
            $this->db->where('id_acara',$id_acara);
            $acara['result']=$this->db->get('acara')->result();
        }
        $this->response($acara,REST_Controller::HTTP_OK);
    }
}
     
 
?>