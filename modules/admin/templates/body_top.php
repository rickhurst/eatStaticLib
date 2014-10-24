<body class="<?php echo $this->getContext('body_class') ?>">

	<?php if($this->getContext('show_navbar')): ?>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo BLOG_TITLE ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $this->getContext('site_root') ?>posts">Posts</a></li>
            <li><a href="<?php echo $this->getContext('site_root') ?>images">Images</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	<?php endif ?>

	<div class="container">

