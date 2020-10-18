<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->change_title ? $this->pageTitle : $this->settings['site_title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">

    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/m-styles.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/m-buttons.min.css" rel="stylesheet">
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/custom.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/jquery-ui-1.8.16.custom.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl?>/theme/css/imgareaselect-default.css" rel="stylesheet">
    
    <?php cs()->registerCoreScript('jquery');?>
	<?php cs()->registerCoreScript('jquery.ui');?>
	
    <script src="<?php echo Yii::app()->baseUrl?>/theme/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/theme/js/functions.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/theme/js/jquery.imgareaselect.pack.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl?>/theme/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->baseUrl?>/theme/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->baseUrl?>/theme/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->baseUrl?>/theme/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->baseUrl?>/theme/ico/apple-touch-icon-57-precomposed.png">
    
  </head>

  <body>

    <?php $this->renderPartial('/layouts/header')?>
	
    <div class="container-fluid">

      	<div class="row-fluid">

      		<?php echo $content?>

    	</div><!--/row-->

      <hr>

    </div><!--/.fluid-container-->

    <?php $this->renderPartial('/layouts/footer')?>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', '<?php echo $this->settings['google_analytics_account']?>', '<?php echo app()->params['domain_name']?>');
		ga('send', 'pageview');
	
	</script> 
    
  </body>
  
</html>
