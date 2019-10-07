
if( !window.console ){
    window.console = {
        log: function(){}
    }
}


/*!
 * jQuery resizeend - A jQuery plugin that allows for window resize-end event handling.
 * 
 * Copyright (c) 2015 Erik Nielsen
 * 
 * Licensed under the MIT license:
 *    http://www.opensource.org/licenses/mit-license.php
 * 
 * Project home:
 *    http://312development.com
 * 
 * Version:  0.2.0
 * 
 */
!function(a){var b=window.Chicago||{utils:{now:Date.now||function(){return(new Date).getTime()},uid:function(a){return(a||"id")+b.utils.now()+"RAND"+Math.ceil(1e5*Math.random())},is:{number:function(a){return!isNaN(parseFloat(a))&&isFinite(a)},fn:function(a){return"function"==typeof a},object:function(a){return"[object Object]"===Object.prototype.toString.call(a)}},debounce:function(a,b,c){var d;return function(){var e=this,f=arguments,g=function(){d=null,c||a.apply(e,f)},h=c&&!d;d&&clearTimeout(d),d=setTimeout(g,b),h&&a.apply(e,f)}}},$:window.jQuery||null};if("function"==typeof define&&define.amd&&define("chicago",function(){return b.load=function(a,c,d,e){var f=a.split(","),g=[],h=(e.config&&e.config.chicago&&e.config.chicago.base?e.config.chicago.base:"").replace(/\/+$/g,"");if(!h)throw new Error("Please define base path to jQuery resize.end in the requirejs config.");for(var i=0;i<f.length;){var j=f[i].replace(/\./g,"/");g.push(h+"/"+j),i+=1}c(g,function(){d(b)})},b}),window&&window.jQuery)return a(b,window,window.document);if(!window.jQuery)throw new Error("jQuery resize.end requires jQuery")}(function(a,b,c){a.$win=a.$(b),a.$doc=a.$(c),a.events||(a.events={}),a.events.resizeend={defaults:{delay:250},setup:function(){var b,c=arguments,d={delay:a.$.event.special.resizeend.defaults.delay};a.utils.is.fn(c[0])?b=c[0]:a.utils.is.number(c[0])?d.delay=c[0]:a.utils.is.object(c[0])&&(d=a.$.extend({},d,c[0]));var e=a.utils.uid("resizeend"),f=a.$.extend({delay:a.$.event.special.resizeend.defaults.delay},d),g=f,h=function(b){g&&clearTimeout(g),g=setTimeout(function(){return g=null,b.type="resizeend.chicago.dom",a.$(b.target).trigger("resizeend",b)},f.delay)};return a.$(this).data("chicago.event.resizeend.uid",e),a.$(this).on("resize",a.utils.debounce(h,100)).data(e,h)},teardown:function(){var b=a.$(this).data("chicago.event.resizeend.uid");return a.$(this).off("resize",a.$(this).data(b)),a.$(this).removeData(b),a.$(this).removeData("chicago.event.resizeend.uid")}},function(){a.$.event.special.resizeend=a.events.resizeend,a.$.fn.resizeend=function(b,c){return this.each(function(){a.$(this).on("resizeend",b,c)})}}()});


/* 
 * jsui
 * ====================================================
*/
jsui.bd = $('body')
jsui.is_signin = jsui.bd.hasClass('logged-in') ? true : false;

if( $('.widget-nav').length ){
    $('.widget-nav li').each(function(e){
        $(this).hover(function(){
            $(this).addClass('active').siblings().removeClass('active')
            $('.widget-navcontent .item:eq('+e+')').addClass('active').siblings().removeClass('active')
        })
    })
}

if( $('.sns-wechat').length ){
    $('.sns-wechat').on('click', function(){
        var _this = $(this)
        if( !$('#modal-wechat').length ){
            $('body').append('\
                <div class="modal fade" id="modal-wechat" tabindex="-1" role="dialog" aria-hidden="true">\
                    <div class="modal-dialog" style="margin-top:200px;width:340px;">\
                        <div class="modal-content">\
                            <div class="modal-header">\
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                <h4 class="modal-title">'+ _this.attr('title') +'</h4>\
                            </div>\
                            <div class="modal-body" style="text-align:center">\
                                <img style="max-width:100%" src="'+ _this.data('src') +'">\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            ')
        }
        $('#modal-wechat').modal()
    })
}
if( $('.carousel').length ){
    var el_carousel = $('.carousel')

    el_carousel.carousel({
        interval: 4000
    })

    tbquire(['hammer'], function(Hammer) {

        // window.Hammer = Hammer
        
        var mc = new Hammer(el_carousel[0]);

        mc.on("panleft panright swipeleft swiperight", function(ev) {
            if( ev.type == 'swipeleft' || ev.type == 'panleft' ){
                el_carousel.carousel('next')
            }else if( ev.type == 'swiperight' || ev.type == 'panright' ){
                el_carousel.carousel('prev')
            }
        });

    })
}

if( Number(jsui.ajaxpager) > 0 && ($('.excerpt').length || $('.excerpt-minic').length) ){
    tbquire(['ias'], function() {
        if( !jsui.bd.hasClass('site-minicat') && $('.excerpt').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/static/img/loading.gif"></div>',
                trigger: 'More',
                onRenderComplete: function() {
                    tbquire(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/static/img/thumbnail.png',
                            threshold: 400
                        });
                    });
                }
            });
        }

        if( jsui.bd.hasClass('site-minicat') && $('.excerpt-minic').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt-minic',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/static/img/loading.gif"></div>',
                trigger: 'More',
                onRenderComplete: function() {
                    tbquire(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/static/img/thumbnail.png',
                            threshold: 400
                        });
                    });
                }
            });
        }
    });
}

    $(function(){
		$title=jsui.collapse_title;
        $(".hidecontent").hide();
        $("button").click(function(){
            var txts = $(this).parents("li");
            if ($(this).text() == $title){
                txts.find(".hidetitle").hide();
                txts.find(".hidecontent").slideToggle('show');
            }
        })
    });
/* 
 * lazyload
 * ====================================================
*/
tbquire(['lazyload'], function() {
    $('.avatar').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/avatar-default.png',
        threshold: 400
    })

    $('.widget .avatar').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/avatar-default.png',
        threshold: 400
    })

    $('.thumb').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })

    $('.widget_ui_posts .thumb').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })
    $('.img-share img').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })

})
     $wintip_srollbar=jsui.wintip_s;
	 $wintip_m=jsui.wintip_m;
/* 
 * wintips
 * ====================================================
*/
    if($wintip_srollbar>0){
		$(function(){
			if($.cookie("isClose") != 'yes'){
				setTimeout(function(){
				$(".wintips").show();
				}, 1000);
				$(".wintips-close").click(function(){
					$(".wintips").fadeOut(500);	
					$.cookie("isClose",'yes',{ expires:1/24});	// 10ms 为 1/8640 24h为1 1h为1/24 10min为1/144 20min为1/72
				
				});
			}
		});
     var width = $(window).width(); 
     if($wintip_m>0 && width < 720){$(".wintips").hide();}
	}
	
/* 
 * minic
 * ====================================================
*/
  
		$(function(){
			if($.cookie("minicClose") != 'yes'){
			setTimeout(function(){	
		     $(".excerpt-minic").show(500);
              }, 3000);
				$(".close-minic").click(function(){
					$(".excerpt-minic").fadeOut(500);	
					$.cookie("minicClose",'yes',{ expires:1/24});	
				
				});
			}
		});

	
/**全天提醒***/
var notices=jsui.notices_s;
  if(notices==1){
   day = new Date(); nge_Hour = day.getHours(); var nge_warmprompt = "";
     notices_str=jsui.notices_content; 
     var notices_strs= new Array(); 
       notices_strs=notices_str.split("|"); 

        if (nge_Hour == 0) {
        nge_warmprompt = notices_strs[0];
          } else if (nge_Hour == 1) {
        nge_warmprompt = notices_strs[1];
            } else if (nge_Hour == 2) {
        nge_warmprompt = notices_strs[2];
              } else if (nge_Hour == 3) {
        nge_warmprompt = notices_strs[3];
                } else if (nge_Hour == 4) {
        nge_warmprompt = notices_strs[4];
                  } else if (nge_Hour == 5) {
        nge_warmprompt = notices_strs[5];
                    } else if (nge_Hour == 6) {
        nge_warmprompt = notices_strs[6];
                     } else if (nge_Hour == 7) {
        nge_warmprompt = notices_strs[7];
                      } else if (nge_Hour == 8) {
        nge_warmprompt = notices_strs[8];
                         } else if ((nge_Hour == 9) || (nge_Hour == 10)) {
        nge_warmprompt = notices_strs[9];
                         } else if ((nge_Hour == 11) || (nge_Hour == 12)) {
        nge_warmprompt = notices_strs[10];
                       } else if ((nge_Hour >= 13) && (nge_Hour <= 17)) {
        nge_warmprompt = notices_strs[11];
                    } else if ((nge_Hour >= 17) && (nge_Hour <= 18)) {
        nge_warmprompt = notices_strs[12];
                 } else if ((nge_Hour >= 18) && (nge_Hour <= 19)) {
        nge_warmprompt = notices_strs[13];
             } else if ((nge_Hour >= 20) && (nge_Hour <= 21)) {
        nge_warmprompt = notices_strs[14];
           } else if ((nge_Hour >= 22) && (nge_Hour <= 23)) {
        nge_warmprompt = notices_strs[15];
      }

 function getDate(){
               
                var date = new Date();
                
                var times = date.toLocaleTimeString('chinese', { hour12: false });
               
               var div1 = document.getElementById("notices_times");

			   div1.innerHTML = times;
            }
           
            setInterval("getDate()",1000);

    $(function(){
	if($.cookie("noticesClose") != 'yes'){
		jsui.bd.append('\
			  <div class="notices">\
			  <div class="notices-icon">\
			  <img src="'+jsui.bing_img+'">\
			  </div>\
			  <div class="notices-content">\
			  <ul>\
			  <h4>'+jsui.notices_title+'</h2>\
			  <li class="notices-body">'+ nge_warmprompt +'</li>\
			  <li class="notices-info">北京时间：<span id="notices_times"></span></li>\
			  </ul>\
			  </div><i class="fa fa-times"></i>\
			  </div>\
                  '); 
		     setTimeout(function(){	
		      $(".notices").show(500);
              }, 3000);
				  	$(".notices>.fa").click(function(){
					$(".notices").hide(500);	
					$.cookie("noticesClose",'yes',{ expires:1/24});
				
				});
                }
	});
  }
	
	
	


$(window).scroll(function() {
	document.documentElement.scrollTop + document.body.scrollTop > 0 ? $('.header').addClass('scrolled') : $('.header').removeClass('scrolled');
    document.documentElement.scrollTop + document.body.scrollTop > 0 ? $('.oldtb').addClass('scrolled') : $('.oldtb').removeClass('scrolled');
})

/* 
 * prettyprint
 * ====================================================
*/
$('pre').each(function(){
    if( !$(this).attr('style') ) $(this).addClass('prettyprint')
})

if( $('.prettyprint').length ){
    tbquire(['prettyprint'], function(prettyprint) {
        prettyPrint()
    })
}


$(document).ready(function(){

	var c=1;								
	$(".group-detail>ul>.card-item").mouseenter(function(){
		var e=$(this);
		c=e.data("card");
		var e=$(this);
		setTimeout(function(){
			if(c==e.data("card")){
				$(".group-detail>ul>.card-item").removeClass("active");
				e.addClass("active")
			}
		},250)
	});

});
//复制下载密码
      function copyArticle(event) {
        const range = document.createRange();
        range.selectNode(document.getElementById('down-pass'));
 
        const selection = window.getSelection();
        if(selection.rangeCount > 0) selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
		obj=document.getElementById('copy-pass');
        obj.innerHTML = '<i class="fa fa-check-circle"></i> 已复制';
		setTimeout(function() {
        obj.innerHTML = '<i class="fa fa-clipboard"></i> 复制';
    },
    2000);
      }
 if(document.getElementById("copy-pass")) { 
       document.getElementById('copy-pass').addEventListener('click', copyArticle, false);
}

//隐藏或者显示侧边栏
    jQuery(document).ready(function($) {
	var width = $(window).width();
        $('.close-sidebar').click(function() {
			if(width > 1024){
            $('.sidebar').addClass('sid-on');
			$('.leftsd').addClass('leftsd-on');
            $('.show-sidebar').show();
			$('.close-sidebar').hide();
            $('.single-content').addClass('hidebianlan');
			 $('.containercc').addClass('boxhidesd');
			}});
        $('.show-sidebar').click(function() {
		if(width > 1024){
            $('.show-sidebar').hide();
			$('.close-sidebar').show();
            $('.sidebar').removeClass('sid-on');
			$('.leftsd').removeClass('leftsd-on');
            $('.single-content').removeClass('hidebianlan');
			 $('.containercc').removeClass('boxhidesd');
	 }});
    });
	
	
	
	  $('.share-haibao').click(function() {
			$('.bigger-share').addClass('haibao-on');
            $('.dialog_overlay').show();
			$('.dialog_overlay').click(function() {
			$('.bigger-share').removeClass('haibao-on');
            $('.dialog_overlay').hide();
			});
			
			});
	$('.share-close').click(function() {
			$('.bigger-share').removeClass('haibao-on');
            $('.dialog_overlay').hide();
			});
	
	
/* 
 * rollbar
 * ====================================================
*/
  if($wintip_srollbar<1){
jsui.rb_comment = ''
if (jsui.bd.hasClass('comment-open')) {
    jsui.rb_comment = "<li><a href=\"javascript:(scrollTo('#comments',-15));\"><i class=\"fa fa-comments\"></i></a><h6>去评论<i></i></h6></li>"
}

jsui.rb_qq = ''
if( jsui.qq_id ){
    jsui.rb_qq = '<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='+jsui.qq_id+'&site=qq&menu=yes"><i class="fa fa-qq"></i></a><h6>'+jsui.qq_tip+'<i></i></h6></li>'
}

jsui.bd.append('\
    <div class="m-mask"></div>\
    <div class="rollbar"><ul>'
    +jsui.rb_comment
    +jsui.rb_qq+
    '<li><a href="javascript:(scrollTo());"><i class="fa fa-angle-up"></i></a><h6>去顶部<i></i></h6></li>\
    </ul></div>\
')

  }else{
	  jsui.bd.append('<div class="m-mask"></div>')
  }

var _wid = $(window).width()

$(window).resize(function(event) {
    _wid = $(window).width()
});





/* 
 * bootstrap
 * ====================================================
*/
$('.user-welcome').tooltip({
    container: 'body',
    placement: 'bottom'
})





/* 
 * single
 * ====================================================
*/

var _sidebar = $('.sidebar')
if (_wid>1024 && _sidebar.length) {
    var h1 = 81,
        h2 = 96
    var rollFirst = _sidebar.find('.widget:eq(' + (jsui.roll[0] - 1) + ')')
    var sheight = rollFirst.height()


    rollFirst.on('affix-top.bs.affix', function() {

        rollFirst.css({
            top: 0
        })
        sheight = rollFirst.height()

        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.removeClass('affix').css({
                top: 0
            })
        };
    })

    rollFirst.on('affix.bs.affix', function() {

     rollFirst.css({
            top: h1
        })


        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.addClass('affix').css({
                top:  sheight+h2+5
            })
            sheight += current.height() + 80
        };
    })

    rollFirst.affix({
        offset: {
            top: _sidebar.height(),
            bottom: $('.footer').outerHeight()
        }
    })


}



$('[data-event="rewards"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeIn()
})

$('[data-event="rewards-close"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeOut()
})


if( $('#SOHUCS').length ) $('#SOHUCS').before('<span id="comments"></span>')


/*$('.plinks a').each(function(){
    var imgSrc = $(this).attr('href')+'/favicon.ico'
    $(this).prepend( '<img src="'+imgSrc+014'">' )
})*/




    $(function(){
        $('.doubt-content').hide();
        //按钮点击事件
        $('.doubt-button').click(function(){
            if ($(this).html() == '<i class="fa fa-chevron-down"></i>'){
				var txts = $(this).parents('.doubt');
                $(this).html('<i class="fa fa-chevron-up"></i>');
                //txts.find(".doubt-tit").hide();
                txts.find('.doubt-content').show(300);
            }else{
				var txts = $(this).parents('.doubt');
                $(this).html('<i class="fa fa-chevron-down"></i>');
                //txts.find(".doubt-tit").show();
                txts.find('.doubt-content').hide(300);
            }
        })
    });




if( $('.post-like').length ){
    tbquire(['jquery.cookie'], function() {
        $('.post-like').on('click', function(){
            var _ta = $(this)
            var pid = _ta.attr('data-pid')
            if ( !pid || !/^\d{1,}$/.test(pid) ) return;

            if( !jsui.is_signin ){
                var lslike = lcs.get('_likes') || ''
                if( lslike.indexOf(','+pid+',')!==-1 ) return alert('你已赞！')

                if( !lslike ){
                    lcs.set('_likes', ','+pid+',')
                }else{
                    if( lslike.length >= 160 ){
                        lslike = lslike.substring(0,lslike.length-1)
                        lslike = lslike.substr(1).split(',')
                        lslike.splice(0,1)
                        lslike.push(pid)
                        lslike = lslike.join(',')
                        lcs.set('_likes', ','+lslike+',')
                    }else{
                        lcs.set('_likes', lslike+pid+',')
                    }
                }
            }

            $.ajax({
                url: jsui.uri + '/action/like.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    key: 'like',
                    pid: pid
                },
                success: function(data, textStatus, xhr) {
                    if (data.error) return false;
                    _ta.toggleClass('actived')
                    _ta.find('span').html(data.response)
                }
            });
        })
    })
}


/*
 *down
 *
*/
$('.down-show').click(function(){
  $('.down-up').show(300);
  $('.m-mask').show();
  $('.down-up>.down-content').css('opacity', '1');
 
});
 $('.m-mask').on('click', function(){
    $(this).hide();
    $('.down-up').hide(300);
     $('.down-up>.down-content').css('opacity', '0');
 });
$('.down-up .close').click(function(){
  $('.down-up').hide(300);
  $('.m-mask').hide();
   $('.down-up>.down-content').css('opacity', '0');
  
});

/* 
 * left
 * ====================================================
*/
    $left=jsui.left_sd;
    if($left>0){
    var leftsd=document.getElementById("leftsd");    
    var H=0,iE6;    
    var Y=leftsd;    
    while(Y){H+=Y.offsetTop;Y=Y.offsetParent};    
    iE6=window.ActiveXObject&&!window.XMLHttpRequest;    
    if(!iE6){    
        window.onscroll=function()    
        {    
            var s=document.body.scrollTop||document.documentElement.scrollTop;   

            if(s>(H-66)){
			leftsd.className="left affix";
			if(iE6){leftsd.style.top=(s-H)+"px";} } else{	leftsd.className="left";    
        }    
    }    
	}
	}
/* 
 * comment
 * ====================================================
*/
if (jsui.bd.hasClass('comment-open')) {
    tbquire(['comment'], function(comment) {
        comment.init()
    })
}


/* 
 * page u
 * ====================================================
*/
if (jsui.bd.hasClass('page-template-pagesuser-php')) {
    tbquire(['user'], function(user) {
        user.init()
    })
}


/* 
 * page nav
 * ====================================================
*/
if( jsui.bd.hasClass('page-template-pagesnavs-php') ){

    var titles = ''
    var i = 0
    $('#navs .items h2').each(function(){
        titles += '<li><a href="#'+i+'">'+$(this).text()+'</a></li>'
        i++
    })
    $('#navs nav ul').html( titles )

    $('#navs .items a').attr('target', '_blank')

    $('#navs nav ul').affix({
        offset: {
            top: $('#navs nav ul').offset().top,
            bottom: $('.footer').height() + $('.footer').css('padding-top').split('px')[0]*2
        }
    })


    if( location.hash ){
        var index = location.hash.split('#')[1]
        $('#navs nav li:eq('+index+')').addClass('active')
        $('#navs nav .item:eq('+index+')').addClass('active')
        scrollTo( '#navs .items .item:eq('+index+')' )
    }
    $('#navs nav a').each(function(e){
        $(this).click(function(){
            scrollTo( '#navs .items .item:eq('+$(this).parent().index()+')' )
            $(this).parent().addClass('active').siblings().removeClass('active')
        })
    })
}


/* 
 * page search
 * ====================================================
*/
if( jsui.bd.hasClass('search-results') ){
    var val = $('.site-search-form .search-input').val()
    var reg = eval('/'+val+'/i')
    $('.excerpt h2 a, .excerpt .note').each(function(){
        $(this).html( $(this).text().replace(reg, function(w){ return '<b>'+w+'</b>' }) )
    })
}


/* 
 * search
 * ====================================================
*/
$('.search-show').bind('click', function(){
    $(this).find('.fa').toggleClass('fa-remove')
    jsui.bd.toggleClass('search-on')
    if( jsui.bd.hasClass('search-on') ){
        $('.site-search').find('input').focus()
        jsui.bd.removeClass('m-nav-show')
    }
})

/* 
 * phone
 * ====================================================
*/

jsui.bd.append( $('.site-navbar').clone().attr('class', 'm-navbar') )

$('.m-navbar li.menu-item-has-children').each(function(){
    $(this).append('<i class="fa fa-angle-down faa"></i>')
})

$('.m-navbar li.menu-item-has-children .faa').on('click', function(){
    $(this).parent().find('.sub-menu').slideToggle(300)
})
$('.m-user').on('click', function(){
    jsui.bd.addClass('m-wel-on')
	$('.m-mask').show()
})
$('.m-mask').on('click', function(){
    $(this).hide()
    jsui.bd.removeClass('m-wel-on')
})
$('.m-wel-content ul a').on('click', function(){
    $('.m-mask').hide()
    jsui.bd.removeClass('m-wel-on')
})

$('.m-icon-nav').on('click', function(){
    jsui.bd.addClass('m-nav-show')

    $('.m-mask').show()

    jsui.bd.removeClass('search-on')
    $('.search-show .fa').removeClass('fa-remove') 
})

$('.m-mask').on('click', function(){
    $(this).hide()
    jsui.bd.removeClass('m-nav-show')
})




video_ok()
$(window).resizeend(function(event) {
    video_ok()
});

function video_ok(){
    var cw = $('.article-content').width()
    $('.article-content embed, .article-content video, .article-content iframe').each(function(){
        var w = $(this).attr('width')||0,
            h = $(this).attr('height')||0
        if( cw && w && h ){
            $(this).css('width', cw<w?cw:w)
            $(this).css('height', $(this).width()/(w/h))
        }
    })
}






/* functions
 * ====================================================
 */
function scrollTo(name, add, speed) {
    if (!speed) speed = 300
    if (!name) {
        $('html,body').animate({
            scrollTop: 0
        }, speed)
    } else {
        if ($(name).length > 0) {
            $('html,body').animate({
                scrollTop: $(name).offset().top + (add || 0)
            }, speed)
        }
    }
}


function is_name(str) {
    return /.{2,12}$/.test(str)
}
function is_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}
function is_qq(str) {
    return /^[1-9]\d{4,13}$/.test(str)
}
function is_mail(str) {
    return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}


$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};


