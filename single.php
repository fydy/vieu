<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
      <style>.header{background-color: transparent;}</style>
		<div class="single-background" style="background-image: url(<?php echo singele_background(); ?>);">
		<?php _moloader('mo_post_prevnext'); ?>
		<div class="wbd">
        <p class="t1"><?php echo the_title(); echo get_the_subtitle();?></p>
        <p class="t2"><?php if(_hui('simlang_s') && get_post_meta(get_the_ID() , 'simlang_text', true)){echo get_post_meta(get_the_ID() , 'simlang_text', true);} else{echo '作者：<a title="查看更多文章" href="'. get_author_posts_url(get_the_author_meta('ID')) .'">'.get_the_author_meta('nickname').'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布于「';the_category(' / ');echo'」&nbsp;-&nbsp;'.get_bloginfo('name');}?></p>
      </div>
<section class="container">
    <div class="containercc">
      <div class="content-box">
          <div class="thumb col-md-2"><?php echo _get_post_thumbnail();?></div>
          <div class="meta col-md-10">
		  <?php if( _hui('single_tags')){echo'<div class="tagcc">';echo the_tags('标签：','','');echo'</div>';} ?>
		  <?php if(_hui('bianlan_on_s')){echo'<span class="close-sidebar"><i class="fa fa-arrows-alt"></i></span><span class="show-sidebar" style="display:none;"><i class="fa fa-window-minimize"></i></span>'; } ?>
            <div class="dess"><span class="item"><?php echo tb_xzh_is_original() ? get_the_time('Y-m-d H:i:s') : get_the_time('Y-m-d'); ?></span>
				<?php _moloader('mo_get_post_from', false); ?>
				<?php if( mo_get_post_from() ){ ?><span class="item"><?php echo mo_get_post_from(); ?></span><?php } ?>
				<span class="item"><?php echo '分类：';the_category(' / '); ?></span>
				<?php if( _hui('post_plugin_view') ){ ?><span class="item post-views"><?php echo _get_post_views() ?></span><?php } ?>
				<span class="item"><?php echo _get_post_comments() ?></span>
					<span class="item"><?php baidu_record(); ?></span>
				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
				</div>	
				 <?php if(_hui('breadcrumbs_single_s')){ echo '<div class="mbx">'. hui_breadcrumbs().'</div>';} ?>							
      </div>
    </div>
	<div class="content-single">
	<?php if( is_single() && _hui('bigger-share_s')) {echo'<span class="btn btn-primary share-haibao"><i class="fa fa-paper-plane"></i> 生成海报</span>';}?>
	<?php 
		$link = get_post_meta(get_the_ID(), 'link', true);
		if( _hui('post_like_s') || _hui('post_rewards_s') || (_hui('post_link_single_s')&&$link) ){ ?>
            <div class="post-actions">
            	<?php if( _hui('post_like_s') ){ ?><?php echo hui_get_post_like($class='btn btn-default post-like action action-like'); ?><?php } ?>
            	<?php if( _hui('post_rewards_s') ){ ?><a href="javascript:;" class="btn btn-default action action-rewards" data-event="rewards"><i class="fa fa-jpy"></i> <?php echo _hui('post_rewards_text', '打赏') ?></a><?php } ?>
            </div>
        <?php } ?>
	</div>
      </section></div>	  
<section class="container">
	<div class="content-wrap">	
	<?php _moloader('mo_left_sidebar', false); 
    if( _hui('left_sd_s')){echo'<div class="single-content">';}else{echo'<style>.content-box{margin-right: 375px;    margin-left: 15px;}</style><div class="content">';}?>
	<?php if( _hui('shengming')){ ?><p class="shengming"><?php echo _hui('shengming'); ?></p><?php } ?>
		<?php tb_xzh_render_body() ?>
		<article class="article-content"<?php if(_hui('lightbox_s')){ echo ' id="image_container"';} ?>>
			<div class="<?php echo get_wow_2(); ?>"><?php _the_ads($name='ads_post_01', $class='asb-post asb-post-01') ?></div>
			<?php if(has_excerpt() && _hui('breadcrumbs_zhaiyao_s')){ ?>
			<div class="article-zhaiyao <?php echo get_wow_4(); ?>"><strong>摘要：</strong><?php echo _get_excerpt(); ?></div>
			<?php } ?>
			<?php the_content(); ?>		
			<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
			<?php if (_hui('ads_post_footer_s')) {
			echo '<div class="asb-post-footer '.get_wow_2().'"><b>AD：</b><strong>【' . _hui('ads_post_footer_pretitle') . '】</strong><a'.(_hui('ads_post_footer_link_blank')?' target="_blank"':'').' href="' . _hui('ads_post_footer_link') . '">' . _hui('ads_post_footer_title') . '</a></div>';
		} ?>
                   
		<?php if( !wp_is_mobile() || (!_hui('m_post_share_s') && wp_is_mobile()) ){ ?>
			<?php _moloader('mo_share'); ?>
		<?php } ?>
		</article>
		<?php if( _hui('post_copyright_s') ){
			echo '<div class="shuoming '.get_wow_2().'"><div class="title"><span>' . _hui('post_copyright') . '</span></div>
			<p class="'.get_wow_4().'">作者:<a title="查看更多文章" href="'. get_author_posts_url(get_the_author_meta('ID')) .'">'.get_the_author_meta('nickname').'</a>，
			转载或复制请以 <a href="' . get_permalink() . '"> 超链接形式</a> 并注明出处 <a href="' . get_bloginfo('url') . '">' . get_bloginfo('name') . '</a>。<br>
			原文地址：<a href="' . get_permalink() . '" title="' . get_permalink() . '">《' . get_the_title() . '》</a>  发布于'.get_the_time('Y-m-d').'</p></div>';
		} ?>
		<?php endwhile; ?>		
		        <?php if( _hui('post_prevnext_s') ){ ?>
            <nav class="article-nav<?php echo get_wow_2(); ?>">
                <span class="article-nav-prev"><?php previous_post_link('上一篇<br>%link'); ?></span>
                <span class="article-nav-next"><?php next_post_link('下一篇<br>%link'); ?></span>
            </nav>
        <?php } ?>
  
		<?php _the_ads($name='ads_post_02', $class='asb-post asb-post-02') ?>
		<?php 
			if( _hui('post_related_s') ){
				_moloader('mo_posts_related', false); 
				mo_posts_related(_hui('related_title'), _hui('post_related_n'));
			}
		?>
		<?php tb_xzh_render_tail() ?>
		<?php _the_ads($name='ads_post_03', $class='asb-post asb-post-03') ?>
		<?php comments_template('', true); ?>
	</div>
	</div>
	<?php 
		if( has_post_format( 'aside' )){

		}else{
			get_sidebar();
		} 
	?>
</section>

<?php get_footer(); 