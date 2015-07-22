<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER daftar_toko
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Coding daftar_toko
*/
class Daftar_toko extends CI_Controller {
    public data = array( 'scjav'=>'<script src='.site_url('html/admin/js/bootstrap.min.js').' type="text/javascript"></script>');
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_toko");
    }
    
    public function index(){
        $page=$this->uri->segment(4);
        $uri=4;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_toko->get_all_toko();
        $url='admin/daftar_toko/index';
        $this->data['pagination'] = $this->template->paging1($pg,$uri,$url,$limit);        
        $this->data['allToko']=$this->model_toko->get_all_toko($limit,$offset);
        
        if ($this->input->post('ajax')) {
            $this->load->view('admin/user/bg_user_ajax', $this->data);
        } else {
            $this->template->admin('admin/user/bg_user', $this->data);
            $this->load->view('admin/daftar_toko/bg_daftar_toko.php', $this->data);
        } 

    }

}
