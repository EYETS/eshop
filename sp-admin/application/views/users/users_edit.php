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
                echo form_open_multipart('users/users_edit/'.$row->user_uid, $attributes);
                ?>
				<?php if (validation_errors() != null) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>خطأ</strong><?php echo validation_errors(); ?> </div>
                <?php } ?>
				<div class="col-md-8">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>بيانات العضو
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label">الأسم بالكامل</label>
                                    <input type="text" class="form-control" name="user_full_name" value="<?php echo $row->user_full_name ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">كلمة المرور</label>
                                    <input type="password" class="form-control" name="user_pwd">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" name="user_pwd1">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">رقم الجوال</label>
                                    <input type="text" class="form-control" name="user_uname" value="<?php echo $row->user_uname; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">البريد الإلكترونى</label>
                                    <input type="text" class="form-control" name="user_email" value="<?php echo $row->user_email; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">الدولة</label>
                                    <select name="country_uid" class="form-control">
                                        <option value="">أختار الدولة</option>
                                        <?php if ($countries !== false) {
                                                    foreach ($countries as $r) :
                                                        ?>
                                        <?php
                                                        if ($row->country_uid == $r->countryID) {
                                                            ?>
                                        <option selected="selected" value="<?php echo $r->countryID; ?>" <?php echo set_select('countryID', $r->countryID); ?> > <?php echo $r->countryName; ?> </option>
                                        <?php } else { ?>
                                        <option value="<?php echo $r->countryID; ?>" <?php echo set_select('countryID', $r->countryID); ?> > <?php echo $r->countryName; ?> </option>
                                        <?php } endforeach;
                                                    } ?>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                        
                </div>
				<div class="col-md-4">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>خاص بالأدارة
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                
                                <div class="form-group">
                                    <label class="control-label">حالة التفعيل</label>
                                    <select name="user_actived" class="form-control">
                                        <option>أختار</option>
                                        <option value="1" <?php if ($row->user_actived == 1) { echo ' selected="selected"';} ?>>مفعل</option>
                                        <option value="0"<?php if ($row->user_actived == 0) { echo ' selected="selected"';} ?>>غير مفعل</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">حالة الحظر</label>
                                    <select name="user_banned" class="form-control">
                                        <option>أختار</option>
                                        <option value="0"<?php if ($row->user_banned == 0) { echo ' selected="selected"';} ?>>غير محظور</option>
                                        <option value="1"<?php if ($row->user_banned == 1) { echo ' selected="selected"';} ?>>محظور</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">المجموعة</label>
                                    <select name="group_uid" class="form-control" style="width: 100%;">
                                        <option value="">أختار المجموعة</option>
                                        <?php
                                        if ($groups !== false) {
											foreach ($groups as $r) :
															?>
											<option value="<?php echo $r->group_uid; ?>" <?php
											if (isset($row)) {
												if ($r->group_name == $row->group_uid) {
													echo ' selected="selected"';
												};
											} else {
												echo set_select('group_uid', $r->group_uid, TRUE);
											}
											?>><?php echo $r->group_name; ?></option>
                                        <?php
											endforeach;
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-actions right">
                                <button type="submit" class="btn green">تعديل</button>
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