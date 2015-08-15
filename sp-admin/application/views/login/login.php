<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>

<meta charset="utf-8">
<title><?php echo $this->session->userdata('siteName'); ?><?php if(isset($pageTitle)) echo " | ".$pageTitle; ?> </title>
<meta name="keywords" content="<?php if(isset($keywords)){echo $keywords;}else{echo $this->session->userdata('siteMetaKW');} ?>">
<meta name="description" content="<?php if(isset($description)){echo $description;}else{echo $this->session->userdata('siteMetaDesc');} ?>">
<meta name="author" content="Ebrahim Elsawy">   


<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- END META SECTION -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo base_url() ;?>../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url() ;?>../assets/admin/pages/css/login-rtl.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url() ;?>../assets/global/css/components-rounded-rtl.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/global/css/plugins-rtl.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/admin/layout/css/layout-rtl.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ;?>../assets/admin/layout/css/themes/default-rtl.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url() ;?>../assets/admin/layout/css/custom-rtl.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->


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
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="<?php echo site_url() ?>">
	<img src="<?php echo base_url() ;?>../assets/admin/layout3/img/logo-big.png" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content" style="font-family:ArabicFont !important">
	<!-- BEGIN LOGIN FORM -->
                
    <?php
    $attributes = array('class' => 'login-form');
    echo form_open('login', $attributes);
    ?> 
    
		<h3 class="form-title">تسجيل الدخول</h3>
		<?php if (validation_errors() != null) { ?>
            <div class="alert alert-danger"><button class="close" data-close="alert"></button>    
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?> 
        <?php
        $all = $this->messages->get();
        if ($all != null) {
            foreach ($all as $type => $messages)
                foreach ($messages as $message)
                    switch ($type) {
                        case "error":
                            echo '<div class="alert alert-danger"><button class="close" data-close="alert"></button>' . $message . "</div>";
                            break;
                        case "success":
                            echo '<div class="alert alert-success"><button class="close" data-close="alert"></button>' . $message . "</div>";
                            break;
                        case "alert":
                            echo '<div class="alert alert-warning"><button class="close" data-close="alert"></button>' . $message . "</div>";
                            break;
                    }
        }
        ?>
        
        
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">البريد الإلكترونى</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="البريد الإلكترونى" name="adminEmail"/>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">كلمة المرور</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="كلمة المرور" name="adminPwd"/>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success uppercase">دخول</button>
			<a href="javascript:;" id="forget-password" class="forget-password">هل نسيت كلمة المرور ؟</a>
		</div>
		
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="index.html" method="post">
		<h3>استعادة كلمة المرور</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn btn-default">Back</button>
			<button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright" style="font-family:ArabicFont !important">
	 جميع الحقوق محفوظة 2015 &copy;
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url() ;?>../assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url() ;?>../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url() ;?>../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() ;?>../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>../assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Login.init();
	Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>