<?php
if ( !defined('ABSPATH') ) {exit;}

add_action( 'admin_menu', 'wppay_add_metabox_data' );
function wppay_add_metabox_data(){
	add_meta_box( 'wppay-postmeta-box','付费下载', 'wppay_get_metabox_options', 'post', 'normal', 'high' );
}

add_action( 'save_post', 'wppay_save_metabox_data' );
function wppay_save_metabox_data($post_id){
	$metaboxes = array_merge( wppay_metabox_options() );
	foreach ( $metaboxes as $metabox ) :
		if ( !wp_verify_nonce( $_POST[$metabox['name'] . '_input_name'], plugin_basename( __FILE__ ) ) )
			return $post_id;
		if ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
		$data = stripslashes( $_POST[$metabox['name']] );
		if ( get_post_meta( $post_id, $metabox['name'] ) == '' )
			add_post_meta( $post_id, $metabox['name'], $data, true );
		elseif ( $data != get_post_meta( $post_id, $metabox['name'], true ) )
			update_post_meta( $post_id, $metabox['name'], $data );
		elseif ( $data == '' )
			delete_post_meta( $post_id, $metabox['name'], get_post_meta( $post_id, $metabox['name'], true ) );
	endforeach;
}

function wppay_metabox_options() {
	$metaboxes = array(
		array(
			"name"             => "wppay_type",
			"title"            => "收费类型",
			"type"             => "radio",
			'options' => array(
				'0' => '不启用',
	            '1' => '查看全部内容',
	            '2' => '查看部分内容（利用短代码[wppay]）',
	            '3' => '下载资源'
	        ),
	        'default' => '0',
	        "desc"=>'',
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_price",
			"title"            => "收费价格",
			"type"             => "number",
			"desc" => '',
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_down_name",
			"title"            => "下载资源名称",
			"type"             => "text",
			"desc"             => "",
			"capability"       => "manage_options"
		),
	    array(
			"name"             => "wppay_down_url",
			"title"            => "下载地址",
			"type"             => "text",
			"desc"             => "",
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_down_pass",
			"title"            => "提取密码",
			"type"             => "text",
			"desc"             => "",
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_down_size",
			"title"            => "文件大小",
			"type"             => "text",
			"desc"             => "",
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_down_time",
			"title"            => "更新时间",
			"type"             => "text",
			"desc"             => "",
			"capability"       => "manage_options"
		),
		array(
			"name"             => "wppay_down_about",
			"title"            => "使用说明",
			"type"             => "textarea",
			"desc"             => "",
			"capability"       => "manage_options"
		)
		
	);
	return $metaboxes;
}

function wppay_get_metabox_options(){
	global $post;
	$metaboxes = wppay_metabox_options(); 
	foreach ( $metaboxes as $meta ) :
		$value = get_post_meta( $post->ID, $meta['name'], true );
		if ( $meta['type'] == 'number' ){
?>
	<div class="wppay-metabox-options" style="margin-bottom: 10px;">
		<label for="<?php echo $meta['name']; ?>"><b><?php echo $meta['title']; ?></b></label><br>
		<input type="number" min="0" step="0.01" name="<?php echo $meta['name']; ?>" id="<?php echo $meta['name']; ?>" value="<?php echo esc_html( $value, 1 ); ?>" style="width: 100px;" /> 元
		<input type="hidden" name="<?php echo $meta['name']; ?>_input_name" id="<?php echo $meta['name']; ?>_input_name" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
	</div>
<?php
		}elseif ( $meta['type'] == 'radio' ){
			echo '<div class="wppay-metabox-options" style="margin-bottom: 10px;"><label for="'.$meta['name'].'"><b>'.$meta['title'].'</b></label><br>';
			$i=1;
            foreach ($meta['options'] as $key => $option) {
            	if(!$value) $value=$meta['default'];
                echo '<input type="radio" name="'.$meta['name'].'" id="'.$meta['name'].$i.'" value="'. esc_attr( $key ) . '" '. checked( $value, $key, false) .' /><label for="'.$meta['name'].$i.'">' . esc_html( $option ) . '</label>&nbsp;&nbsp;&nbsp;&nbsp;';
                $i ++;
            }
            echo '<input type="hidden" name="'.$meta['name'].'_input_name" id="'.$meta['name'].'_input_name" value="'.wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
            echo '</div>';
		}else{
?>
	<div class="wppay-metabox-options" style="margin-bottom: 10px;">
		<label for="<?php echo $meta['name']; ?>"><b><?php echo $meta['title']; ?></b></label><br>
		<input type="text" name="<?php echo $meta['name']; ?>" id="<?php echo $meta['name']; ?>" value="<?php echo esc_html( $value, 1 ); ?>" style="width: 100%" />
		<input type="hidden" name="<?php echo $meta['name']; ?>_input_name" id="<?php echo $meta['name']; ?>_input_name" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		<?php if($meta['desc']){ echo '<p style="margin:0">（'.$meta['desc'].'）</p>';}?>
	</div>
<?php		
		}
	endforeach; 
}