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

    function auth_post(){
        $id = $this->post('android_id');
        $this->db->where('android_id',$id);
        $users = $this->db->get('trafic')->result();
        if($users){
            $data = array( 'last_login' => date("Y-m-d H:i:s") );
            $this->db->where('android_id', $id);
            $update = $this->db->update('trafic', $data);
            if($update){
                $go = array(
                    'response' => 'success'
                ); 
                $this->response($go,REST_Controller::HTTP_OK);
                // $this->respone(array('respone'=>'succes',200));
            }else{
                $this->response(array('response' => 'fail', 502));

            }
         } 
         else{
                $data = array(
                    'android_id'    => $this->post('android_id'),
                    'created'       => date("Y-m-d H:i:s"),
                    'last_login'    => date("Y-m-d H:i:s")
                );
                $insert = $this->db->insert('trafic', $data);
                if($insert){
                    $this->db->where('android_id', $id);
                    $users = $this->db->get('trafic')->result();
                    $this->response(array('response' => 'success', 'users' => $users ), 201);
                } else {
                    $this->response(array('response' => 'fail', 502));
                }
            }
        }
    }
 
?>