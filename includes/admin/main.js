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
	

})
