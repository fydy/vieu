<?php

//vieugonnengjiazai
require get_stylesheet_directory() . '/include/fn-theme.php';
require get_template_directory() . '/action/avatars.php';
include_once('include/metadown.php'); 
require_once('include/modules/mo_sign.php');
include_once('action/notify.php');
function appthemes_add_quicktags() {
require_once('include/modules/mo_editbutton.php');
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags' );
//后台登陆数学验证码
function myplugin_add_login_fields() {
//获取两个随机数, 范围0~9
$num1=rand(1,20);
$num2=rand(1,20);
//最终网页中的具体内容
    echo "<p><label for='math' class='small'>验证码</label><br /> $num1 + $num2 = ?<input type='text' name='sum' class='input' value='' size='25' tabindex='4'>"
."<input type='hidden' name='num1' value='$num1'>"
."<input type='hidden' name='num2' value='$num2'></p>";
}
add_action('login_form','myplugin_add_login_fields');
function login_val() {
$sum=$_POST['sum'];//用户提交的计算结果
switch($sum){
//得到正确的计算结果则直接跳出
case $_POST['num1']+$_POST['num2']:break;
//未填写结果时的错误讯息
case null:wp_die('错误: 请输入验证码.');break;
//计算错误时的错误讯息
default:wp_die('错误: 验证码错误,请重试.');
}
}
add_action('login_form_login','login_val');