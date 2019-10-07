<?php 
/**
 * Template name: 用户中心
 * Description:   A user profile page
 */

get_header();

?>
<style>.header {
    background-color: transparent;
}</style>
<?php if( !_hui('user_page_s') ) exit('该功能需要开启！'); ?>
<div class="usertitle" style="background-image: url(<?php echo _hui('user_banner_bg'); ?>);">
      <section class="container">
				<?php echo _get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true); ?>
				<h2><?php echo $current_user->display_name.' <span>UID：'.$current_user->ID.'</span>'; ?></h2>
				<?php echo '<p>'.get_user_meta( $current_user->ID, 'text', true ).'</p>'; ?>
				</section>
			</div>
<section class="container">
	<div class="container-user"<?php echo is_user_logged_in()?'':' id="issignshow" style="height:500px;"' ?>>
		<?php if( is_user_logged_in() ){ global $current_user, $user_ID; ?>
		<div class="userside">
			
			<div class="usermenus">	
				<ul class="usermenu">
				    <li class="usermenu-index"><a href="#index"><i class="fa fa-dashboard"></i> 用户中心</a></li>
					<li class="usermenu-pay"><a href="#pay"><i class="fa fa-shopping-cart"></i> 我的订单</a></li>
					<?php if( _hui('tougao_s') ){ ?><li class="usermenu-post-new"><a href="#post-new"><i class="fa fa-pencil-square-o"></i> 发布文章</a></li><?php } ?>
					<li class="usermenu-posts"><a href="#posts/all"><i class="fa fa-file-word-o"></i> 我的文章</a></li>
					<li class="usermenu-comments"><a href="#comments"><i class="fa fa-comments"></i> 我的评论</a></li>
					<li class="usermenu-info"><a href="#info"><i class="fa fa-cogs"></i> 修改资料</a></li>
					<li class="usermenu-password"><a href="#password"><i class="fa fa-lock"></i> 修改密码</a></li>
					<li class="usermenu-signout"><a href="<?php echo wp_logout_url(home_url()) ?>"><i class="fa fa-sign-in fa-flip-horizontal"></i> 退出</a></li>
				</ul>
			</div>
		</div>
		<div class="content" id="contentframe">
			<div class="user-main">
				
			</div>
			<?php if( _hui('tougao_s') ){ ?>
				<div class="user-main-postnew" style="display:none">
					<form class="user-postnew-form">
					  	<ul class="user-meta user-postnew">
					  		<li><label>标题</label>
								<input type="text" class="form-control" name="post_title" placeholder="文章标题">
					  		</li>
					  		<li><label>内容</label>
					  			<?php
									$content = '';
									$editor_id = 'post_index';
									$settings = array(
										'textarea_rows' => 10,
										'editor_height' => 350,
										'media_buttons' => false,
										'quicktags' => false,
										'editor_css'    => '',
										'tinymce'       => array(
											'content_css' => get_stylesheet_directory_uri() . '/static/css/user-editor-style.css'
										),
										'teeny' => true,
									);
									wp_editor( $content, $editor_id, $settings );
								?>
					  		</li>
					  		<li><label>来源链接</label>
								<input type="text" class="form-control" name="post_url" placeholder="文章来源链接">
					  		</li>
					  		<li>
					  			<br>
								<input type="button" evt="postnew.submit" class="btn btn-primary" name="submit" value="提交审核">
								<input type="hidden" name="action" value="post.new">
					  		</li>
					  	</ul>
					</form>
				</div>
			<?php } ?>
			<div class="user-tips"></div>
		</div>
		<?php } ?>
	</div>
</section>

<?php if( is_user_logged_in() ){ ?>

<script id="temp-index" type="text/x-jsrender">
<?php global $wpdb, $wppay_table_name, $user_ID; $list = $wpdb->get_results("select * FROM $wppay_table_name WHERE user_id = $user_ID AND order_status=1 ORDER BY order_time"); ?>
		<div class="row">
        <div class="col-xl-4 col-sm-4 mb-4">
          <div class="user-card bg-primary">
            <div class="card-body">
              <div class="card-body-icon">
               <i class="fa fa-file-word-o"></i>
              </div>
              <div class="mr-5"><?php global $user_ID; echo count_user_posts($user_ID,'post',true); ?>篇文章</div>
            </div>
            <a class="card-footer" href="#posts/all">
              <span class="float-left">查看详情</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-4 mb-4">
          <div class="user-card bg-warning">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-comments"></i>
              </div>
              <div class="mr-5"><?php echo get_comments('count=true&user_id='.$user_ID); ?>条评论</div>
            </div>
            <a class="card-footer" href="#comments">
              <span class="float-left">查看详情</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-4 mb-4">
          <div class="user-card bg-success">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <div class="mr-5"><?php echo count($list);	?>个商品</div>
            </div>
            <a class="card-footer" href="#pay">
              <span class="float-left">查看详情</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
       <section class="author-card">
            <div class="inner">
                <?php echo _get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true); ?>              
				<div class="card-text">
                    <div class="display-name"><?php echo $current_user->display_name; ?></div>
                    <div class="register-time"><?php if ( is_user_logged_in() ) { user_registered_date();} ?></div>
                    <div class="login-ip">当前登陆位置：<?php echo  get_local($ip);?></div>
                                        			
                </div>
            </div>
        </section>
		
		
		
		<section class="info-basis">
            <header><h2>基本信息</h2></header>
            <div class="info-group clearfix">
                <label class="col-md-1 control-label">昵称</label>
                <p class="col-md-11"><?php echo $current_user->display_name; ?></p>
            </div>
                            <div class="info-group clearfix">
                    <label class="col-md-1 control-label">邮箱</label>
                    <p class="col-md-11"><?php echo $current_user->user_email; ?></p>
                </div>
                        <div class="info-group clearfix">
                <label class="col-md-1 control-label">网页</label>
                <p class="col-md-11"><?php echo $current_user->user_url; ?></p>
            </div>
            <div class="info-group clearfix">
                <label class="col-md-1 control-label">个人描述</label>
                <p class="col-md-11"><?php echo get_user_meta( $user_ID, 'text', true ); ?></p>
            </div>
        </section>
		
		
		
		
</script>

<script id="temp-pay" type="text/x-jsrender">



<?php
global $wpdb, $wppay_table_name;
$list = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE user_id = $current_user->ID AND order_status=1 ORDER BY order_time");
	
		if($list) {
			foreach($list as $value){
				echo '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
				<a href="'.get_permalink($value->post_id).'">
              <div class="card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="clearfix-icon">
                      <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="clearfix-box">
                      <p class="text-right">商品：'.get_the_title($value->post_id).'</p>
					  <p class="text-right">时间：'.$value->order_time.'</p>
					  <p class="text-right">IP：'.$value->ip_address.'</p>
                      <div class="fluid-container">
                        <h3 class="text-right">￥'.$value->post_price.'</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted">订单号：'.$value->order_num.'</p>
                </div>
              </div>
			  </a>
            </div>';
			}
		}
		else{
			echo '<strong>没有订单</strong>';
		}
	?>
	
    
</div>
</script>

<script id="temp-postnew" type="text/x-jsrender">
	
</script>

<script id="temp-postmenu" type="text/x-jsrender">
	<a href="#posts/{{>name}}">{{>title}}<small>({{>count}})</small></a>
</script>
<script id="temp-postitem" type="text/x-jsrender">
	<li>
		<img data-src="{{>thumb}}" class="thumb">
		<h2><a target="_blank" href="{{>link}}">{{>title}}</a></h2>
		<p class="note">{{>desc}}</p>
		<p class="text-muted">{{>time}} &nbsp;&nbsp; 分类：{{>cat}} &nbsp;&nbsp; 阅读({{>view}}) &nbsp;&nbsp; 评论({{>comment}}) &nbsp;&nbsp; 赞({{>like}})</p>
	</li>
</script>

<script id="temp-info" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta">
	  		<li><label>入门时间</label>
				{{>regtime}}
	  		</li>
	  		<li><label>用户名</label>
				<input type="input" class="form-control" disabled value="{{>logname}}">
	  		</li>
	  		<li><label>邮箱</label>
				<input type="email" class="form-control" disabled value="{{>email}}">
	  		</li>
	  		<li><label>昵称</label>
				<input type="input" class="form-control" name="nickname" value="{{>nickname}}">
	  		</li>
	  		<li><label>网址</label>
				<input type="input" class="form-control" name="url" value="{{>url}}">
	  		</li>
	  		<li><label>QQ</label>
				<input type="input" class="form-control" name="qq" value="{{>qq}}">
	  		</li>
	  		<li><label>微信号</label>
				<input type="input" class="form-control" name="weixin" value="{{>weixin}}">
	  		</li>
	  		<li><label>微博地址</label>
				<input type="input" class="form-control" name="weibo" value="{{>weibo}}">
	  		</li>
			<li><label>个人描述</label>
				<input type="input" class="form-control" name="text" value="{{>text}}">
	  		</li>
	  		<li>
				<input type="button" evt="info.submit" class="btn btn-primary" name="submit" value="确认修改资料">
				<input type="hidden" name="action" value="info.edit">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-password" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta">
	  		<li><label>原密码</label>
				<input type="password" class="form-control" name="passwordold">
	  		</li>
	  		<li><label>新密码</label>
				<input type="password" class="form-control" name="password">
	  		</li>
	  		<li><label>重复新密码</label>
				<input type="password" class="form-control" name="password2">
	  		</li>
	  		<li>
				<input type="button" evt="password.submit" class="btn btn-primary" name="submit" value="确认修改密码">
				<input type="hidden" name="action" value="password.edit">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-commentitem" type="text/x-jsrender">
	<li>
		<time>{{>time}}</time>
		<p class="note">{{>content}}</p>
		<p class="text-muted">文章：<a target="_blank" href="{{>post_link}}">{{>post_title}}</a></p>
	</li>
</script>

<?php
}
?>

<?php

get_footer();