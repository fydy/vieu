<?php
/*
Template Name: 在线下载
*/

  $str = $_GET['key'];
  $i = base64_decode($str);
  $pid = substr($i,0,strrpos($i,"&"));
  $key = substr($i,strripos($i,"&")+1);
  $rand1=get_post_meta($pid, 'down_rand1', true);
  $rand2=get_post_meta($pid, 'down_rand2', true);
  $okkey=$rand1+$rand2;
  if(empty($key) && empty($pid) && $okkey!=$key){Header('Location:'.get_permalink($pid));}elseif($okkey==$key){
              if (_hui('down_blank_s')){  
		        $down_name=get_post_meta($pid, 'down_name', true);
		        $down_size=get_post_meta($pid, 'down_size', true);
		        $down_date=get_post_meta($pid, 'down_date', true);
				$down_demo_url=get_post_meta($pid, 'down_demo_url', true);
		        $down_version=get_post_meta($pid, 'down_version', true);
	 	        $down_author=get_post_meta($pid, 'down_author', true);
		        $down_url_1=get_post_meta($pid, 'down_url_1', true);
                $down_key_1=get_post_meta($pid, 'down_key_1', true);
		        $down_url_2=get_post_meta($pid, 'down_url_2', true);
                $down_key_2=get_post_meta($pid, 'down_key_2', true);
		        $down_url_3=get_post_meta($pid, 'down_url_3', true); 
                $down_new_name1=get_post_meta($pid, 'down_new_name1', true);
                $down_key_3=get_post_meta($pid, 'down_key_3', true);
		        $down_url_4=get_post_meta($pid, 'down_url_4', true); 
                $down_new_name2=get_post_meta($pid, 'down_new_name2', true);
                $down_key_4=get_post_meta($pid, 'down_key_4', true);
		
				$down_url_text1 = '';$down_key_text1 = '';$down_url_text2 = '';$down_key_text2 = '';$down_url_text3 = '';$down_key_text3 = '';$down_key_text4 = '';
				if ($down_key_1){$down_key_text1 = '&nbsp;&nbsp;<span>密码：'.$down_key_1.'</span>';}
				if ($down_demo_url){$down_demo_url_text = '<li><a href="'.home_url().'/demo?pid='.$pid.'"><span class="glyphicon glyphicon-eye-open"></span> 在线演示</a></li>';}
				if ($down_url_1){$down_url_text1 = '<a class="btn btn-primary" href="'.$down_url_1.'" target="_blank"><i class="glyphicon glyphicon-cloud-download"></i> 百度云盘'.$down_key_text1.'</a>';}
				if ($down_key_2){$down_key_text2 = '&nbsp;&nbsp;<span>密码：'.$down_key_2.'</span>';}
				if ($down_url_2){$down_url_text2 = ' <a class="btn btn-danger" href="'.$down_url_2.'" target="_blank"><i class="glyphicon glyphicon-cloud-download"></i> 蓝奏云盘'.$down_key_text2.'</a>';}
				if ($down_key_3){$down_key_text3 = '&nbsp;&nbsp;<span>密码：'.$down_key_3.'</span>';}
				if ($down_new_name1){$down_url_text3 = ' <a class="btn btn-success" href="'.$down_url_3.'" target="_blank"><i class="glyphicon glyphicon-cloud-download"></i> '. $down_new_name1.''.$down_key_text3.'</a>';}
				if ($down_key_4){$down_key_text4 = '&nbsp;&nbsp;<span>密码：'.$down_key_4.'</span>';}
				if ($down_new_name2){$down_url_text4 = ' <a class="btn btn-info" href="'.$down_url_4.'" target="_blank"><i class="glyphicon glyphicon-cloud-download"></i> '. $down_new_name2.''.$down_key_text4.'</a>';}
                if (_hui('down_asb2'))	{ $asb2='<div class="panel">'._hui('down_asb2').'</div>';	}		
				
				
				
				$down_body='<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">资源信息</h3></div>
           <div class="panel-body">
               <div class="plus_box">
				<div class="plus_l">
				<ul> 
                <li>文件名称 ：'.$down_name.'</li>
				<li>文件大小 ：'.$down_size.'</li>
				<li>适用版本 ：'.$down_version.'</li>
				<li>作者信息 ：'.$down_author.'</li>
				<li>更新时间 ：'.$down_date.'</li>
				</ul>
				</div>
	            <div class="plus_r">
				<img src="'._hui('down_tishi_src').'">
				</div>
				</div>
				  '.$down_url_text1.''.$down_url_text2.''.$down_url_text3.''.$down_url_text4.'
				  </div>
                </div>   
	    '.$asb2.'
          <div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">下载说明</h3></div>
           <div class="panel-body">
		   '._hui('down_xqsm').'</div>
				</div>';
			  }
  }else{Header('Location:'.get_permalink($pid));}
           
?>
    
<!DOCTYPE html>
<html> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="下载" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link type="text/css" href="https://lib.baomitu.com/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="<?php echo get_stylesheet_directory_uri() ?>/static/css/down.css" rel="stylesheet">
    <title>Down：<?php echo get_the_title($pid); ?>–<?php echo get_bloginfo( 'name') ?></title>
  
  </head>
  
  <body>
  
  <div class="navbar navbar-default" role="navigation">
 <div class="navbar-header">
    <a class="navbar-brand" href="<?php echo get_permalink($pid); ?>"><span class="glyphicon glyphicon-chevron-left"></span> 返回文章</a>
	<p class="navbar-text"><small class="text-muted text-sm"><em>文件名称 ：<?php echo $down_name;?></em></small></p>
	<p class="navbar-text"><small class="text-muted text-sm"><em>大小 ：<?php echo $down_size;?></em></small></p>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
	  <li><a href="<?php echo get_bloginfo('url');?>"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
	   <li class="active"><a href="#"><span class="glyphicon glyphicon-cloud-download"></span> 附件下载</a></li>
	   <?php echo $down_demo_url_text; ?>
	  <li><a href="<?php echo 'http://wpa.qq.com/msgrd?v=3&uin='._hui('qq').'&site=qq&menu=yes';?>" target="_blank"><span class="glyphicon glyphicon-comment"></span> 联系客服</a></li>
	  	  	  </ul>
  </div><!-- /.navbar-collapse -->
</div>
  
  
    <section class="container">		
	<div class="content-wrap">
	<div class="content">
    <?php echo $down_body; ?>
    </section>
	</div>
	</div>
</body>

</html>
