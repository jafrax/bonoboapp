<?php class Template{
	
	# START TEMPLATE #
	function bonobo_step($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        
		$ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        //$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
		
        $ci->load->view('enduser/template/bg_header', $data);
		$ci->load->view('enduser/template/bg_nav_step', $data);
		$ci->load->view($view, $data);
		$ci->load->view('enduser/template/bg_footer', $data);
	}

    function bonobo($view=null,$data=null){
        $ci =& get_instance();
        $ci->load->model('Facebook_Model', 'fb');
        
		$ci->getFbUser = $ci->fb->getUser();
        $ci->data['getFbUser'] = $ci->getFbUser;
        //$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        
		$ci->load->view('enduser/template/bg_header', $data);        
        $ci->load->view('enduser/'.$view, $data);
        $ci->load->view('enduser/template/bg_footer', $data);
    }

	function bonobo_admin($view=null,$data=null){
        $ci =& get_instance();
        //$ci->load->model('Facebook_Model', 'fb');
        
		//$ci->getFbUser = $ci->fb->getUser();
        //$ci->data['getFbUser'] = $ci->getFbUser;
        //$data['recaptcha'] = $ci->recaptcha->recaptcha_get_html();
        
		$ci->load->view('admin/template/bg_header', $data);        
		$ci->load->view('admin/template/bg_nav_right', $data);        
		$ci->load->view('admin/template/bg_left', $data);        
        $ci->load->view('admin/'.$view, $data);
        $ci->load->view('admin/template/bg_bottom', $data);
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
		$config['uri_segment']=$uri;
		$config['full_tag_open']="<ul class='pagination'>";
		$config['full_tag_close']='</ul>';
		$config['num_tag_open'] = "<li class='waves-effect'>";
		$config['num_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0);'>";
		$config['cur_tag_lose'] = "</a></li>";
		$config['first_link']="<li class='waves-effect'>First</li>";
		$config['last_link']="<li class='waves-effect'>Last</li>";
		$config['next_link']="<li class='waves-effect'><i class='mdi-navigation-chevron-right'></i></li>";
		$config['prev_link']="<li class='waves-effect'><i class='mdi-navigation-chevron-left'></i></li>";
		
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
    }
	
	function paging2($pg,$uri,$url,$limit){
        $ci =& get_instance();
        $pg=$pg;
		
		$config['base_url'] = base_url($url);
		$config['total_rows'] = $pg->num_rows();
		$config['per_page']=$limit;
		$config['uri_segment']=$uri;
		$config['full_tag_open']="<ul class='pagination pagination-sm no-margin pull-right'>";
		$config['full_tag_close']="</ul>";
		$config['uri_segment']		= $uri;
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class='active'><span>";
		$config['cur_tag_lose'] = "</span></li>";
		$config['first_link']		= "First";
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['next_link']		= "&raquo;";
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_link']		= "Last";
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link']		= "&laquo;";
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
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
            $ci->email->from('no-reply@bonoboapp.com','no-reply@bonoboapp.com');
        }
        
		$ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($message);
        
		if($ci->email->send()){
			return true;
		}else{
			return false;
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
        
		$result = '';
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
            $result 	= $data['file_name'];
            
			if($picture!=null){
                @unlink($url.$picture);
                @unlink($url."resize/".$picture);
            }
        }else{
			$result = 'error';
		}
		
        return $result;
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

    function clearInput($text){
        $name   = mysql_real_escape_string($text);
        $name   = preg_replace('/\\\\/', '', $name);
        return $name;
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
	
	function xTimeAgo ($oldTime, $newTime) {
        $timeCalc = strtotime($newTime) - strtotime($oldTime);       
        $timeCalc = round($timeCalc/60/60);
        return $timeCalc;
    }


    function xTimeAgoDesc ($oldTime, $newTime) {
        $timeCalc = strtotime($newTime)-strtotime($oldTime);

        if ($timeCalc > (60*60*24)) {$timeCalc = round($timeCalc/60/60/24) . " hari yang lalu";}
        else if ($timeCalc > (60*60)) {$timeCalc = round($timeCalc/60/60) . " jam yang lalu";}
        else if ($timeCalc > 60) {$timeCalc = round($timeCalc/60) . " menit yang lalu";}
        else if ($timeCalc > 0) {$timeCalc .= " detik yang lalu";}

        return $timeCalc;
    }    

    function cek_license(){
    	if (isset($_SESSION['bonobo'])) {    		
	    	$date1 = date("Y-m-d");
			$date2 = $_SESSION['bonobo']['expired_on'];

			$diff = abs(strtotime($date2) - strtotime($date1));

			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			if (date('Y-m-d') > $_SESSION['bonobo']['expired_on'] || $_SESSION['bonobo']['expired_on'] == "0000-00-00") {
				redirect('license');
			}
    	}else{
    		redirect('index/logout');
    	}
	}
	
	function limitc($text, $limit=18){
		$cetak = substr($text,0,$limit);
		return $cetak;
	}

	function print2pdf($title='',$content='')
	{
		$ci =& get_instance();
		$ci->load->helper('pdf_helper');
		
		$data['title']  	= $title;
		$data['content']	= $content;
	    $ci->load->view('pdfreport', $data);
	}
	
}
	