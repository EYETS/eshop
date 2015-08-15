<!DOCTYPE html>
<html lang="en">
	<head>
        <!-- BEGIN META SECTION -->
        <meta charset="utf-8">
        <title><?php echo $this->session->userdata('siteName'); ?><?php if(isset($pageTitle)) echo " | ".$pageTitle; ?> </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta name="keywords" content="<?php if(isset($keywords)){echo $keywords;}else{echo $this->session->userdata('siteMetaKW');} ?>">
        <meta name="description" content="<?php if(isset($description)){echo $description;}else{echo $this->session->userdata('siteMetaDesc');} ?>">
        <meta name="author" content="Ebrahim Elsawy">   
    
        <meta property="og:description" content="<?php if(isset($description)){echo $description;}else{echo $this->session->userdata('siteMetaDesc');} ?>" />
        <meta property="og:image" content="<?php if(isset($pic)){echo $pic;}else{echo base_url().'wahtsapp.jpg';} ?>" />
        <meta property='og:title' content='<?php echo $this->session->userdata('siteName') ?><?php if(isset($title)){echo ' - '.$title;} ?>' />
        <meta property='og:url' content='<?php echo current_url(); ?>' />
        <meta property='og:description' content='<?php if(isset($description)){echo $description;}else{echo $this->session->userdata('siteMetaDesc');} ?>' />
        <meta property='og:site_name' content='<?php echo $this->session->userdata('siteName') ?>' />
        <meta property='og:locale' content='ar_AR' />
        <!-- END META SECTION -->
    
        <!-- Global styles START -->          
        <link href="<?php echo base_url() ;?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet">
        <!-- Global styles END --> 
        
        <!-- Page level plugin styles START -->
        <link href="<?php echo base_url() ;?>assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel-rtl.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/global/plugins/slider-layer-slider/css/layerslider.css" rel="stylesheet">
        <!-- Page level plugin styles END -->
        
        <!-- Theme styles START -->
        <link href="<?php echo base_url() ;?>assets/global/css/components-rtl.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/frontend/layout/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/frontend/pages/css/style-shop.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ;?>assets/frontend/pages/css/style-layer-slider.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/frontend/layout/css/style-responsive.css" rel="stylesheet">
        <link href="<?php echo base_url() ;?>assets/frontend/layout/css/themes/blue.css" rel="stylesheet" id="style-color">
        <link href="<?php echo base_url() ;?>assets/frontend/layout/css/custom.css" rel="stylesheet">
        <!-- Theme styles END -->
            
        <!-- Google Analytics-->
        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', '<?php echo $this->session->userdata('siteAnalytics') ?>']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
        
        <!-- Alexa Analytics-->
        <meta name="alexaVerifyID" content="<?php echo $this->session->userdata('siteAlexa') ?>" />
   
	</head>

<body class="ecommerce">

    <!-- BEGIN TOP BAR -->
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <!-- BEGIN TOP BAR LEFT PART -->
                <div class="col-md-6 col-sm-6 additional-shop-info">
                    <ul class="list-unstyled list-inline">
                        <li><i class="fa fa-phone"></i><span>+1 456 6717</span></li>
                        <li><i class="fa fa-skype"></i><span>skype.account</span></li>
                    </ul>
                </div>
                <!-- END TOP BAR LEFT PART -->
                <!-- BEGIN TOP BAR MENU -->
                <div class="col-md-6 col-sm-6 additional-nav">
                    <ul class="list-unstyled list-inline pull-right">
                        <li><a href="#">المفضلة</a></li>
                        <li><a href="#">دخول</a></li>
                    </ul>
                </div>
                <!-- END TOP BAR MENU -->
            </div>
        </div>        
    </div>
    <!-- END TOP BAR -->

    <!-- BEGIN HEADER -->
    <div class="header">
      <div class="container">
        <a class="site-logo" href="<?php echo site_url() ?>"><img src="<?php echo base_url() ;?>assets/frontend/layout/img/logos/logo-shop-red.png" alt="Metronic Shop UI"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN CART -->
        
        <!--END CART -->

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation">
			<?php $this->load->view('includes/menu'); ?>
        </div>
        <!-- END NAVIGATION -->
      </div>
    </div>
    <!-- Header END -->
