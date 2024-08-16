jQuery(document).ready(function($) {
	var fix = $('.fnc--slider--container').attr('data-fix')/1;
	var width = $('.fnc--slider--container').attr('data-width')/1;
	var height = $('.fnc--slider--container').attr('data-height')/1;
	var ratio = width/height;
	
	$('.js__fnc--slider--inner__absolute').css('height',height);
	$('.js__fnc--slider--inner__relative').css('height',height);
	if ((fix==1)||(width>$('.fnc--slider--container').width())) { width=$('.fnc--slider--container').innerWidth(); height=$('.fnc--slider--container').width()/ratio; }
	
	if (width>$('.fnc--slider--container').width()) {
		height=$('.fnc--slider--container').width()/ratio;
	}
	
	$('.js__fnc--slider--inner__absolute').css('height',height);
	$('.js__fnc--slider--inner__relative').css('height',height);
	
	$('div[class*="js__adv--banner"]').each(function(){
		$(this).css('width',width+'px');
		$(this).css('height',height+'px');
	});
	
	$('.js__fnc--slider--inner__absolute').css('width',width+'px').animate({'opacity':'1'},200);
	
	$(window).on('resize',function() { 
	
		var fix = $('.fnc--slider--container').attr('data-fix');
		var width = $('.fnc--slider--container').attr('data-width');
		var height = $('.fnc--slider--container').attr('data-height');
		var ratio = width/height;
	
		$(this).css('width','');
		$(this).css('height','');
		$('.js__fnc--slider--inner__absolute').css('height','');
		$('.js__fnc--slider--inner__relative').css('height','');
		
		if ((fix==1)||(width>$('.fnc--slider--container').width())) { width=$('.fnc--slider--container').innerWidth(); height=$('.fnc--slider--container').width()/ratio; }
		
		if (width>$('.fnc--slider--container').width()) {
			height=$('.fnc--slider--container').width()/ratio;
		}
		
		$('.js__fnc--slider--inner__absolute').css('height',height);
		$('.js__fnc--slider--inner__relative').css('height',height);
		
		$('div[class*="js__adv--banner"]').each(function(){
			$(this).css('width',width+'px');
			$(this).css('height',height+'px');
		});
		
		$('.js__fnc--slider--inner__absolute').css('width',width+'px').animate({'opacity':'1'},200);
		
	});
	
	$('.js__fnc--slider--inner__relative').animate({'opacity':'1'},1000);
	
	var adv=0; var adi=0;
	var advfreq = ($('.fnc--slider--container').attr('data-freq')/1)*1000;
	
	$('div[class*="js__adv--banner"]').each(function(){ adi++; });
	$('div[id*="slidedivbut"]').click(function(){
		var oldadv = adv; 
		adv = ($(this).attr('data-info')/1)-1;
		if (adv!=oldadv) {
			$('.js__adv--banner'+oldadv).fadeOut(2000);
			$('.js__adv--banner'+adv).fadeIn(2000);
			$('div[id*="slidedivbut"]').each(function(){
				$(this).removeClass('fnc--slider--inner--button__active').addClass('fnc--slider--inner--button');
			});
			$('div[id="slidedivbut'+adv+'"]').removeClass('fnc--slider--inner--button').addClass('fnc--slider--inner--button__active');
		}
	});
	if (adi>1) {
		setInterval(function(){ 
			$('.js__adv--banner'+adv).fadeOut(2000);
			adv++;
			if ($('.js__adv--banner'+adv).html()==null) { 
				adv=0;
				$('.js__adv--banner'+adv).fadeIn(2000);
			} else {
				$('.js__adv--banner'+adv).fadeIn(2000);
			}
			$('div[id*="slidedivbut"]').each(function(){
				$(this).removeClass('fnc--slider--inner--button__active').addClass('fnc--slider--inner--button');
			});
			$('div[id="slidedivbut'+adv+'"]').removeClass('fnc--slider--inner--button').addClass('fnc--slider--inner--button__active');
		}, advfreq);
		$('#advbanright').click(function(){
			$('.js__adv--banner'+adv).fadeOut(2000);
			adv++;
			if ($('.js__adv--banner'+adv).html()==null) { 
				adv=0;
				$('.js__adv--banner'+adv).fadeIn(2000);
			} else {
				$('.js__adv--banner'+adv).fadeIn(2000);
			}
			$('div[id*="slidedivbut"]').each(function(){
				$(this).removeClass('fnc--slider--inner--button__active').addClass('fnc--slider--inner--button');
			});
			$('div[id="slidedivbut'+adv+'"]').removeClass('fnc--slider--inner--button').addClass('fnc--slider--inner--button__active');
		});
		$('#advbanleft').click(function(){
			var cont =0;	
			$('div[class*="js__adv--banner"]').each(function(){
				cont++;
			});
			$('.js__adv--banner'+adv).fadeOut(2000);
			adv--;
			if (adv<0) { 
				adv=(cont-1);
				$('.js__adv--banner'+adv).fadeIn(2000);
			} else {
				$('.js__adv--banner'+adv).fadeIn(2000);
			}
			$('div[id*="slidedivbut"]').each(function(){
				$(this).removeClass('fnc--slider--inner--button__active').addClass('fnc--slider--inner--button');
			});
			$('div[id="slidedivbut'+adv+'"]').removeClass('fnc--slider--inner--button').addClass('fnc--slider--inner--button__active');
		});
	}
});