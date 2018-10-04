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
}
     
 
?>