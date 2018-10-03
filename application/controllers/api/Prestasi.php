<?php
/**
 * Created by PhpStorm.
 * User: HelsanF
 * Date: 29/08/2018
 * Time: 18.24
 */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
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

class Prestasi extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    function index_get(){
        $id_prestasi = $this->get('id_prestasi');
        

        if($id_prestasi == ''){
        // $mahasiswa = array();
        // $mahasiswa['result'] = array();          
        $prestasi['result'] = $this->db->get('prestasi')->result();
            
        }else{
            $this->db->where('id_prestasi',$id_prestasi);
            $prestasi['result'] = $this->db->get('prestasi')->result();
           
        }
        // $mahasiswa = $this->db->get('t_mahasiswa')->result();
        
        $this->response($prestasi , REST_Controller::HTTP_OK);
    }
   
    
}