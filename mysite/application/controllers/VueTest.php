<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VueTest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('result');
    }

    public function index()
    {
        $page = $this->input->get_post('page', true);
        $num = $this->input->get_post('num', true);
        if (is_numeric($page) && $page > 1) {
            $page--;
        } else {
            $page = 0;
        }
        if (is_numeric($num) && $num > 1) {

        } else {
            $num = 10;
        }
        $start = $page * $num;
        $res = $this->db->query("SELECT * FROM test LIMIT $start,$num");
        if (!empty($res->result_array())) {
            echo json_encode(Helper_Result::get(RET_SUCC, 'success', $res->result_array()), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(Helper_Result::get(RET_NULL, 'null'), JSON_UNESCAPED_UNICODE);
        }
    }

    public function index1()
    {
        //$this->load->database();

        $res = $this->db->query('select * from test');
        print_r($res->result_array());  //数组
        print_r($res->result());        //对象
        print_r($res->row_array());     //单行数组
        print_r($res->row());           //单行对象

        //$this->db->query("INSERT INTO test VALUES (335)");
        //echo $this->db->affected_rows();
    }

}
