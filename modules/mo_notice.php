<?php
global $wpdb;
$count_posts = wp_count_posts();
$comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");
$users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
$last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j H:i', strtotime($last[0]->MAX_m));
if (_hui('celan_about_s')) {
    echo '<article class="widget"><div class="widget_about' . get_wow_3() . '" style="visibility: visible; animation-name: bounceInUp;">';
    if (_hui('celan_date_s')) {
        echo '<ul class="countdown">
    <li>
      <span id="vi-hour" class="hours">00</span>
      <p class="hours_ref">hours</p></li>
    <li class="seperator">:</li>
    <li>
      <span id="vi-minute" class="minutes">00</span>
      <p class="minutes_ref">minutes</p></li>
    <li class="seperator">:</li>
    <li>
      <span id="vi-second" class="seconds">00</span>
      <p class="seconds_ref">seconds</p></li>
  </ul>';
    }
    echo '<section class="about">';
    if (_hui('celan_img_s')) {echo '<img src="' . _hui('celan_img_s') . '" alt="SBKKO">';}
    if (_hui('celan_title_s')){echo '<h3>' . _hui('celan_title_s') . '</h3>';}
    if (_hui('celan_keyword_s')){echo '<span>' . _hui('celan_keyword_s') . '</span>';}
    if (_hui('celan_description_s')){echo '<div class="excerpt">
	<p>' . _hui('celan_description_s') . '</p>';}
    echo'</div>';
    if (_hui('celan_statistics_s')) {
        echo '<ul class="layout_ul">
      <li class="layout_li">
        <span>文章</span>
        <b>' . $count_posts->publish . '</b>
      </li>
      <li class="layout_li">
        <span>评论</span>
        <b>' . $comments . '</b>
      </li>
      <li class="layout_li">
        <span>标签</span>
        <b>' . wp_count_terms('post_tag') . '</b>
      </li>
      <li class="layout_li">
        <span>用户</span>
        <b>' . $users . '</b>
      </li>
    </ul>';
    }
    echo '</section>
</div></article>';
} ?>