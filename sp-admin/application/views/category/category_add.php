<?php $this->load->view('includes/header'); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php $this->load->view('includes/menu'); ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<?php $this->load->view('includes/breadcrumb',$breadcrumbs); ?>
                <div class="page-toolbar">
                </div>
            </div>
			<!-- END PAGE HEADER-->
			<div class="row">
				<?php
                $attributes = array('class' => '');
                echo form_open_multipart('category/category_add', $attributes);
                ?>
				<?php if (validation_errors() != null) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>خطأ</strong><?php echo validation_errors(); ?> </div>
                <?php } ?>
				<div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i><?php echo $pageTitle ?>
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label">القسم</label>
                                    <input type="text" class="form-control" name="cat_name" value="<?php echo set_value('cat_name'); ?>">
                                </div>
                            </div>
                            <div class="form-actions right">
                                <button type="submit" class="btn green">إضافة</button>
                            </div>

                        </div>
                    </div>
                        
                </div>
				
                    
				</div>
            </div>
            
			<div class="clearfix">
			</div>
			
			
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('includes/footer'); ?>