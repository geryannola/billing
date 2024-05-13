<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning box-solid">

					<div class="box-header">
						<h3 class="box-title">DATA HOSTPOT AKTIF</h3>
					</div>

					<div class="box-body">
						<div class='row'>
							<div class='col-md-9'>
								<div style="padding-bottom: 10px;"'>
        <!-- <?php echo anchor(site_url('mikrotik/hostpot/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?> -->
		<!-- <?php echo anchor(site_url('mikrotik/hostpot/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?> -->
	</div>
            </div>
            <div class=' col-md-3'>
									<form action="<?php echo site_url('mikrotik/hostpot/index'); ?>" class="form-inline" method="get">
										<div class="input-group">
											<input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
											<span class="input-group-btn">
												<?php
												if ($q <> '') {
												?>
													<a href="<?php echo site_url('mikrotik/hostpot'); ?>" class="btn btn-sm btn-default">Reset</a>
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
										<th>Server</th>
										<th>user</th>
										<th>Address</th>
										<th>Login By</th>
										<th>bytesIn</th>
										<th>bytesOut</th>
										<th>Comment</th>
										<th>Action</th>
									</tr>
									<?php
									foreach ($hostpot_data as $aktif) {
										$id = str_replace(
											"*",
											'',
											$aktif['.id']
										);
										$bytes_in = round($aktif['bytes-in'] / pow(2, 20), 1);
										$bytes_out = round($aktif['bytes-out'] / pow(2, 20), 1);
										// var_dump($aktif['comment']);

										// if ($aktif['comment'] == NULL) {
										// 	$comment = "-";
										// } else {
										// $comment = $aktif['comment'];
										// }
									?>
										<tr>
											<td width="10px"><?php echo ++$start ?></td>
											<td><?php echo $aktif['server'] ?></td>
											<td><?php echo $aktif['user'] ?></td>
											<td><?php echo $aktif['address'] ?></td>
											<td><?php echo $aktif['login-by'] ?></td>
											<td><?php echo $bytes_in ?> MiB</td>
											<td><?php echo $bytes_out ?> MiB</td>
											<td><?php echo isset($aktif['comment']) ? $aktif['comment'] : ''; ?></td>
											<td style="text-align:center" width="200px">
												<?php
												// echo anchor(site_url('mikrotik/hostpot/read/' . $aktif->id_hostpot), '<i class="fa fa-refresh" aria-hidden="true"></i>', 'class="btn btn-success btn-sm"');
												// echo '  ';
												// echo anchor(site_url('mikrotik/hostpot/update/' . $aktif->id_hostpot), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-primary btn-sm"');
												echo '  ';
												?>
												<a href="deleteAktif/<?= $id; ?>" class="btn btn-danger btn-sm" onclick=" return confirm('Apakah Kamu Benar Menghapus')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
									<?php
									}
									?>
								</table>
								<div class="row">
									<div class="col-md-6">

									</div>
									<!-- <div class="col-md-6 text-right">
										<?php echo $pagination ?>
									</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
	</section>
</div>