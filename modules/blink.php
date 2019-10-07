<?php
/*
  Template Name: 自助申请友链
  * 提示：友情链接，需在后台审核
*/
?>
<?php 
if( isset($_POST['blink_form']) && $_POST['blink_form'] == 'send'){
  global $wpdb;
 
  // 表单变量初始化
  $link_name = isset( $_POST['blink_name'] ) ? trim(htmlspecialchars($_POST['blink_name'], ENT_QUOTES)) : '';
  $link_url =  isset( $_POST['blink_url'] ) ? trim(htmlspecialchars($_POST['blink_url'], ENT_QUOTES)) : '';
  $link_description =  isset( $_POST['blink_lianxi'] ) ? trim(htmlspecialchars($_POST['blink_lianxi'], ENT_QUOTES)) : ''; // 联系方式
  $link_target =  "_blank";
  $link_visible = "N"; // 表示链接默认不可见
 
  // 表单项数据验证
  if ( empty($link_name) || mb_strlen($link_name) > 20 ){
    wp_die('连接名称必须填写，且长度不得超过30字');
  }
  if ( empty($link_url) || strlen($link_url) > 60 || !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $link_url))
//验证url
{ 
wp_die('链接地址必须填写');
}
 
  $sql_link = $wpdb->insert(
    $wpdb->links, 
    array(
      'link_name' => '【待审核】--- '.$link_name,
      'link_url' => $link_url,
      'link_target' => $link_target,
      'link_description' => $link_description,
      'link_visible' => $link_visible
    )
  );
 
  $result = $wpdb->get_results($sql_link);
 
  wp_die('亲，友情链接提交成功，【等待站长审核中】！<a href="/blinks/">点此返回</a>', '提交成功');
 
}
?>
<?php get_header(); ?>
 
<div id="main">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article class="col-md-10 col-md-offset-2 view clearfix">
    <?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?> 
 
    <p class="mt20">欢迎同类站点与本站交换友情链接，要求有权重有排名，收录良好的，内容健康，内容相关更佳。</p>
 
    <p class="mt20"><strong>友链自助申请须知</strong></p>
 
    <p>&#x2714; 申请前请先加上本站链接；</p>
 
    <p>&#x2714; 网站域名必须是一级域名，非一级域名的网站暂不考虑；</p>
 
    <p>&#x2714; 稳定更新，每月至少发布1篇文章，最好是建站半年以上；</p>
 
    <p>&#x2714; 禁止一切产品营销、广告联盟类型的网站，优先通过同类原创、内容相近的网站；</p>
 
    <p>&#x2714; 网站内容一定要健康积极向上，凡内容污秽不堪的、反动反共的、宣扬暴力的、广告挂马的都将不会通过申请。</p>
 
    <p class="mt20"><strong>其他</strong></p>
 
    <p>博主会不定期访问友链，如果遇到网站长时间打不开、网站被降权，内容不符合条件等情况的话，将会撤销该友链！</p>
    <p>如果申请后，长时间未通过审核，有可能是博主太忙未看到，可以通过右侧QQ联系告知我，谢谢~</p>
 
    <p class="mt20"><strong>本站链接信息</strong></p>
 
    <p>名称：zhattyt的博客</p>
 
    <p>网址：http://www.zhattyt.com</p>
 
    <!--表单开始-->
    <form method="post" class="mt20" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
 
      <div class="form-group">
        <label for="blink_name"><font color="red">*</font> 链接名称:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_name" placeholder="请输入链接名称" name="blink_name" />
      </div>
 
      <div class="form-group">
        <label for="blink_url"><font color="red">*</font> 链接地址:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_url" placeholder="请输入链接地址" name="blink_url" />
      </div>
 
      <div class="form-group">
        <label for="blink_lianxi">联系QQ:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_lianxi" placeholder="请输入联系QQ" name="blink_lianxi" />
      </div>
 
      <div>
        <input type="hidden" value="send" name="blink_form" />
        <button type="submit" class="btn btn-primary">提交申请</button>
        <button type="reset" class="btn btn-default">重填</button>
        （提示：带有<font color="red">*</font>，表示必填项~）
      </div>
    </form>
    <!--表单结束-->
 
  </article>
  <?php endwhile; else: ?>
  <?php endif; ?>
</div>
 
<?php get_footer(); ?>