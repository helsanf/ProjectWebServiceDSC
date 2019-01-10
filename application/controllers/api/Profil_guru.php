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
class Profil_guru extends REST_Controller{
function __construct($config ='rest'){
        parent::__construct($config);
    }

    function index_get(){
        $id_guru = $this->get('id_guru');

        if ($id_guru == '') {
            # code...'
            $sql = "select * from profil_guru where jabatan not in('Kepala Sekolah')";
            $guru['result']=$this->db->query($sql)->result();
        }else {
            
            $this->db->where('id_guru',$id_guru);
            $guru=$this->db->get('profil_guru')->row();
        }
        $this->response($guru,REST_Controller::HTTP_OK);
    }

    function kepala_get(){
        $sql = "select * from profil_guru where jabatan = 'Kepala Sekolah'";
        $query = $this->db->query($sql)->row();
        $this->response($query,REST_Controller::HTTP_OK);
    }
}
     
 
?>