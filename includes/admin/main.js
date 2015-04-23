/* Copyright YouTube information Widget Plugin, by Samuel Elh ( sam at elegance-style.com ) */

$(document).ready(function(){

	$('.ytio-help-user').click(function(){
		$(this).toggleClass("ytio-help-active");
		$('#ytio-help-user').toggleClass("ytio-hid");
	})
	$('.ytio-help-id').click(function(){
		$(this).toggleClass("ytio-help-active");
		$('#ytio-help-id').toggleClass("ytio-hid");
	})
	$('.ytio-help-max').click(function(){
		$(this).toggleClass("ytio-help-active");
		$('#ytio-help-max').toggleClass("ytio-hid");
	})
	$('.ytio-help-width').click(function(){
		$(this).toggleClass("ytio-help-active");
		$('#ytio-help-width').toggleClass("ytio-hid");
	})
	$('.ytio-help-height').click(function(){
		$(this).toggleClass("ytio-help-active");
		$('#ytio-help-height').toggleClass("ytio-hid");
	})
	$('#ytio-form input').change(function() {
		$('#ytio-form input[type="submit"]').attr( "disabled", "disabled" );
		$('#ytio-clear-cache').css('display','block');
	})
	
	$('#ytio-clear-cache a').click(function(){
	$('#ytio-clear-cache img').css('display','inline-block');
	$.ajax({
		url : "options-general.php?page=ytio_clear_cache",
		type : "post",
		success: function(){
			$('#ytio-form input[type="submit"]').prop("disabled", false);
			$('#ytio-clear-cache img').css('display','none');
			$('#ytio-clear-cache span').css('display','inline-block');
			setTimeout(function() {
				$('#ytio-clear-cache,#ytio-clear-cache img,#ytio-clear-cache span').css('display','none');
			}, 5000);
		}
	})
	event.preventDefault();
	})
})
