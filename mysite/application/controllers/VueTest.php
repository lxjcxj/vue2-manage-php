<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VueTest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //$this->load->database();
        $res = $this->db->query('select * from test');
        print_r($res->result_array());  //数组
        print_r($res->result());        //对象
        print_r($res->row_array());     //单行数组
        print_r($res->row());           //单行对象

        $this->db->query("INSERT INTO test VALUES (335)");
        echo $this->db->affected_rows();
    }

}
