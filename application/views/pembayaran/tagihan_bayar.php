<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA </h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>
					<tr>
						<td width='200'>Nama Pelanggan</td>
						<td><?php echo $nama_pelanggan; ?></td>
					</tr>
					<tr>
						<td width='200'>Bulan</td>
						<td><?php echo $nama_bulan; ?></td>
					</tr>
					<tr>
						<td width='200'>Tahun</td>
						<td><?php echo $tahun; ?></td>
					</tr>
					<tr>
						<td width='200'>Jumlah Tagihan</td>
						<td><?php echo number_format($harga_paket); ?></td>
					</tr>
					<tr>
						<td width='200'>Tgl Mulai <?php echo form_error('tgl_bayar') ?></td>
						<td><input type="date" class="form-control" name="tgl_bayar" id="tgl_bayar" placeholder="Tanggal Bayar" value="<?php echo $tgl_bayar; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Cara Bayar <?php echo form_error('id_cara_bayar') ?></td>
						<td><select class="form-control" name="id_cara_bayar" id="id_cara_bayar">
								<option value=''>-- Pilih --</option>
								<?php foreach ($cara_bayar as $rows) { ?>
									<?php if ($cara_bayar == $rows['id_cara_bayar']) { ?>
										<option value="<?php echo $rows['id_cara_bayar'] ?>" selected><?php echo $rows['cara_bayar'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_cara_bayar'] ?>"><?php echo $rows['cara_bayar'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_tagihan" value="<?php echo $id_tagihan; ?>" />
							<input type="hidden" name="nama_bulan" value="<?php echo $nama_bulan; ?>" />
							<input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
							<input type="hidden" name="nama_pelanggan" value="<?php echo $nama_pelanggan; ?>" />
							<input type="hidden" name="no_wa" value="<?php echo $no_wa; ?>" />
							<input type="hidden" name="harga_paket" value="<?php echo $harga_paket; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('tagihan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>