<?php
$ii = 0;
$p_meta = _hui("post_plugin");
echo "<div class=\"layout_card\">";
while (have_posts()) {
	the_post();
	$ii++;
	
	if($ii%2==0){
		echo "<article class=\"card-right".get_wow_1()." card card-" . $ii . (_hui("list_type") == "text" ? " card-text" : "") . "\">";
	}else{
		echo "<article class=\" card-left".get_wow_1()." card card-" . $ii . (_hui("list_type") == "text" ? " card-text" : "") . "\">";
	}
    echo "<div class=\"itemcard\">";
	echo "<div class=\"cardtitle pictitle\">";
	echo "<span class=\"bigpic\"><a ". _post_target_blank() ."class=\"focus\" href=". get_permalink() .">". _get_post_thumbnail() ." </a>";
	if (!is_category()) {
		$category = get_the_category();

		if ($category[0]) {
			echo "<a class=\"cat\" href=\"" . get_category_link($category[0]->term_id) . "\">" . $category[0]->cat_name . "<i></i></a> ";
		}
	}
	if(get_post_meta($post->ID,'pay_switch',true) == 1) echo'<small><a href="'.get_permalink().'#pay-content" title="'.get_the_title().'" target="_blank">立即购买</small>';
	echo "</span>";        
    echo "<h2><a" . _post_target_blank() . " href=\"" . get_permalink() . "\" title=\"" . get_the_title() . _get_delimiter() . get_bloginfo("name") . "\"> <div class=\"title-mask\"></div><span>" . get_the_title() . "</span></a></h2>";
	echo "</div>";
	echo "<div class=\"abstract\"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". _get_excerpt() ." </p></div>";
	
	echo "<div class=\"meta\" >";
			
	if ($p_meta && $p_meta["view"]) {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"pv\"><i class=\"fa fa-eye\"></i>" . _get_post_views('','') . "</span>";
	}

	if (comments_open() && $p_meta && $p_meta["view"]) {
		echo "<a class=\"pc\" href=\"" . get_comments_link() . "\"><i class=\"fa fa-comments-o\"></i>" . get_comments_number("0", "1", "%") . "</a>";
	}
	if ($p_meta && $p_meta["author"]) {
		$author = get_the_author();

		if (_hui("author_link")) {
			$author = "<a href=\"" . get_author_posts_url(get_the_author_meta("ID")) . "\">" . $author . "</a>";
		}

		echo "<span class=\"author\"><i class=\"fa fa-user\"></i>" . $author . "</span>";
	}
		if(function_exists('ldclite_addPostLike')) ldclite_addPostLike();
	
	echo "</div>";
	echo "</div>";
	echo "</article>";
}
echo "</div>";
_moloader("mo_paging");
wp_reset_query();

?>
