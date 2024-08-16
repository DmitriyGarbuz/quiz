$(document).ready(function() {
	var locale = $('#defaultLocale').attr('data-lang');
	var localeArray = [];
	$.getJSON('/admin/language/language'+locale+'.json', {rand:Math.random()}, function(response) {
		$(response).each(function(i,val){
			$.each(val,function(key,val){
				localeArray[key]=val;
			});
		});
	});
	$('img[id*="showmobilemenu"]').click(function(){ 
		var chapw = $(window).width()/1.5;
		$('#leftdivnew').animate({'width':chapw+'px'},200);
		$('#leftdivnew').fadeIn(200);
		$('#backall').fadeIn(200);
	});
	var comments_interval;
	var faq_interval;
	var callme_interval;
	var connects_interval;
	function newcomments_interval() {
		if ($('#newcomments').css('opacity')==1) {
			$('#newcomments').animate({opacity:0},200); $('#newcomments').parent('div').children('img').animate({opacity:0},200);
		} else {
			$('#newcomments').animate({opacity:1},200); $('#newcomments').parent('div').children('img').animate({opacity:1},200);
		}
    }
	function newfaq_interval() {
		if ($('#newfaq').css('opacity')==1) {
			$('#newfaq').animate({opacity:0},200); $('#newfaq').parent('div').children('img').animate({opacity:0},200);
		} else {
			$('#newfaq').animate({opacity:1},200); $('#newfaq').parent('div').children('img').animate({opacity:1},200);
		}
    }
	function newconnects_interval() {
		if ($('#newconnects').css('opacity')==1) {
			$('#newconnects').animate({opacity:0},200); $('#newconnects').parent('div').children('img').animate({opacity:0},200);
		} else {
			$('#newconnects').animate({opacity:1},200); $('#newconnects').parent('div').children('img').animate({opacity:1},200);
		}
    }
	function newcallme_interval() {
		if ($('#newcallme').css('opacity')==1) {
			$('#newcallme').animate({opacity:0},200); $('#newcallme').parent('div').children('img').animate({opacity:0},200);
		} else {
			$('#newcallme').animate({opacity:1},200); $('#newcallme').parent('div').children('img').animate({opacity:1},200);
		}
    }
	if ($('#leftdivnew').val()!=undefined) { 
		setInterval(function() {  
			$.post('/controler/home/getNewEventsCount',function(data){
				var obj = jQuery.parseJSON(data); 
				var cols = 0;
				if (obj.comments>0) { 	
					$('#newcomments').empty().append(obj.comments);
					$('#newcomments').css('display','block');
					clearInterval(comments_interval);
					comments_interval=setInterval(newcomments_interval,500);
					cols++;
				} else {
					$('#newcomments').empty();
					$('#newcomments').css('display','none');
					clearInterval(comments_interval);
					$('#newcomments').parent('div').children('img').animate({opacity:1},200);
				}
				if (obj.faq>0) { 	
					$('#newfaq').empty().append(obj.faq);
					$('#newfaq').css('display','block');
					clearInterval(faq_interval);
					faq_interval=setInterval(newfaq_interval,500);
					cols++;
				} else {
					$('#newfaq').empty();
					$('#newfaq').css('display','none');
					clearInterval(faq_interval);
					$('#newfaq').parent('div').children('img').animate({opacity:1},200);
				}
				if (obj.callme>0) { 	
					$('#newcallme').empty().append(obj.callme);
					$('#newcallme').css('display','block');
					clearInterval(callme_interval);
					callme_interval=setInterval(newcallme_interval,500);
					cols++;
				} else {
					$('#newcallme').empty();
					$('#newcallme').css('display','none');
					clearInterval(callme_interval);
					$('#newcallme').parent('div').children('img').animate({opacity:1},200);
				}
				if (obj.feeds>0) { 	
					$('#newconnects').empty().append(obj.feeds);
					$('#newconnects').css('display','block');
					clearInterval(connects_interval);
					connects_interval=setInterval(newconnects_interval,500);
					cols++;
				} else {
					$('#newconnects').empty();
					$('#newconnects').css('display','none');
					clearInterval(connects_interval);
					$('#newconnects').parent('div').children('img').animate({opacity:1},200);
				}
				if ((cols>0)&&($('#orderwav').val()!=undefined)) {
					var orderwav = $("#orderwav")[0];
					orderwav.play();
				}
			});
		}, 10000);
		$.post('/controler/home/getNewEventsCount',function(data){
			var obj = jQuery.parseJSON(data); 
			var cols = 0;
			if (obj.comments>0) { 	
				$('#newcomments').empty().append(obj.comments);
				$('#newcomments').css('display','block');
				clearInterval(comments_interval);
				comments_interval=setInterval(newcomments_interval,500);
				cols++;
			} else {
				$('#newcomments').empty();
				$('#newcomments').css('display','none');
				clearInterval(comments_interval);
				$('#newcomments').parent('div').children('img').animate({opacity:1},200);
			}
			if (obj.faq>0) { 	
				$('#newfaq').empty().append(obj.faq);
				$('#newfaq').css('display','block');
				clearInterval(faq_interval);
				faq_interval=setInterval(newfaq_interval,500);
				cols++;
			} else {
				$('#newfaq').empty();
				$('#newfaq').css('display','none');
				clearInterval(faq_interval);
				$('#newfaq').parent('div').children('img').animate({opacity:1},200);
			}
			if (obj.callme>0) { 	
				$('#newcallme').empty().append(obj.callme);
				$('#newcallme').css('display','block');
				clearInterval(callme_interval);
				callme_interval=setInterval(newcallme_interval,500);
				cols++;
			} else {
				$('#newcallme').empty();
				$('#newcallme').css('display','none');
				clearInterval(callme_interval);
				$('#newcallme').parent('div').children('img').animate({opacity:1},200);
			}
			if (obj.feeds>0) { 	
				$('#newconnects').empty().append(obj.feeds);
				$('#newconnects').css('display','block');
				clearInterval(connects_interval);
				connects_interval=setInterval(newconnects_interval,500);
				cols++;
			} else {
				$('#newconnects').empty();
				$('#newconnects').css('display','none');
				clearInterval(connects_interval);
				$('#newconnects').parent('div').children('img').animate({opacity:1},200);
			}
			if ((cols>0)&&($('#orderwav').val()!=undefined)) {
				var orderwav = $("#orderwav")[0];
				orderwav.play();
			}
		});
	}
	$('.js__user--ct--button').click(function(){ 
		$('.js__info--message').empty();
		var error=0;
		var ctUserId = $('.js__ct--user--id').val();
		var login = $('.js__ct--user--login').val();
		var password = $('.js__ct--user--password').val();
		var pattern = /^([A-Za-z0-9\-\_\+\.]{0,})$/;
		if (!pattern.test(login)) {
			$('.js__info--message').append(localeArray['loginWrongIsset']+'<br>'); error=1;
		} 
		if (!pattern.test(password)) {
			$('.js__info--message').append(localeArray['passwordWrongIsset']+'<br>'); error=1;
		} 
		if ((login.length<6)||(login.length>12)||(password.length<6)||(password.length>12)) {
			$('.js__info--message').append(localeArray['loginAndPasswordIsset']+'<br>'); error=1;
		}
		var name = $('.js__ct--user--name').val();
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
		}
		if (error==0) {
			$.post('/controler/ctusers/testCtUserLogin',{ctUserId,login,rand:Math.random()},function(response){
				if (response==0) {
					$('.js__ct--user--form').submit();
				} else { 
					$('.js__info--message').append(localeArray['dublicateLogin']+'<br>'); 
				}
			});
		}
	});
	$('#installlanguage').change(function(){
		var language = $(this).val();
		$.post('/install/config.php',{language},function(){
			window.location.reload();
		});
	});
	$('#initbut').click(function(){
		$('#backall').fadeIn(100);
		var a=0; $('#initInfo').empty();
		var makebase=0;
		var installlanguage = $('#installlanguage').val();
		var sitename = $('#sitename').val();
		var siteemail = $('#siteemail').val();
		var bdname = $('#bdname').val();
		if (bdname=='') { $('#initInfo').append(localeArray['enterDatabaseName']+'<br>'); a=1; }
		var bdpass = $('#bdpass').val();
		var bduser = $('#bduser').val();
		if (bduser=='') { $('#initInfo').append(localeArray['enterLoginDatabase']+'<br>'); a=1; }
		var bdhost = $('#bdhost').val();
		if (bdhost=='') { $('#initInfo').append(localeArray['enterHostDatabase']+'<br>'); a=1; }
		var serial = $('#serial').val();
		var pattern = /^([0-9]{0,})$/;
		if ((serial=='')||(!pattern.test(serial))||(serial.length<12)||(serial.length>12)) { $('#initInfo').append(localeArray['invalidSerial']+'<br>'); a=1; }
		if ($('#makebase').is(":checked")) { makebase=1; } else { makebase=0; }
		var bdfile = $('#bdfile').val();
		if (a==0) {
			if (bdfile=='') { 
				$.post('/install/init.php',{bdname,installlanguage,siteemail,sitename,bdpass,bdhost,bduser,serial,makebase,bdfile},function(data){
					if (data=='OK') {
						location.href="/";
					} else {
						$('#backall').fadeOut(100);
						$('#initInfo').empty().append(data); 
					}
				});
			} else {
			$('#bdfileform').ajaxForm({
				success: function(data){ 
					$.post('/install/init.php',{bdname,siteemail,sitename,bdpass,bdhost,bduser,serial,makebase,bdfile:data},function(data1){
						if (data1=='OK') {
							location.href="/";
						} else {
							$('#backall').fadeOut(100);
							$('#initInfo').empty().append(data1); 
						}
					});
				}
			}).submit();
			
			}
		} else {
			$('#backall').fadeOut(100);
		}
	});
	$('.js__close--conf--but').click(function(){
		var login = $('.js__close--login').val();
		var password = $('.js__close--password').val();
		$.post('/close',{login,password},function(data){
			if (data==1) {
				window.location.href="/";
			} else {
				$('.js__control--info--message').empty().append(localeArray['invalidLoginOrPassword']);
			}
		});
	});
	$('.js__user--control--delete--button').click(function(){
		var ctUserId = $(this).attr('data-id');
		if (ctUserId==undefined) { var ctUserId = $('.js__control--user--id').val(); }
		$.post('/controler/ctusers/testCtUser',{ctUserId},function(response){
			if (response==true) {
				
				$('.js__popup--text').empty().append(localeArray['deleteConfirm']); showPopup();
				$('.js__popup--close').click(function(){ hidePopup(); });
				$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
				$(window).bind('keypress', function(e){ 
					if (e.keyCode==13) { $.post('/controler/ctusers/delCtUser',{ctUserId,rand:Math.random()},function(){ location.href="/controler/ctusers"; }); e.preventDefault(); } 
				});
				$('.js__popup--confirm').click(function(){
					$.post('/controler/ctusers/delCtUser',{ctUserId,rand:Math.random()},function(){ location.href="/controler/ctusers"; })
				});
				
			} else {
				
				$('.js__popup--text').empty().append(localeArray['cantDeleteAdmin']); showPopup();
				$('.js__popup--close').click(function(){ hidePopup(); });
				$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
				
			}
		});	
	});
	function userlogin () { 
		var login = $('.js__control--user--login').val();
		var password = $('.js__control--user--password').val(); 
		if ((simpleValidate(login,'simple'))&&(simpleValidate(password,'simple'))) {   
			$.post('/controler/document/testNow',{login,password},function(response){ 
				if (response) {
					window.location="/control";
				} else {
					$('.js__control--info--message').empty().append(localeArray['failedAuth']);
				}
			});
		} else { 
			$('.js__control--info--message').empty().append(localeArray['failedAuthData']);
		}
	}
	function simpleValidate (data,type) {
		var response = true;
		if (type=='simple') { if ((data.indexOf("<")==-1)&&(data.indexOf(">")==-1)&&(data!='')) { response=true; } else { response=false; } }
		return response;
	}
	$('.center--block').css('min-height',$(window).height()-$('.header--block').height());
	$('#backall').click(function(){
		$('#backall').fadeOut(200);
		$('#fadediv').fadeOut(200);
		$('#leftdivnew').fadeOut(200);
		$('#leftdivnew').animate({'width':'0px'},200);
		hidePopup();
	});
	$('.js__control--user--login').bind('keypress', function(e){if (e.keyCode==13) { userlogin(); }});
	$('.js__control--user--password').bind('keypress', function(e){if (e.keyCode==13) { userlogin(); }});
	$('.js__control--button--login').click(function(){ userlogin(); });
	$('.js__logOut').click(function(){
		$.post('/controler/document/testNowDel',function(){
			window.location.reload();
		});
	});
	$('.js__title--change').keyup(function(){
		$('.js__title--span').empty().append('('+$('.js__title--change').val().length+')');
		if (($('.js__title--change').val().length>0)&&($('.js__title--change').val().length<61)) {
			$('.js__title--span').removeClass('title--span--bad').addClass('title--span-good');
		} else {
			$('.js__title--span').removeClass('title--span--good').addClass('title--span--bad');
		}
	});
	$('.js__description--change').keyup(function(){
		$('.js__description--span').empty().append('('+$('.js__description--change').val().length+')');
		if (($('.js__description--change').val().length>0)&&($('.js__description--change').val().length<161)) {
			$('.js__description--span').removeClass('title--span--bad').addClass('title--span--good');
		} else {
			$('.js__description--span').removeClass('title--span--good').addClass('title--span--bad');
		}
	});
	$('.js__chapter--button').click(function(){ 
		$('.js__info--message').empty();
		var chapterId = $('.js__chapter--id').val();
		var error=0;
		var url = $('.js__chapter--url').val();
		var pattern = /^([A-Za-z0-9\-\_]{0,})$/;
		if ((!pattern.test(url))&&(url!='')) {
			error=1;
			$('.js__info--message').append(localeArray['testUrl']+'<br>'); 
			$('.js__chapter--url').addClass('fail');
		} else { $('.js__chapter--url').removeClass('fail'); }
		var name = $('.js__chapter--name').val(); 
		if (!simpleValidate(name,'simple')) {
			error=1;
			$('.js__info--message').append(localeArray['enterName']+'<br>'); 
			$('.js__chapter--name').addClass('fail');
		} else { $('.js__chapter--name').removeClass('fail'); }
		if (error==0) {
			$.post('/controler/chapters/testChapterURL',{url,chapterId},function(response){
				if ((response==0)||(url=='')) {
					$('.js__chapter--form').submit();
				} else {
					$('.js__info--message').append(localeArray['duplicateUrl']);
					$('.js__chapter--url').addClass('fail');
				}
			})
		}
	});
	$('.js__article--button').click(function(){ 
		$('.js__info--message').empty();
		var articleId = $('.js__article--id').val();
		var error=0;
		var url = $('.js__article--url').val();
		var pattern = /^([A-Za-z0-9\-\_]{0,})$/;
		if ((!pattern.test(url))&&(url!='')) {
			error=1;
			$('.js__info--message').append(localeArray['testUrl']+'<br>'); 
			$('.js__article--url').addClass('fail');
		}
		var name = $('.js__article--name').val(); 
		if (name=='') {
			error=1;
			$('.js__info--message').append(localeArray['enterName']+'<br>'); 
			$('.js__article--name').addClass('fail');
		} else { $('.js__article--name').removeClass('fail'); }
		if (error==0) {
			$.post('/controler/chapters/testArticleUrl',{url,articleId},function(response){
				if ((response==0)||(url=='')) {
					$('.js__article--form').submit();
				} else {
					$('.js__info--message').append(localeArray['duplicateUrl']+'<br>');
					$('.js__article--url').addClass('fail');
				}
			})
		}
	});
	$('input[id*="js__change--article--visible"]').on('change',function(){
		var articleId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'visible';
		$.post('/controler/chapters/changeArticleData',{articleId,param,type});
	});
	$('input[class*="js__change--article--number"]').change(function(){
		var articleId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'number';
		$.post('/controler/chapters/changeArticleData',{articleId,param,type});
	});
	$('input[class*="js__change--article--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var articleId = $(this).attr('data-id');
			var param = $(this).val();
			var type = 'number';
			$.post('/controler/chapters/changeArticleData',{articleId,param,type},function(){
				location.reload();
			});
		}
	});
	$('select[class*="js__change--article--parent"]').change(function(){
		var articleId = $(this).attr('data-id');
		var chapterId = $(this).val();
		$.post('/controler/chapters/changeArticleParent',{articleId,chapterId},function(){
			location.reload();
		})
	});
	$('input').keyup(function(){ 
		$(this).removeClass('fail');
	});
	$('textarea').keyup(function(){ 
		$(this).removeClass('fail');
	});
	$('.js__delete--button').click(function(){
		var id = $(this).attr('data-id');
		var type = $(this).attr('data-type');
		var module = $(this).attr('data-module');
		$('.js__popup--text').empty().append(localeArray['deleteConfirm']); showPopup();
		$('.js__popup--close').click(function(){ hidePopup(); });
		$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
		$(window).bind('keypress', function(e){ 
			if (e.keyCode==13) { $.post('/controler/'+type+'/del'+module,{id},function(response){ 
				location.href=response; 
			}); e.preventDefault(); } 
		});
		$('.js__popup--confirm').click(function(){
			$.post('/controler/'+type+'/del'+module,{id},function(response){ 
				location.href=response; 
			})
		});
	});
	function showPopup () {
		$('.js__popup--window').css('display','flex').css('margin-top','-'+($('.js__popup--window').height()/2)+'px').css('margin-left','-'+($('.js__popup--window').width()/2)+'px');
		$('.js__popup--window').animate({'opacity':'1'},200);
		$('#backall').fadeIn(200);
	}
	function hidePopup () {
		$('.js__popup--window').animate({'opacity':'0'},100,function(){
			$('.js__popup--window').css('display','none')
		});
		$('#backall').fadeOut(200);
	}
	$('.js__theme--button').click(function(){ 
		$('.js__info--message').empty();
		var a=0;
		if ($('.js__theme--name').val()=='') {
			$('.js__info--message').append(localeArray['invalidNameEnteredCssFile']+'<br>'); a=1;
			$('.js__theme--name').removeClass().addClass('fail');
		}
		var pattern = /^([a-z0-9]{0,})$/;
		if (($('.js__theme--file').val()=='')||(!pattern.test($('#file').val()))) {
			$('.js__info--message').append(localeArray['enterName']); a=1;
			$('.js__theme--file').removeClass().addClass('fail');
		}
		if (a==0) {
			$('.js__theme--form').submit();
		}
	});
	$('.js__save--css').click(function(){ 
		var css = $('.js__theme--css').val();
		$.post('/controler/design/editCss',{css:css},function(){
			$('.js__info1--message').append(localeArray['saved']); 
			setTimeout(function() {
				$('div[class*="js__info1--message"]').each(function(){
					$(this).empty();
				});
			}, 1000);
		});
	});
	$('.js__change--banner--view').change(function(){
		var type = $(this).val();
		$.post('/controler/chapters/changeBannerView',{type:type},function(){ 
			location.reload();
		});
	});
	$('.js__situation--button').click(function(){
		var actPage = $('#actPage').val();
		var type = $(this).attr('data-info');
		$('#situationForm').attr('action','/controler/'+actPage+'/editSituation'+type).submit();
	});
	$('.js__edit--banner').click(function(){ 
		var banner = $(this).attr('data-info');
		var id = $('#id').val();
		var actPage = $('#actPage').val();
		if ($('.js__change--banner--view').val()==0) {
			var text = $('#editBanner'+banner).val(); 
		} else {
			var text = tinyMCE.get('editBanner'+banner).getContent();
		}
		if ($('#allBanner'+banner).is(":checked")) { var all=1; } else { var all=0; }
		$.post('/controler/'+actPage+'/editBanner',{banner,id,text,all},function(){
			$('#allBanner'+banner).prop('checked',false);
			$('.js__popup--text').empty().append(localeArray['saved']); showPopup();
			$('.js__popup--close').click(function(){ hidePopup(); });
			$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
			$(window).bind('keypress', function(e){ if (e.keyCode==13) { hidePopup(); e.preventDefault(); } });
			$('.js__popup--confirm').click(function(){ hidePopup(); });
		});
	});
	$('.js__chapter--preview--button').click(function(){
		$('.js__info1--message').empty();
		var error=0;
		if ($('.js__chapter--preview--file').val()=='') {
			$('.js__info1--message').append(localeArray['selectFileToUpload']); 
			error=1;
		} 
		if (error==0) {
			$('.js__chapter--preview--form').submit();
		}
	});
	$('.js__gallery--button').click(function(){
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__gallery--file').val()=='') {
			$('.js__info--message').append(localeArray['selectFileToUpload']); 
			error=1;
		} 
		if (error==0) {
			$('.js__gallery--form').submit();
		}
	});
	$('.js__header--logo--button').click(function(){
		$('.js__header--logo--message').empty();
		var error=0;
		if ($('.js__header--logo--file').val()=='') {
			$('.js__header--logo--message').append(localeArray['selectFileToUpload']); 
			error=1;
		} 
		if (error==0) {
			$('.js__header--logo--form').submit();
		}
	});
	$('.js__slider--button').click(function(){
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__slider--file').val()=='') {
			$('.js__info--message').append(localeArray['selectFileToUpload']); 
			error=1;
		} 
		if (error==0) {
			$('.js__slider--form').submit();
		}
	});
	$('input[id*="changeCompMenuNumber"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var number = $(this).val();
			var id = $(this).attr('data-id');
			$.post('/controler/chapters/changeCompMenuNumber',{id,number},function(){
				location.reload();
			});
		}
	});
	$('input[id*="js__change--callme--visible"]').change(function(){
		var id = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'visible';
		$.post('/controler/callme/changeCallmeData',{id,param,type});
	});
	$('input[class*="js__change--compmenu--number"]').blur(function(){
		var number = $(this).val();
		var id = $(this).attr('data-id');
		$.post('/controler/chapters/changeCompMenuNumber',{id,number},function(){
			location.reload();
		});
	});
	$('select[class*="js__change--comment--parent"]').change(function(){
		var commentId = $(this).attr('data-id');
		var chapterId = $(this).val();
		$.post('/controler/comments/changeCommentParent',{commentId,chapterId},function(){
			location.reload();
		})
	});
	$('input[id*="js__change--comment--visible"]').change(function(){
		var commentId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'visible';
		$.post('/controler/comments/changeCommentData',{commentId,param,type});
	});
	$('select[class*="js__change--faq--parent"]').change(function(){
		var faqId = $(this).attr('data-id');
		var chapterId = $(this).val();
		$.post('/controler/faq/changeFaqParent',{faqId,chapterId},function(){
			location.reload();
		})
	});
	$('input[id*="js__change--faq--visible"]').change(function(){
		var faqId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'visible';
		$.post('/controler/faq/changeFaqData',{faqId,param,type});
	});
	$('select[class*="js__alerts--type"]').change(function(){
		var type = $(this).val();
		var page = $(this).attr('data-page');
		$.post('/controler/'+page+'/changeType',{type},function(){
			location.reload();
		})
	});
	$('button[class*="js__send--test--letter"]').click(function(){
		var id = $(this).attr('data-id');
		var theme = $('#theme' + id).val();
		var text =  tinyMCE.get('text' + id).getContent();
		var email = $('#email' + id).val();
		$.post('/controler/moduls/sendTestLetter',{theme,text,email},function(){
			$('.js__popup--text').empty().append(localeArray['letterSent']); showPopup();
			$('.js__popup--close').click(function(){ hidePopup(); });
			$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
			$(window).bind('keypress', function(e){ if (e.keyCode==13) { hidePopup(); e.preventDefault(); } });
			$('.js__popup--confirm').click(function(){ hidePopup(); });
		});
	});
	$('.js__add--language--button').click(function(){ 
		$('.js__info--message').empty();
		var error=0;
		var url = $('.js__add--language--url').val();
		var pattern = /^([a-z]{0,})$/;
		if (!pattern.test(url)) {
			$('.js__info--message').append(localeArray['invalidCharactersInPrefix']+'<br>'); error=1;
			$('.js__add--language--url').removeClass().addClass('fail');
		} 
		var name = $('.js__add--language--name').val();
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
			$('.js__add--language--name').removeClass().addClass('fail');
		}
		if (error==0) {
			$.post('/controler/moduls/testLanguagePrefix',{id:0,url},function(response){
				if (response==1) {
					$('.js__add--language--form').ajaxForm({	
						beforeSend: function() {
							$('.js__popup--close').css('display','none');
							$('.js__popup--confirm').css('display','none');
							$('.js__popup--text').empty().append(localeArray['addingLanguage']); showPopup();
						},success: function(){
							$('.js__popup--window').animate({'opacity':'0'},100,function(){
								$('.js__popup--window').css('display','none');
								$('.js__popup--close').css('display','block');
								$('.js__popup--confirm').css('display','block');
								window.location.reload();
							});
							$('#backall').fadeOut(200);
						}
					}).submit();
				} else { 
					$('.js__info--message').append(localeArray['prefixAlreadyUse']+'<br>'); 
				}
			});
		}
	});
	$('.js__edit--language--button').click(function(){ 
		$('.js__info--message').empty();
		var a=0;
		var name = $('.js__edit--language--name').val();
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__edit--language--name').removeClass().addClass('fail');
		}
		if (a==0) {
			$('.js__edit--language--form').submit();
			}
	});
	$('span[id*="changeLanguage"]').click(function(){
		var language = $(this).attr('data-url');
		$.post('/controler/moduls/changeLanguage',{language:language},function(){ 
			location.reload();
		});
	});
	$('input[id*="js__change--language--visible"]').change(function(){
		var id = $(this).val();
		if ($(this).is(":checked")){ var visible=1; } else { var visible=0; }
		$.post('/controler/moduls/changeLanguageVisible',{id,visible});
	});
	$('input[class*="js__change--language--number"]').change(function(){
		var id = $(this).attr('data-id');
		var number = $(this).val();
		$.post('/controler/moduls/changeLanguageNumber',{id,number},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--language--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var id = $(this).attr('data-id');
			var number = $(this).val();
			$.post('/controler/moduls/changeLanguageNumber',{id,number},function(){
				location.reload();
			});
		}
	});
	$('button[class*="js__language--delete"]').click(function(){
		var id = $(this).attr('data-id');
		$('.js__popup--text').empty().append(localeArray['deleteConfirm']); showPopup();
		$('.js__popup--close').click(function(){ hidePopup(); });
		$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
		$(window).bind('keypress', function(e){ 
			if (e.keyCode==13) { 
				$('.js__delete--language--form'+id).ajaxForm({	
					beforeSend: function() { 
						$('.js__popup--close').css('display','none');
						$('.js__popup--confirm').css('display','none');
						$('.js__popup--text').empty().append(localeArray['deletingLanguage']); showPopup();
					},success: function(){ 
						$('.js__popup--window').animate({'opacity':'0'},100,function(){
							$('.js__popup--window').css('display','none');
							$('.js__popup--close').css('display','block');
							$('.js__popup--confirm').css('display','block');
							window.location.reload();
						});
						$('#backall').fadeOut(200);
					}
				}).submit();
				e.preventDefault(); 
			} 
		});
		$('.js__popup--confirm').click(function(){
			$('.js__delete--language--form'+id).ajaxForm({	
				beforeSend: function() { 
					$('.js__popup--close').css('display','none');
					$('.js__popup--confirm').css('display','none');
					$('.js__popup--text').empty().append(localeArray['deletingLanguage']); showPopup();
				},success: function(){ 
					$('.js__popup--window').animate({'opacity':'0'},100,function(){
						$('.js__popup--window').css('display','none');
						$('.js__popup--close').css('display','block');
						$('.js__popup--confirm').css('display','block');
						window.location.reload();
					});
					$('#backall').fadeOut(200);
				}
			}).submit();
		});
	});
	$('.js__user--param--button').click(function(){
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__user--param--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
			$('.js__user--param--name').removeClass().addClass('fail');
		} 
		if (error==0) {
			$('.js__user--param--form').submit();
		}
	});
	$('input[class*="js__change--user--param--number"]').blur(function(){
		var userParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'number';
		$.post('/controler/moduls/changeUserParamData',{userParamId,type,param},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--user--param--name"]').keyup(function(){
		var userParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'name';
		$.post('/controler/moduls/changeUserParamData',{userParamId,type,param});
	});
	$('select[class*="js__change--user--param--type"]').change(function(){
		var userParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'type';
		$.post('/controler/moduls/changeUserParamData',{userParamId,type,param},function(){
			location.reload();
		});
	});
	$('input[id*="js__change--user--param--need"]').change(function(){
		var userParamId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'need';
		$.post('/controler/moduls/changeUserParamData',{userParamId,type,param});
	});
	$('input[class*="js__change--user--param--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var userParamId = $(this).attr('data-id');
			var param = $(this).val();
			var type = 'number';
			$.post('/controler/moduls/changeUserParamData',{userParamId,type,param},function(){
				location.reload();
			});
		}
	});
	$('input[class*="js__change--user--param--text"]').keyup(function(){
		var userParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'text';
		$.post('/controler/moduls/changeUserParamData',{userParamId,type,param});
	});
	$('input[class*="js__change--user--tab--number"]').change(function(){
		var userTabId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'number';
		$.post('/controler/moduls/changeUserTabData',{userTabId,type,param},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--user--tab--name"]').keyup(function(){
		var userTabId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'name';
		$.post('/controler/moduls/changeUserTabData',{userTabId,type,param});
	});
	$('select[class*="js__change--user--tab--type"]').change(function(){
		var userTabId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'type';
		$.post('/controler/moduls/changeUserTabData',{userTabId,type,param});
	});
	$('.js__user--tab--button').click(function(){
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__user--tab--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
			$('.js__user--tab--name').removeClass().addClass('fail');
		} 
		if (error==0) {
			$('.js__user--tab--form').submit();
		}
	});
	$('.js__feedback--button').click(function(){
		$('.js__info--message').empty();
		var a=0;
		if ($('.js__feedback--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__feedback--name').removeClass().addClass('fail');
		} 
		if (a==0) {
			$('.js__feedback--form').submit();
		}
	});
	$('.js__feedback--param--button').click(function(){
		$('.js__info1--message').empty();
		var a=0;
		if ($('.js__feedback--param--name').val()=='') {
			$('.js__info1--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__feedback--param--name').removeClass().addClass('fail');
		} 
		if (a==0) {
			$('.js__feedback--param--form').submit();
		}
	});
	$('input[class*="js__change--feedback--param--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var feedbackParamId = $(this).attr('data-id');
			var param = $(this).val();
			var type = 'number';
			$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type},function(){
				location.reload();
			});
		}
	});
	$('input[class*="js__change--feedback--param--number"]').blur(function(){
		var feedbackParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'number';
		$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--feedback--param--name"]').keyup(function(){
		var feedbackParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'name';
		$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type});
	});
	$('select[class*="js__change--feedback--param--type"]').change(function(){
		var feedbackParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'type';
		$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type},function(){
			location.reload();
		});
	});
	$('input[id*="js__change--feedback--param--need"]').change(function(){
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var feedbackParamId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'need';
		$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type});
	});
	$('input[class*="js__change--feedback--param--text"]').keyup(function(){
		var feedbackParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'text';
		$.post('/controler/moduls/changeFeedbackParamData',{feedbackParamId,param,type});
	});
	$('.js__poll--button').click(function(){
		$('.js__info--message').empty();
		var a=0;
		if ($('.js__poll--name').val()=='') {
			$('.js__info--message').append(entername+'<br>'); a=1;
			$('.js__poll--name').removeClass().addClass('fail');
		} 
		if (a==0) {
			$('.js__poll--form').submit();
		}
	});
	$('.js__poll--param--button').click(function(){
		$('.js__info1--message').empty();
		var a=0;
		if ($('.js__poll--param--name').val()=='') {
			$('.js__info1--message').append(entername+'<br>'); a=1;
			$('.js__poll--param--name').removeClass().addClass('fail');
		} 
		if (a==0) {
			$('.js__poll--param--form').submit();
		}
	});
	$('input[class*="js__change--poll--number"]').blur(function(){
		var pollId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'number';
		$.post('/controler/moduls/changePollData',{pollId,type,param},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--poll--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var pollId = $(this).attr('data-id');
			var param = $(this).val();
			var type = 'number';
			$.post('/controler/moduls/changePollData',{pollId,type:type,param},function(){
				location.reload();
			});
		}
	});
	$('input[class*="js__change--poll--param--votes"]').blur(function(){
		var pollParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'votes';
		$.post('/controler/moduls/changePollParamData',{pollParamId,type:type,param},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--poll--param--votes"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var pollParamId = $(this).attr('data-id');
			var param = $(this).val();
			var type = 'votes';
			$.post('/controler/moduls/changePollParamData',{pollParamId,type,param},function(){
				location.reload();
			});
		}
	});
	$('input[class*="js__change--poll--param--name"]').keyup(function(){
		var pollParamId = $(this).attr('data-id');
		var param = $(this).val();
		var type = 'name';
		$.post('/controler/moduls/changePollParamData',{pollParamId,type,param});
	});
	$('input[class*="js__change--counter--number"]').change(function(){
		var id = $(this).attr('data-id');
		var number = $(this).val();
		$.post('/controler/moduls/changeCounterNumber',{id,number},function(){
			location.reload();
		});
	});
	$('textarea[class*="js__change--counter--code"]').change(function(){
		var id = $(this).attr('data-id');
		var code = $(this).val();
		$.post('/controler/moduls/changeCounterCode',{id,code},function(){
			location.reload();
		});
	});
	$('input[id*="js__change--feed--visible"]').change(function(){
		var feedId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var param=1; } else { var param=0; }
		var type = 'visible';
		$.post('/controler/connects/changeFeedData',{feedId,param,type});
	});
	$('#js__user--active').change(function(){ 
		if ($(this).is(":checked")) {
			$('.js__user--tr--active').css('display','none');
		} else {
			$('.js__user--tr--active').css('display','flex');
		}
	});
	$('.js__user--button').click(function(){  
		$('.js__info--message').empty(); 
		var error=0; var b=0;
		var userId = $('.js__user--id').val(); 
		var email = $('.js__user--email').val();
		if ((email.indexOf("@")==-1)||(email.indexOf(".")==-1)||(email=='')) {
			$('.js__info--message').append(localeArray['incorrectlyEnteredEmail']+'<br>'); error=1;  
			$('.js__user--email').addClass('fail');
		} 
		var fio = $('.js__user--fio').val();
		if (fio!=undefined) {
			if (($('.js__user--fio').parent('div').attr('data-need')==1)&&(fio=='')) {
				$('.js__info--message').append(localeArray['enterFirstName']+'<br>'); error=1; 
				$('.js__user--fio').addClass('fail');
			}
		} 
		var surname = $('.js__user--surname').val();
		if (surname!=undefined) {
			if (($('.js__user--surname').parent('div').attr('data-need')==1)&&(surname=='')) {
				$('.js__info--message').append(localeArray['enterSurname']+'<br>'); error=1; 
				$('.js__user--surname').addClass('fail');
			}
		} 
		var phone = $('.js__user--phone').val();
		if (phone!=undefined) {
			if (($('.js__user--phone').parent('div').attr('data-need')==1)&&(phone=='')) {
				$('.js__info--message').append(localeArray['enterPhone']+'<br>'); error=1; 
				$('.js__user--phone').addClass('fail');
			}
		} 
		var password = $('.js__user--password').val();
		var pattern = /^([a-zA-Z0-9_]{0,})$/;
		if ((!pattern.test(password))||(password.length<6)||(password.length>12)||(password=='')) {
			$('.js__info--message').append(localeArray['passwordMustContainBetweenCharacters']+'<br>'); error=1; 
			$('.js__user--password').addClass('fail');
		} 
		$('input[class*="js__user--param"]').each(function(){
			var number = $(this).attr('data-info')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
				a=1; if (b==0) { $('.js__info--message').append(localeArray['notAllRequiredFieldsFilled']+'<br>'); b=1; }
				$(this).addClass('fail');
			}
		});
		$('input[id*="js__user--param"]').each(function(){
			var number = $(this).attr('data-info')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
				a=1; if (b==0) { $('.js__info--message').append(localeArray['notAllRequiredFieldsFilled']+'<br>'); b=1; }
				$(this).addClass('fail');
			}
		});
		$('select[class*="js__user--param"]').each(function(){
			var value = $(this).val(); 
			var number = $(this).attr('data-info')/1;
			if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
				a=1; if (b==0) { $('.js__info--message').append(localeArray['notAllRequiredFieldsFilled']+'<br>'); b=1; }
				$(this).addClass('fail');
			} 
		});
		$('textarea[class*="js__user--param"]').each(function(){
			var number = $(this).attr('data-info')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
				error=1; if (b==0) { $('.js__info--message').append(localeArray['notAllRequiredFieldsFilled']+'<br>'); b=1; }
				$(this).addClass('fail');
			} 
		});
		if (error==0) { 
			$.post('/controler/user/checkEmail',{email,userId},function(response){ 
				if (response>0) { 
					$('.js__info--message').append(localeArray['userWithThisEmailAlreadyExists']+'<br>');
				} else {
					$('.js__user--form').submit();
				}
			});
		} 
	});
	$('input[id*="js__change--user--active"]').change(function(){
		var userId = $(this).attr('data-id');
		if ($(this).is(":checked")){ var active=1; } else { var active=0; }
		$.post('/controler/user/changeUserActive',{userId,active});
	});
	$('select[class*="js__change--user--parent"]').change(function(){
		var userId = $(this).attr('data-id');
		var parent = $(this).val();
		$.post('/controler/user/changeUserParent',{userId,parent},function(){
			location.reload();
		})
	});
	$('.js__user--cat--button').click(function(){ 
		$('.js__info--message').empty();
		var a=0;
		var name = $('.js__user--cat--name').val(); 
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__user--cat--name').removeClass().addClass('fail');
		}
		if (a==0) {
			$('.js__user--cat--form').submit();
		}
	});
	$('.js__search--button').click(function(){
		searchFun();
	});
	$('.js__unsearch--button').click(function(){
		var chapter = $(this).attr('data-page');
		$.post('/controler/'+chapter+'/unSearch',function(){
			window.location.href="/controler/"+chapter;
		});
	});
	$('.js__search--pole').bind('keypress', function(e){
		if (e.keyCode==13) {
			searchFun();
		}
	});
	function searchFun(){
		var chapter = $('.js__unsearch--button').attr('data-page');
		if ($('.js__search--pole').val()!='') { 
			$('.js__search--form').submit(); 
		}
	}
	$('.js__subsc--test--button').click(function(){ 
		var theme = $('.js__subsc--theme').val();
		var text =  tinyMCE.get('js__subsc--text').getContent();
		var email = $('.js__subsc--test--email').val();
		$.post('/controler/subsc/sendTestSubsc',{theme,text,email},function(){
			$('.js__popup--text').empty().append(localeArray['letterSent']); showPopup();
			$('.js__popup--close').click(function(){ hidePopup(); });
			$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
			$(window).bind('keypress', function(e){ if (e.keyCode==13) { hidePopup(); e.preventDefault(); } });
			$('.js__popup--confirm').click(function(){ hidePopup(); });
		});
	});
	$('.js__make--subsc--button').click(function(){
		var id = $(this).attr('data-id');
		$('.js__info--message').empty();
		if (id!=0) {
			$('.js__subsc--form').attr('action','/controler/subsc/makeSubsc/' + id);
		} else {
			$('.js__subsc--form').attr('action','/controler/subsc/makeSubsc');
		}
		$('.js__subsc--form').submit();
	});
	$('.js__add--subsc--button').click(function(){
		$('.js__info--message').empty();
		var a=1;
		if ($('.js__subsc--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=0;
			$('.js__subsc--name').removeClass().addClass('fail');
		}
		if (a==1) {
			$('.js__subsc--form').submit();
		}
	});
	$('.js__edit--subsc--button').click(function(){
		$('.js__info--message').empty();
		var a=1;
		if ($('.js__subsc--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=0;
			$('.js__subsc--name').removeClass().addClass('fail');
		}
		if (a==1) {
			$('.js__subsc--form').attr('action','/controler/subsc/editSubsc');
			$('.js__subsc--form').submit();
		}
	});
	$('.js__note--button').click(function(){ 
		$('.js__info--message').empty();
		var noteId = $('.js__note--id').val();
		var a=0;
		var url = $('.js__note--url').val();
		var pattern = /^([A-Za-z0-9\-\_]{0,})$/;
		if ((!pattern.test(url))&&(url!='')) {
			$('.js__info--message').append(localeArray['testUrl']+'<br>'); a=1;
			$('.js__note--url').addClass('fail');
		}
		var name = $('.js__note--name').val(); 
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__note--button').prop('disabled',false);
			$('.js__note--name').addClass('fail');
		}
		if (a==0) {
			$.post('/controler/note/testNoteUrl',{url,noteId,rand:Math.random()},function(response){
				if ((response==0)||(url=='')) {
					$('.js__note--form').submit();
				} else {
					$('.js__info--message').append(localeArray['duplicateUrl']+'<br>'); a=1;
					$('.js__note--url').addClass('fail');
				}
			})
		}
	});
	$('.js__note--cat--button').click(function(){ 
		$('.js__info--message').empty();
		var a=0;
		var name = $('.js__note--cat--name').val(); 
		if (name=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__note--cat--name').addClass('fail');
		}
		if (a==0) {
			$('.js__note--cat--form').submit();
		}
	});
	$('select[class*="js__change--note--parent"]').change(function(){
		var noteId = $(this).attr('data-id');
		var noteCatId = $(this).val();
		$.post('/controler/note/changeNoteParent',{noteId,noteCatId,rand:Math.random()},function(){
			location.reload();
		})
	});
	$('input[class*="change--note--number"]').blur(function(){
		var noteId = $(this).attr('data-id');
		var number = $(this).val();
		$.post('/controler/note/changeNoteNumber',{noteId,number,rand:Math.random()},function(){
			location.reload();
		})
	});
	$('input[class*="change--note--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var noteId = $(this).attr('data-id');
			var number = $(this).val();
			$.post('/controler/note/changeNoteNumber',{noteId,number,rand:Math.random()},function(){
				location.reload();
			})
		}
	});
	$('.js__note--tab--button').click(function(){ 
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__note--tab--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
			$('.js__note--tab--name').addClass('fail');
		} 
		if (error==0) {
			$('.js__note--tab--form').submit();
		}
	});
	$('input[class*="js__change--note--tab--number"]').change(function(){
		var noteTabId = $(this).attr('data-id');
		var number = $(this).val();
		$.post('/controler/note/changeNoteTabNumber',{noteTabId,number,rand:Math.random()},function(){
			location.reload();
		});
	});
	$('input[class*="js__change--note--tab--number"]').bind('keypress', function(e){
		if (e.keyCode==13) {
			var noteTabId = $(this).attr('data-id');
			var number = $(this).val();
			$.post('/controler/note/changeNoteTabNumber',{noteTabId,number,rand:Math.random()},function(){
				location.reload();
			});
		}
	});
	$('input[class*="js__change--note--tab--name"]').keyup(function(){
		var noteTabId = $(this).attr('data-id');
		var name = $(this).val();
		$.post('/controler/note/changeNoteTabName',{noteTabId,name,rand:Math.random()});
	});
	$('.js__modul--button').click(function(){
		$('.js__info--message').empty();
		var error=0;
		if ($('.js__modul--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); error=1;
			$('.js__modul--name').addClass('fail');
		} 
		var pattern = /^([A-Za-z0-9\-\_]{0,})$/;
		if (!pattern.test($('.js__modul--name').val())) {
			$('.js__info--message').append(localeArray['onlyLatinCharacters']+'<br>'); error=1;
			$('.js__modul--name').addClass('fail');
		} 
		if (error==0) {
			$('.js__modul--form').submit();
		}
	});
	$('select[id*="myModulView"]').change(function(){
		var type = $(this).val();
		$.post('/controler/config/changeMyModulView',{type,rand:Math.random()},function(){ 
			location.reload();
		});
	});
	if ($('.js__need--stats').html()!=undefined) { 
		$('.js__see--new--stats').click(function(){
			
			$('#back1all').css('width',$('.home--rightmain').width()+'px').css('height',$(window).height()-66+'px').fadeIn(300);
			$('.js__info--if--not--isset').animate({'opacity':'0.2'},200);
			
			var dateStatFrom = $('.js__date--stat--from').val();
			var dateStatTo = $('.js__date--stat--to').val();
			var width = $('.js__filter--stat--pole').width();
			$.post('/controler/home/changeStatDates',{dateStatFrom,dateStatTo},function(){
				$.post('/controler/home/getSvgGraph',{width},function(data){
					$('.js__svg--graph--pole').empty().append(data);
					$('circle[id*="circleinfo"]').hover(function(){
						$(this).attr('stroke','#aa8787');
					},function(){
						$(this).attr('stroke','none');
					});
					$('circle[id*="circleinfo"]').click(function(){
						//alert($(this).attr('info'));
						$('.js__popup--text').empty().append($(this).attr('info')); showPopup();
						$('.js__popup--close').click(function(){ hidePopup(); });
						$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
						$(window).bind('keypress', function(e){  if (e.keyCode==13) { hidePopup(); e.preventDefault(); } });
						$('.js__popup--confirm').click(function(){ hidePopup(); e.preventDefault(); });
					});
					$('.js__info--if--not--isset').animate({'opacity':'1'},200);
					var type = $('.js__stat--graph--view').val();
					$.post('/controler/home/changeGraphStatView',{type:type,rand:Math.random()},function(data){ 
						$('.js__table--stat--pole').empty().append(data);
						$('#back1all').fadeOut(300);
					});
				});
			});
		});
		$('select[class*="js__stat--graph--view"]').change(function(){
			$('#back1all').css('width',$('.home--rightmain').width()+'px').css('height',$(window).height()-66+'px').fadeIn(300);
			var type = $(this).val();
			$.post('/controler/home/changeGraphStatView',{type,rand:Math.random()},function(data){ 
				$('.js__table--stat--pole').empty().append(data);
				$('#back1all').fadeOut(300);
			});
		});
		$('#back1all').css('width',$('.home--rightmain').width()+'px').css('height',$(window).height()-66+'px').fadeIn(1);
		//$(window).on('load',function(){ 
			var width = $('.js__filter--stat--pole').width();
			var type = $('.js__stat--graph--view').val(); 
			$.post('/controler/home/testGaAnalytics',function(data){ 
				var obj = jQuery.parseJSON(data); 
				if (obj.status=='ok') {
					$.post('/controler/home/getSvgGraph',{width},function(data){
						$('.js__svg--graph--pole').empty().append(data);
						$('circle[id*="circleinfo"]').hover(function(){
							$(this).removeClass('circleclass').addClass('circleclass1'); 
						},function(){
							$(this).removeClass('circleclass1').addClass('circleclass'); 
						});
						$('circle[id*="circleinfo"]').click(function(){
							//alert($(this).attr('info'));
							$('.js__popup--text').empty().append($(this).attr('info')); showPopup();
							$('.js__popup--close').click(function(){ hidePopup(); });
							$(window).bind('keyup', function(e){ if (e.keyCode==27) { hidePopup(); e.preventDefault(); } });
							$(window).bind('keypress', function(e){  if (e.keyCode==13) { hidePopup(); e.preventDefault(); } });
							$('.js__popup--confirm').click(function(){ hidePopup(); e.preventDefault(); });
						});
						$('.js__info--if--not--isset').animate({'opacity':'1'},200);
						$('.js__filter--stat--pole').animate({'opacity':'1'},200);
						$.post('/controler/home/changeGraphStatView',{type,rand:Math.random()},function(data){ 
							$('.js__table--stat--pole').empty().append(data);
							$('#back1all').fadeOut(300);
						});
					});
				} else {
					$('#back1all').fadeOut(300);
					if (obj.status=='error') { 
						$('.js__info--if--not--isset').empty().addClass('empty--stat').append(obj.text).animate({'opacity':'1'},200);
					}
					if (obj.status=='alsee') { 
						$('.js__filter--stat--pole').animate({'opacity':'1'},200);
						$('.js__svg--graph--pole').empty().append(obj.text1);
						$('.js__table--stat--pole').empty().append(obj.text);
						$('.js__info--if--not--isset').animate({'opacity':'1'},200);
					}
				}
			});
		//});
	}
	var countUsers = [];
	var ci=0;
	$('span[class*="js__see--count--users"]').each(function(){
		countUsers[ci]=$(this).attr('data-id');
		ci++;
	});
	if ($('.js__see--count--users').html()!=undefined) {
		$.post('/controler/users/getCountUsers',{countUsers},function(response){
			var obj = jQuery.parseJSON(response); 
			$('span[class*="js__see--count--users"]').each(function(){
				var id = $(this).attr('data-id');
				$(this).empty().append('('+obj[id]+')');
			});
		});
	}
	$('.js__uservar--button').click(function(){
		$('.js__info--message').empty();
		var a=0;
		if ($('.js__uservar--name').val()=='') {
			$('.js__info--message').append(localeArray['enterName']+'<br>'); a=1;
			$('.js__uservar--name').removeClass().addClass('fail');
		} 
		if (a==0) {
			$('.js__uservar--form').submit();
		}
	});
});