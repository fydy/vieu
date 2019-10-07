<?php 
 if( _hui('left_sd_s')){
 echo'<div class="leftsd"> 
    <div id="leftsd" class="left top"> 
        <div class="introduce'.get_wow_3().'">';
		if( _hui('left_post_authordesc_s') ){ 
		echo _get_the_avatar(get_the_author_meta('ID'), get_the_author_meta('email'));
			echo'<h4>作者：<a title="查看更多文章" href="'; echo get_author_posts_url(get_the_author_meta('ID'));echo'">'; echo get_the_author_meta('nickname');echo'</a></h4>
			<p>'; echo get_the_author_meta('description'); echo'</p>'; 
			} 
	    if( _hui('left_qrcode_s')){echo'<div class="qrcode"><img src="'._hui('left_qrcode_url_s'),the_permalink(); echo'"><small>手机扫码查看</small></div>';} 
		echo'<div class="contact">';
			 if(_hui('wechat')){ echo ' <a class="sns-wechat" href="javascript:;" title="'.__('关注', 'haoui').'“'._hui('wechat').'”" data-src="'._hui('wechat_qr').'"><i class="fa fa-weixin"></i></a>'; } 
			 if(_hui('weibo')){ echo ' <a target="_blank" nofollow" href="'._hui('weibo').'"><i class="fa fa-weibo"></i></a>'; } 
			 if(_hui('qq')){ echo ' <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='._hui('qq').'&site=qq&menu=yes"><i class="fa fa-qq"></i></a>'; } 
		     echo'</div>
        </div>';
		if( _hui('left_asb_s')){ echo'<div class="left_asb'.get_wow_3().'">'._hui('left_asb_s').'</div>';}		
		if( _hui('left_tags_s')){echo'<div class="'._hui('left_tags_style') , get_wow_3().'">';echo the_tags('<p>标签：</p>','','');echo'</div>';}
	  echo'</div>   
    </div>';
 }
 ?>