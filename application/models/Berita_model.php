<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Berita_model extends CI_Model
{

    public $table = 'berita';
    public $id = 'id_berita';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_berita,judul_berita,SUBSTR(isi_berita,1,100) as isi_berita ,tanggal,image');
        $this->datatables->from('berita');
        //add this line for join
        //$this->datatables->join('table2', 'berita.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('berita/read/$1'),'<i class="fa fa-eye" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
            ".anchor(site_url('berita/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('berita/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_berita');
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
    function get_gambar($id){
        $this->db->where('id_berita',$id);
        return $this->db->get('berita')->result();
    }

    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_berita', $q);
	$this->db->or_like('judul_berita', $q);
	$this->db->or_like('isi_berita', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('image', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_berita', $q);
	$this->db->or_like('judul_berita', $q);
	$this->db->or_like('isi_berita', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('image', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        $last_id = $this->db->insert_id();
        return $last_id; 
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

