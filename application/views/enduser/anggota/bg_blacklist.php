<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."'>ANGGOTA BARU</a> <span class='new badge'>".$countNewMember."</span></li>
			<li><a href='".base_url("anggota/invite")."'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."' class='active'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		Blacklist
	</div>
";

?>