<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prestasi_model extends CI_Model
{

    public $table = 'prestasi';
    public $id = 'id_prestasi';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_prestasi,nama_prestasi,tanggal,keterangan,image');
        $this->datatables->from('prestasi');
        //add this line for join
        //$this->datatables->join('table2', 'prestasi.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('prestasi/read/$1'),'<i class="fa fa-eye" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
            ".anchor(site_url('prestasi/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('prestasi/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_prestasi');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_gambar($id){
        $this->db->where('id_prestasi',$id);
        return $this->db->get('prestasi')->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_prestasi', $q);
	$this->db->or_like('nama_prestasi', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('image', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_prestasi', $q);
	$this->db->or_like('nama_prestasi', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('image', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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

/* End of file Prestasi_model.php */
/* Location: ./application/models/Prestasi_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-14 14:58:14 */
/* http://harviacode.com */