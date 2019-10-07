<?php
require('./wp-blog-header.php');
header("Content-type: text/xml");
header('HTTP/1.1 200 OK');
$posts_to_show = 1000; // 获取文章数量
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
?>
<!-- generated-on=<?php echo get_lastpostdate('blog'); ?>-->
  <url>
      <loc>https://www.zhattyt.com/</loc>
      <lastmod><?php echo get_lastpostdate('blog'); ?></lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
  </url>
<?php
header("Content-type: text/xml");
$myposts = get_posts( "numberposts=" . $posts_to_show );
foreach( $myposts as $post ) { ?>
  <url>
      <loc><?php the_permalink(); ?></loc>
      <lastmod><?php the_time('c') ?></lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.6</priority>
  </url>
<?php } // end foreach ?>
</urlset>