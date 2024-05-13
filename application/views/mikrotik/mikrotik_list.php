<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning box-solid">

					<div class="box-header">
						<h3 class="box-title">KELOLA DATA MIKROTIK</h3>
					</div>

					<div class="box-body">
						<div class='row'>
							<div class='col-md-9'>
								<div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('mikrotik/mikrotik/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('mikrotik/mikrotik/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?></div>
            </div>
            <div class=' col-md-3'>
									<form action="<?php echo site_url('mikrotik/index'); ?>" class="form-inline" method="get">
										<div class="input-group">
											<input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
											<span class="input-group-btn">
												<?php
												if ($q <> '') {
												?>
													<a href="<?php echo site_url('mikrotik'); ?>" class="btn btn-sm btn-default">Reset</a>
												<?php
												}
												?>
												<button class="btn btn-sm btn-primary" type="submit">Search</button>
											</span>
										</div>
									</form>
								</div>
							</div>


							<div class="row" style="margin-bottom: 10px">
								<div class="col-md-4 text-center">
									<div style="margin-top: 8px" id="message">
										<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
									</div>
								</div>
								<div class="col-md-1 text-right">
								</div>
								<div class="col-md-3 text-right">

								</div>
							</div>
							<div class="box-body" style="overflow-x: scroll; ">
								<table class="table table-bordered" style="margin-bottom: 10px">
									<tr>
										<th>No</th>
										<th>Nama</th>
										<th>IP</th>
										<th>Connect</th>
										<th>Status Aktive</th>
										<th>Action</th>
									</tr><?php
											foreach ($mikrotik_data as $mikrotik) {
												// Konfigurasi koneksi ke MikroTik
												$host = $mikrotik->ip_mikrotik; // Ganti dengan alamat IP MikroTik Anda
												$username = $mikrotik->user_mikrotik; // Ganti dengan username Anda
												$password = $mikrotik->pass_mikrotik; // Ganti dengan password Anda
												$API = new Mikweb();

												if ($API->connect($host, $username, $password)) {
													$status = "Connected";
												} else {
													$status = "Disconnected";
												}

											?>
										<tr>
											<td width="10px"><?php echo ++$start ?></td>
											<td><?php echo $mikrotik->mikrotik ?></td>
											<td><?php echo $mikrotik->ip_mikrotik ?></td>
											<td><?php echo $status ?></td>
											<?php if ($mikrotik->is_aktive == 1) { ?>
												<td>Aktive</td>
											<?php } else { ?>
												<td>Non Aktive </td>
											<?php } ?>
											<td style="text-align:center" width="200px">
												<?php
												if ($mikrotik->is_aktive == 2) {
													echo anchor(site_url('mikrotik/mikrotik/is_aktif/' . $mikrotik->id_mikrotik), '<i class="fa fa-check-square" aria-hidden="true"></i>', 'class="btn btn-warning btn-sm" Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
												}
												echo anchor(site_url('mikrotik/mikrotik/read/' . $mikrotik->id_mikrotik), '<i class="fa fa-refresh" aria-hidden="true"></i>', 'class="btn btn-success btn-sm"');
												echo '  ';
												echo anchor(site_url('mikrotik/mikrotik/update/' . $mikrotik->id_mikrotik), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-primary btn-sm"');
												echo '  ';
												?>
												<a href="mikrotik/delete/<?= $mikrotik->id_mikrotik; ?>" class="btn btn-danger btn-sm" onclick=" return confirm('Apakah Kamu Benar Menghapus')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
									<?php
											}
									?>
								</table>
								<div class="row">
									<div class="col-md-6">

									</div>
									<div class="col-md-6 text-right">
										<?php echo $pagination ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	</section>
</div>