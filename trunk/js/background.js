// Onload: Background Resize
// Void the image src before binding onload (http://code.google.com/p/chromium/issues/detail?id=7731)
/*background_image_src = $('#background-image').attr('src');
$('#background-image').attr('src','');
$('#background-image').bind("load", function() {
    bgResize();
    
    // Reset the body background
    $('body').css({backgroundColor: 'transparent'});    
}, false);
$('#background-image').attr('src',background_image_src);*/


// Resize the background

var bgResize = function() {
	var bgImg = $('#background-image'),
		newWidth,
		imgWidth = bgImg.width(),
		imgHeight = bgImg.height(),
		winWidth = $(window).width(),
		widthRatio = winWidth / imgWidth,
		heightRatio = $(window).height() / imgHeight;
		
	if (widthRatio < heightRatio) {
		widthRatio = heightRatio;
	}
	
	newWidth = widthRatio * imgWidth;
		
	bgImg.css({
		width:  newWidth + 'px',
		height: (widthRatio * imgHeight) + 'px',
		padding: 0,
		left: newWidth > winWidth ? '-' + (newWidth - winWidth) / 2 + 'px' : 0
	});
}

// Background Resize
$(window).resize(bgResize);
$(window).load(bgResize);
bgResize();
//$(document).ready(bgResize);
