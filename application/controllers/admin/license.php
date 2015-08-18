<?php
/*
 * Author : dinarwahyu13@gmail.com
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class License extends CI_Controller {
    var $data = array('scjav' => 'assets/jController/admin/CtrlLicense.js');
    var $limit = 10;
    var $offset = 0;
    function __construct(){
        parent::__construct();

        $this->load->model("admin/model_license");
    }
    
	public function index(){
        $redirect('license/daftar');
	}

/*
 *  Dinar Wahyu Wibowo
 *  PAGE LICENSE GENERATOR 
 */

    public function generator(){
        $this->data['toko']     = $this->model_license->get_toko();
        $this->template->bonobo_admin('license/bg_generator',$this->data);
    }

    public function generate(){
        if ($_POST) {
            $toko           = $this->template->clearInput($this->input->post('toko'));
            
            $duration       = $this->template->clearInput($this->input->post('duration'));
            $duration_type  = $this->template->clearInput($this->input->post('duration_type'));

            $unik = $this->db->where('email',$toko)->where('validity','1')->get('tb_activation_code');

            if ($unik->num_rows() > 0) {
                echo "2";
                return;
            }

            $saltkey        = $this->config->item('saltkey');

            $string         = $saltkey.".".$toko.".".$duration_type.".".$duration.".".date("Y-m-d H:i:s");

            $code = $this->generate_code($string,$toko);
            
            $toko_id = $this->db->where('email',$toko)->get('tb_toko')->row();
            
            $data = array(
                'toko_id'       => $toko_id->id,
                'code'          => $code,
                'email'         => $toko,
                'duration'      => $duration,
                'duration_type' => $duration_type,
                'validity'      => 1,
                'create_date'   => date("Y-m-d H:i:s"),
                'create_user'   => $_SESSION['bonobo_admin']->email,
                'update_user'   => $_SESSION['bonobo_admin']->email
                );

            $data_edit = array(                
                'code'          => $code,                
                'duration'      => $duration,
                'duration_type' => $duration_type,
                'validity'      => 1,
                'create_date'   => date("Y-m-d H:i:s"),
                'create_user'   => $_SESSION['bonobo_admin']->email,
                'update_user'   => $_SESSION['bonobo_admin']->email
                );

            //$request = $this->db->where('email',$toko)->where('validity','2')->get('tb_activation_code');

            //if ($request->num_rows() > 0) {
               // $insert = $this->db->where('id',$request->row()->id)->update('tb_activation_code',$data_edit);
            //}else{
                $insert = $this->db->insert('tb_activation_code',$data);
            //}
            
            if ($insert) {
                echo "<div class='callout callout-info'>
                        <h4>License telah di generate!</h4>
                        <div class='box-body'>
                            <dl class='dl-horizontal'>
                                <dt>Nama Toko</dt>
                                <dd>".$toko_id->name."</dd>
                                <dt>Durasi</dt>
                                <dd>".$duration."</dd>                                                
                                <dt>Tipe Durasi</dt>
                                <dd>";
                                if ($duration_type =='d') {
                                    echo "Hari";
                                }elseif ($duration_type =='m') {
                                    echo "Bulan";
                                }else{
                                    echo "Tahun";
                                } echo"</dd>
                                <dt><br></dt>
                                <dd><br></dd>
                                <dt>LICENSI CODE</dt>
                                <dd><h4>".$code."</h4></dd>
                            </dl>
                        </div>
                    </div>";
            }else{
                echo "0";
                //echo $request->num_rows();
            }
        }
    }

    function generate_code($string,$email){
        $bignum = hexdec( md5($string));
        $bignum = number_format($bignum);
        $bignum = str_replace(',', '',$bignum);
        $bignum = substr($bignum, 0,16);
        $bignum = chunk_split($bignum,4,"-");
        $bignum = substr($bignum, 0,19);

        $unik = $this->db->where('email',$email)->where('code',$bignum)->get('tb_activation_code');

        if ($unik->num_rows() > 0) {
            $code = $this->generate_code($string,$email);
        }else{
            return $bignum;
        }        
    }

/*
 *  Dinar Wahyu Wibowo
 *  PAGE LICENSE SETTING 
 */

    public function setting(){
        $this->template->bonobo_admin('license/bg_setting',$this->data);
    }

/*
 *  Dinar Wahyu Wibowo
 *  PAGE LICENSE SETTING 
 */
    public function save_setting(){
        if ($_POST) {
            $auto_add_license   = $this->template->clearInput($this->input->post($this->config->item('default_auto_add_license')));
            $duration_type      = $this->template->clearInput($this->input->post($this->config->item('default_duration_type')));
            $duration           = $this->template->clearInput($this->input->post($this->config->item('default_duration')));

            $code_1 = $this->template->clearInput($this->input->post('code_1'));
            $code_2 = $this->template->clearInput($this->input->post('code_2'));
            $code_3 = $this->template->clearInput($this->input->post('code_3'));
            $code_4 = $this->template->clearInput($this->input->post('code_4'));

            $code = implode('-', array($code_1,$code_2,$code_3,$code_4));
            

            //default_auto_add_license            
            if ($auto_add_license == 'on'){$auto_add = 1;}else{$auto_add = 0;}
            if ($this->model_license->get_config($this->config->item('default_auto_add_license'))->num_rows() > 0) {             
                $this->update_setting($this->config->item('default_auto_add_license'),$auto_add);
            }else{

                $this->insert_setting($this->config->item('default_auto_add_license'),$auto_add);
            }

            //default_code
            if ($this->model_license->get_config($this->config->item('default_code'))->num_rows() > 0) {                
                $this->update_setting($this->config->item('default_code'),$code);
            }else{
                $this->insert_setting($this->config->item('default_code'),$code);
            }

            //default_duration_type
            if ($this->model_license->get_config($this->config->item('default_duration_type'))->num_rows() > 0) {
                $this->update_setting($this->config->item('default_duration_type'),$duration_type);
            }else{
                $this->insert_setting($this->config->item('default_duration_type'),$duration_type);
            }

            //default_duration
            if ($this->model_license->get_config($this->config->item('default_duration'))->num_rows() > 0) {
                $this->update_setting($this->config->item('default_duration'),$duration);
            }else{
                $this->insert_setting($this->config->item('default_duration'),$duration);
            }
        }
    }

    private function update_setting($name,$value){
        $update = $this->db->where('name',$name)->set('value',$value)->update('tb_config');
        if ($update) {
            echo "1";
        }else{
            echo "0";
        }
    }

    private function insert_setting($name,$value){
        $insert = $this->db->set('name',$name)->set('value',$value)->insert('tb_config');
        if ($insert) {
            echo "1";
        }else{
            echo "0";
        }
    }

/*
 *  Dinar Wahyu Wibowo
 *  END PAGE LICENSE SETTING 
 */

    public function daftar(){

        
        $page=$this->uri->segment(4);
        $uri=4;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg = $this->model_license->get_license();        
        $url='admin/license/daftar';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['license']=$this->model_license->get_license($limit,$offset);
        
        if ($this->input->post('ajax')) {
            $this->load->view('admin/license/bg_daftar_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('license/bg_daftar',$this->data);
        }
        
        
    }

    public function search(){
        if(isset($_POST['search'])  ){
            $search = $this->db->escape_str($this->input->post('search'));
            
            if(empty($search)){$search ='all-search';}
            $_SESSION['search'] = $search;
        }   
        if(isset($_SESSION['search'])){         
            $page   = $this->uri->segment(4);
            $uri    = 4;
            $limit  = $this->limit;
            if(!$page){
                $offset = $this->offset;
            }else{
                $offset = $page;
            }
            
            $this->data["search"]   = $_SESSION['search'];
            $pg                     = $this->model_license->search($_SESSION['search']);
            $url                    = 'admin/license/search';
            $this->data['pagination']   = $this->template->paging2($pg,$uri,$url,$limit);
            $this->data['license']     = $this->model_license->search($_SESSION['search'],$limit,$offset);
            $this->load->view('admin/license/bg_daftar_ajax', $this->data);
        }
    }

    public function option()
    {
        if ($_POST) {
            $opt =  $this->input->post('opt');
            if ($opt != 3) {
                $_SESSION['option'] = $opt;
            }else{
                $_SESSION['option'] = null;
            }
            
        }
    }

}
