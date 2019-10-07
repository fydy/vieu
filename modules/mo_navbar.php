<?php
           //pc login
		   echo'<div class="wel">';
			 if( is_user_logged_in() ): global $current_user;
				_moloader('mo_get_user_page', false) ;
				if( _hui('user_page_s') ){
					echo'<div class="wel-item">
					<a href="'.mo_get_user_page().'">会员中心</a></div>
				    <div class="wel-item has-sub-menu">
					<a href="'. mo_get_user_page().'">
					'. _get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true).'					
					<span class="wel-name">'.$current_user->display_name .'</span>
					</a>
					<div class="sub-menu">
					<ul>							<li><a href="'.mo_get_user_page().'#info">修改资料</a></li>
					<li><a href="/wp-admin/profile.php">详细资料</a></li>';
					if( is_super_admin() ){ 
					echo'<li><a target="_blank" href="'.site_url('/wp-admin/') .'">后台管理</a></li>';
				 } 
					echo'<li><a href="'.wp_logout_url( home_url(add_query_arg(array(),$wp->request)) ).'">退出</a></li>
					</ul>
					</div>
				</div>';
				 } ?>
			<?php elseif( _hui('user_page_s') ): 
				echo _moloader('mo_get_user_rp', false) ;
					echo'<div class="wel-item">'; if (_hui('ligin_off')){echo'<a href="javascript:;" id="loginbtn">登录</a>'; }else{ echo' <a href="javascript:;" class="user-login"  data-sign="0">登录</a>';} 
					echo'</div><div class="wel-item wel-item-btn">';
					if(get_option('users_can_register')==1){ echo'<a href="javascript:;" class="user-reg" data-sign="1">我要注册</a>';}else{ 
					echo'<a href="javascript:;" id="zhucebtn">我要注册</a>'; } echo'</div>';
	            endif; 
				//menu
			echo'</div>
            <div class="site-navbar">
		<ul>';echo _the_menu('nav');echo'</ul>
	</div>';
	//phone login
		if( _hui('m_navbar') ){ 
		 if( is_user_logged_in() ){
			 		echo'<div class="m-wel-start"><a class="m-user" href="javascript:;"><i class="fa fa-user"></i></a></div>
					<div class="m-wel">
				<header>
			       '. _get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true).'<h4>'.$current_user->display_name .'</h4>
					<h5>'. $current_user->user_email .'</h5>
				</header>
				<div class="m-wel-content">
					<ul>					
					    <li><a href="'. mo_get_user_page().'#posts/all">我的文章</a></li>
						<li><a href="'.mo_get_user_page().'#info">修改资料</a></li>
						<li><a href="/wp-admin/profile.php">详细资料</a></li>
						<li><a href="'.mo_get_user_page().'#comments">评论管理</a></li>
						<li><a href="'.mo_get_user_page().'#password">修改密码</a></li>';
						if( is_super_admin() ){ 
					    echo'<li><a target="_blank" href="'.site_url('/wp-admin/') .'">后台管理</a></li>';
				 } 
					echo'</ul>
				</div>
				<footer>
					<a href="'.wp_logout_url( home_url(add_query_arg(array(),$wp->request)) ).'">退出当前账户</a>
				</footer>
			</div>'; } else {
			echo'<div class="m-wel-start"><a href="javascript:;" class="user-login"  data-sign="0"><i class="fa fa-login"></i></a></div>';
	 }
		}
?>       
         <script type="text/javascript">
             $(function(){
               $('#zhucebtn').click(function(){
                alert('抱歉！管理员关闭了注册！');
            });
			   $('#loginbtn').click(function(){
                alert('抱歉！管理员关闭了登录！');
            })
            })
            </script>