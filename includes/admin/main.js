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
		$('#ytio-form input[type="submit"]').prop("disabled", "disabled");
		$('#ytio-submit img').css('display','inline-block');
		$('#ytio-submit span').css('display','none');
		$.ajax({
			url : "options-general.php?page=ytio_clear_cache",
			type : "post",
			success: function(){
				$('#ytio-form input[type="submit"]').prop("disabled", false);
				$('#ytio-submit img').css('display','none');
				$('#ytio-submit span').css('display','inline-block');
			}
		})
	})
	$('a.ytio-cc-alt').click(function() {
		$.ajax({
		url : "options-general.php?page=ytio_clear_cache",
		type : "post",
			success: function(){
				alert("Done! don't forget to save changes.");
			}
		})
		event.preventDefault();
	})
	
})
