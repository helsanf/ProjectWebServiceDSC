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
class Trafic extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_trafic = $this->get('id_trafic');

        if ($id_trafic == '') {
            # code...
            $trafic['result']=$this->db->get('trafic')->result();
        }else {
            
            $this->db->where('id_trafic',$id_trafic);
            $trafic['result']=$this->db->get('trafic')->result();
        }
        $this->response($trafic,REST_Controller::HTTP_OK);
    }
}
     
 
?>