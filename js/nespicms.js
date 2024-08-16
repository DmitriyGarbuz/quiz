$(document).ready(function() {
	var langtext = $('#defaultLocale').attr('data-text');
	var langlink = $('#defaultLocale').attr('data-link');
	var localeArray = [];
	$.getJSON('/js/languages/language'+langtext+'.json', function(response) {
		$(response).each(function(i,val){
			$.each(val,function(key,val){
				localeArray[key]=val;
			});
		});
	});
	footerPosition();
	$('.js__search--button').on('click',function(){ 
		var searchWord = $('.js__search--field').val();
		if (simpleValidate(searchWord,'simple')) { 
			$.post('/datawork/setSearchWord',{searchWord,rand:Math.random()},function(){
				window.location.href="/"+langlink+"search";
			});
		}
	});
	$('.js__pagination--button').on('click',function(){
		var type = $(this).attr('data-type');
		var url = $(this).attr('data-url');
		var page = $(this).attr('data-page');
		getNextItems (type,url,page);
	});
	$('.js__body--background').click(function(){ 
		$('.js__body--popup').fadeOut(200).css('opacity',0); 
		$('.js__body--background').fadeOut(200); 
		$('.js__mobile--menu--container').fadeOut(200);
		$('.js__mobile--menu--container').animate({'width':'0px'},200);
	});
	$('div[class*="js__show--mobile--menu"]').click(function(){ 
		var chapw = $(window).width()/1.5;
		if ($('.js__mobile--menu--container').html()=='') {
			$('.js__mobile--menu--container').load('/datawork/getMobileMenu',{langlink,langtext,rand:Math.random()},function(){
				$('.js__mobile--menu--container').animate({'width':chapw+'px'},200);
				$('.js__mobile--menu--container').css('display','block').animate({'opacity':'1'},100);
				$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			});
		} else {
			$('.js__mobile--menu--container').animate({'width':chapw+'px'},200);
			$('.js__mobile--menu--container').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
		}
	});
	$('.js__addcomment--article--button').click(function(){
		var articleId = $(this).attr('data-id');
		addComment(0,articleId);
	});
	$('.js__addcomment--button').click(function(){
		var chapterId = $(this).attr('data-id');
		addComment(chapterId);
	});
	$('.js__addfaq--button').click(function(){
		var chapterId = $(this).attr('data-id');
		addFaq(chapterId);
	});
	$('.js__addfaq--firstname').keyup(function(){
		if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
	});
	$('.js__addfaq--firsttext').keyup(function(){
		if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
	});
	$('.js__addcomment--firstname').keyup(function(){
		if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
	});
	$('.js__addcomment--firsttext').keyup(function(){
		if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
	});
	$('button[class*="js__addcomment--inarticle--button"]').click(function(){
		var articleId = $(this).attr('data-parent');
		var commentId = $(this).attr('data-id');
		var padding = $(this).attr('data-left');
		addCommentArtIn(articleId,commentId,padding);
	});
	$('span[class*="js__addcomment--addanswer--show"]').click(function(){ 
		var commentId = $(this).attr('data-id');
		if ($('.fnc--addcomment--container--none'+commentId).css('display')=='block') {
			$('.fnc--addcomment--container--none'+commentId).slideUp(100);
		} else {
			$('.fnc--addcomment--container--none'+commentId).slideDown(100);
		}
	});
	$('button[class*="js__order--call--button"]').click(function(){
		$('.js__body--popup').load('/datawork/callmeShow',{langlink,langtext,rand:Math.random()},function(){
			$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			$('.js__close--popup').click(function(){ 
				$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
				$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
			});
			$('.js__popup--order--call--button').click(function(){ 
				var error=0;
				var firstName = $('.js__order--call--firstname').val();
				if (!simpleValidate(firstName,'simple')) { error=1; $('.js__order--call--firstname').addClass('fail--input'); } else { $('.js__order--call--firstname').removeClass('fail--input'); }
				var telnumber = $('.js__order--call--telnumber').val();
				if (!simpleValidate(telnumber,'simple')) { error=1; $('.js__order--call--telnumber').addClass('fail--input'); } else { $('.js__order--call--telnumber').removeClass('fail--input'); }
				var text = $('.js__order--call--text').val();
				if (!simpleValidate(text,'justscript')) { error=1; $('.js__order--call--text').addClass('fail--input'); } else { $('.js__order--call--text').removeClass('fail--input'); }
				if (error==0) { 
					$.post('/datawork/addCallme',{firstName,text,telnumber,langlink,langtext,rand:Math.random()},function(response){
						$('.js__order--call--firstname').val(''); 
						$('.js__order--call--text').val(''); 
						$('.js__order--call--telnumber').val('');
						showAnswer(response);
					});
				}
			});
			$('.js__order--call--firstname').keyup(function(){
				if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
			});
			$('.js__order--call--telnumber').keyup(function(){
				if ($(this).val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); }
			});
		});
	});
	$('.js__comment--slider--left').click(function(){
		var page = $('.js__slider--comment--next').attr('data-info')/1-1;
		nextSlideComment (page);
	});
	$('.js__comment--slider--right').click(function(){
		var page = $('.js__slider--comment--next').attr('data-info')/1+1;
		nextSlideComment (page);
	});
	$('input[id*="js__poll--check"]').click(function(){ 
		var pollParamId = $(this).attr('data-id');
		var pollId = $(this).attr('data-poll');
		$('input[id*="js__poll--check"]').each(function(){
			if ($(this).attr('data-poll')==pollId) {
				$(this).attr('disabled',true);
			}
		});
		$.post('/datawork/makeVote',{pollParamId,langlink,langtext,rand:Math.random()},function(response){
			showAnswer (response);
		});
	});
	function nextSlideComment (page) {
		$.post('/datawork/getSliderComment',{page,langlink,langtext,rand:Math.random()},function(response){
			var obj = jQuery.parseJSON(response); 
			$('.js__slider--comment--next').attr('data-info',obj.next);
			$('.js__slider--comment--next').animate({'opacity':0},300,function(){
				$(this).empty().append(obj.text).animate({'opacity':1},300);
			});
		});
	}
	function showAnswer (response) {
		$('.js__body--popup').load('/datawork/answerShow',{response,langlink,langtext,rand:Math.random()},function(){
			$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			$('.js__close--popup').click(function(){ 
				$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
				$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
			});
		});
	}
	function addCommentArtIn (articleId,commentId,padding) { 
		var error=0; 
		$('.js__addcomment--inarticle--info'+commentId).empty(); 
		var firstName = $('.js__addcomment--inarticle--firstname'+commentId).val();
		if (!simpleValidate(firstName,'simple')) { error=1; $('.js__addcomment--inarticle--firstname'+commentId).addClass('fail--input'); } else { $('.js__addcomment--inarticle--firstname'+commentId).removeClass('fail--input'); }
		var text = $('.js__addcomment--inarticle--text'+commentId).val();
		if (!simpleValidate(text,'simple')) { error=1; $('.js__addcomment--inarticle--text'+commentId).addClass('fail--input'); } else { $('.js__addcomment--inarticle--text'+commentId).removeClass('fail--input'); }
		if (error==0) {
			$.post('/datawork/addComment',{chapterId:0,articleId,commentId,firstName,text,padding,langlink,langtext,rand:Math.random()},function(response){
				var obj = jQuery.parseJSON(response); 
				$('.js__addcomment--inarticle--firstname'+commentId).val(''); 
				$('.js__addcomment--inarticle--text'+commentId).val(''); 
				$('.js__addcomment--inarticle--info'+commentId).empty(); 
				showAnswer (obj.response);
				$('.fnc--addcomment--container--none'+commentId).slideUp(100);
				$('.js__addcomment--inarticle--info'+commentId).parent('div').parent('div').parent('div').after(obj.text);
			});
		} 
	}
	function addComment (chapterId=0,articleId=0) { 
		var error=0; 
		$('.js__comment--info').empty(); 
		var firstName = $('.js__addcomment--firstname').val();
		if (!simpleValidate(firstName,'simple')) { error=1; $('.js__addcomment--firstname').addClass('fail--input'); } else { $('.js__addcomment--firstname').removeClass('fail--input'); }
		var text = $('.js__addcomment--text').val();
		if (!simpleValidate(text,'simple')) { error=1; $('.js__addcomment--text').addClass('fail--input'); } else { $('.js__addcomment--text').removeClass('fail--input'); }
		if (error==0) {
			$.post('/datawork/addComment',{chapterId,articleId,firstName,text,langlink,langtext,rand:Math.random()},function(response){
				$('.js__addcomment--firstname').val(''); 
				$('.js__addcomment--text').val(''); 
				$('.js__addcomment--info').empty(); 
				if (articleId>0) {
					var obj = jQuery.parseJSON(response); 
					$('.fnc--article--comments--container').prepend(obj.text);
					showAnswer (obj.response);
				} else {
					showAnswer (response);
				}
			});
		} 
	}
	function addFaq (chapterId) {
		var error=0; 
		$('.js__faq--info').empty(); 
		var firstName = $('.js__addfaq--firstname').val();
		if (!simpleValidate(firstName,'simple')) { error=1; $('.js__addfaq--firstname').addClass('fail--input'); } else { $('.js__addfaq--firstname').removeClass('fail--input'); }
		var text = $('.js__addfaq--text').val();
		if (!simpleValidate(text,'simple')) { error=1; $('.js__addfaq--text').addClass('fail--input'); } else { $('.js__addfaq--text').removeClass('fail--input'); }
		if (error==0) {
			$.post('/datawork/addFaq',{chapterId,firstName,text,langlink,langtext,rand:Math.random()},function(response){
				$('.js__addfaq--firstname').val(''); 
				$('.js__addfaq--text').val(''); 
				showAnswer (response);
			});
		} 
	}
	function getNextItems (type,url,page) {
		$.post('/datawork/getNextItems',{type,url,page,langlink,langtext,rand:Math.random()},function(response){
			var obj = jQuery.parseJSON(response); 
			$('.js__list--container').empty().append(obj.items);
			$('.js__pagination--container').empty().append(obj.pagination);
			if (type=='chapter') { var typeLink=''; } else { var typeLink=type; }
			if (url!='') { var urlLink=url; } else { var urlLink=''; }
			if (page==0) { var pageLink = ''; } else { var pageLink = '/page-'+(page/1+1); }
			history.pushState(null, null, '/'+langlink+typeLink+urlLink+pageLink);
			$('.js__pagination--button').on('click',function(){
				var type = $(this).attr('data-type');
				var url = $(this).attr('data-url');
				var page = $(this).attr('data-page');
				getNextItems (type,url,page);
			})
			footerPosition();
		});
	}
	$('.js__feedback--button').click(function(){
		var feedbackId = $(this).attr('data-id');
		feedback(feedbackId);
	});
	$('.js__feedback--popup--button').click(function(){
		var feedbackId = $(this).attr('data-id');
		$('.js__body--popup').load('/datawork/feedbackShow',{feedbackId,langlink,langtext,rand:Math.random()},function(){
			
			$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			$('.js__close--popup').click(function(){ 
				$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
				$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
			});
			
			$('.js__feedback--button').click(function(){
				var feedbackId = $(this).attr('data-id');
				feedback(feedbackId);
			});
			$('input[id*="feedback"]').keyup(function(){ 
				var number = $(this).attr('data-info')/1;
				var value = $(this).val(); 
				if ($(this).attr('type')=='text') {
					if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
						$(this).removeClass().addClass('fail'); 
					} else {
						if ((value.indexOf("<")!=-1)||(value.indexOf(">")!=-1)) {  } else {
							$(this).removeClass(); 
						}
					}
				}
			});
			$('textarea[id*="feedback"]').keyup(function(){
				var number = $(this).attr('data-info')/1;
				var value = $(this).val(); 
				if (($(this).parent('div').attr('data-info')==1)&&(value=='')) {
					$(this).removeClass().addClass('fail'); 
				} else {
					if ((value.indexOf("<")!=-1)||(value.indexOf(">")!=-1)) { } else {
						$(this).removeClass(); 
					}
				}
			});
		});
	});
	function feedback (feedbackId) {
		var error=0;
		var params = []; 
		$('input[class*="js__feedback--param'+feedbackId+'"]').each(function(){
			var feedbackParamId = $(this).attr('data-id')/1;
			var value = $(this).val(); 
			if (($(this).attr('type')=='text')||($(this).attr('type')=='feedbackParamId')) {
				if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
					$(this).addClass('fail--input'); error=1;
				} else {
					if (!simpleValidate(value,'justscript')) { error=1; } else {
						params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
					}
				}
			}
			if ($(this).attr('type')=='number') {
				if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
					$(this).addClass('fail--input'); error=1;
				} else {
					if (!simpleValidate(value,'justscript')) { error=1; } else {
						params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
					}
				}
			}
			if ($(this).attr('type')=='checkbox') {
				if (($(this).parent('div').attr('data-need')==1)&&(!$(this).is(":checked"))) {
					$(this).addClass('fail--input'); error=1;
				} else {
					if (!simpleValidate(value,'justscript')) { error=1; } else {
						params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
					}
				}
			}
			if ($(this).attr('type')=='radio') {
				if ($(this).is(":checked")) { 
					if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
						$(this).addClass('fail--input'); error=1;
					} else {
						if (!simpleValidate(value,'justscript')) { error=1; } else {
							params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
						}
					}
				}
			}
		});
		$('select[class*="js__feedback--param'+feedbackId+'"]').each(function(){
			var value = $(this).val(); 
			var feedbackParamId = $(this).attr('data-id')/1;
			if (($(this).parent('div').attr('need')==1)&&(value=='')) {
				$(this).addClass('fail--input'); error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
				}
			}
		});
		$('textarea[class*="js__feedback--param'+feedbackId+'"]').each(function(){
			var feedbackParamId = $(this).attr('data-id')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				$(this).addClass('fail--input'); error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[feedbackParamId] = value; $(this).removeClass('fail--input'); 
				}
			}
		});
		if (error==0) {			
			var length = $('input[class*="js__feedback--file'+feedbackId+'"]').length;		
			var i=0;	 
			if (length>0) { 
				$('input[class*="js__feedback--file'+feedbackId+'"]').each(function(){				
					var feedbackParamId = $(this).attr('data-id');				
					var filetype = $('.js__feedback--file--format'+feedbackParamId).val();				
					var file = $(this).val(); 				
					$.post('/datawork/feedbackFileTest',{file,filetype,rand:Math.random()},function(testfile){					
						if (testfile==0) { 						
							$('#divFeedbackParamFile'+feedbackParamId).css('display','block');					
						}					
						$('.js__feedback--form'+feedbackParamId).ajaxForm({						
							success: function(data){  							
								i++;								
								if (length==i) {								
									$.post('/datawork/feedback',{params,feedbackId,langlink,langtext,rand:Math.random()},function(response){									
										feedbackClear (feedbackId);
										showAnswer(response);
									});							
								}						
							}					
						}).submit();				
					});			
				});	
			} else { 
				$.post('/datawork/feedback',{params,feedbackId,langlink,langtext,rand:Math.random()},function(response){	
					feedbackClear (feedbackId);
					showAnswer(response);
				});	
			}
		}
	}
	function feedbackClear (feedbackId) {
		$('input[class*="js__feedback--param'+feedbackId+'"]').each(function(){ $(this).val(''); });									
		$('input[class*="js__feedback--param'+feedbackId+'"]').each(function(){ $(this).val(''); });									
		$('textarea[class*="js__feedback--param'+feedbackId+'"]').each(function(){ $(this).val(''); });									
		$('input:checkbox[class*="js__feedback--param'+feedbackId+'"]').each(function(){ $(this).prop('checked',false); });									
		var r=0; 
		$('input:radio[class*="feedback'+feedbackId+'"]').each(function(){ 
			if (r==0) { $(this).prop('checked',true); } else { $(this).prop('checked',false); } r++; 
		});									
		$('select[class*="js__feedback--param'+feedbackId+'"]').each(function(){ $(this).prop('selectedIndex',0); });		
		$('#divfeedbackparamfile'+feedbackId).css('display','none');							
	}
	$('input[class*="js__feedback--param"]').keyup(function(){ 
		var value=$(this).val();
		if ($(this).attr('type')=='text') {
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				$(this).addClass('fail--input'); 
			} else {
				if (simpleValidate(value,'justscript')) { 
					$(this).removeClass('fail--input'); 
				}
			}
		}
	});
	$('textarea[class*="js__feedback--param"]').keyup(function(){
		var value=$(this).val();
		if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
			$(this).addClass('fail--input'); 
		} else {
			if (simpleValidate(value,'justscript')) { 
				$(this).removeClass('fail--input'); 
			}
		}
	});
	function simpleValidate (data,type) { 
		var response = true;
		if (type=='simple') { if ((data.indexOf("<")==-1)&&(data.indexOf(">")==-1)&&(data!='')) { response=true; } else { response=false; } }
		if (type=='justscript') { if ((data.indexOf("<")==-1)&&(data.indexOf(">")==-1)) { response=true; } else { response=false; } }
		if (type=='email') { if ((data.indexOf("@")!=-1)||(data.indexOf(".")!=-1)) { response=true; } else { response=false; } }
		if (type=='password') { 
			var pattern = /^([a-zA-Z0-9_]{0,})$/;
			if ((pattern.test(data))&&(data.length>=6)&&(data.length<=15)) { response=true; } else { response=false; } 
		}
		return response;
	}
	function userLogin () {
		$('.js__login--info').empty(); var error=0;
		var email = $('.js__login--email').val();
		var password = $('.js__login--password').val();
		if ((!simpleValidate(email,'simple'))||(!simpleValidate(email,'email'))) { error=1; $('.js__login--email').addClass('fail--input'); }
		if ((!simpleValidate(password,'simple'))||(!simpleValidate(password,'password'))) { error=1; $('.js__login--password').addClass('fail--input'); }
		if (error==0) { 
			$.post('/datawork/checkEmail',{email,userId:0,rand:Math.random()},function(response){
				if (response>0) {
					$.post('/datawork/checkEmailPassword',{email,password,rand:Math.random()},function(response){
						if (response>0) {
							$.post('/datawork/userLogin',{langlink,langtext,email,password,rand:Math.random()},function(response){
								var obj = jQuery.parseJSON(response); 
								if (obj.success==1) { 
									window.location.href="/"+langlink+"account";
								} else {
									$('.js__login--info').empty().append(obj.error);
								}
							});
						} else {
							$('.js__login--password').addClass('fail--input'); 
							$('.js__login--info').empty().append(localeArray['passwordIsIncorrect']).fadeIn(100);
						}
					});
				} else {
					$('.js__login--email').addClass('fail--input'); 
					$('.js__login--info').empty().append(localeArray['userWithEmailDoesNotExist']).fadeIn(100);
				}
			});
		}
	}
	$('button[class*="js__logout--button"]').click(function(){
		$.post('/datawork/logOut',{rand:Math.random()},function(){
			location.href="/"+langlink;
		});
	}); 
	$('button[class*="js__login--button"]').click(function(){ 
		userLogin();
	});
	$('.js__login--email').bind('keypress', function(e){
		if (e.keyCode==13) {
			userLogin();
		}
	});
	$('js__login--password').bind('keypress', function(e){
		if (e.keyCode==13) {
			userLogin();
		}
	});
	$('.js__login--form--open').click(function(){ 
		$('.js__body--popup').load('/datawork/showUserLogin',{langlink,langtext,rand:Math.random()},function(){
			$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			$('.js__close--popup').click(function(){ 
				$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
				$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
			});
			$('.js__login--email').bind('keypress', function(e){
				if (e.keyCode==13) {
					userLogin();
				}
			});
			$('.js__login--password').bind('keypress', function(e){
				if (e.keyCode==13) {
					userLogin();
				}
			});
			$('.js__login--button').click(function(){
				userLogin();
			});
			$('.js__forgot--button').click(function(){
				$('.js__body--popup').load('/datawork/showUserForget',{langlink,langtext,rand:Math.random()},function(){
					$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
					$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
					$('.js__close--popup').click(function(){ 
						$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
						$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
					});
					$('.js__forgot--button').click(function(){
						userForget(); 
					});
				});
			});
		});
	});
	$('.js__forgot--button').click(function(){ 
		$('.js__body--popup').load('/datawork/showUserForget',{langlink,langtext,rand:Math.random()},function(){
			$('.js__body--popup').css('display','block').animate({'opacity':'1'},100);
			$('.js__body--background').css('display','block').animate({'opacity':'0.8'},100);
			$('.js__close--popup').click(function(){ 
				$('.js__body--popup').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
				$('.js__body--background').animate({'opacity':'0'},100,function(){$(this).css('display','none')}); 
			});
			$('.js__forgot--button').click(function(){
				userForget();
			});
		});
	});
	function userForget () {  
		$('.js__forgot--info').empty(); var error=0;
		var email = $('.js__forgot--email').val();
		if ((!simpleValidate(email,'simple'))&&(!simpleValidate(email,'email'))) { error=1; $('.js__forgot--email').addClass('fail--input'); } 
		if (error==0) { 
			$.post('/datawork/checkEmail',{email,rand:Math.random()},function(response){
				if (response>0) {
					$('.js__forgot--info').load('/datawork/userForget',{langlink,langtext,email,rand:Math.random() },function(){
						$('.js__forgot--email').val('');
					});
				} else { 
					$('.js__forgot--email').addClass('fail--input'); 
					$('.js__forgot--info').empty().append(localeArray['userWithEmailDoesNotExist']).fadeIn(100);
				}	
			});
		}
	}
	$('button[class*="js__registration--button"]').click(function(){ 
		var error=0; 
		$('.js__registration--info').empty();  
		var params = []; 
		var fio = '';
		var surname = '';
		var phone = '';
		var email = '';
		var password = '';
		email = $('.js__registration--email').val();
		password = $('.js__registration--password').val();
		repassword = $('.js__registration--repassword').val();
		if ((!simpleValidate(email,'simple'))||(!simpleValidate(email,'email'))) { error=1; $('.js__registration--email').addClass('fail--input'); 
			$('.js__registration--info').append(localeArray['emailRules']+'<br>'); 
		}
		if ((!simpleValidate(password,'simple'))||(!simpleValidate(password,'password'))) { error=1; $('.js__registration--password').addClass('fail--input'); 
			$('.js__registration--info').append(localeArray['passwordRules']+'<br>'); 
		}
		if ((!simpleValidate(repassword,'simple'))||(password!=repassword)) { error=1; $('.js__registration--repassword').addClass('fail--input'); 
			$('.js__registration--info').append(localeArray['repasswordError']+'<br>'); 
		}
		if ($('.js__registration--fio').val()!=undefined) {
			fio = $('.js__registration--fio').val();
			if (!simpleValidate(fio,'simple')) { error=1; $('.js__registration--fio').addClass('fail--input'); }
		}
		if ($('.js__registration--surname').val()!=undefined) {
			surname = $('.js__registration--surname').val();
			if (!simpleValidate(email,'simple')) { error=1; $('.js__registration--surname').addClass('fail--input'); }
		}
		if ($('.js__registration--phone').val()!=undefined) {
			phone = $('.js__registration--phone').val();
			if (!simpleValidate(phone,'simple')) { error=1; $('.js__registration--phone').addClass('fail--input'); }
		}
		$('input[class*="js__registration--user--param"]').each(function(){
			var userParamId = $(this).attr('data-id')/1;
			var value = $(this).val(); 
			if ($(this).attr('type')=='text') {
				if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
					$('.js__registration--user--param'+userParamId).addClass('fail--input'); error=1;
				} else {
					if (!simpleValidate(value,'simple')) { error=1; } else {
						params[userParamId] = value;
						$('.js__registration--user--param'+userParamId).removeClass('fail--input'); 
					}
				}
			}
			if ($(this).attr('type')=='radio') {
				if ($(this).is(":checked")) { 
					if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
						$('.js__registration--user--param'+userParamId).addClass('fail--input'); error=1;
					} else {
						if (!simpleValidate(value,'justscript')) { error=1; } else {
							params[userParamId] = value;
							$('.js__registration--user--param'+userParamId).removeClass('fail--input'); 
						}
					}
				}
			}
			if ($(this).attr('type')=='checkbox') {
				if ($(this).is(":checked")) { 
					if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
						$('.js__registration--user--param'+userParamId).addClass('fail--input'); error=1;
					} else {
						if (!simpleValidate(value,'justscript')) { error=1; } else {
							params[userParamId] = value;
							$('.js__registration--user--param'+userParamId).removeClass('fail--input'); 
						}
					}
				}
			}
		});
		$('select[class*="js__registration--user--param"]').each(function(){
			var value = $(this).val(); 
			var userParamId = $(this).attr('data-id')/1;
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[userParamId] = value;
				}
			}
		});
		$('textarea[class*="js__registration--user--param"]').each(function(){
			var userParamId = $(this).attr('data-id')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				$('.js__registration--user--param'+userParamId).addClass('fail--input'); error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[userParamId] = value;
					$('.js__registration--user--param'+userParamId).removeClass('fail--input'); 
				}
			}
		});
		if (error==0) {
			$.post('/datawork/checkEmail',{email,userId:0,rand:Math.random()},function(response){
				if (response==0) {
					$.post('/datawork/regUser',{params,email,password,fio,phone,surname,langlink,langtext,rand:Math.random()},function(response){
						if (response==1) {
							$('.js__registration--page--content').fadeOut(100,function(){
								$('.js__registration--info').empty().append(localeArray['registrationCompletedAnEmailSentActivate']);
								footerPosition();
							});
						} else {
							window.location.href="/"+langlink+"account";
						}
					});
				} else { 
					$('.js__registration--email').addClass('fail--input'); 
					$('.js__registration--info').empty().append(localeArray['userWithThisEmailAlreadyExists']).fadeIn(100);
				}				
			});
		} 
	});
	function footerPosition () {
		$('.content--footer').css('position','').css('bottom','');
		if ($('.under--header--slider').height()==undefined) { var sliderheight=0; } else { var sliderheight=$('.under--header--slider').height(); }
		if ($('.header').height()+$('.content--center--main').height()+sliderheight+$('.content--footer').height()<$(window).height()) {
			$('.content--footer').css('position','fixed').css('bottom',0);
		}  
	}
	$('.js__registration--fio').keyup(function(){ 
		if ($('.js__registration--fio').val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); } $('.js__registration--info').empty();
	});
	$('.js__registration--surname').keyup(function(){ 
		if ($('.js__registration--surname').val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); } $('.js__registration--info').empty();
	});
	$('.js__registration--phone').keyup(function(){ 
		if ($('.js__registration--phone').val()=='') { $(this).addClass('fail--input'); } else { $(this).removeClass('fail--input'); } $('.js__registration--info').empty();
	});
	$('.js__registration--email').blur(function(){
		$('.js__registration--info').empty();
		if (($('.js__registration--email').val().indexOf("@")==-1)||($('.js__registration--email').val().indexOf(".")==-1)||($('.js__registration--email').val()=='')) {
			$('.js__registration--email').addClass('fail--input'); 
		} else {
			$.post('/datawork/checkEmail',{email:$('.js__registration--email').val(),rand:Math.random()},function(response){
				if (response==0) { $('#registrationEmail').removeClass('fail--input'); } else { $('#registrationEmail').addClass('fail--input'); }
			}); 
		}
	});
	$('.js__registration--password').keyup(function(){
		$('.js__registration--info').empty();
		if ($('.js__registration--password').val().length>5) { 
			var pattern = /^([a-zA-Z0-9_]{0,})$/;
			if ((!pattern.test($('.js__registration--password').val()))||($('.js__registration--password').val().length<6)||($('.js__registration--password').val().length>15)||($('.js__registration--password').val()=='')) {
				$('.js__registration--password').addClass('fail--input'); 
			} else {
				$('.js__registration--password').removeClass('fail--input'); 
			}
		}
	});
	$('.js__registration--repassword').blur(function(){
		$('.js__registration--info').empty();
		if ($('.js__registration--repassword').val().length>5) { 
			if ($('.js__registration--repassword').val()!=$('.js__registration--password').val()) { 
				$('.js__registration--repassword').addClass('fail--input');
			} else {
				$('.js__registration--repassword').removeClass('fail--input'); 
			}
		}
	});
	$('input[class*="js__registration--user--param"]').keyup(function(){ 
		$('.js__registration--info').empty();
		var userParamId = $(this).attr('data-id')/1;
		var value = $(this).val(); 
		if ($(this).attr('type')=='text') {
			if ($(this).parent('div').attr('data-need')==1) {
				if (value=='') {
					$('#registrationUserParam'+userParamId).addClass('fail--input'); 
				} else {
					$('#registrationUserParam'+userParamId).removeClass('fail--input'); 
				}
			}
		}
	});
	$('textarea[class*="js__registration--user--param"]').keyup(function(){
		$('.js__registration--info').empty();
		var userParamId = $(this).attr('data-id')/1;
		var value = $(this).val(); 
		if ($(this).parent('div').attr('data-need')==1) {
			if (value=='') {
				$('#registrationUserParam'+userParamId).addClass('fail--input'); 
			} else {
				$('#registrationUserParam'+userParamId).removeClass('fail--input'); 
			}
		}
	});
	$('button[class*="js__user--data--button"]').click(function(){  
		$('.js__user--data--info').empty(); var error=0; 
		var params = []; 
		var fio = '';
		var surname = '';
		var phone = '';
		if ($('.js__user--data--fio').val()!=undefined) {
			fio = $('.js__user--data--fio').val();
			if ($('.js__user--data--fio').parent('div').attr('data-need')==1) {
				if (!simpleValidate(fio,'simple')) { $('.js__user--data--fio').addClass('fail--input'); error=1; } else { $('.js__user--data--fio').removeClass('fail--input'); }
			}
		}
		if ($('.js__user--data--surname').val()!=undefined) {
			surname = $('.js__user--data--surname').val();
			if ($('.js__user--data--surname').parent('div').attr('data-need')==1) {
				if (!simpleValidate(surname,'simple')) { $('.js__user--data--surname').addClass('fail--input'); error=1; } else { $('.js__user--data--surname').removeClass('fail--input'); }
			}
		}
		if ($('.js__user--data--phone').val()!=undefined) {
			phone = $('.js__user--data--phone').val();
			if ($('.js__user--data--phone').parent('div').attr('data-need')==1) {
				if (!simpleValidate(phone,'simple')) { $('.js__user--data--phone').addClass('fail--input'); error=1; } else { $('.js__user--data--phone').removeClass('fail--input'); }
			}
		}
		$('input[class*="js__user--data--param"]').each(function(){
			var userParamId = $(this).attr('data-id')/1;
			var value = $(this).val();  
			if ($(this).attr('type')=='radio') {
				if ($(this).is(":checked")) { 
					if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
						$('.js__user--data--param'+userParamId).addClass('fail--input'); error=1;
					} else {
						if (!simpleValidate(value,'justscript')) { error=1; } else {
							params[userParamId] = value;
							$('.js__user--data--param'+userParamId).removeClass('fail--input'); 
						}
					}
				}
			}
			if ($(this).attr('type')=='checkbox') {
				if ($(this).is(":checked")) { 
					if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
						$('.js__user--data--param'+userParamId).addClass('fail--input'); error=1;
					} else {
						if (!simpleValidate(value,'justscript')) { error=1; } else {
							params[userParamId] = value;
							$('.js__user--data--param'+userParamId).removeClass('fail--input'); 
						}
					}
				}
			}	
			if ($(this).attr('type')=='text') {
				if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
					$('.js__user--data--param'+userParamId).addClass('fail--input'); error=1;
				} else {
					if (!simpleValidate(value,'justscript')) { error=1; } else {
						params[userParamId] = value;
						$('.js__user--data--param'+userParamId).removeClass('fail--input'); 
					}
				}
			}
		});
		$('select[class*="js__user--data--param"]').each(function(){
			var value = $(this).val(); 
			var userParamId = $(this).attr('data-id')/1;
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[userParamId] = value;
				}
			}
		});
		$('textarea[class*="js__user--data--param"]').each(function(){
			var userParamId = $(this).attr('data-id')/1;
			var value = $(this).val(); 
			if (($(this).parent('div').attr('data-need')==1)&&(value=='')) {
				$('#userDataParam'+userParamId).addClass('fail--input'); error=1;
			} else {
				if (!simpleValidate(value,'justscript')) { error=1; } else {
					params[userParamId] = value;
					$('#userDataParam'+userParamId).removeClass('fail--input'); 
				}
			}
		});
		if (error==0) {
			$.post('/datawork/userData',{params,fio,phone,surname,rand:Math.random()},function(){ 
				$('.js__user--data--info').empty().append(localeArray['saved']).fadeIn(100,function(){ 
					setTimeout(function() {
						$('.js__user--data--info').fadeOut(100);
					}, 2000);
				});
			});
		} 
	});
	$('.js__edit--preview--user').change(function(){
		$('.js__edit--user--preview').ajaxForm({						
			success: function(response){  							
				$('.js__user--avatar--container').empty().append(response);
			}		
		}).submit();			
	});
	$('.js__user--data--fio').keyup(function(){ 
		if ($('#userDataFio').val()=='') { $(this).addClass('fail'); } else { $(this).removeClass('fail--input'); }
	});
	$('.js__user--data--phone').keyup(function(){ 
		if ($('#userDataTelnumber').val()=='') { $(this).addClass('fail'); } else { $(this).removeClass('fail--input'); }
	});
	$('.js__user--data--surname').keyup(function(){ 
		if ($('#userDataSurname').val()=='') { $(this).addClass('fail'); } else { $(this).removeClass('fail--input'); }
	});
	$('input[class*="js__user--data--param"]').keyup(function(){ 
		var userParamId = $(this).attr('data-id')/1;
		var value = $(this).val(); 
		if ($(this).attr('type')=='text') {
			if ($(this).parent('div').attr('data-need')==1) {
				if (value=='') { $('.js__user--data--param'+userParamId).addClass('fail--input'); } else { $('.js__user--data--param'+userParamId).removeClass('fail--input'); }
			}
		}
	});
	$('textarea[class*="js__user--data--param"]').keyup(function(){ 
		var userParamId = $(this).attr('data-id')/1;
		var value = $(this).val(); 
		if ($(this).parent('div').attr('data-need')==1) { 
			if (value=='') { $('.js__user--data--param'+userParamId).addClass('fail--input');  } else { $('.js__user--data--param'+userParamId).removeClass('fail--input'); }
		}
	});
	$('button[class*="js__user--main--button"]').click(function(){ 
		$('.js__user--main--info').empty(); var error=0; 
		var email = $('.js__user--main--email').val();
		if ((!simpleValidate(email,'simple'))||(!simpleValidate(email,'email'))) { error=1; $('.js__user--main--email').addClass('fail--input'); } else { $('.js__user--main--email').removeClass('fail--input');  }
		var password = $('.js__user--main--password').val();
		if ((!simpleValidate(password,'simple'))||(!simpleValidate(password,'password'))) { error=1; $('.js__user--main--password').addClass('fail--input'); } else { $('.js__user--main--password').removeClass('fail--input');  }
		var repassword = $('.js__user--main--repassword').val();
		if ((!simpleValidate(repassword,'simple'))||(!simpleValidate(repassword,'password'))||(repassword!=password)) { error=1; $('.js__user--main--repassword').addClass('fail--input'); } else { $('.js__user--main--repassword').removeClass('fail--input');  }
		var oldpassword = $('.js__user--main--oldpassword').val();
		if ((!simpleValidate(oldpassword,'simple'))||(!simpleValidate(oldpassword,'password'))) { error=1; $('.js__user--main--oldpassword').addClass('fail--input'); } else { $('.js__user--main--oldpassword').removeClass('fail--input');  }
		if (repassword!=password) { 
			error=1; 
			$('.js__user--main--info').append(localeArray['passwordsDoNotMatch']).fadeIn(100);
			$('.js__user--main--repassword').addClass('input--fail'); 
		}
		if (error==0) {
			$.post('/datawork/checkEmail',{email,rand:Math.random()},function(response){
				if (response==0) {
					$.post('/datawork/checkOldPassword',{oldpassword,rand:Math.random()},function(response){
						if (response>0) { 
							$.post('/datawork/userMain',{email,password,rand:Math.random()},function(){
								$('.js__user--main--password').val('');
								$('.js__user--main--repassword').val('');
								$('.js__user--main--oldpassword').val('');
								$('.js__user--main--info').empty().append(localeArray['saved']).fadeIn(100,function(){
									setTimeout(function() {
										$('.js__user--main--info').fadeOut(100);
									}, 2000);
								});
							});
						} else {
							$('.js__user--main--oldpassword').removeClass().addClass('fail'); 
							$('.js__user--main--info').empty().append(localeArray['invalidOldPassword']).fadeIn(100);
						}
					});
				} else {
					$('.js__user--main--email').removeClass().addClass('fail'); 
					$('.js__user--main--info').empty().append(localeArray['userWithThisEmailAlreadyExists']).fadeIn(100);
				}
			});
		} 
	});
	$('.js__user--main--email').keyup(function(){
		if (($('#userMainEmail').val().indexOf("@")==-1)||($('#userMainEmail').val().indexOf(".")==-1)||($('#userMainEmail').val()=='')) {
			$('#userMainEmail').removeClass().addClass('fail'); 
			$('#userMainDivEmail').empty().append(EmailIsIncorrect).fadeIn(100);
		} else {
			$.post('/datawork/checkEmail',{email:$('.js__user--main--email').val(),rand:Math.random()},function(response){
				if (response==0) {
					$('#userMainEmail').removeClass('fail--input'); 
				} else {
					$('#userMainEmail').addClass('fail--input'); 
				}
			}); 
		}
	});
	$('.js__user--main--oldpassword').blur(function(){
		var pattern = /^([a-zA-Z0-9_]{0,})$/;
		if ((!pattern.test($('.js__user--main--oldpassword').val()))||($('.js__user--main--oldpassword').val().length<6)||($('.js__user--main--oldpassword').val().length>15)||($('.js__user--main--oldpassword').val()=='')) {
			$('.js__user--main--oldpassword').addClass('fail--input'); 
		} else {
			$.post('/datawork/checkOldPassword',{oldpassword:$('.js__user--main--oldpassword').val(),rand:Math.random()},function(response){
				if (response>0) {
					$('.js__user--main--oldpassword').removeClass('fail--input'); 
				} else { 
					$('.js__user--main--oldpassword').addClass('fail--input'); 
				}
			}); 
		}
	});
	$('.js__user--main--password').keyup(function(){
		if ($('.js__user--main--password').val().length>5) {  
			var pattern = /^([a-zA-Z0-9_]{0,})$/;
			if ((!pattern.test($('.js__user--main--password').val()))||($('.js__user--main--password').val().length<6)||($('.js__user--main--password').val().length>15)||($('.js__user--main--password').val()=='')) {
				$('.js__user--main--password').addClass('fail--input'); 
			} else {
				$('.js__user--main--password').removeClass('fail--input'); 
			}
		}
	});
	$('.js__user--main--repassword').blur(function(){
		if ($('.js__user--main--repassword').val().length>5) { 
			if ($('.js__user--main--repassword').val()!=$('.js__user--main--password').val()) { 
				$('.js__user--main--repassword').addClass('fail--input'); 
			} else {
				$('.js__user--main--repassword').removeClass('fail--input'); 
			}
		}
	});
	$('div[class*="js__account--button--tab"]').click(function(){
		var tab = $(this).attr('data-tab');
		$('div[class*="js__account--button--tab"]').each(function(){
			if ($(this).attr('data-tab')!=tab) { $(this).removeClass('account--tab__active').addClass('account--tab'); } else {
				$(this).removeClass('account--tab').addClass('account--tab__active');
				$.post('/datawork/changeActiveAccountTab',{tab,rand:Math.random()});
			}
		});
		$('div[class*="js__account--window--tab"]').each(function(){
			if ($(this).attr('data-tab')!=tab) { $(this).css('display','none'); } else {
				$(this).fadeIn(1,function(){
					footerPosition();
				});	
			}
		});
	});
	$('div[id*="itemVote"]').click(function(){ 
		var name = $(this).attr('data-id');
		$('#commentRating').val(name);
		if ($(this).attr('data-type')!=undefined) {
			if ($(this).attr('data-type')=='article') {
				var articleId = $(this).parent('div').parent('div').attr('data-id');
				$.post('/datawork/changeArticleRating',{articleId,rating:name},function(){
					window.location.reload();
				});
			}
			if ($(this).attr('data-type')=='chapter') {
				var chapterId = $(this).parent('div').parent('div').attr('data-id');
				$.post('/datawork/changeChapterRating',{chapterId,rating:name},function(){
					window.location.reload();
				});
			}
		}
	});
	$('div[id*="itemVote"]').hover(function(){
		var name = $(this).attr('data-id');
		if (name==1) {
			$(this).removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote2').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote3').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote4').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote5').removeClass('item--vote--act').addClass('item--vote');
		}
		if (name==2) {
			$('#itemVote1').removeClass('item--vote').addClass('item--vote--act');
			$(this).removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote3').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote4').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote5').removeClass('item--vote--act').addClass('item--vote');
		}
		if (name==3) {
			$('#itemVote1').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote2').removeClass('item--vote').addClass('item--vote--act');
			$(this).removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote4').removeClass('item--vote--act').addClass('item--vote');
			$('#itemVote5').removeClass('item--vote--act').addClass('item--vote');
		}
		if (name==4) {
			$('#itemVote1').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote2').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote3').removeClass('item--vote').addClass('item--vote--act');
			$(this).removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote5').removeClass('item--vote--act').addClass('item--vote');
		}
		if (name==5) {
			$('#itemVote1').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote2').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote3').removeClass('item--vote').addClass('item--vote--act');
			$('#itemVote4').removeClass('item--vote').addClass('item--vote--act');
			$(this).removeClass('item--vote').addClass('item--vote--act');
		}
	},function(){
		var rating = $('#commentRating').val();
		if (rating>0) {
			$('#rating1').removeClass('item--vote').addClass('item--vote--act');
		} else {
			$('#rating1').removeClass('item--vote--act').addClass('item--vote');
		}
		if (rating>1) {
			$('#rating2').removeClass('item--vote').addClass('item--vote--act');
		} else {
			$('#rating2').removeClass('item--vote--act').addClass('item--vote');
		}
		if (rating>2) {
			$('#rating3').removeClass('item--vote').addClass('item--vote--act');
		} else {
			$('#rating3').removeClass('item--vote--act').addClass('item--vote');
		}
		if (rating>3) {
			$('#rating4').removeClass('item--vote').addClass('item--vote--act');
		} else {
			$('#rating4').removeClass('item--vote--act').addClass('item--vote');
		}
		if (rating>4) {
			$('#rating5').removeClass('item--vote').addClass('item--vote--act');
		} else {
			$('#rating5').removeClass('item--vote--act').addClass('item--vote');
		}
		
	});
});