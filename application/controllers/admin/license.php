<?php
/*
 * Author : dinarwahyu13@gmail.com
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class License extends CI_Controller {
    var $data = array('scjav' => 'assets/jController/admin/CtrlLicense.js');

    function __construct(){
        parent::__construct();

        $this->load->model("admin/model_license");
    }
    
	public function index(){
        $redirect('license/daftar');
	}

    public function generator(){
        
    }

    public function setting(){
        
        $this->template->bonobo_admin('license/bg_setting',$this->data);
    }

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

    public function daftar(){
        
    }

}
