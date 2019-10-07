<?php
/**
Template Name: 分享海报(修固定链接为“toimage”)
* 唯爱资源网  www.vizyw.com
* 原创版权开发，侵权必究，请注意出处
*/
function get_the_haibao_gz()
{
    $i = '';
    if (_hui('bigger_gz_s')) {
        $i = 1;
    } else {
        $i = 0;
    }
    return $i;
}
$pid     = $_GET['pid'];
$time    = $_REQUEST['time'] ? $_REQUEST['time'] : "1999/01/01";
$cat     = $_REQUEST['cat'] ? $_REQUEST['cat'] : "0";
$random  = mt_rand(1, 9);
$err     = '内容错误';
$errimg  = get_stylesheet_directory_uri() . '/static/img/random/' . $random . '.jpg';
$errqr   = 'https://ww2.sinaimg.cn/large/006Qd4WYly1g11fhe6qsxj3060060t8y.jpg';
$gz_huzi = _hui('bigger_gz_huzi');
$gz_text = _hui('bigger_gz_text');
if (empty($gz_huzi)) {
    $gz_huzi = '内容暂未输入';
}
if (empty($gz_text)) {
    $gz_text = '内容错误';
}
$str     = get_post($pid)->post_content;
$excerpt = wp_trim_words(strip_tags($str), 80, '...');
$pic     = image_url($pid);
if (_hui('bigger-share-logo')) {
    $logo = _hui('bigger-share-logo');
} else {
    $logo = get_stylesheet_directory_uri() . "/static/img/logo.png";
} //logo
$line   = get_stylesheet_directory_uri() . "/static/img/xuxian.png";
$title  = get_post($pid)->post_title;
$timebg = get_stylesheet_directory_uri() . "/static/img/timebg.png";
$gz     = get_stylesheet_directory_uri() . "/static/img/gz.png";
$gzopen = get_the_haibao_gz();
if ($gzopen == 1) {
    $cachet = $gz_huzi . '/' . $gz_text;
} else {
    $cachet = '功能暂时未开启/系统提示';
}
$userid = get_post($pid)->post_author;
$avatar = "作者：" . get_the_author_meta('nickname', $userid) . "/发布于：「" . get_category($cat)->cat_name . "」";
$sub    = _hui('bigger-share-sub');
$qrtxt  = get_stylesheet_directory_uri().'/action/qrcode.php?text=';
$code   = $qrtxt . get_permalink($pid);
if (empty($pic)) {
    $pic = $errimg;
}
if (empty($title)) {
    $title = $err;
}
if (empty($excerpt)) {
    $excerpt = $err;
}
if (empty($sub)) {
    $sub = $err;
}
if (empty($qrtxt)) {
    $code = $errqr;
}
$result = array(
    'time' => $time,
    'excerpt' => $excerpt,
    'pic' => $pic,
    'logo' => $logo,
    'line' => $line,
    'title' => $title,
    'timebg' => $timebg,
    'gz' => $gz,
    'cachet' => $cachet,
    'gzopen' => $gzopen,
    'avatar' => $avatar,
    'sub' => $sub,
    'code' => $code
);
if (empty($pid) || empty($time) || empty($cat)) {
    Header('Location:/');
} else {
    echo json_encode($result);
}
?>