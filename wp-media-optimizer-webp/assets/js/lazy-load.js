/*jQuery(document).ready(function() {
	[].forEach.call(document.querySelectorAll('img[data-lazysrc]'), function(img) {
		img.setAttribute('src', img.getAttribute('data-lazysrc'));
		img.onload = function() {
			img.removeAttribute('data-lazysrc');
		};
	});
})*/
jQuery(document).ready(function($) {
	$(window).scroll(function() {
		$.each($('img'), function() {
			if($(this).attr('data-lazysrc') && $(this).offset().top < ($(window).scrollTop() + $(window).height() + 10)) {
				$(this).attr('src', $(this).attr("data-lazysrc"));
				$(this).removeAttr('data-lazysrc');
			}
		})
	})
})