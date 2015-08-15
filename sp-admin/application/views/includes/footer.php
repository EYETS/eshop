<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 جميع الحقوق محفوظة 2015 ©
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url() ;?>../assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url() ;?>../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script>
	$(document).ready(function() {
		$('#selectall').click(function(event) {  //on click 
			if(this.checked) { // check select status
				$('.select').each(function() { //loop through each checkbox
					this.checked = true;  //select all checkboxes with class "checkbox1"               
				});
			}else{
				$('.select').each(function() { //loop through each checkbox
					this.checked = false; //deselect all checkboxes with class "checkbox1"                       
				});         
			}
		});
	});
</script>
<?php
if (isset($javascripts) && $javascripts != null) {
	foreach ($javascripts as $javascript){
		echo "<script src=" . $javascript . "></script>";
//		if(strpos($javascript, 'uniform') !== false)
//		{
//			echo "";
//		}
	}
}
?>
<script>
jQuery(document).ready(function() {  
  
<?php
if (isset($init) && $init != null) {
	foreach ($init as $item){
		echo $item;
	}
}
?>
});
</script>
<script>
	$(document).ready(function() {
		$('#selectall').click(function(event) {  
			if(this.checked) { // check select status
				$('.select').each(function() { 
					this.checked = true;                
				});
			}else{
				$('.select').each(function() { 
					this.checked = false;                     
				});         
			}
		});
	});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
