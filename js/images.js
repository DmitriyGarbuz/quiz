jQuery(document).ready(function($) {	
	var gallerywidth = $('div[id*="js__gallery--center--container"]').width();
	$('div[id*="js__gallery--center--container"]').each(function(){
		var parent = $(this).attr('data-parent');
		var width = $('#js__slider--gallery--info'+parent).width(); 
		if (($('#js__gallery--center--container'+parent).width()+$('.js__slider--gallery__left').width()+$('.js__slider--gallery__right').width())>width) { 
			$('#js__gallery--center--container'+parent).css('max-width',0).css('max-width',width-20-($('.js__slider--gallery__left').width()+$('.js__slider--gallery__right').width())).css({'display':'block','margin':'auto'}); $('.js__slider--gallery__container').css('justify-content','baseline'); 
			$('#js__gallery--right'+parent).css({"opacity":1,"cursor":"pointer","cursor":"hand"}).prop('disabled',false);
		
			var con = Math.round($('.js__slider--gallery__container').width()/$('.js__slider--gallery__main').width());
			var newwidth = $('.js__slider--gallery__container').width()/con-($('.fnc--slider--gallery--container--center__item').css('margin-right').replace(/[^-0-9]/gim,'')/1*2);
			$('div[class*="fnc--slider--gallery--container--center__item"]').each(function(){
				$(this).css('width',newwidth+'px')
			});
		
		
		} else { $('#js__gallery--center--container'+parent).css({'display':'block','margin':'0 auto'}); $('.js__slider--gallery__container').css('justify-content','center'); $('#js__gallery--right'+parent).css({"opacity":0,"cursor":"default"}).prop('disabled',true); $('#js__gallery--left'+parent).css({"opacity":0,"cursor":"default"}).prop('disabled',true); }
	});
	$(window).on('resize',function() {
		$('div[id*="js__gallery--center--container"]').each(function(){
			var parent = $(this).attr('data-parent');
			$('#js__gallery--center--container'+parent).css('display','none').css('max-width','');
		});
		$('div[id*="js__gallery--center--container"]').each(function(){
			var parent = $(this).attr('data-parent');
			var width = $('#js__slider--gallery--info'+parent).width();
			if (($('#js__gallery--center--container'+parent).width()+$('.js__slider--gallery__left').width()+$('.js__slider--gallery__right').width())>width) {
				$('#js__gallery--center--container'+parent).css('max-width',0).css('max-width',width-20-($('.js__slider--gallery__left').width()+$('.js__slider--gallery__right').width())).css({'display':'block','margin':'auto'}); $('.js__slider--gallery__container').css('justify-content','baseline'); 
				$('#js__gallery--right'+parent).css({"opacity":1,"cursor":"pointer","cursor":"hand"}).prop('disabled',false);
			} else { $('#js__gallery--center--container'+parent).css({'display':'block','margin':'0 auto'}); $('.js__slider--gallery__container').css('justify-content','center'); $('#js__gallery--right'+parent).css({"opacity":0,"cursor":"default"}).prop('disabled',true); $('#js__gallery--left'+parent).css({"opacity":0,"cursor":"default"}).prop('disabled',true); }
		});
	});
	
	var gallslide=0;
	$('div[id*="js__gallery--center--container"]').each(function(){
		$(this).animate({'scrollLeft': 0}, 1);
	});
	$('button[id*="js__gallery--left"]').click(function(){ 
		var parent = $(this).attr('data-parent');
		var slide = $('.js__slider--gallery__main').width();
		$('#js__gallery--left'+parent).prop('disabled',true); $('#js__gallery--right'+parent).prop('disabled',true);
		var oldsc = $('#js__gallery--center--container'+parent).scrollLeft();
		$('#js__gallery--center--container'+parent).animate({'scrollLeft': (gallslide-slide)}, 400,function(){
			var newsc = $('#js__gallery--center--container'+parent).scrollLeft();
			if (oldsc!=newsc) {
				gallslide=gallslide-slide;
			}
			$('#js__gallery--right'+parent).prop('disabled',false).css('opacity','1');
			if (newsc==0) {
				$('#js__gallery--left'+parent).attr('disabled',true).css('opacity','0');
			} else {
				$('#js__gallery--left'+parent).attr('disabled',false).css('opacity','1');
			}
		});
	});
	$('button[id*="js__gallery--right"]').click(function(){ 
		var parent = $(this).attr('data-parent');
		var slide = $('.js__slider--gallery__main').width();
		$('#js__gallery--left'+parent).prop('disabled',true); $('#js__gallery--right'+parent).prop('disabled',true);
		var oldsc = $('#js__gallery--center--container'+parent).scrollLeft(); 
		$('#js__gallery--center--container'+parent).animate({'scrollLeft': (gallslide+slide)}, 400,function(){
			var newsc = $('#js__gallery--center--container'+parent).scrollLeft();
			if (oldsc!=newsc) {
				gallslide=gallslide+slide;
			}
			$('#js__gallery--left'+parent).prop('disabled',false).css('opacity','1');
			if ((newsc+$('#js__gallery--center--container'+parent).width())+50>=gallerywidth) {
				$('#js__gallery--right'+parent).attr('disabled',true).css('opacity','0');
			} else {
				$('#js__gallery--right'+parent).attr('disabled',false).css('opacity','1');
			}
		});
	});
});