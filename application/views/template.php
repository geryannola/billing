<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Billing ABhostpot</title>
	<meta name="description" content="Static &amp; Dynamic Tables" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/fonts.googleapis.com.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/ace-rtl.min.css" />
	<script src="<?php echo base_url() ?>assets/assets/js/ace-extra.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/jQuery-3.5.1.min.js"></script>

</head>

<body class="no-skin">
	<div id="navbar" class="navbar navbar-default          ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>
				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="index.html" class="navbar-brand">
					<small>
						<i class="fa fa-leaf"></i>
						ABhostpot
					</small>
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="<?php echo base_url() ?>assets/assets/images/avatars/masjid2.jpg" alt="Jason's Photo" />
							<span class="user-info">
								<small>Selamat Datang,</small>
								<?php echo ucfirst($this->session->userdata('nama')); ?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="<?php echo base_url() ?>login/ganti_password/<?php echo $this->session->userdata('id_username') ?>">
									<i class="ace-icon fa fa-cog"></i>
									Rubah Password
								</a>
							</li>

							<li>
								<a href="<?php echo base_url() ?>login/edit_profile/<?php echo $this->session->userdata('id_username') ?>">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="<?php echo base_url() ?>login/logout">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}
		</script>
		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try {
					ace.settings.loadState('sidebar')
				} catch (e) {}
			</script>
			<ul class="nav nav-list">
				<!-- ADMINISTRATOR -->
				<?php if ($this->session->userdata('level') == 1) { ?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/administartor">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Mikrotik
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>mikrotik/mikrotik">
									<i class="menu-icon fa fa-caret-right"></i>
									Router
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>mikrotik/hostpotProfile">
									<i class="menu-icon fa fa-caret-right"></i>
									Hostpot Profile
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>mikrotik/hostpot">
									<i class="menu-icon fa fa-caret-right"></i>
									Hostpot
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>mikrotik/pppProfile">
									<i class="menu-icon fa fa-caret-right"></i>
									PPP Profile
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>mikrotik/ppp">
									<i class="menu-icon fa fa-caret-right"></i>
									PPP
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Kas
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>Tagihan">
									<i class="menu-icon fa fa-caret-right"></i>
									Tagihan
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url() ?>Kas_masuk">
									<i class="menu-icon fa fa-caret-right"></i>
									Pemasukan
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url() ?>Kas_keluar">
									<i class="menu-icon fa fa-caret-right"></i>
									Pengeluaran
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url() ?>rekap_kas
								">
									<i class="menu-icon fa fa-caret-right"></i>
									Rekap
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>laporan">
							<i class="menu-icon fa fa-book"></i>
							<span class="menu-text"> Laporan </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="<?php echo base_url() ?>cabang">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Setting Cabang </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pelanggan">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Setting Pelanggan </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>paket">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Setting Paket </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>users">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Setting User</span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>user_level">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Setting User Level </span>
						</a>

						<b class="arrow"></b>
					</li>


				<?php } elseif ($this->session->userdata('level') == 2) { ?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/sales">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
				<?php
					// Sales
				} elseif ($this->session->userdata('level') == 2) {
				?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
				<?php
					// Teknisi
				} elseif ($this->session->userdata('level') == 3) {
				?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
				<?php
					// Pelanggan
				} elseif ($this->session->userdata('level') == 4) {
				?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pelanggan/ticket">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>
					</li>
				<?php } elseif ($this->session->userdata('level') == 5) { ?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
				<?php } elseif ($this->session->userdata('level') == 6) { ?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
				<?php } elseif ($this->session->userdata('level') == 7) { ?>
					<li class="">
						<a href="<?php echo base_url() ?>dashboard/teknisi">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>pembayaran">
							<i class="menu-icon fa fa-bell"></i>
							<span class="menu-text">
								Pembayaran
							</span>

							<!-- <b class="arrow fa fa-angle-down"></b> -->
						</a>

						<b class="arrow"></b>

						<!-- <ul class="submenu">
							<li class="">
								<a href="<?php echo base_url() ?>pembayaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Pembayaran
								</a>
								<b class="arrow"></b>
							</li>
						</ul> -->
					</li>
				<?php } ?>
			</ul><!-- /.nav-list -->

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<div class="ace-settings-container" id="ace-settings-container">
						<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
							<i class="ace-icon fa fa-cog bigger-130"></i>
						</div>

						<div class="ace-settings-box clearfix" id="ace-settings-box">
							<div class="pull-left width-50">
								<div class="ace-settings-item">
									<div class="pull-left">
										<select id="skin-colorpicker" class="hide">
											<option data-skin="no-skin" value="#438EB9">#438EB9</option>
											<option data-skin="skin-1" value="#222A2D">#222A2D</option>
											<option data-skin="skin-2" value="#C6487E">#C6487E</option>
											<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
										</select>
									</div>
									<span>&nbsp; Choose Skin</span>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
									<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
									<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
									<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
									<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
									<label class="lbl" for="ace-settings-add-container">
										Inside
										<b>.container</b>
									</label>
								</div>
							</div><!-- /.pull-left -->

							<div class="pull-left width-50">
								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
									<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
									<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
								</div>

								<div class="ace-settings-item">
									<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
									<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
								</div>
							</div><!-- /.pull-left -->
						</div><!-- /.ace-settings-box -->
					</div><!-- /.ace-settings-container -->

					<div class="row">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<div class="row">
								<div class="col-xs-12">
									<?php echo $contents ?>
								</div><!-- /.span -->
							</div><!-- /.row -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

		<div class="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<span class="bigger-120">
						<span class="blue bolder">ABhotpot - </span>
						&copy; 2022
					</span>

					&nbsp; &nbsp;
					<!-- <span class="action-buttons">
							<a href="https://web.facebook.com/muhammadramdan599">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>
						</span> -->
				</div>
			</div>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="<?php echo base_url() ?>assets/assets/js/jquery-2.1.4.min.js"></script>

	<!-- <![endif]-->

	<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>
	<script src="<?php echo base_url() ?>assets/assets/js/bootstrap.min.js"></script>

	<!-- page specific plugin scripts -->
	<script src="<?php echo base_url() ?>assets/assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/jquery.dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/buttons.flash.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/buttons.colVis.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/dataTables.select.min.js"></script>

	<!-- ace scripts -->
	<script src="<?php echo base_url() ?>assets/assets/js/ace-elements.min.js"></script>
	<script src="<?php echo base_url() ?>assets/assets/js/ace.min.js"></script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		jQuery(function($) {
			//initiate dataTables plugin
			var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable({
					bAutoWidth: false,
					"aoColumns": [{
							"bSortable": false
						},
						null, null, null, null, null,
						{
							"bSortable": false
						}
					],
					"aaSorting": [],


					//"bProcessing": true,
					//"bServerSide": true,
					//"sAjaxSource": "http://127.0.0.1/table.php"	,

					//,
					//"sScrollY": "200px",
					//"bPaginate": false,

					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element

					//"iDisplayLength": 50


					select: {
						style: 'multi'
					}
				});



			$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

			new $.fn.dataTable.Buttons(myTable, {
				buttons: [{
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					},
					{
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					}
				]
			});
			myTable.buttons().container().appendTo($('.tableTools-container'));

			//style the message box
			var defaultCopyAction = myTable.button(1).action();
			myTable.button(1).action(function(e, dt, button, config) {
				defaultCopyAction(e, dt, button, config);
				$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
			});


			var defaultColvisAction = myTable.button(0).action();
			myTable.button(0).action(function(e, dt, button, config) {

				defaultColvisAction(e, dt, button, config);


				if ($('.dt-button-collection > .dropdown-menu').length == 0) {
					$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
				}
				$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
			});

			////

			setTimeout(function() {
				$($('.tableTools-container')).find('a.dt-button').each(function() {
					var div = $(this).find(' > div').first();
					if (div.length == 1) div.tooltip({
						container: 'body',
						title: div.parent().text()
					});
					else $(this).tooltip({
						container: 'body',
						title: $(this).text()
					});
				});
			}, 500);





			myTable.on('select', function(e, dt, type, index) {
				if (type === 'row') {
					$(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
				}
			});
			myTable.on('deselect', function(e, dt, type, index) {
				if (type === 'row') {
					$(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
				}
			});




			/////////////////////////////////
			//table checkboxes
			$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

			//select/deselect all rows according to table header checkbox
			$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function() {
				var th_checked = this.checked; //checkbox inside "TH" table header

				$('#dynamic-table').find('tbody > tr').each(function() {
					var row = this;
					if (th_checked) myTable.row(row).select();
					else myTable.row(row).deselect();
				});
			});

			//select/deselect a row when the checkbox is checked/unchecked
			$('#dynamic-table').on('click', 'td input[type=checkbox]', function() {
				var row = $(this).closest('tr').get(0);
				if (this.checked) myTable.row(row).deselect();
				else myTable.row(row).select();
			});



			$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
				e.stopImmediatePropagation();
				e.stopPropagation();
				e.preventDefault();
			});



			//And for the first simple table, which doesn't have TableTools or dataTables
			//select/deselect all rows according to table header checkbox
			var active_class = 'active';
			$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
				var th_checked = this.checked; //checkbox inside "TH" table header

				$(this).closest('table').find('tbody > tr').each(function() {
					var row = this;
					if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
					else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
				});
			});

			//select/deselect a row when the checkbox is checked/unchecked
			$('#simple-table').on('click', 'td input[type=checkbox]', function() {
				var $row = $(this).closest('tr');
				if ($row.is('.detail-row ')) return;
				if (this.checked) $row.addClass(active_class);
				else $row.removeClass(active_class);
			});



			/********************************/
			//add tooltip for small view action buttons in dropdown menu
			$('[data-rel="tooltip"]').tooltip({
				placement: tooltip_placement
			});

			//tooltip placement on right or left
			function tooltip_placement(context, source) {
				var $source = $(source);
				var $parent = $source.closest('table')
				var off1 = $parent.offset();
				var w1 = $parent.width();

				var off2 = $source.offset();
				//var w2 = $source.width();

				if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
				return 'left';
			}

			$('.show-details-btn').on('click', function(e) {
				e.preventDefault();
				$(this).closest('tr').next().toggleClass('open');
				$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
			});
		})
	</script>
</body>

</html>