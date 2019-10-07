<?php
if ( !defined('ABSPATH') ) {exit;}
add_action('admin_menu', 'wppay_menu');
function wppay_menu() {
	add_menu_page('支付', '支付', 'activate_plugins', 'wppay_setting_page', 'wppay_setting_page','dashicons-shield');
	add_submenu_page('wppay_setting_page', '设置', '设置', 'activate_plugins', 'wppay_setting_page','wppay_setting_page');
	add_submenu_page('wppay_setting_page', '订单', '订单', 'activate_plugins', 'wppay_orders_page','wppay_orders_page');
	add_action( 'admin_init', 'wppay_setting_group');
}

function wppay_setting_group() {
	register_setting( 'wppay_setting_group', 'wppay_setting' );
}	

function wppay_setting_page(){
    @include 'setting.php';
}

function wppay_orders_page(){
    @include 'orders.php';
}

add_action('admin_enqueue_scripts', 'wppay_setting_scripts');
function wppay_setting_scripts(){
	if( isset($_GET['page']) && $_GET['page'] == "wppay_setting_page" ){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wppay_setting', wppay_js_url('setting'), array( 'wp-color-picker' ), false, true );	
	}
}


function wppay_plugin_action_link($actions, $plugin_file, $plugin_data){
	if( strpos($plugin_file, 'wp-wppay') !== false && is_plugin_active($plugin_file) ){
		$myactions = array(
			'option' => "<a href=\"" . WPPAY_ADMIN_URL . "options-general.php?page=wppay.functions.php\">设置</a>"
		);
		$actions = array_merge($myactions, $actions);
	}
	return $actions;
}
add_filter('plugin_action_links', 'wppay_plugin_action_link', 10, 4);

function wppay_scripts(){
	wp_enqueue_style( 'wppay', wppay_css_url('wppay'), array(), WPPAY_VERSION );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'wppay',  wppay_js_url('wppay'), array(), WPPAY_VERSION );
    wp_localize_script( 'wppay', 'wppay_ajax_url', WPPAY_ADMIN_URL . "admin-ajax.php");
}
add_action('wp_enqueue_scripts', 'wppay_scripts', 20, 1);

function wppay_head_style(){?>
	<style type="text/css">
		.erphp-wppay{
			border-color: <?php echo wppay_get_setting('border-color');?> !important;
			background-color: <?php echo wppay_get_setting('background-color');?> !important;
			color: <?php echo wppay_get_setting('text-color');?> !important;
		}
		.erphp-wppay-success{
			border-color: <?php echo wppay_get_setting('border-color-success');?> !important;
		}
		.erphp-wppay a{
			color: <?php echo wppay_get_setting('btn-color');?> ;
		}
		.erphp-wppay b{
			color: <?php echo wppay_get_setting('price-color');?> !important;
		}
		.wppay-custom-modal-box .wppay-modal .erphp-wppay-qrcode .tab a .price{
			color: <?php echo wppay_get_setting('code-color');?> !important;
		}
		.wppay-custom-modal-box .wppay-modal .erphp-wppay-qrcode .tab-list{
			background-color: <?php echo wppay_get_setting('code-color');?> !important;
		}
	</style>
	<script>window._WPPAY = {"uri":"<?php echo WPPAY_URL;?>", "payment": "<?php if(wppay_get_setting('f2fpay-app-id')) echo "1"; else echo "2";?>", "author": "mobantu"}</script>
<?php }
add_action( 'wp_head', 'wppay_head_style' );

function wppay_callback(){
	$post_id = $_POST['post_id'];
	$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	$price = get_post_meta($post_id,'wppay_price',true);
	$code='';$link='';$msg='';$num='';$status=400;
	$out_trade_no = date("ymdhis").mt_rand(100,999).mt_rand(100,999).mt_rand(100,999);

	if($price){
		$wppay = new WPPAY($post_id, $user_id);
		if(wppay_get_setting('f2fpay-app-id')){
			//当面付
			$qrPayResult = $wppay->f2fpayQr($out_trade_no, $price);
			if($qrPayResult->getTradeStatus() == 'SUCCESS'){
				if($wppay->add($out_trade_no, $price)){
					$response = $qrPayResult->getResponse();
					$code = WPPAY_URL.'/action/qrcode.php?text='.urlencode($response->qr_code);
					$link = '';
					$num = $out_trade_no;
					$status=200;
				}
			}else{
				$status=201;
				$msg = '获取支付信息失败！';
			}
		}else{
			//有赞
			$token = $wppay->youzan_token();
			if($token){
				$qr = $wppay->youzan_qr($out_trade_no, $price, $token);
				if($qr['response']['qr_code']){
					if($wppay->add($out_trade_no, $price)){
						$code = $qr['response']['qr_code'];
						$link = $qr['response']['qr_url'];
						$num = $out_trade_no;
						$status=200;
					}
				}
			}else{
				$status=201;
				$msg = '获取有赞Token失败或插件未激活！';
			}
		}

	}

	$result = array(
		'status' => $status,
		'price' =>$price,
		'code' => $code,
		'link' => $link,
		'num' => $num,
		'msg' => $msg
	);

	header('Content-type: application/json');
	echo json_encode($result);
	exit;
}
add_action( 'wp_ajax_wppay', 'wppay_callback');
add_action( 'wp_ajax_nopriv_wppay', 'wppay_callback');



function wppay_pay_callback(){
	$post_id = $_POST['post_id'];
	$order_num = $_POST['order_num'];
	$status = 0;
	$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	$wppay = new WPPAY($post_id, $user_id);
	if($wppay->check_paid($order_num)){
		$days = wppay_get_setting('pay-expire');
		$expire = time() + $days*24*60*60;
	    setcookie('wppay_'.$post_id, $wppay->set_key($order_num), $expire, '/', $_SERVER['HTTP_HOST'], false);
	    $status = 1;
	}else{
		//setcookie('wppay_'.$post_id, '', time(), '/', $_SERVER['HTTP_HOST'], false);
	}

	$result = array(
		'status' => $status
	);

	header('Content-type: application/json');
	echo json_encode($result);
	exit;
}
add_action( 'wp_ajax_wppay_pay', 'wppay_pay_callback');
add_action( 'wp_ajax_nopriv_wppay_pay', 'wppay_pay_callback');


add_action('the_content','wppay_content_show');
function wppay_content_show($content){
	global $post;
	$type = get_post_meta($post->ID,'wppay_type',true);
	$price = get_post_meta($post->ID,'wppay_price',true);
	$down_name = get_post_meta($post->ID,'wppay_down_name',true);
	$down_url = get_post_meta($post->ID,'wppay_down_url',true);
	$down_pass = get_post_meta($post->ID,'wppay_down_pass',true);
	$down_size = get_post_meta($post->ID,'wppay_down_size',true);
	$down_time = get_post_meta($post->ID,'wppay_down_time',true);
	$down_about = get_post_meta($post->ID,'wppay_down_about',true);
	if($price){
		if($type == '1'){
			$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
			$wppay = new WPPAY($post->ID, $user_id);
			
			if(wppay_get_setting('pay-login')){
			if(($wppay->is_paid() && is_user_logged_in()) || is_super_admin()){ 
				return $content;
			}else{
				if(is_singular()){
					if(is_user_logged_in()){
					$mobantu = '<div class="erphp-wppay">
						您需要先支付 <b>'.$price.'元</b> 才能下载此资源！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post->ID.'">立即支付</a>
					</div>';
					}else{
					$mobantu = '<div class="erphp-wppay">
						本资源售价 <b>'.$price.'元</b> 您需要 <a href="javascript:;" class="user-login erphp-login-must"  data-sign="0" ><i class="fa fa-wordpress"></i> 登录/注册</a> <a href="/wp-content/plugins/foxlogin/auth/qq.php?foxloginurl='.get_permalink($post->ID).'" class="erphp-login-must"><i class="fa fa-qq"></i> 快捷登陆</a> 后才能购买此资源！
					</div>';}
					return $mobantu;
				}else{
					return '';
				}
			}
			}else{
			if($wppay->is_paid()  || is_super_admin()){ //整文
				return $content;
			}else{
				if(is_singular()){
					$mobantu = '<div class="erphp-wppay">
						您需要先支付 <b>'.$price.'元</b> 才能查看此处内容！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post->ID.'">立即支付</a>
					</div>';
					return $mobantu;
				}else{
					return '';
				}
			}
			}
		}elseif($type == '3'){
			$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
			$wppay = new WPPAY($post->ID, $user_id);
			$d_name=null;
			$d_size=null;
			$d_time=null;
			$d_pass=null;
			$d_url=null;
			$d_about=null;
			if($down_name){$d_name='<p><i class="fa fa-bookmark"></i> 附件名称：'.$down_name.'</p>'; }
			if($down_size){$d_size='<p><i class="fa fa-pie-chart"></i> 附件大小：'.$down_size.'</p>'; }
			if($down_time){$d_time='<p><i class="fa fa-clock-o"></i> 更新时间：'.$down_time.'</p>'; }
			if($down_pass){$d_pass='<p class="wppay-down-pass"><i class="fa fa-lock"></i> 提取密码：<span id="down-pass">'.$down_pass.'</span>  <a id="copy-pass"><i class="fa fa-clipboard"></i> 复制</a></p>'; }
			if($down_url){$d_url='<p class="wppay-down-url"><i class="fa fa-download"></i> 下载地址：<a href="'.$down_url.'" target="_blank" title="'.$down_name.'"><i class="fa fa-cloud-download"></i> 立即下载</a></p>'; }
			if($down_about){$d_about='<p class="down-about"><i class="fa fa-exclamation-circle"></i> '.$down_about.'</p>'; }
			
			if(wppay_get_setting('pay-login')){
			if(($wppay->is_paid() && is_user_logged_in())  || is_super_admin()){ //下载
				$content .= '<div class="down-detail"><h5><i class="fa fa fa-file-text fa-fw"></i> 付费资源下载<span class="bc-icon"></span></h5>
				'.$d_name.$d_size.$d_time.$d_pass.$d_url.$d_about.'
				</div>';
			}else{
					if(is_singular()){
					if(is_user_logged_in()){
					$mobantu = '<div class="erphp-wppay">
						您需要先支付 <b>'.$price.'元</b> 才能下载此资源！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post->ID.'">立即支付</a>
					</div>';
					}else{
					$mobantu = '<div class="erphp-wppay">
						本资源售价 <b>'.$price.'元</b> 您需要 <a href="javascript:;" class="user-login erphp-login-must"  data-sign="0" ><i class="fa fa-wordpress"></i> 登录/注册</a> <a href="/wp-content/plugins/foxlogin/auth/qq.php?foxloginurl='.get_permalink($post->ID).'" class="erphp-login-must"><i class="fa fa-qq"></i> 快捷登陆</a> 后才能购买此资源！
					</div>';
					}
					
					return $content.$mobantu;
				}else{
					return '';
				}
			}
			}else{
			 if($wppay->is_paid() || is_super_admin()){ //下载

				$content .= '<div class="down-detail"><h5><i class="fa fa fa-file-text fa-fw"></i> 付费资源下载<span class="bc-icon"></span></h5>
				'.$d_name.$d_size.$d_time.$d_pass.$d_url.$d_about.'
				</div>';
			}else{
				if(is_singular()){
					$mobantu = '<div class="erphp-wppay">
						您需要先支付 <b>'.$price.'元</b> 才能下载此资源！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post->ID.'">立即支付</a>
					</div>';
					return $content.$mobantu;
				}else{
					return '';
				}
			}
			}
		}
	}
	return $content;
}

add_shortcode('wppay','wppay_shortcode');
function wppay_shortcode($atts, $content){ 
	$atts = shortcode_atts( array(
        'id' => 0
    ), $atts, 'wppay' );

	global $post,$wpdb;
	$post_id = $post->ID;
	if($atts['id']){
		$post_id = $atts['id'];
	}
	$type = get_post_meta($post_id,'wppay_type',true);
	$price = get_post_meta($post_id,'wppay_price',true);
	if($price && $type == '2'){
		$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
		$wppay = new WPPAY($post_id, $user_id);
		if(wppay_get_setting('pay-login')){
			if(($wppay->is_paid() && is_user_logged_in()) || is_super_admin()){//部分内容
			return '<p><div class="erphp-wppay erphp-wppay-success">'.do_shortcode($content).'</div></p>';
		}else{
			if(is_user_logged_in()){
				$erphp = '<p><div class="erphp-wppay">
				您需要先支付 <b>'.$price.'元</b> 才能查看此处内容！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post_id.'">立即支付</a>
			</div></p>';}else{
				$erphp = '<p><div class="erphp-wppay">
				本资源售价 <b>'.$price.'元</b> 您需要 <a href="javascript:;" class="user-login erphp-login-must"  data-sign="0" ><i class="fa fa-wordpress"></i> 登录/注册</a> <a href="/wp-content/plugins/foxlogin/auth/qq.php?foxloginurl='.get_permalink($post->ID).'" class="erphp-login-must"><i class="fa fa-qq"></i> 快捷登陆</a> 后才能购买此资源！
			</div></p>';
			}
			return $erphp;
		}
		}else{
		if($wppay->is_paid() || is_super_admin()){//部分内容
			return '<p><div class="erphp-wppay erphp-wppay-success">'.do_shortcode($content).'</div></p>';
		}else{
			$erphp = '<p><div class="erphp-wppay">
				您需要先支付 <b>'.$price.'元</b> 才能查看此处内容！<a href="javascript:;" class="erphp-wppay-loader" data-post="'.$post_id.'">立即支付</a>
			</div></p>';
			return $erphp;
		}
		}
		
	}else{
		return '';
	}
	
}  

function wppay_get_setting($key=NULL){
	$setting = get_option('wppay_setting');
	return $key ? $setting[$key] : $setting;
}

function wppay_delete_setting(){
	delete_option('wppay_setting');
}

function wppay_setting_key($key){
	if( $key ){
		return "wppay_setting[$key]";
	}

	return false;
}

function wppay_update_setting($setting){
	update_option('wppay_setting', $setting);
}	

function wppay_css_url($css_url){
	return WPPAY_URL . "/static/css/{$css_url}.css";
}

function wppay_js_url($js_url){
	return WPPAY_URL . "/static/js/{$js_url}.js";
}


function wppay_admin_pagenavi($total_count, $number_per_page=15){

	$current_page = isset($_GET['paged'])?$_GET['paged']:1;

	if(isset($_GET['paged'])){
		unset($_GET['paged']);
	}

	$base_url = add_query_arg($_GET,admin_url('admin.php'));

	$total_pages	= ceil($total_count/$number_per_page);

	$first_page_url	= $base_url.'&amp;paged=1';
	$last_page_url	= $base_url.'&amp;paged='.$total_pages;
	
	if($current_page > 1 && $current_page < $total_pages){
		$prev_page		= $current_page-1;
		$prev_page_url	= $base_url.'&amp;paged='.$prev_page;

		$next_page		= $current_page+1;
		$next_page_url	= $base_url.'&amp;paged='.$next_page;
	}elseif($current_page == 1){
		$prev_page_url	= '#';
		$first_page_url	= '#';
		if($total_pages > 1){
			$next_page		= $current_page+1;
			$next_page_url	= $base_url.'&amp;paged='.$next_page;
		}else{
			$next_page_url	= '#';
		}
	}elseif($current_page == $total_pages){
		$prev_page		= $current_page-1;
		$prev_page_url	= $base_url.'&amp;paged='.$prev_page;
		$next_page_url	= '#';
		$last_page_url	= '#';
	}
	?>
	<div class="tablenav bottom">
		<div class="tablenav-pages">
			<span class="displaying-num">每页 <?php echo $number_per_page;?> 共 <?php echo $total_count;?></span>
			<span class="pagination-links">
				<a class="first-page <?php if($current_page==1) echo 'disabled'; ?>" title="前往第一页" href="<?php echo $first_page_url;?>">«</a>
				<a class="prev-page <?php if($current_page==1) echo 'disabled'; ?>" title="前往上一页" href="<?php echo $prev_page_url;?>">‹</a>
				<span class="paging-input">第 <?php echo $current_page;?> 页，共 <span class="total-pages"><?php echo $total_pages; ?></span> 页</span>
				<a class="next-page <?php if($current_page==$total_pages) echo 'disabled'; ?>" title="前往下一页" href="<?php echo $next_page_url;?>">›</a>
				<a class="last-page <?php if($current_page==$total_pages) echo 'disabled'; ?>" title="前往最后一页" href="<?php echo $last_page_url;?>">»</a>
			</span>
		</div>
		<br class="clear">
	</div>
	<?php
}