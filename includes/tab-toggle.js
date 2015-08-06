// Copyright YouTube information Widget Plugin, by Samuel Elh ( sam.elegance-style.com/contact-me/ )

function yiw_tab_1(elem) {
	elem.classList.add('active');
	document.getElementById('sw-nd').setAttribute('class','');
	document.getElementById('sw-rd').setAttribute('class','');
	document.getElementById('ytio-last-uploads').setAttribute('class','');
	document.getElementById('ytio-popular-uploads').setAttribute('class','ytio-hid');
	document.getElementById('ytio-stats').setAttribute('class','ytio-hid');
}
function yiw_tab_2(elem) {
	elem.classList.add('active');
	document.getElementById('sw-st').setAttribute('class','');
	document.getElementById('sw-rd').setAttribute('class','');
	document.getElementById('ytio-last-uploads').setAttribute('class','ytio-hid');
	document.getElementById('ytio-popular-uploads').setAttribute('class','');
	document.getElementById('ytio-stats').setAttribute('class','ytio-hid');
}
function yiw_tab_3(elem) {
	elem.classList.add('active');
	document.getElementById('sw-st').setAttribute('class','');
	document.getElementById('sw-nd').setAttribute('class','');
	document.getElementById('ytio-last-uploads').setAttribute('class','ytio-hid');
	document.getElementById('ytio-popular-uploads').setAttribute('class','ytio-hid');
	document.getElementById('ytio-stats').setAttribute('class','');	
}
