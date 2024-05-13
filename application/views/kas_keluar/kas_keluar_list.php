<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5>
						<i class="icon fa fa-info"></i> Total Pengeluaran
					</h5>

					<h2>
						<?php echo 'Rp. ' . number_format($total_keluar); ?>
					</h2>
				</div>
				<div class="box-header">
					<h3 class="box-title">KELOLA DATA KAS</h3>
				</div>

				<div class="box-body">
					<div class='row'>
						<div class='col-md-9'>
							<div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('kas_keluar/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('kas_keluar/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php echo anchor(site_url('kas_keluar/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
            </div>
            <div class=' col-md-3'>
								<form action="<?php echo site_url('kas_keluar/index'); ?>" class="form-inline" method="get">
									<div class="input-group">
										<input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
										<span class="input-group-btn">
											<?php
											if ($q <> '') {
											?>
												<a href="<?php echo site_url('kas_keluar'); ?>" class="btn btn-sm btn-default">Reset</a>
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
									<th>Tgl Km</th>
									<th>Uraian Pengeluaran</th>
									<th>Keluar</th>
									<th>Cara Bayar</th>
									<th>Action</th>
								</tr><?php
										foreach ($kas_keluar_data as $kas_keluar) {
										?>
									<tr>
										<td width="10px"><?php echo ++$start ?></td>
										<td><?php echo $kas_keluar->tgl_km ?></td>
										<td><?php echo $kas_keluar->uraian_km ?></td>
										<td><?php echo number_format($kas_keluar->keluar) ?></td>
										<td><?php echo $kas_keluar->cara_bayar ?></td>
										<td style="text-align:center" width="200px">
											<?php
											echo anchor(site_url('kas_keluar/read/' . $kas_keluar->id_km), '<i class="fa fa-eye" aria-hidden="true"></i>', 'class="btn btn-success btn-sm"');
											echo '  ';
											echo anchor(site_url('kas_keluar/update/' . $kas_keluar->id_km), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-primary btn-sm"');
											echo '  ';
											?>
											<a href="kas_keluar/delete/<?= $kas_keluar->id_km; ?>" class="btn btn-danger btn-sm" onclick=" return confirm('Apakah Kamu Benar Menghapus')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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