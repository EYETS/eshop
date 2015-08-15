<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search sidebar-search-bordered sidebar-search-solid" action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="بحث عن عضو ...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="start active open">
					<a href="<?php echo site_url('main') ?>">
					<i class="icon-home"></i>
					<span class="title">الرئيسية</span>
					<span class="selected"></span>
					</a>
					
				</li>

				<li>
					<a href="<?php echo site_url('category/category_list') ?>">
					<i class="icon-call-out"></i>
					<span class="title">الأقسام</span>
					<span class="selected"></span>
					</a>
					
				</li>

				<li>
					<a href="<?php echo site_url('product/product_list') ?>">
					<i class="icon-call-out"></i>
					<span class="title">المنتجات</span>
					<span class="selected"></span>
					</a>
					
				</li>

                
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>