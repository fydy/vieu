<div class="wrap mobantu">
	<h2>付费下载设置</h2><br>
	<form method="post" action="options.php">
		<?php 
			settings_fields( 'wppay_setting_group' );
			$setting = wppay_get_setting();
		?>
		<table class="form-table">
			<tbody>
              <p class="description" style="color:#ff0000;font-size: 16px;font-weight: bold;">支付宝企业当面付代开通每个/100元，直接到账无第三方提现，企业支付一次开通永久使用，审核不过全额退款，QQ：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1452938190&amp;site=qq&amp;menu=yes">1452938190</a></p>
				<tr valign="top">
					<th scope="row"><label>基础设置</label></th>
					<td>
						<ul class="wppay-ul">
							<?php $basic = array(
									array(
										'title' => 'cookie保存天数',
										'key' => 'pay-expire',
										'default' => '7',
										'desc' => '',
										'type' => 'number'
									),
									array(
										'title' => 'cookie key',
										'key' => 'pay-key',
										'default' => 'G1U3OHG8',
										'desc' => '请随机设置一个8位字符串，设置后不要更改，随机密码生成：<a href="http://t.cn/RaHRXy3" target="_blank">http://t.cn/RaHRXy3</a> 否则之前的用户购买状态会无法识别',
										'type' => 'text'
									),
									array(
										'title' => '加通过IP判断',
										'key' => 'pay-ip',
										'default' => '1',
										'desc' => '（勾选后就算cookie过期，只要IP不变，一样会判断成已支付）',
										'type' => 'checkbox'
									),
									array(
										'title' => '必须登陆',
										'key' => 'pay-login',
										'default' => '1',
										'desc' => '（勾选后必须用户登陆账号后才能购买）',
										'type' => 'checkbox'
									)
								);
								foreach ($basic as $key => $V) {
									if($V['type'] == 'checkbox'){
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="checkbox" value="1" id="<?php echo wppay_setting_key($V['key']);?>" <?php if(esc_html( $value, 1 )=='1') echo 'checked="checked"'?> style="margin-top: 5px;"/>
										<span style="top: 3px;position: relative;" class="MOBANTU"><?php echo $V['desc'];?></span>
									</li>
								<?php }elseif($V['type'] == 'number'){
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="number" min="0" step="0.1" value="<?php echo $value;?>" id="<?php echo wppay_setting_key($V['key']);?>" class="regular-text" />
										<?php echo $V['desc'];?>
									</li>
								<?php
									}else{
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="text" value="<?php echo $value;?>" id="<?php echo wppay_setting_key($V['key']);?>" class="regular-text" />
										<?php echo $V['desc'];?>
									</li>
								<?php
									}
								}
							?>
						</ul>
						<p class="description">1、首先根据浏览器cookie来判断是否已支付，若cookie过期，然后根据以上设置来看是否通过IP来判断用户是否已支付<br>2、已登录用户购买后可永久保存</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>颜色设置</label></th>
					<td>
						<ul class="wppay-color-ul">
							<?php $color = array(
									array(
										'title' => '购买边框颜色',
										'key' => 'border-color',
										'default' => '#ff5f33',
										'type' => 'color'
									),
									array(
										'title' => '成功边框颜色',
										'key' => 'border-color-success',
										'default' => '#54c468',
										'type' => 'color'
									),
									array(
										'title' => '背景颜色',
										'key' => 'background-color',
										'default' => '#ffffff',
										'type' => 'color'
									),
									array(
										'title' => '文字颜色',
										'key' => 'text-color',
										'default' => '#333333',
										'type' => 'color'
									),
									array(
										'title' => '价格颜色',
										'key' => 'price-color',
										'default' => '#ff5f33',
										'type' => 'color'
									),
									array(
										'title' => '按钮颜色',
										'key' => 'btn-color',
										'default' => '#21759b',
										'type' => 'color'
									),
									array(
										'title' => '弹窗颜色',
										'key' => 'code-color',
										'default' => '#00aaee',
										'type' => 'color'
									)
								);
								foreach ($color as $key => $V) {
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $color = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="text" value="<?php echo $color;?>" id="<?php echo wppay_setting_key($V['key']);?>" data-default-color="<?php echo $V['default'];?>" class="regular-text wppay-color-picker" />
									</li>
								<?php
								}
							?>
						</ul>
						<p class="description">提醒大家不要选择太奇怪的颜色组合</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>支付宝当面付设置</label></th>
					<td>
						<ul class="wppay-ul">
							<?php $youzan = array(
									array(
										'title' => '应用ID',
										'key' => 'f2fpay-app-id',
										'default' => '',
										'type' => 'text'
									),
									array(
										'title' => '商户应用私钥',
										'key' => 'f2fpay-private-key',
										'default' => '',
										'type' => 'textarea'
									),
									array(
										'title' => '支付宝公钥',
										'key' => 'f2fpay-public-key',
										'default' => '',
										'type' => 'textarea'
									)
								);
								foreach ($youzan as $key => $V) {
									if($V['type'] == 'text'){
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="text" value="<?php echo $value;?>" id="<?php echo wppay_setting_key($V['key']);?>" class="regular-text" />
									</li>
								<?php }elseif($V['type'] == 'textarea'){
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<textarea name="<?php echo wppay_setting_key($V['key']);?>" id="<?php echo wppay_setting_key($V['key']);?>" class="regular-text" style="height:150px;"/><?php echo $value;?></textarea>
									</li>
								<?php }else{
									?>
									
								<?php
									}
								}
							?>
						</ul>
						<p class="description">注意是商户应用私钥而不是AES密钥、是支付宝公钥而不是商户应用公钥</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>有赞云设置</label></th>
					<td>
						<ul class="wppay-ul">
							<?php $youzan = array(
									array(
										'title' => 'cliend_id',
										'key' => 'youzan-client-id',
										'default' => '',
										'type' => 'text'
									),
									array(
										'title' => 'cliend_secret',
										'key' => 'youzan-client-secret',
										'default' => '',
										'type' => 'text'
									),
									array(
										'title' => '授权店铺id',
										'key' => 'youzan-shop-id',
										'default' => '',
										'type' => 'text'
									)
								);
								foreach ($youzan as $key => $V) {
									if($V['type'] == 'text'){
									?>
									<li class="wppay-li">
										<code><?php echo $V['title'];?></code>
										<?php $value = $setting[$V['key']] ? $setting[$V['key']] : $V['default'];?>
										<input name="<?php echo wppay_setting_key($V['key']);?>" type="text" value="<?php echo $value;?>" id="<?php echo wppay_setting_key($V['key']);?>" class="regular-text" />
									</li>
								<?php }else{
									?>
									
								<?php
									}
								}
							?>
						</ul>
						<p class="description">推送网址设置：<?php echo WPPAY_URL;?>/include/wppay/payment/youzan/notify.php</p>
					</td>
				</tr>
				<tr>
					<td>
						<div class="wppay-submit-form">
							<input type="submit" class="button-primary mobantu_submit_form_btn" name="save" value="<?php _e('Save Changes') ?>"/>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
	</form>
	<style>
		/*Powered by mobantu.com*/
		.wppay-li{position: relative;padding-left: 120px}
		.wppay-li code{position: absolute;left: 0;top: 2px;}
	</style>		
</div>