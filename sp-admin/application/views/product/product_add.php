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
                echo form_open_multipart('product/product_add', $attributes);
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
                                    <label class="control-label">أسم المنتج</label>
                                    <input type="text" class="form-control" name="pro_title" value="<?php echo set_value('pro_title'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">صورة المنتج</label>
                                    <input type="file" class="form-control" name="userfile" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">وصف قصير</label>
                                    <input type="text" class="form-control" name="pro_short_desc" value="<?php echo set_value('pro_short_desc'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">السعر</label>
                                    <input type="number" class="form-control" name="pro_price" value="<?php echo set_value('pro_price'); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">القسم</label>
                                    <select name="cat_uid" class="form-control">
                                        <option value="">أختار القسم</option>
                                        <?php if ($categories !== false) {
                                                    foreach ($categories as $r) :
                                                        ?>
                                        <?php
                                                        if ($row->cat_uid == $r->cat_uid) {
                                                            ?>
                                        <option selected="selected" value="<?php echo $r->cat_uid; ?>" <?php echo set_select('cat_uid', $r->cat_uid); ?> > <?php echo $r->cat_name; ?> </option>
                                        <?php } else { ?>
                                        <option value="<?php echo $r->cat_uid; ?>" <?php echo set_select('cat_uid', $r->cat_uid); ?> > <?php echo $r->cat_name; ?> </option>
                                        <?php } endforeach;
                                                    } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">وصف المنتج</label>
                                    <textarea name="pro_desc" class="ckeditor"><?php echo set_value('pro_desc'); ?></textarea>
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