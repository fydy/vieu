<?php
    /*
    Template Name: 外链跳转(修固定链接为“go”)
    */ 
if(strlen($_SERVER['REQUEST_URI']) > 384 ||  
    strpos($_SERVER['REQUEST_URI'], "eval(") ||  
    strpos($_SERVER['REQUEST_URI'], "base64")) {  
        @header("HTTP/1.1 414 Request-URI Too Long");  
        @header("Status: 414 Request-URI Too Long");  
        @header("Connection: Close");  
        @exit;  
}   
$t_url = preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]);   

    if ($t_url == base64_encode(base64_decode($t_url))) {  
        $t_url =  base64_decode($t_url);  
    }  
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i',$t_url,$matches);  
    if($matches){  
        $url=$t_url;  
        $title='提示：您即将访问未知链接';  
    } else {  
        preg_match('/\./i',$t_url,$matche);  
        if($matche){  
            $url='http://'.$t_url;  
            $title='提示：您即将访问未知链接';  
        } else {  
            $url = 'http://'.$_SERVER['HTTP_HOST'];  
            $title='参数错误，正在返回首页...';  
        }  
    }  

?>  
<html>  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
<meta name="robots" content="noindex, nofollow" />  
<meta name="viewport" content="width=device-width,initial-scale=1" />
<noscript><meta http-equiv="refresh" content="1;url='<?php echo $url;?>';"></noscript>  
<script>  
var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");  
function link_jump()  
{
    if (!MyHOST.test(document.referrer)) {  
         location.href="http://" + MyHOST;  
    }  
}   
setTimeout(link_jump, 2000); 
setTimeout(function(){window.opener=null;window.close();}, 60000);  
function cuowugo()  
{  
    if (!MyHOST.test(document.referrer)) {   
		 var nv = document.getElementById("404");
         nv.innerHTML="404";
		 var cw = document.getElementById("cuowu");
         cw.innerHTML="参数错误，正在返回首页...";
    }  
}   
setTimeout(cuowugo, 0000);    
</script> 
<title><?php echo $title;?></title>  
<style type="text/css">
body{padding:0 30px;}.container{max-width:640px;margin:0 auto;padding-top:25px;}.header{margin-bottom:40px;}.content{border:1px solid #bbb;box-shadow:0 0 3px #d4d4d4;}.c-container{padding:30px;}.remind_block{overflow:hidden;}.remind_block .remind_icon{float:left;margin-right:10px;width:32px;height:32px;background:url(https://rescdn.qqmail.com/zh_CN/htmledition/images/webp/newicon/prompt1e9c5d.png) no-repeat;}.warning .remind_icon{background-position:-64px 0;}.remind_block .remind_content{overflow:hidden;*zoom:1;}.warning .remind_title{color:#d68300;}.remind_block .remind_title{margin-bottom:10px;padding-top:3px;_margin-top:4px;font-weight:bold;font-size:20px;font-family:"Microsoft YaHei","lucida Grande",Verdana;}.remind_block .remind_detail{line-height:1.5;font-size:14px;color:#535353;}.safety-url{margin-bottom:15px;padding-bottom:15px;border-bottom:1px solid #dfdfdf;word-wrap:break-word;word-break:break-all;}.safety-qqbrowser{font-size:14px;line-height:1.5;margin-top:12px;-webkit-transition:margin 0.2s ease-in;-moz-transition:margin 0.2s ease-in;-o-transition:margin 0.2s ease-in;transition:margin 0.2s ease-in;}.c-footer{padding:10px 15px;background:#f1f1f1;border-top:1px solid #bbb;overflow:hidden;*zoom:1;}.gohome {float: left;width: 94px;height: 32px;background: url(../wp-content/themes/vieu/img/gohome.png) no-repeat;}.gohome:hover{background-position: 0px -32px;}a.btn_blue{border:1px solid #0d659b;color:#fff;color:#fff!important;background-color:#238aca;background:-moz-linear-gradient(top,#238aca,#0074bc);background:-webkit-linear-gradient(top,#238aca,#0074bc);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#238aca',endColorstr='#0074bc');-ms-filter:"progid:DXImageTransform.Microsoft.gradient(startColorstr='#238aca',endColorstr='#0074bc')";}a.btn_blue{display:inline-block;_overflow:hidden;padding:6px 25px;margin:0;font-size:14px;font-weight:bold;text-align:center;border-radius:3px;text-decoration:none;}.c-footer-a2{margin: 8px 0 0 15px;color: #127fc3;cursor: pointer;font-size: 12px;}.footer{margin-top:18px;text-align:center;color:#a0a0a0;font-size:10px;}@media (max-width:420px){.remind_icon{display:none;}}
</style>  
</head>  
<body>

<div class="container">
  <div class="header">
    <a href="/"><i class="gohome"></i></a></div>
  <div class="content">
    <div class="c-container warning">
      <div id="remind_block" class="remind_block">
        <span class="remind_icon"></span>
        <div class="remind_content">
          <div class="remind_title" id="404">您将要访问：</div>
          <div class="remind_detail">
            <div class="safety-url" id="cuowu"><?php echo $url;?></div>我们无法确认该网页是否安全，它可能包含未知的安全隐患，建议您不要在该网页输入账号密码、密保资料等信息。
          </div>
        </div>
      </div>
    </div>
    <div class="c-footer">
      <a href="<?php echo $url;?>" class="c-footer-a1 btn_blue">继续访问</a>
      <a class="c-footer-a2" onclick="window.close();">关闭网页</a></div>
  </div>
  <div class="footer">©&nbsp;2014&nbsp;-&nbsp;2018&nbsp;Vi network.&nbsp;All&nbsp;Rights&nbsp;Reserved</div></div>

</body>
</html>  