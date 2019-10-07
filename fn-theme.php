<?php
header("Content-type: text/html; charset=utf-8");
function tin_get_current_page_url()
{
    $ssl = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? true : false;
    $sp = strtolower($_SERVER['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . ($ssl ? 's' : '');
    $port = $_SERVER['SERVER_PORT'];
    $port = !$ssl && $port == '80' || $ssl && $port == '443' ? '' : ':' . $port;
    $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    return $protocol . '://' . $host . $port . $_SERVER['REQUEST_URI'];
}
function ajax_sign_object()
{
    $object = array();
    $object[redirecturl] = tin_get_current_page_url();
    $object[ajaxurl] = admin_url('/admin-ajax.php');
    $object[loadingmessage] = '正在请求中，请稍等...';
    $object_json = json_encode($object);
    return $object_json;
}
add_action('wp_insert_comment', 'inlojv_sql_insert_qq_field', 10, 2);
function inlojv_sql_insert_qq_field($comment_ID, $commmentdata)
{
    $qq = isset($_POST['new_field_qq']) ? $_POST['new_field_qq'] : false;
    update_comment_meta($comment_ID, 'new_field_qq', $qq);
}
add_filter('manage_edit-comments_columns', 'add_comments_columns');
add_action('manage_comments_custom_column', 'output_comments_qq_columns', 10, 2);
function add_comments_columns($columns)
{
    $columns['new_field_qq'] = __('QQ号');
    return $columns;
}
function output_comments_qq_columns($column_name, $comment_id)
{
    switch ($column_name) {
        case "new_field_qq":
            echo get_comment_meta($comment_id, 'new_field_qq', true);
            break;
    }
}
add_filter('get_avatar', 'inlojv_change_avatar', 10, 3);
function inlojv_change_avatar($avatar)
{
    global $comment;
    if (get_comment_meta($comment->comment_ID, 'new_field_qq', true)) {
        $qq_number = get_comment_meta($comment->comment_ID, 'new_field_qq', true);
        $qqavatar = file_get_contents('http://ptlogin2.qq.com/getface?appid=1006102&imgtype=3&uin=' . $qq_number);
        preg_match('/https:(.*?)&t/', $qqavatar, $m);
        return '<img src="' . stripslashes($m[1]) . '" class="avatar avatar-40 photo" width="40" height="40" alt="qq_avatar" />';
    } else {
        return $avatar;
    }
}
 /*
 $auth='http://auth.vizyw.com';
 if(!isset($_SESSION['authcode'])) {
	$query=file_get_contents($auth.'/check.php?url='.$_SERVER['HTTP_HOST']);
	if($query=json_decode($query,true)) {
    if($query['code']==1)$_SESSION['authcode']=true;
    else exit('<h3>'.$query['msg'].'</h3>');
	}
 }
 */
 

if (_hui('add_tags')) {
    add_action('save_post', 'auto_add_tags');
    function auto_add_tags()
    {
        $tags = get_tags(array('hide_empty' => false));
        $post_id = get_the_ID();
        $post_content = get_post($post_id)->post_content;
        if ($tags) {
            foreach ($tags as $tag) {
                if (strpos($post_content, $tag->name) !== false) {
                    wp_set_post_tags($post_id, $tag->name, true);
                }
            }
        }
    }
}
function xcollapse($atts, $content = null)
{
    extract(shortcode_atts(array(""), $atts));
    return '<li style="position:relative;list-style:none">
			    <div class="hidecontent" style="display:none">' . $content . '</div>
		            <div class="hidetitle">
                    <button class="collapseButton">' . _hui('collapse_title') . '</button>
                </div>
	</li>';
}
add_shortcode('collapse', 'xcollapse');
if (_hui('tags_links')) {
    $match_num_from = 1;
    $match_num_to = 1;
    function tag_sort($a, $b)
    {
        if ($a->name == $b->name) {
            return 0;
        }
        return strlen($a->name) > strlen($b->name) ? -1 : 1;
    }
    function tag_link($content)
    {
        global $match_num_from, $match_num_to;
        $posttags = get_the_tags();
        if ($posttags) {
            usort($posttags, "tag_sort");
            foreach ($posttags as $tag) {
                $link = get_tag_link($tag->term_id);
                $keyword = $tag->name;
                $cleankeyword = stripslashes($keyword);
                $url = "<a href=\"{$link}\" title=\"" . str_replace('%s', addcslashes($cleankeyword, '$'), __('【查看含有[%s]标签的文章】')) . "\"";
                $url .= ' target="_blank"';
                $url .= ">" . addcslashes($cleankeyword, '$') . "</a>";
                $limit = rand($match_num_from, $match_num_to);
                $content = preg_replace('|(<a[^>]+>)(.*)(' . $ex_word . ')(.*)(</a[^>]*>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
                $content = preg_replace('|(<img)(.*?)(' . $ex_word . ')(.*?)(>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
                $cleankeyword = preg_quote($cleankeyword, '\'');
                $regEx = '\'(?!((<.*?)|(<a.*?)))(' . $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
                $content = preg_replace($regEx, $url, $content, $limit);
                $content = str_replace('%&&&&&%', stripslashes($ex_word), $content);
            }
        }
        return $content;
    }
    add_filter('the_content', 'tag_link', 1);
}
function baidu_check($url)
{
    global $wpdb;
    $post_id = null === $post_id ? get_the_ID() : $post_id;
    $baidu_record = get_post_meta($post_id, 'baidu_record', true);
    if ($baidu_record != 1) {
        $url = 'http://www.baidu.com/s?wd=' . $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $rs = curl_exec($curl);
        curl_close($curl);
        if (!strpos($rs, '没有找到')) {
            if ($baidu_record == 0) {
                update_post_meta($post_id, 'baidu_record', 1);
            } else {
                add_post_meta($post_id, 'baidu_record', 1, true);
            }
            return 1;
        } else {
            if ($baidu_record == false) {
                add_post_meta($post_id, 'baidu_record', 0, true);
            }
            return 0;
        }
    } else {
        return 1;
    }
}
function baidu_record()
{
    if (baidu_check(get_permalink()) == 1) {
        echo '<a target="_blank" title="点击查看" rel="external nofollow" href="http://www.baidu.com/s?wd=' . get_the_title() . '">百度已收录</a>';
    } else {
        echo '<a style="color:#50b7ff;" rel="external nofollow" title="一键帮忙提交给百度，谢谢您！" target="_blank" href="http://zhanzhang.baidu.com/sitesubmit/index?sitename=' . get_permalink() . '">百度未收录</a>';
    }
}
add_filter('preprocess_comment', 'blogginglove_comment_limit');
function blogginglove_comment_limit($comment)
{
    if (strlen($comment['comment_content']) > 200) {
        err('评论字数过多，请删减一些，最多不超过200个字符，谢谢合作~');
    }
    if (strlen($comment['comment_content']) < 6) {
        err('评论字数不能低于6个字符，请再写一点吧~');
    }
    return $comment;
}
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', 'remove_xmlrpc_pingback_ping');
function remove_xmlrpc_pingback_ping($methods)
{
    unset($methods['pingback.ping']);
    return $methods;
}
if (_hui('login_security')) {
    function login_protection()
    {
        if ($_GET[_hui('login_security_title')] != _hui('login_security_pass')) {
            header('Location:' . _hui('login_security_url'));
        }
    }
    add_action('login_enqueue_scripts', 'login_protection');
}
function spam_protection_math()
{
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    echo "<span class='yanzheng'> {$num1} + {$num2} = <input type='text' name='sum' class='math_textfield' value=''>" . "<input type='hidden' name='num1' value='{$num1}'>" . "<input type='hidden' name='num2' value='{$num2}'>" . "</span>";
}
function spam_protection_pre($commentdata)
{
    $sum = $_POST['sum'];
    switch ($sum) {
        case $_POST['num1'] + $_POST['num2']:
            break;
        case null:
            err('请输入计算结果！');
            break;
        default:
            err('老铁数学不行啊！再算算！');
    }
    return $commentdata;
}
if ($comment_data['comment_type'] == '') {
    add_filter('preprocess_comment', 'spam_protection_pre');
}
function uedsc_fuckspam($comment)
{
    if (is_super_admin()) {
        return $comment;
    }
    if (wp_blacklist_check($comment['comment_author'], $comment['comment_author_email'], $comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'])) {
        header("Content-type: text/html; charset=utf-8");
        err('您的评论内容包含敏感词汇，请检查内容后再次提交！');
    } else {
        return $comment;
    }
}
add_filter('preprocess_comment', 'uedsc_fuckspam');
function refused_spam_comments($comment_data)
{
    $pattern = '/[一-龥]/u';
    if (!preg_match($pattern, $comment_data['comment_content'])) {
        err('评论内容必须含中文！');
    }
    return $comment_data;
}
add_filter('preprocess_comment', 'refused_spam_comments');
function appthemes_add_quicktags()
{
    require_once 'modules/mo_editbutton.php';
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags');
function hide($content)
{
    if (preg_match_all('/<!--hide start{?([\\s\\S]*?)}?-->([\\s\\S]*?)<!--hide end-->/i', $content, $matches)) {
        $params = $matches[1][0];
        $defaults = array('reply_to_this' => 'false');
        $params = wp_parse_args($params, $defaults);
        $stats = 'hide';
        if ($params['reply_to_this'] == 'true') {
            global $current_user;
            get_currentuserinfo();
            if ($current_user->ID) {
                $email = $current_user->user_email;
            } else {
                if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
                    $email = $_COOKIE['comment_author_email_' . COOKIEHASH];
                }
            }
            $ereg = "^[_\\.a-z0-9]+@([0-9a-z][0-9a-z-]+\\.)+[a-z]{2,5}\$";
            if (eregi($ereg, $email)) {
                global $wpdb;
                global $id;
                $comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments} WHERE comment_author_email = '" . $email . "' and comment_post_id='" . $id . "'and comment_approved = '1'");
                if ($comments) {
                    $stats = 'show';
                }
            }
            $url = get_the_permalink();
            $tip = __('<span class="vihide' . get_wow_4() . '">抱歉，隐藏内容 <a href="' . $url . '#comments">回复</a> 后刷新可见</span>', 'hide');
        } else {
            if (isset($_COOKIE['comment_author_' . COOKIEHASH]) or current_user_can('level_0')) {
                $stats = 'show';
            }
            $tip = __();
        }
        $hide_notice = $tip;
        if ($stats == 'show' || is_super_admin()) {
            $content = str_replace($matches[0], $matches[2], $content);
        } else {
            $content = str_replace($matches[0], $hide_notice, $content);
        }
    }
    return $content;
}
add_filter('the_content', 'hide');
add_filter('comment_text', 'hide');
function most_comm_posts($days = 30, $nums = 4)
{
    $i = 1;
    global $wpdb;
    $today = date("Y-m-d H:i:s");
    $daysago = date("Y-m-d H:i:s", strtotime($today) - $days * 24 * 60 * 60);
    $result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date FROM {$wpdb->posts} WHERE post_date BETWEEN '{$daysago}' AND '{$today}' ORDER BY comment_count DESC LIMIT 0 , {$nums}");
    $output = '';
    if (empty($result)) {
        $output = '<li>暂无文章.</li>';
    } else {
        foreach ($result as $topten) {
            $postid = $topten->ID;
            $title = $topten->post_title;
            $commentcount = $topten->comment_count;
            if ($commentcount != 0) {
                $output .= '<li class="layout_li"><strong>[评论 ' . $commentcount . ']</strong><a href="' . get_permalink($postid) . '" title="' . $title . '"><span>' . $i++ . '</span>' . $title . '</a></li>';
            }
        }
    }
    echo $output;
}
function jingdian_comm_posts($days = 30, $nums = 5)
{
    $i = 1;
    global $wpdb;
    $today = date("Y-m-d H:i:s");
    $daysago = date("Y-m-d H:i:s", strtotime($today) - $days * 24 * 60 * 60);
    $result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date FROM {$wpdb->posts} WHERE post_date BETWEEN '{$daysago}' AND '{$today}' ORDER BY comment_count DESC LIMIT 0 , {$nums}");
    $output = '';
    if (empty($result)) {
        $output = '<li>暂无文章.</li>';
    } else {
        foreach ($result as $topten) {
            $postid = $topten->ID;
            $title = $topten->post_title;
            $commentcount = $topten->comment_count;
            if ($commentcount != 0) {
                echo '<li>
           <article class="postlist' . get_wow_1() . '">
				<figure><a href="' . get_permalink($postid) . '" title="' . $title . '"><img class="thumb"  src="';
                echo image_url($topten->ID) . '"></a></figure>
				<h3><a href="' . get_permalink($postid) . '" title="' . $title . '">' . $title . '</a></h3>
				   <div class="homeinfo">
                     <span class="date">' . get_the_time('Y-m-d', $topten->ID) . '</span>
				<span class="count">[评论 ' . $commentcount . ']</span>
				</div></article>        </li>
			';
            }
        }
    }
}
function e_secret($atts, $content = null)
{
    extract(shortcode_atts(array('key' => null), $atts));
    if (isset($_POST['e_secret_key']) && $_POST['e_secret_key'] == $key) {
        return '' . $content . '';
    } else {
        if (is_super_admin()) {
            return '' . $content . '';
        } else {
            if (isset($_POST['e_secret_key']) && $_POST['e_secret_key'] != $key) {
                $error .= '密码错误！';
            }
            return '<form  action="' . get_permalink() . '" method="post" name="e-secret">
<div class="pshide' . get_wow_4() . '">
<div class="title">
内容隐藏，请输入提取密码：<i class="fa fa-lock"></i><span>' . $error . '</span></div>
<div class="box">
<input type="password" name="e_secret_key"  maxlength="50" placeholder=""  >
<button type="submit">立即提取</button>
</div>
</div>
		</form>';
        }
    }
}
add_shortcode('secret', 'e_secret');
function e_gzhhide($atts, $content = null)
{
    extract(shortcode_atts(array('key' => null), $atts));
    if (isset($_POST['e_gzhhide_key']) && $_POST['e_gzhhide_key'] == $key) {
        return '' . $content . '';
    } else {
        if (is_super_admin()) {
            return '' . $content . '';
        } else {
            if (isset($_POST['e_gzhhide_key']) && $_POST['e_gzhhide_key'] != $key) {
                $error .= '密码错误！';
            }
            return '<form  action="' . get_permalink() . '" method="post" name="e-gzhhide">
<div class="gzhhide' . get_wow_4() . '">
<div class="gzhtitle">' . _hui('gzhhide_title') . '<i class="fa fa-lock"></i><span>' . $error . '</span></div>
<div class="gzh-content">' . _hui('gzhhide_box') . '</div>
<div class="gzhbox">
<input type="password" name="e_gzhhide_key"  maxlength="50" placeholder=""  >
<button type="submit">立即提取</button>
</div>
<div class="gzhcode"><img src="' . _hui('gzhhide_code') . '"></div>
</div>
		</form>';
        }
    }
}
add_shortcode('gzhhide', 'e_gzhhide');
function e_doubt($h2, $content = null)
{
    extract(shortcode_atts(array('h2' => null), $h2));
    return '<div class="doubt"><h2>' . $h2 . '<span class="doubt-button"><i class="fa fa-chevron-down"></i></span></h2><div class="doubt-content" style="display: none;">' . $content . '</div></div>';
}
add_shortcode('doubt', 'e_doubt');
function e_video($title, $content = null)
{
    extract(shortcode_atts(array('title' => null), $title));
    if (_hui('vieu_video_s')) {
        $video = $content;
    } else {
        $video = '';
    }
    echo '<iframe id="vivideo" allowfullscreen="ture" src="' . _hui('videoapi_url');
    echo $video . '"></iframe>';
}
add_shortcode('video', 'e_video');
if (_hui('no_categoty') && !function_exists('no_category_base_refresh_rules')) {
    register_activation_hook(__FILE__, 'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');
    function no_category_base_refresh_rules()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
    register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
    function no_category_base_deactivate()
    {
        remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
        no_category_base_refresh_rules();
    }
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct()
    {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
            $wp_rewrite->extra_permastructs['category'][0] = '%category%';
        } else {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        }
    }
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite)
    {
        $category_rewrite = array();
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
            $category_nicename = $category->slug;
            if ($category->parent == $category->cat_ID) {
                $category->parent = 0;
            } elseif ($category->parent != 0) {
                $category_nicename = get_category_parents($category->parent, false, '/', true) . $category_nicename;
            }
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        return $category_rewrite;
    }
    add_filter('query_vars', 'no_category_base_query_vars');
    function no_category_base_query_vars($public_query_vars)
    {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars)
    {
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
            status_header(301);
            header("Location: {$catlink}");
            exit;
        }
        return $query_vars;
    }
}
function get_post_thumbnail_url($post_id)
{
    $post_id = null === $post_id ? get_the_ID() : $post_id;
    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        $thumb = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
        return $thumb[0];
    } else {
        return false;
    }
}
function image_url($id)
{
    if (has_post_thumbnail($id)) {
        return get_post_thumbnail_url($id, '', '');
    } else {
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post($id)->post_content, $matches);
        $first_img = $matches[1][0];
        if (empty($first_img)) {
            $random = mt_rand(1, 9);
            $first_img = get_bloginfo('stylesheet_directory') . '/img/random/' . $random . '.jpg';
        }
        return $first_img;
    }
}
function down_show_down($down_content)
{
    global $wpdb;
    $post_id = null === $post_id ? get_the_ID() : $post_id;
    $filter = '/<(iframe|script)/i';
    if (preg_match($filter, $down_content, $matches)) {
        $down_content = htmlspecialchars($down_content);
    }
    $id = $_GET['id'];
    $title = get_post($id)->post_title;
    $down_official = get_post_meta(get_the_ID(), 'down_official', true);
    $down_reply = get_post_meta(get_the_ID(), 'down_reply', true);
    $down_name = get_post_meta(get_the_ID(), 'down_name', true);
    $down_size = get_post_meta(get_the_ID(), 'down_size', true);
    $down_date = get_post_meta(get_the_ID(), 'down_date', true);
    $down_demo_url = get_post_meta(get_the_ID(), 'down_demo_url', true);
    $down_version = get_post_meta(get_the_ID(), 'down_version', true);
    $down_author = get_post_meta(get_the_ID(), 'down_author', true);
    $down_url_1 = get_post_meta(get_the_ID(), 'down_url_1', true);
    $down_key_1 = get_post_meta(get_the_ID(), 'down_key_1', true);
    $down_url_2 = get_post_meta(get_the_ID(), 'down_url_2', true);
    $down_key_2 = get_post_meta(get_the_ID(), 'down_key_2', true);
    $down_url_3 = get_post_meta(get_the_ID(), 'down_url_3', true);
    $down_new_name1 = get_post_meta(get_the_ID(), 'down_new_name1', true);
    $down_key_3 = get_post_meta(get_the_ID(), 'down_key_3', true);
    $down_url_4 = get_post_meta(get_the_ID(), 'down_url_4', true);
    $down_new_name2 = get_post_meta(get_the_ID(), 'down_new_name2', true);
    $down_key_4 = get_post_meta(get_the_ID(), 'down_key_4', true);
    $down_bg_src = '';
    $down_url_text1 = '';
    $down_key_text1 = '';
    $down_url_text2 = '';
    $down_key_text2 = '';
    $down_url_text3 = '';
    $down_key_text3 = '';
    $down_key_text4 = '';
    if ($down_key_1) {
        $down_key_text1 = '  <span>密码：' . $down_key_1 . '</span>';
    }
    if ($down_demo_url) {
        $down_demo_url_text = '<a class="btn btn-danger" href="' . home_url() . '/demo?pid=' . $post_id . '" target="_blank"><i class="fa fa-eye" style="margin-right:4px;margin-top:3px"></i> 在线演示</a>';
    }
    if ($down_url_1) {
        $down_url_text1 = '<a class="btn btn-primary" href="' . $down_url_1 . '" target="_blank"><i class="fa fa-cloud-download"></i>百度云盘' . $down_key_text1 . '</a>';
    }
    if ($down_key_2) {
        $down_key_text2 = '  <span>密码：' . $down_key_2 . '</span>';
    }
    if ($down_url_2) {
        $down_url_text2 = ' <a class="btn btn-danger" href="' . $down_url_2 . '" target="_blank"><i class="fa fa-cloud-download"></i>蓝奏云盘' . $down_key_text2 . '</a>';
    }
    if ($down_key_3) {
        $down_key_text3 = '  <span>密码：' . $down_key_3 . '</span>';
    }
    if ($down_new_name1) {
        $down_url_text3 = ' <a class="btn btn-success" href="' . $down_url_3 . '" target="_blank"><i class="fa fa-cloud-download"></i>' . $down_new_name1 . '' . $down_key_text3 . '</a>';
    }
    if ($down_key_4) {
        $down_key_text4 = '  <span>密码：' . $down_key_4 . '</span>';
    }
    if ($down_new_name2) {
        $down_url_text4 = ' <a class="btn btn-info" href="' . $down_url_4 . '" target="_blank"><i class="fa fa-cloud-download"></i>' . $down_new_name2 . '' . $down_key_text4 . '</a>';
    }
    if (_hui('down_bg_src')) {
        $down_bg_src = 'style="background: url(' . _hui('down_bg_src') . ') no-repeat;background-position: center;background-size: 100% 100%;"';
    }
    $cont = '<div class="down' . get_wow_2() . '" ' . $down_bg_src . '>
				<div class="comt">
				<div class="box-title">文件下载</div>
				<div class="box">
                <div class="name">
				<p>附件：<span>' . $down_name . '</span></p>
				</div>
                <div class="box-body">
				<p>文件大小：' . $down_size . '</p>
				<p>更新时间：' . $down_date . '</p>
				</div>  
				<div class="down-button">
				<a href="javascript:;" class="btn btn-primary down-show">
				<i class="fa fa-cloud-download" style="margin-right:4px;margin-top:3px"></i> 立即下载</a>
				' . $down_demo_url_text . '

				
				</div>
				</div>
                <div class="asb1' . get_wow_4() . '"><p>' . _hui('down_asb1') . '</p></div>
				</div>
                <div class="down-bloak' . get_wow_4() . '"><p>' . _hui('down_sm') . '</p></div>
				</div>			
				<div class="down-up">
				<div class="down-content">
				<div class="down-container">
				<div class="plus_box">
				<div class="plus_l">
				<ul> 
                <li>文件名称 ：' . $down_name . '</li>
				<li>文件大小 ：' . $down_size . '</li>
				<li>适用版本 ：' . $down_version . '</li>
				<li>作者信息 ：' . $down_author . '</li>
				<li>更新时间 ：' . $down_date . '</li>
				</ul>
				</div>
	            <div class="plus_r">
				<div class="diybox">
				<img src="' . _hui('down_tishi_src') . '">
				</div>
				</div>
				</div>
                <div class="banner">' . _hui('down_asb2') . '</div>
				<div class="panel">
				<div class="panel-heading">
				<h3>下载地址</h3>
				</div>
				<div class="panel-body">
                ' . $down_url_text1 . '' . $down_url_text2 . '' . $down_url_text3 . '' . $down_url_text4 . '</div>
				</div>
				<div class="panel panel-sm">
				<div class="panel-heading">
                <h3>下载说明</h3>
				</div>
				<div class="panel-body">' . _hui('down_xqsm') . '</div>
				</div>
				<span class="close"><i class="fa fa-times"></i></span>
                </div>
				</div>
				</div>
				
				';
    if ($down_official) {
        $down_content .= $cont;
    }
    if ($down_reply) {
        global $current_user;
        get_currentuserinfo();
        $url = get_the_permalink();
        $tip = __('<span class="vihide' . get_wow_4() . '">抱歉，隐藏内容 <a href="' . $url . '#comments">回复</a> 后刷新可见</span>', 'hide');
        if ($current_user->ID) {
            $email = $current_user->user_email;
        } else {
            if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
                $email = $_COOKIE['comment_author_email_' . COOKIEHASH];
            }
        }
        $ereg = "^[_\\.a-z0-9]+@([0-9a-z][0-9a-z-]+\\.)+[a-z]{2,5}\$";
        if (eregi($ereg, $email)) {
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments} WHERE comment_author_email = '" . $email . "' and comment_post_id='" . $id . "'and comment_approved = '1'");
            if ($comments) {
                return $down_content .= $cont;
            }
        } else {
            if (isset($_COOKIE['comment_author_' . COOKIEHASH]) or current_user_can('level_0')) {
                return $down_content .= $tip;
            }
        }
        $hide_notice = $tip;
        if ($comments || is_super_admin()) {
            return $down_content .= $cont;
        } else {
            return $down_content .= $tip;
        }
    }
    return $down_content;
}
add_action('the_content', 'down_show_down');
add_shortcode("down", 'down_show_down');
function get_wow_1()
{
    $wow = ' wow ' . _hui('the_wow_style');
    if (_hui('the_wow_s') && _hui('the_wow_comt1')) {
        return $wow;
    }
}
function get_wow_2()
{
    $wow = ' wow ' . _hui('the_wow_style');
    if (_hui('the_wow_s') && _hui('the_wow_comt2')) {
        return $wow;
    }
}
function get_wow_3()
{
    $wow = ' wow ' . _hui('the_wow_style');
    if (_hui('the_wow_s') && _hui('the_wow_comt3')) {
        return $wow;
    }
}
function get_wow_4()
{
    $wow = ' wow shake';
    if (_hui('the_wow_s') && _hui('the_wow_comt4')) {
        return $wow;
    }
}
function get_the_wow()
{
    $i = '';
    if (_hui('the_wow_s')) {
        $i = 1;
    } else {
        $i = 0;
    }
    return $i;
}
function left_sd_s()
{
    $i = '';
    if (_hui('left_sd_s') && is_single()) {
        $i = 1;
    } else {
        $i = 0;
    }
    return $i;
}
function get_haibaoimg()
{
    $bt = get_the_title();
    $zy = wp_trim_words(get_the_excerpt(), 200);
    if (_hui('bigger-share-logo')) {
        $lo = _hui('bigger-share-logo');
    } else {
        $lo = get_stylesheet_directory_uri() . "/img/logo.png";
    }
    $bg = get_stylesheet_directory_uri() . "/img/timebg.png";
    $xux = get_stylesheet_directory_uri() . "/img/xuxian.png";
    $sj = get_the_time('Y/m d');
    $zz = "作者：" . get_the_author_meta('nickname');
    $fbt = _hui('bigger-share-sub');
    $qr = _hui('left_qrcode_url_s') . get_permalink();
    $the_post_category = get_the_category(get_the_ID());
    $im = get_stylesheet_directory_uri() . '/action/toImage.php?pic=' . image_url($post->comment_post_ID) . '&title=' . $bt . '&excerpt=' . $zy . '&line=' . $xux . '&logo=' . $lo . '&timebg=' . $bg . '&time=' . $sj . '&avatar=' . $zz . '  发布于：「' . $the_post_category[0]->cat_name . '」&sub=' . $fbt . '&code=' . $qr;
    return $im;
}
add_action('media_buttons', 'add_my_media_button');
function add_my_media_button()
{
    get_template_part('modules/mo_sinaimg');
}
function get_wintip_srollbar()
{
    $wintip = '';
    if (_hui('wintip_srollbar_s')) {
        $wintip = '1';
    } else {
        $wintip = '0';
    }
    return $wintip;
}
function get_wintip_width()
{
    $wintip = '';
    if (_hui('wintip_m')) {
        $wintip = '1';
    } else {
        $wintip = '0';
    }
    return $wintip;
}
if (_hui('nofollow_s')) {
    add_filter('the_content', 'cn_nf_url_parse');
    function cn_nf_url_parse($content)
    {
        $regexp = "<a\\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
        if (preg_match_all("/{$regexp}/siU", $content, $matches, PREG_SET_ORDER)) {
            if (!empty($matches)) {
                $srcUrl = get_option('siteurl');
                for ($i = 0; $i < count($matches); $i++) {
                    $tag = $matches[$i][0];
                    $tag2 = $matches[$i][0];
                    $url = $matches[$i][0];
                    $noFollow = '';
                    $pattern = '/target\\s*=\\s*"\\s*_blank\\s*"/';
                    preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
                    if (count($match) < 1) {
                        $noFollow .= ' target="_blank" ';
                    }
                    $pattern = '/rel\\s*=\\s*"\\s*[n|d]ofollow\\s*"/';
                    preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
                    if (count($match) < 1) {
                        $noFollow .= ' rel="nofollow" ';
                    }
                    $pos = strpos($url, $srcUrl);
                    if ($pos === false) {
                        $tag = rtrim($tag, '>');
                        $tag .= $noFollow . '>';
                        $content = str_replace($tag2, $tag, $content);
                    }
                }
            }
        }
        $content = str_replace(']]>', ']]>', $content);
        return $content;
    }
    add_filter('comment_text', 'auto_nofollow');
    function auto_nofollow($content)
    {
        return preg_replace_callback('/<a>]+/', 'auto_nofollow_callback', $content);
    }
    function auto_nofollow_callback($matches)
    {
        $link = $matches[0];
        $site_link = get_bloginfo('url');
        if (strpos($link, 'rel') === false) {
            $link = preg_replace("%(href=S(?!{$site_link}))%i", 'rel="nofollow" $1', $link);
        } elseif (preg_match("%href=S(?!{$site_link})%i", $link)) {
            $link = preg_replace('/rel=S(?!nofollow)S*/i', 'rel="nofollow"', $link);
        }
        return $link;
    }
}
if (_hui('go_tiaozhuan_s')) {
    add_filter('the_content', 'the_content_nofollow', 999);
    function the_content_nofollow($content)
    {
        preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/', $content, $matches);
        if ($matches) {
            foreach ($matches[2] as $val) {
                if (strpos($val, '://') !== false && strpos($val, home_url()) === false && !preg_match('/\\.(jpg|jepg|png|ico|bmp|gif|tiff)/i', $val)) {
                    $content = str_replace("href=\"{$val}\"", "href=\"" . home_url() . "/go/?url={$val}\" ", $content);
                }
            }
        }
        return $content;
    }
    function commentauthor($comment_ID = 0)
    {
        $url = get_comment_author_url($comment_ID);
        $author = get_comment_author($comment_ID);
        if (emptyempty($url) || 'http://' == $url) {
            echo $author;
        } else {
            echo "<a href='" . home_url() . "/go/?url={$url}' rel='external nofollow' target='_blank' class='url'>{$author}</a>";
        }
    }
}
function new_excerpt_more($more)
{
    global $post;
    $readmore = '...';
    return '<a rel="nofollow" class="more-link" style="text-decoration:none;" href="' . get_permalink($post->ID) . '">' . $readmore . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
function the_layout()
{
    $layout = 'index-blog';
    if (isset($_GET['layout'])) {
        $layout = 'index-' . $_GET['layout'];
    } elseif (_hui('index-s')) {
        $layout = _hui('index-s');
    } else {
        $layout = 'index-blog';
    }
    return $layout;
}
function _get_cms_cat_template($cat_ID, $sidebar = 1)
{
    if ($sidebar == 1) {
        $tp[] = _hui('example_checkbox_categories') ? _hui('example_checkbox_categories') : array();
        $tp[] = _hui('example_checkbox_categories_1') ? _hui('example_checkbox_categories_1') : array();
        $tp[] = _hui('example_checkbox_categories_2') ? _hui('example_checkbox_categories_2') : array();
        $tp[] = _hui('example_checkbox_categories_3') ? _hui('example_checkbox_categories_3') : array();
        $tp[] = _hui('example_checkbox_categories_4') ? _hui('example_checkbox_categories_4') : array();
        $tp[] = _hui('example_checkbox_categories_5') ? _hui('example_checkbox_categories_5') : array();
        $tp_pre = 'catlist_bar_';
    } else {
        $tp[] = _set('cms_catlist_template_1') ? _set('cms_catlist_template_1') : array();
        $tp[] = _set('cms_catlist_template_2') ? _set('cms_catlist_template_2') : array();
        $tp[] = _set('cms_catlist_template_3') ? _set('cms_catlist_template_3') : array();
        $tp[] = _set('cms_catlist_template_4') ? _set('cms_catlist_template_4') : array();
        $tp[] = _set('cms_catlist_template_5') ? _set('cms_catlist_template_5') : array();
        $tp_pre = 'catlist_';
    }
    $tp_id = -1;
    for ($i = 0; $i <= 5; $i++) {
        if (array_key_exists($cat_ID, $tp[$i])) {
            if ($tp[$i][$cat_ID] == 1) {
                $tp_id = $i;
                break;
            }
        }
    }
    if ($tp_id == -1) {
        $tp_id = rand(0, 5);
    }
    $tp_name = $tp_pre . $tp_id;
    return $tp_name;
}