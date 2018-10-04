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
class Gambar_fasilitas extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_gambar_fasilitas = $this->get('id_gambar_fasilitas');

        if ($id_gambar_fasilitas == '') {
            # code...
            $gambar_fasilitas['result']=$this->db->get('gambar_fasilitas')->result();
        }else {
            
            $this->db->where('id_gambar_fasilitas',$id_gambar_fasilitas);
            $gambar_fasilitas['result']=$this->db->get('gambar_fasilitas')->result();
        }
        $this->response($gambar_fasilitas,REST_Controller::HTTP_OK);
    }
}
     
 
?>