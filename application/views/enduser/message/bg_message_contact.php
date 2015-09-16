<?php
foreach($Messages->result() as $Message){
							$MessageStatus = "";
							$MemberImage = base_url("assets/image/img_default_logo.jpg");
							
							if(!empty($Message->qmember_image) && file_exists("./assets/pic/user/".$Message->qmember_image)){
								$MemberImage = base_url("assets/pic/user/resize/".$Message->qmember_image);
							}
							
							$MessageNew = $this->model_toko_message->get_by_shop_member_new($_SESSION["bonobo"]["id"],$Message->member_id)->result();
							if(sizeOf($MessageNew) > 0){
								$MessageStatus = "<p class='red-text'>Pesan baru</p>";
							}
							
							$MessageLast = $this->model_toko_message->get_by_shop_member_last($_SESSION["bonobo"]["id"],$Message->member_id)->row();
							
							echo"
								<li class='col s12 m12 listanggodaf waves-effect' onclick=ctrlMessage.showMessageDetail(".$Message->member_id.")>
									<div class='col s3 m5 l4'>
										<img src='".$MemberImage."' class='responsive-img userimg'>
									</div>
									<div class='col s9 m7 l8'>
										<p class=' blue-grey-text lighten-3 right'>".$this->hs_datetime->getTime4String($MessageLast->create_date)."</p>
										<p><a  href=''><b class='userangoota'>".$Message->qmember_name."</b></a></p>															
										<p>".$this->template->limitChar($MessageLast->message,50)."</p>
										".$MessageStatus."
										<a href='#popupDelete' onclick=ctrlMessage.popupDelete(".$Message->member_id.",'".urlencode($Message->member_name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>
									</div>
								</li>
							";
						}
echo "
<script>
var offset_c=5;		
		function scrollContact () {
			
		    if ($('#contact-scroll').scrollTop() == ($('#contact-scroll').get(0).scrollHeight - $('#contact-scroll').height()) && scroll==true) {
		        $('#loader-contact').slideDown();
		        
		        scroll      = false;		        
		        var id  	= $('#member').val();
		        var url 	= base_url+'message/showContactDetail/'+offset_c;

		        //$('#contact-scroll').scrollTo(0, ($('#contact-scroll').get(0).scrollHeight - 50) );
		        $.ajax({
		            type: 'POST',
		            data: 'ajax=1&id='+id,
		            url: url,
		            async: false,
		            success: function(msg) {
		                if (msg){
		                    $('#contact-pesan').append(msg);
		                    $('#loader-contact').slideUp();
		                    offset_c = offset_c+5;		                    
		                    scroll   = true;		                    
		                }else{
		                    $('#loader-contact').slideUp();
		                    scroll   = false;
		                    $('#habis-contact').slideDown();
		                }
		            }
		        });
		        return false;
		    }
		}
</script>
";