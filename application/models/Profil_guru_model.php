<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profil_guru_model extends CI_Model
{

    public $table = 'profil_guru';
    public $id = 'id_guru';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_guru,nama_guru,mapel,kelas_ajar,jabatan,image');
        $this->datatables->from('profil_guru');
        //add this line for join
        //$this->datatables->join('table2', 'profil_guru.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('profilguru/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('profilguru/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_guru');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_guru', $q);
	$this->db->or_like('nama_guru', $q);
	$this->db->or_like('mapel', $q);
	$this->db->or_like('kelas_ajar', $q);
	$this->db->or_like('jabatan', $q);
	$this->db->or_like('image', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_guru', $q);
	$this->db->or_like('nama_guru', $q);
	$this->db->or_like('mapel', $q);
	$this->db->or_like('kelas_ajar', $q);
	$this->db->or_like('jabatan', $q);
	$this->db->or_like('image', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Profil_guru_model.php */
/* Location: ./application/models/Profil_guru_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-14 14:06:41 */
/* http://harviacode.com */