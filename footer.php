<?php  
	if( _hui('footer_brand_s') ){
		_moloader('mo_footer_brand', false);
	}
?>

<footer class="footer">
	<div class="container">
		<?php if( _hui('flinks_s') && _hui('flinks_cat') && ((_hui('flinks_home_s')&&is_home()) || (!_hui('flinks_home_s'))) ){ ?>
			<div class="flinks">
				<?php 
					wp_list_bookmarks(array(
						'category'         => _hui('flinks_cat'),
						'category_orderby' => 'slug',
						'category_order'   => 'ASC',
						'orderby'          => 'rating',
						'order'            => 'DESC',
						'show_description' => false,
						'between'          => '',
						'title_before'     => '<strong>',
    					'title_after'      => '</strong>',
						'category_before'  => '',
						'category_after'   => ''
					));
				?>
			</div>
		<?php } ?>
		<?php if( _hui('fcode') ){ ?>
			<div class="fcode">
				<?php echo _hui('fcode') ?>
			</div>
		<?php } ?>
		<p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a> &nbsp; <?php echo _hui('footer_seo') ?></p>
	  </p>数据查询次数：<?php echo get_num_queries(); ?> | 消耗时间： <?php timer_stop(3);?> | 在线人数：<?php echo get_num_queries();?></p>	
      <?php echo _hui('trackcode') ?>
	</div>
</footer>
<?php if(_hui('all_fonts')) { ?>
<style>
body{
font-family: xmlt,Microsoft Yahei; }
</style>
<?php } ?>
<?php if( is_single() && _hui('bigger-share_s')) { _moloader('mo_shareimg', false); }  ?>
<?php if( (is_single() && _hui('post_rewards_s')) && ( _hui('post_rewards_alipay') || _hui('post_rewards_wechat') ) ){ ?>
	<div class="rewards-popover-mask" data-event="rewards-close"></div>
	<div class="rewards-popover">
		<h3><?php echo _hui('post_rewards_title') ?></h3>
		<?php if( _hui('post_rewards_alipay') ){ ?>
		<div class="rewards-popover-item">
			<h4>支付宝扫一扫打赏</h4>
			<img src="<?php echo _hui('post_rewards_alipay') ?>">
		</div>
		<?php } ?>
		<?php if( _hui('post_rewards_wechat') ){ ?>
		<div class="rewards-popover-item">
			<h4>微信扫一扫打赏</h4>
			<img src="<?php echo _hui('post_rewards_wechat') ?>">
		</div>
		<?php } ?>
		<span class="rewards-popover-close" data-event="rewards-close"><i class="fa fa-close"></i></span>
	</div>
<?php } ?>

<?php  
	$roll = '';
	if( is_home() && _hui('sideroll_index_s') ){
		$roll = _hui('sideroll_index');
	}else if( (is_category() || is_tag() || is_search()) && _hui('sideroll_list_s') ){
		$roll = _hui('sideroll_list');
	}else if( is_single() && _hui('sideroll_post_s') ){
		$roll = _hui('sideroll_post');
	}
	if( $roll ){
		$roll = json_encode(explode(' ', $roll));
	}else{
		$roll = json_encode(array());
	}

	_moloader('mo_get_user_rp'); 
	?>



<!---底部均为重要文件，请勿修改，如修改损坏本站概不负责--->
<script>
window.jsui={
	www: '<?php echo home_url() ?>',
	uri: '<?php echo get_stylesheet_directory_uri() ?>',
	ver: '<?php echo THEME_VERSION ?>',
	roll: <?php echo $roll ?>,
	ajaxpager: '<?php echo _hui("ajaxpager") ?>',
	get_wow: '<?php echo get_the_wow() ?>',
	left_sd: '<?php echo left_sd_s() ?>',
	url_rp: '<?php echo mo_get_user_rp() ?>',
	qq_id: '<?php echo _hui('fqq_s') ? _hui('fqq_id') : '' ?>',
	qq_tip: '<?php echo _hui('fqq_s') ? _hui('fqq_tip') : '' ?>',
	wintip_s: '<?php echo get_wintip_srollbar() ?>',
	collapse_title: '<?php echo _hui('collapse_title') ?>',
	wintip_m: '<?php echo get_wintip_width() ?>'
};
</script>


<script src="<?php bloginfo('template_directory'); ?>/js/activate-power-mode.js "></script>
<script>
    POWERMODE.colorful = true; // ture 为启用礼花特效
    POWERMODE.shake = false; // false 为禁用震动特效
    document.body.addEventListener('input', POWERMODE);
</script>
<?php if (_hui('lightbox_s') && is_single()) { ?>
<script>
  (function() {

	function setClickHandler(id, fn) {
	  document.getElementById(id).onclick = fn;
	}

	setClickHandler('image_container', function(e) {
	  e.target.tagName === 'IMG' && BigPicture({
		el: e.target,
		imgSrc: e.target.src.replace('_thumb', '')
	  });
	});

  })();
</script>
<?php } ?>
<script type="text/javascript">
var ajax_sign_object = <?php echo ajax_sign_object(); ?>;
</script>
<?php _moloader('mo_wintips', false);?>
<?php wp_footer(); ?>
</body>
</html>