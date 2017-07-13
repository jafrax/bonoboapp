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
		
		$message = $this->viewEmail($message);
        
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
        $config['max_size'] 		= 1000;
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

    //upload picture not with resize
	function upload_picture_not_resize($url,$name,$name_resize,$picture=null,$width=325,$height=325){
		$ci = & get_instance();
        $ci->load->library('upload');
		$ci->load->library('image_lib');
		
        $config['upload_path'] 		= $url; 
        $config['allowed_types'] 	= "gif|jpg|png|jpeg|bmp";
        $config['max_size'] 		= 1000;
        $config['encrypt_name'] 	= TRUE;
        $ci->upload->initialize($config);

		$result = '';
        if($ci->upload->do_upload($name)){
            $data=$ci->upload->data();
            $ci->image_lib->clear();
			
            $image['image_library'] = "GD2";
            $image['source_image'] 	= $data['full_path'];
			$ci->image_lib->initialize($image);

            $result 	= $data['file_name'];

            $img_resize 		= $name_resize;
			$img_resize 		= str_replace('data:image/png;base64,', '', $img_resize);
			$img_resize 		= str_replace(' ', '+', $img_resize);
			$data_img_resize 	= base64_decode($img_resize);
			$file 				= $url.'resize/'.$result;
			$success 			= file_put_contents($file, $data_img_resize);
            
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
	
	function viewEmail($message){
		return "
	<!doctype html>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
	<head>
		<!-- NAME: 1 COLUMN -->
		<!--[if gte mso 15]>
		<xml>
			<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>*|MC:SUBJECT|*</title>
        
    <style type='text/css'>
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
		}
		.templateContainer{
			max-width:600px !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#FAFAFA;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:32px;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:30px;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:26px;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:24px;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email's preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:18px;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email's header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email's header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:24px;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email's body area.
	*/
		#templateBody{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email's body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:24px;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email's footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:18px;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnShareContent,.mcnCaptionTopContent,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:28px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:26px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:24px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:22px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:22px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:22px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:24px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:24px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:22px !important;
		}

}</style></head>
    <body>
        <center>
            <table align='center' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
                <tr>
                    <td align='center' valign='top' id='bodyCell'>
                        <!-- BEGIN TEMPLATE // -->
						<!--[if gte mso 9]>
						<table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
						<tr>
						<td align='center' valign='top' width='600' style='width:600px;'>
						<![endif]-->
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
                            <tr>
                                <td valign='top' id='templatePreheader'></td>
                            </tr>
                            <tr>
                                <td valign='top' id='templateHeader'><table class='mcnImageBlock' style='min-width:100%;' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnImageBlockOuter'>
            <tr>
                <td style='padding:9px' class='mcnImageBlockInner' valign='top'>
                    <table class='mcnImageContentContainer' style='min-width:100%;' align='left' border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <tbody><tr>
                            <td class='mcnImageContent' style='padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;' valign='top'>
                                
                                    
                                        <img alt='' src='".base_url("html/images/comp/logo/c_logo_shadow.png")."' style='max-width:161px; padding-bottom: 0; display: inline !important; vertical-align: bottom;' class='mcnImage' align='middle' width='161'>
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table class='mcnTextBlock' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td class='mcnTextBlockInner' valign='top'>
                
                <table class='mcnTextContentContainer' align='left' border='0' cellpadding='0' cellspacing='0' width='600'>
                    <tbody><tr>
                        
                        <td class='mcnTextContent' style='padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;' valign='top'>
                        
                            <div style='text-align: center;'><span style='font-size:12px'><span style='font-family:tahoma,verdana,segoe,sans-serif'>Memberikan pelayanan berbelanja online di Bonoboapp.com</span></span></div>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table class='mcnDividerBlock' style='min-width:100%;' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnDividerBlockOuter'>
        <tr>
            <td class='mcnDividerBlockInner' style='min-width:100%; padding:18px;'>
                <table class='mcnDividerContent' style='min-width: 100%;border-top: 2px solid #EAEAEA;' border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign='top' id='templateBody'><table class='mcnTextBlock' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td class='mcnTextBlockInner' valign='top'>
                
                <table class='mcnTextContentContainer' align='left' border='0' cellpadding='0' cellspacing='0' width='600'>
                    <tbody><tr>
                        
                        <td class='mcnTextContent' style='padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;' valign='top'>".$message."</td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign='top' id='templateFooter'><table class='mcnDividerBlock' style='min-width:100%;' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnDividerBlockOuter'>
        <tr>
            <td class='mcnDividerBlockInner' style='min-width: 100%; padding: 10px 18px 25px;'>
                <table class='mcnDividerContent' style='min-width: 100%;border-top: 2px solid #EEEEEE;' border='0' cellpadding='0' cellspacing='0' width='100%'>
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table><table class='mcnTextBlock' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody class='mcnTextBlockOuter'>
        <tr>
            <td class='mcnTextBlockInner' valign='top'>
                
                <table class='mcnTextContentContainer' align='left' border='0' cellpadding='0' cellspacing='0' width='600'>
                    <tbody><tr>
                        
                        <td class='mcnTextContent' style='padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;' valign='top'>
                        
                            <span style='font-family:tahoma,verdana,segoe,sans-serif'><strong>PRIVATE ONLINE PLATFORM</strong><br>
Copyright © Bonoboapp.com, All rights reserved.</span><br>
&nbsp; <a href='http://www.bonoboapp.com/'>www.bonoboapp.com</a>
                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						<!--[if gte mso 9]>
						</td>
						</tr>
						</table>
						<![endif]-->
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
";
	}
	
}
	