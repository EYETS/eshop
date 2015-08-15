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
					<a href="<?php echo site_url('users/users_add') ?>" class="btn blue">إضافة عضو جديد</a>
					<a href="<?php echo site_url('users/users_all_export') ?>" class="btn purple">تصدير الكل</a>
                </div>
            </div>
			<!-- END PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<?php
                    $all = $this->messages->get();
                    if ($all != null) {
                        foreach ($all as $type => $messages)
                            foreach ($messages as $message)
                                switch ($type) {
                                    case "error":
                                        echo '<div class="alert alert-danger innerLR"><button type="button" class="close" data-dismiss="alert">×</button><strong>خطأ</strong><br>' . $message . '</div>';
                                        break;
                                    case "success":
                                        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>نجاح</strong><br>' . $message . '</div>';
                                        break;
                                    case "alert":
                                        echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>تحذير</strong><br>' . $message . '</div>';
                                        break;
                                }
                    }
                    ?>
                    <?php if (validation_errors() != null) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>خطأ</strong><?php echo validation_errors(); ?> </div>
                    <?php } ?>
                
                
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i><?php echo $pageTitle ?>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
                                    <th>#</th>
									<th>أسم العضو</th>
									<th>البريد الإلكترونى</th>
									<th>رقم الجوال</th>
									<th>الرصيد</th>
									<th>الإعدادات</th>
								</tr>
								</thead>
								<tbody>
									<?php
                                    if($rows != false)
                                    foreach($rows as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $row->user_uid; ?></td>
                                        <td><?php echo $row->user_full_name ?></td>
                                        <td><?php echo $row->user_email ?></td>
                                        <td><?php echo $row->user_uname ?></td>
                                        <td><?php echo $this->users_model->getCreditByID($row->user_uid) ?></td>
                                        <td>
                                        	<a href="#" class="btn btn-xs purple"><i class="fa fa-group"></i> المجموعات</a>
                                        	<a href="#" class="btn btn-xs blue"><i class="fa fa-dollar"></i> أدارة الرصيد</a>
                                        	<a href="<?php echo site_url('users/users_edit/' . $row->user_uid) ?>" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> تعديل</a>
                                            <a href="<?php echo site_url('users/users_del/' . $row->user_uid . '/' . 2) ?>" class="btn btn-xs red"><i class="fa fa-trash-o"></i> حذف</a>
                                            
										
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
								</table>
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