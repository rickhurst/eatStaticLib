<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<?php foreach($pages as $page): ?>
	<url>
	   <loc><?php echo LIVE_HOST.$page['loc'] ?></loc>
	   <lastmod><?php 
	   		if($page['lastmod'] == 'NOW'){
	   			echo date("Y-m-d")."T".date("H:i:s+00:00");
	   		} 
	   ?></lastmod>
	   <changefreq><?php echo $page['changefreq'] ?></changefreq>
	   <priority><?php echo $page['priority'] ?></priority>
	</url>
	<?php endforeach; ?>

	<?php foreach($posts as $post): ?>
	<url>
	   <loc><?php echo LIVE_HOST.$post->uri ?></loc>
	   <lastmod><?php 
	   		//if($page['lastmod'] == 'NOW'){
	   			echo date("Y-m-d")."T".date("H:i:s+00:00");
	   		//} 
	   ?></lastmod>
	   <changefreq>daily</changefreq>
	   <priority>0.9000</priority>
	</url>
	<?php endforeach; ?>

</urlset>