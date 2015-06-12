<?php class Template{
	
	# START TEMPLATE #
	function admin($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->view('admin/templates/bg_top', $data);
		$ci->load->view('admin/templates/bg_header', $data);
		$ci->load->view($view, $data);
		$ci->load->view('admin/templates/bg_bottom', $data);
	}
	
	function user($view=null,$data=null){
        $ci =& get_instance();
		$ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
		$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('enduser/templates/bg_top', $data);
		$ci->load->view('enduser/templates/bg_header', $data);
		$ci->load->view('enduser/'.$view, $data);
		$ci->load->view('enduser/templates/bg_bottom', $data);
	}
	
	function user2($view=null,$data=null){
        $ci =& get_instance();
		$ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
		$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
		$ci->load->view('enduser/templates/bg_top', $data);
		$ci->load->view('enduser/templates/bg_header_small', $data);
		$ci->load->view('enduser/'.$view, $data);
		$ci->load->view('enduser/templates/bg_bottom', $data);
	}

    function user_website($view=null,$data=null){
        $ci =& get_instance();
		$ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
		$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('enduser/templates/bg_top', $data);
        $ci->load->view('enduser/templates/bg_slidder', $data);
        $ci->load->view('enduser/'.$view, $data);
        $ci->load->view('enduser/templates/bg_bottom', $data);
    }
	# END TEMPLATE #
	
    # START TEMPLATE #    
    function v2_user($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('v2/templates/bg_top', $data);
        $ci->load->view('v2/templates/bg_header', $data);
        $ci->load->view('v2/templates/bg_left_home', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('v2/templates/bg_bottom', $data);
    }
    
    function v2_user2($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('v2/templates/bg_top', $data);
        $ci->load->view('v2/templates/bg_header', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('v2/templates/bg_bottom', $data);
    }

    function v2_user_search($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('v2/templates/bg_top', $data);
        $ci->load->view('v2/templates/bg_header_small', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('v2/templates/bg_bottom', $data);
    }

    function v2_buyer($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('v2/templates/bg_top', $data);
        $ci->load->view('v2/templates/bg_header_small', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('v2/templates/bg_bottom', $data);
    }

    function v2_user_website($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        $ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        $ci->load->view('v2/templates/bg_top', $data);
        $ci->load->view('v2/templates/bg_slidder', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('enduser/templates/bg_bottom', $data);
    }
	
	function company($view=null,$data=null){
		$ci =& get_instance();
		
		$ci->load->model('Facebook_Model', 'fb');
		$ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        $data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
		
        $ci->load->view('v2/templates/bg_top', $data);
		$ci->load->view('v2/templates/c_header', $data);
        $ci->load->view('v2/'.$view, $data);
        $ci->load->view('v2/templates/bg_bottom', $data);
	}
    # END TEMPLATE #


    function paging($total,$uri,$url,$limit){
        $ci 						=& get_instance();
		$config['base_url'] 		= base_url($url);
		$config['total_rows'] 		= count($total);
		$config['per_page']			= $limit;
		$config['full_tag_open']	= '<div id="pagination">';
		$config['full_tag_close']	= '</div>';
		$config['uri_segment']		= $uri;
		$config['first_link']		= 'First';
		$config['last_link']		= 'Last';
		$config['next_link']		= '&raquo;';
		$config['prev_link']		= '&laquo;';
		
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
    }
	
	
	function paging1($pg,$uri,$url,$limit){
        $ci =& get_instance();
        $pg=$pg;
		
		$config['base_url'] = base_url($url);
		$config['total_rows'] = $pg->num_rows();
		$config['per_page']=$limit;
		$config['full_tag_open']='<div id="pagination">';
		$config['full_tag_close']='</div>';
		$config['uri_segment']=$uri;
		$config['first_link']='First';
		$config['last_link']='Last';
		$config['next_link']='>>';
		$config['prev_link']='<<';
		
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
    }
    
	
	function send_email($to,$subject,$message,$from=null,$nama=null){
        $ci = & get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtps";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "ifarsolo@gmail.com"; 
        $config['smtp_pass'] = "ifarsolo123";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $ci->email->initialize($config);
        if($from != null){
            $ci->email->from($from,$nama);
        }else{
            $ci->email->from('no-reply@vertibox.com','no-reply@vertibox.com');
        }
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($message);
        $send = $ci->email->send();
		if($send){
			return 'sent';
		}
    }
	
	function rand($length){
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }
		
    # ENCRIPTION
    //$key = 'visione-system@12345'; ojo diganti
    var $key = 'visione-system@12345';
    function encrypt($string) {
            $result = '';
            for($i = 0; $i < strlen($string); $i++) {
                    $char = substr($string, $i, 1);
                    $keychar = substr($this->key, ($i % strlen($this->key))-1, 1);
                    $char = chr(ord($char) + ord($keychar));
                    $result .= $char;
            }

            return base64_encode($result);
    }

    function decrypt($string) {
            $result = '';
            $string = base64_decode($string);

            for($i = 0; $i < strlen($string); $i++) {
                    $char = substr($string, $i, 1);
                    $keychar = substr($this->key, ($i % strlen($this->key))-1, 1);
                    $char = chr(ord($char) - ord($keychar));
                    $result .= $char;
            }

            return $result;
    }
	
	//upload picture with resize
	function upload_picture($url,$name,$picture=null,$width=325,$height=325){
		$ci = & get_instance();
        $ci->load->library('upload');
		$ci->load->library('image_lib');
        $config['upload_path'] 		= $url; 
        $config['allowed_types'] 	= "gif|jpg|png|jpeg|bmp";
        $config['max_size'] 		= 3000;
        $config['encrypt_name'] 	= TRUE;
        $ci->upload->initialize($config);
        $logo='';
        if($ci->upload->do_upload($name)){
            $data=$ci->upload->data();
            $ci->image_lib->clear();
            $image['image_library'] = "GD2";
            $image['source_image'] 	= $data['full_path'];
            $image['new_image'] 	= $url.'resize/'.$data['file_name'];
            $size 					= getimagesize($_FILES[$name]["tmp_name"]);
            $image['maintain_ratio']= TRUE;
			$image['master_dim'] 	= 'auto';
			$image['width'] 		= $width;
			$image['height'] 		= $height;
            $ci->image_lib->initialize($image);
            $ci->image_lib->resize();
            $logo 	= $data['file_name'];
            if($picture!=null){
                @unlink($url.$picture);
                @unlink($url."resize/$picture");
            }
        }else{
			$logo = 'error';
		}
        return $logo;
    }
	
	function sluggify($url){
		# Prep string with some basic normalization
		$url = strtolower($url);
		$url = strip_tags($url);
		$url = stripslashes($url);
		$url = html_entity_decode($url);
	
		# Remove quotes (can't, etc.)
		$url = str_replace('\'', '', $url);
	
		# Replace non-alpha numeric with hyphens
		$match = '/[^a-z0-9]+/';
		$replace = '-';
		$url = preg_replace($match, $replace, $url);
	
		$url = trim($url, '-');
	
		return $url;
	}

    function removeSlash($text){
        # Prep string with some basic normalization
        $text = stripslashes($text);
    
        # Remove quotes (can't, etc.)
        $text = str_replace('\'', '', $text);
    
        # Replace non-alpha numeric with hyphens
        $match = '/[^a-z0-9]+/';
        $replace = '';
        $text = preg_replace($match, $replace, $text);
    
        return $text;
    }
	
	function limitChar($content, $limit=15){
		if (strlen($content) <= $limit) {
			return $content;
		} else {
			$hasil = substr($content, 0, $limit);
			return $hasil . "...";
		}
	}
	
	function notif($patern,$data1=null,$data2=null,$data3=null){
		$notif = lang($patern);
		
		if(!empty($data1)){
			$notif = str_replace("[1?]",$data1,$notif);
		}
		
		if(!empty($data2)){
			$notif = str_replace("[2?]",$data2,$notif);
		}
		
		if(!empty($data3)){
			$notif = str_replace("[3?]",$data3,$notif);
		}
		
		$notif = str_replace("[1?]","",$notif);
		$notif = str_replace("[2?]","",$notif);
		$notif = str_replace("[3?]","",$notif);
		
		return $notif;
	}

	function closetags ( $html )
        {
        #put all opened tags into an array
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
        $openedtags = $result[1];
        #put all closed tags into an array
        preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
        $closedtags = $result[1];
        $len_opened = count ( $openedtags );
        # all tags are closed
        if( count ( $closedtags ) == $len_opened )
        {
        return $html;
        }
        $openedtags = array_reverse ( $openedtags );
        # close tags
        for( $i = 0; $i < $len_opened; $i++ )
        {
            if ( !in_array ( $openedtags[$i], $closedtags ) )
            {
            $html .= "</" . $openedtags[$i] . ">";
            }
            else
            {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
            }
        }
        return $html;
    }

    public function cek_email($to_id,$last_chat){
        $ci =& get_instance();
        $ci->load->model("enduser/model_message");
        $ci->load->model("enduser/model_company");
        $ci->load->model("enduser/model_user_contact");
        $company    = $ci->model_company->get_company_id($to_id)->row();
        $cek_member = $ci->model_company->get_name($company->company_id)->row();
        $durasi     = $ci->model_message->cek_durasi()->row();
        
        $jam        = $last_chat;
        //$datetime1  = date('H:i:s', $jam);
        $diff1  = $this->xTimeAgo($jam,date('Y-m-d H:i:s'));
        $diff2  = $this->xTimeAgo($jam,date('Y-m-d H:i:s'));     
        
        $messages       = $ci->model_message->get_rung_ditonton($to_id);
        $data['email']  = $company->email;      
        $data['name']   = $_SESSION['vertibox']['name'];
        $data['pesan']  = '';
        //echo "string";
        foreach($messages->result() as $Message){
            $user_image = base_url("assets/icon/user-def.png");         
            
            if(!empty($Message->userfrom_image)){
                $user_image = base_url("assets/pic/user/resize/".$Message->userfrom_image);
            }

            $hour = strtotime($Message->message_update);
            $message_hour = date('H:i', $hour);

            if($Message->message_date == date('Y-m-d')){
                $date = $message_hour;
            }else{
                $date = $Message->message_date;
            }
            $data['pesan'] .= "
                <div style='margin-bottom: 10px;margin-top: 10px;min-height: 50px;'>
                    <img src='".$user_image."' style='border: 1px solid #ddd !important;border-radius: 5px;height: 50px;position: absolute;width: 50px;'> 
                    <div style='margin-left: 70px;'>
                        <div style='color: #aaa;cursor: pointer;display: inline-block;float: right;font-size: 11px;margin-top: 5px;padding: 5px;text-shadow: none;'>".$date."</div>
                        <a href='#' style='color: #337ab7;text-decoration: none;'>".$Message->userfrom_name." - (".$Message->company_name.")</a><br>".$Message->message_text."
                    </div>
                </div>                              
            ";
        }

        $message= $ci->load->view('v2/email/send_chat',$data,TRUE);
        
        if ($ci->model_company->get_name($company->company_id)->num_rows() > 0){
            if (($cek_member->verified == 2 || $cek_member->verified == 1) && $durasi->gold_message_status == 1 ){
                if ($diff1 >= $durasi->gold_message_hour){
                    $sending=$ci->template->send_email($company->email,'New Message from '.$_SESSION['vertibox']['name'],$message,'no-reply@vertibox.com','no-reply@vertibox.com');
                    //echo "gold";
                }
            }elseif ($cek_member->verified == 0 && $durasi->free_message_status == 1){
                if ($diff2 >= $durasi->free_message_hour){
                    $sending=$ci->template->send_email($company->email,'New Message from '.$_SESSION['vertibox']['name'],$message,'no-reply@vertibox.com','no-reply@vertibox.com');
                    //echo "free";
                }
            }
			//echo $cek_member->verified.":".$durasi->free_message_status."<br> diff- durasi".$diff2 .":". $durasi->free_message_hour."<br>";
			//echo $jam." ".date('Y-m-d H:i:s');
        }else{
            if ($durasi->free_message_status == 1){
                if ($diff2 >= $durasi->free_message_hour){
                    $sending=$ci->template->send_email($company->email,'New Message from '.$_SESSION['vertibox']['name'],$message,'no-reply@vertibox.com','no-reply@vertibox.com');
                    //echo "string";
                }
            }
        }
    }

    public function selisih($jam_masuk,$jam_keluar) {
        list($h,$m,$s) = explode(":",$jam_masuk);
        $dtAwal = mktime($h,$m,$s,"1","1","1");
        list($h,$m,$s) = explode(":",$jam_keluar);
        $dtAkhir = mktime($h,$m,$s,"1","1","1");
        $dtSelisih = $dtAkhir-$dtAwal;

        $totalmenit=$dtSelisih/60;
        $jam =explode(".",$totalmenit/60);
        $sisamenit=($totalmenit/60)-$jam[0];
        $sisamenit2=$sisamenit*60;
        $jml_jam=$jam[0];
        return $jml_jam;
    }
	
	function xTimeAgo ($oldTime, $newTime) {
        $timeCalc = strtotime($newTime) - strtotime($oldTime);       
        $timeCalc = round($timeCalc/60/60);
        return $timeCalc;
    }
	
}