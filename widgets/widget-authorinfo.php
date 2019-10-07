<?php

class widget_ui_authorinfo extends WP_Widget {
 
function widget_ui_authorinfo() {
$widget_ops = array('description' => '显示当前文章的作者信息！');
$this->WP_Widget('widget_ui_authorinfo', '作者', $widget_ops);
}
 
function update($new_instance, $old_instance) {
return $new_instance;
}
 
function widget($args, $instance) {
extract( $args );
echo $before_widget;
echo widget_authorinfo();
echo $after_widget;
}
}
 
function widget_authorinfo(){
?>
<div class="author-info">
<img class="zuozeipc" src="/wp-content/themes/dux/img/post-lz.png">
<div class="author-avatar">
<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" title="<?php the_author(); ?>" rel="author">
<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); }?><i title="博主认证 " class="author-ident"></i>
</a>
</div>
<div class="author-name">
<?php the_author_posts_link(); ?>
<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" target="_blank">(<?php the_author_posts(); ?>篇文章)</a>
<span><?php
	if(author_can($post->ID,'install_plugins')){
		echo '<span>博主</span>';
		}
	elseif(author_can($post->ID,'edit_others_posts')){
		echo '<span>管理编辑</span>';
		}
	elseif(author_can($post->ID,'publish_posts')){
		echo '<span>作者</span>';
		}
	elseif(author_can($post->ID,'delete_posts')){
		echo '<span>投稿者</span>';
		}
	elseif(author_can($post->ID,'read')){
		echo '<span>订阅者</span>';
		} ?></span>
</div>
<div class="author-des">
<?php the_author_description(); ?>
</div>
<div class="author-social">
<span class="author-blog">
<a href="<?php the_author_url(); ?>" rel="nofollow" target="_blank"><i class="icon-home"></i>网站</a>
</span>
<span class="author-weibo">
<a href="<?php the_author_meta('weibo'); ?>" rel="nofollow" target="_blank"><i class="icon-weibo"></i>微博</a>
</span>
</div>
</div>

<?php
}
?>
