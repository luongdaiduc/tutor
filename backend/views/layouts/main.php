<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->settings['site_title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?php echo $this->siteUrl?>/theme/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->siteUrl?>/theme/css/m-styles.min.css" rel="stylesheet">
    <link href="<?php echo $this->siteUrl?>/theme/css/m-buttons.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="<?php echo $this->siteUrl?>/theme/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo $this->siteUrl?>/theme/css/custom.css" rel="stylesheet">
    <link href="<?php echo app()->baseUrl?>/theme/css/custom.css" rel="stylesheet">
    <link href="<?php echo app()->baseUrl?>/theme/css/jquery.tagit.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<?php cs()->registerCoreScript('jquery');?>
	<?php cs()->registerCoreScript('jquery.ui');?>
	
    <script src="<?php echo $this->siteUrl?>/theme/js/bootstrap.min.js"></script>
    <script src="<?php echo app()->baseUrl?>/theme/js/functions.js"></script>
    <script src="<?php echo app()->baseUrl?>/theme/js/tag-it.js"></script>
    
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $this->siteUrl?>/theme/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->siteUrl?>/theme/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->siteUrl?>/theme/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->siteUrl?>/theme/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->siteUrl?>/theme/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <?php $this->renderPartial('/layouts/header')?>

    <div class="container-fluid">

      <div class="row-fluid">
		
      		<?php $this->renderPartial('/layouts/left_column')?>
		
		
		<?php echo $content?>
		
      </div><!--/row-->

      <hr>

    </div><!--/.fluid-container-->

    <?php $this->renderPartial('/layouts/footer')?>

  </body>
</html>

                                             
          