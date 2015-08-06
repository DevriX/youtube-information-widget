// Copyright YouTube information Widget Plugin, by Samuel Elh ( sam.elegance-style.com/contact-me/ )

$(document).ready(function(){

	$('div[id*="_yiw_widget"] input[type="submit"]').click(function() {
		$('div[id*="_yiw_widget"] input[type="submit"]').prop("disabled", "disabled");
		$.ajax({
			url : "../wp-content/plugins/youtube-information-widget/includes/clear_cache.php",
			type : "post",
			success: function(){
				$('div[id*="_yiw_widget"] input[type="submit"]').prop("disabled", false);
			}
		})
	})
	$('a.yiw-cc-alt').click(function() {
		$('span.yiw-cc-msg').html('doing..');
		$.ajax({
		url : "../wp-content/plugins/youtube-information-widget/includes/clear_cache.php",
		type : "post",
			success: function(){
				//alert("Done! don't forget to save changes.");
				$('span.yiw-cc-msg').html('done!');
			}
		})
		event.preventDefault();
	})
	
})
