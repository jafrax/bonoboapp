<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Forbidden</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/error/style.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/css/notification.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/error/tipsy/tipsy.css" media="all"/>
<script type="text/javascript" src="<?=base_url()?>assets/jLib/jQuery/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/error/tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/error/effect/jquery-jrumble.js"></script>
<script type="text/javascript">
          jQuery(function($){
			 $('#tv-wrap').jrumble({ x: 4,y: 0,rotation: 0 });	
			$('#tv-wrap').trigger('startRumble');		  
              $('.slides').addClass('active').cycle({
                  fx:     'none',
                  speed:   1,
                  timeout: 70
              }).cycle("resume");	
          });
</script>
<style type="text/css">
html {
	background-image: none;
}
</style>
</head>
<body class="error">
<a href="<?= base_url()?>">
<div class="errorpage">
<div id="tv-wrap"> <img src="<?=base_url()?>assets/error/tv.png" width="300" height="273" id="tv"/>
  <div class="slideshow-block">
    <ul class="slides">
        <li><img src="<?=base_url()?>assets/error/javascript_error.png"/></li>
    </ul>
  </div>
</div>
<div id="text">
  <h1> 404 Page not found!</h1>
  <h2>Oops! Sorry, an error has occured.</h2>
</div>
</a>
<div class="clear"></div>
<script type="text/javascript">
var text = document.getElementById('text'),
	body = document.body,
	steps = 7;
function threedee (e) {
	var x = Math.round(steps / (window.innerWidth / 2) * (window.innerWidth / 2 - e.clientX)),
		y = Math.round(steps / (window.innerHeight / 2) * (window.innerHeight / 2 - e.clientY)),
		shadow = '',
		color = 190,
		radius = 3,
		i;	
	for (i=0; i<steps; i++) {
		tx = Math.round(x / steps * i);
		ty = Math.round(y / steps * i);
		if (tx || ty) {
			color -= 3 * i;
			shadow += tx + 'px ' + ty + 'px 0 rgb(' + color + ', ' + color + ', ' + color + '), ';
		}
	}
	shadow += x + 'px ' + y + 'px 1px rgba(0,0,0,.2), ' + x*2 + 'px ' + y*2 + 'px 6px rgba(0,0,0,.3)';	
	text.style.textShadow = shadow;
	text.style.webkitTransform = 'translateZ(0) rotateX(' + y*1.5 + 'deg) rotateY(' + -x*1.5 + 'deg)';
	text.style.MozTransform = 'translateZ(0) rotateX(' + y*1.5 + 'deg) rotateY(' + -x*1.5 + 'deg)';
}
document.addEventListener('mousemove', threedee, false);
</script>
</body>
</html>