<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5>
						<i class="icon fa fa-info"></i> Total Tagihan
					</h5>
					<h2>
						<?php echo 'Rp. ' . number_format($total_tagihan); ?>
					</h2>

				</div>
				<div class="box-header">
					<h3 class="box-title">KELOLA DATA</h3>
				</div>

				<div class="box-body">
					<div class='row'>
						<div class='col-md-9'>
							<div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('tagihan/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
        <?php echo anchor(site_url('tagihan/create_all'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data Sekaligus', 'class="btn btn-danger btn-sm"'); ?>
        <?php echo anchor(site_url('tagihan/notif_all'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Notifikasi Sekaligus', 'class="btn btn-danger btn-sm"'); ?>
		<?php echo anchor(site_url('tagihan/excel'), '<i  class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php echo anchor(site_url('tagihan/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
            </div>
            <div class=' col-md-3'>
								<form action="<?php echo site_url('tagihan/index'); ?>" class="form-inline" method="get">
									<div class="input-group">
										<input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
										<span class="input-group-btn">
											<?php
											if ($q <> '') {
											?>
												<a href="<?php echo site_url('tagihan'); ?>" class="btn btn-sm btn-default">Reset</a>
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
									<th>Nama Pelanggan</th>
									<th>Cabang</th>
									<th>Bulan</th>
									<th>Tahun</th>
									<th>Jumlah Tagihan</th>
									<th>Notif</th>
									<th>Action</th>
								</tr><?php
										foreach ($tagihan_data as $tagihan) {
										?>
									<tr>
										<td width="10px"><?php echo ++$start ?></td>
										<td><?php echo $tagihan->nama_pelanggan ?></td>
										<td><?php echo $tagihan->cabang ?></td>
										<td><?php echo $tagihan->nama_bulan ?></td>
										<td><?php echo $tagihan->tahun ?></td>
										<td><?php echo number_format($tagihan->jml_tagihan) ?></td>
										<td><?php echo $tagihan->notif_kirim ?></td>
										<td style="text-align:center" width="200px">
											<?php
											echo anchor(site_url('tagihan/notif/' . $tagihan->id_tagihan), '<i class="fa fa-bell" aria-hidden="true"></i>', 'class="btn btn-primary btn-sm"');
											echo '  ';
											echo anchor(site_url('tagihan/bayar/' . $tagihan->id_tagihan), '<i class="fa fa-money" aria-hidden="true"></i>', 'class="btn btn-success btn-sm"');
											echo '  ';
											?>
											<a href="tagihan/delete/<?= $tagihan->id_tagihan; ?>" class="btn btn-danger btn-sm" onclick=" return confirm('Apakah Kamu Benar Menghapus')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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