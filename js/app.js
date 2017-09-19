function hide() {
	$('.characters').css({height: 0})
	$('.fader').addClass('hide');
}

function show() {
	$('.characters').css({height: "200px"})
	$('.fader').removeClass('hide');
}


$(document).ready(function() {
	
	$('.fader').on('click', function() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "index.php", true);	
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		if ( !$(this).hasClass("hide") ) {
			$('.characters').css({animation: "anim_hide 2s ease forwards"});
			xmlhttp.send("c_hide_footer=1");	
		} else {
			$('.characters').css({animation: "anim_show 2s ease forwards"});
			xmlhttp.send("c_hide_footer=0");		
		}
		
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//alert(this.responseText);
		}
    };
		$(this).toggleClass("hide");
	});
	//$('#')
});