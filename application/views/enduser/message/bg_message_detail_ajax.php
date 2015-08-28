<?php


$date = '0000-00-00';
foreach(array_reverse($Messages) as $Message){
	$old_date 			= $Message->create_date;
	$old_date_timestamp = strtotime($old_date);
	$create_date 		= date('Y-m-d', $old_date_timestamp);
	$jam 		= date('H:i', $old_date_timestamp);

	if ($create_date != $date){
		$date = $create_date;

		$print_date 		= $this->hs_datetime->getDate4String($date);

		if ($create_date == date("Y-m-d")) {
			echo "<div class='datetime'><p>Hari Ini</p></div>";
		}else{
			echo "<div class='datetime'><p>".$print_date."</p></div>";
		}
	}

	if($Message->flag_from == 0){
		if ($Message->product_id != null) {
			$image = $this->model_toko_message->get_product_image($Message->product_id);

			if ($image->num_rows() > 0) {
				echo "<div class='row'><div class='pesanku'><img src='".base_url()."assets/pic/product/resize/".$image->row()->file."'><br>".$Message->message." <span class='white-text ' style='display:table;font-size:10px'>$jam</span></div></div>";
			}else{
				echo "string";
				//echo "<div class='row'><div class='pesanku'><img src='".base_url()."pic/product/resize/".$image->row()->file."'><br>Keterangan Gambar</div></div>";
			}
		}else{
			echo"<div class='row'><div class='pesanku'>".$Message->message." <span class='white-text ' style='display:table;font-size:10px'>$jam</span></div></div>";
		}		
	}else{
		echo"<div class='row'><div class='pesanmu'>".$Message->message." <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>$jam</span></div></div>";
	}
}

?>