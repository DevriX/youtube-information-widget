// Copyright YouTube information Widget Plugin, by Samuel Elh ( sam at elegance-style.com )

$(document).ready(function(){

	$('#ytio-switch #sw-st').click(function(){
		$(this).addClass("active");
		$('#ytio-switch #sw-nd,#ytio-switch #sw-rd').removeClass("active");
		$('#ytio-popular-uploads,#ytio-stats').addClass("ytio-hid");
		$('#ytio-last-uploads').removeClass("ytio-hid");
	})
	$('#ytio-switch #sw-nd').click(function(){
		$(this).addClass("active");
		$('#ytio-switch #sw-st,#ytio-switch #sw-rd').removeClass("active");
		$('#ytio-popular-uploads').removeClass("ytio-hid");
		$('#ytio-last-uploads,#ytio-stats').addClass("ytio-hid");
	})
	$('#ytio-switch #sw-rd').click(function(){
		$(this).addClass("active");
		$('#ytio-switch #sw-st,#ytio-switch #sw-nd').removeClass("active");
		$('#ytio-stats').removeClass("ytio-hid");
		$('#ytio-last-uploads,#ytio-popular-uploads').addClass("ytio-hid");
	})

})
