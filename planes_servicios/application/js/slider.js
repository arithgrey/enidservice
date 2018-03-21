$('.search').click(function(){
		$(this).addClass('active');
		$(this).find('input').focus();
		$(document).mouseup(function (e)
			{
			var searchInpt = $('.search');

			if (!searchInpt.is(e.target) && searchInpt.has(e.target).length === 0) { 
			    searchInpt.removeClass('active');
			}
		});
	});
	$('nav li a').click(function(){
		$('nav li a').removeClass('active');
		$(this).addClass('active');
	});
	$('.slider .slide').not(':first-child').hide();
	$('.slider .slider-nav .next').click(function() {
		if ($('.slide.active').next('.slide').length === 0 ) {
			$('.slide:last').removeClass('active').hide();
			$('.slide:first').addClass('active').fadeIn();
		} else {
			$('.slide.active').hide().removeClass('active').next('.slide').fadeIn().addClass('active');
		}
	});
	$('.slider .slider-nav .prev').click(function() {
		if ($('.slide.active').prev('.slide').length === 0 ) {
			$('.slide:first').removeClass('active').hide();
			$('.slide:last').addClass('active').fadeIn();
		} else {
			$('.slide.active').hide().removeClass('active').prev('.slide').fadeIn().addClass('active');
		}
	});