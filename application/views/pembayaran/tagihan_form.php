<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA </h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>
					<tr>
						<td width='200'>Pelanggan1 <?php echo form_error('id_pelanggan') ?></td>
						<td><select class="form-control" name="id_pelanggan" id="id_pelanggan">
								<option value=''>-- Pilih --</option>
								<?php foreach ($pelanggan as $rows) { ?>
									<?php if ($id_pelanggan == $rows['id_pelanggan']) { ?>
										<option value="<?php echo $rows['id_pelanggan'] ?>" selected><?php echo $rows['cabang'] ?> - <?php echo $rows['nama_pelanggan'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_pelanggan'] ?>"><?php echo $rows['cabang'] ?> - <?php echo $rows['nama_pelanggan'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Bulan <?php echo form_error('bulan') ?></td>
						<td><select class="form-control" name="bulan" id="bulan">
								<option value=''>-- Pilih --</option>
								<?php foreach ($bulan as $rows) { ?>
									<?php if ($bulan == $rows['id_bulan']) { ?>
										<option value="<?php echo $rows['id_bulan'] ?>" selected><?php echo $rows['nama_bulan'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_bulan'] ?>"><?php echo $rows['nama_bulan'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Tahun <?php echo form_error('tahun') ?></td>
						<td><select class="form-control" name="tahun" id="tahun">
								<option value=''>-- Pilih --</option>
								<?php foreach ($tahun as $rows) { ?>
									<?php if ($tahun == $rows['tahun']) { ?>
										<option value="<?php echo $rows['tahun'] ?>" selected><?php echo $rows['tahun'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['tahun'] ?>"><?php echo $rows['tahun'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Diskon <?php echo form_error('diskon') ?></td>
						<td><select class="form-control" name="diskon" id="diskon">
								<option value=''>-- Pilih --</option>
								<option value='0'>Tidak Ada</option>
								<option value='10'>10 %</option>
								<option value='20'>20 %</option>
								<option value='30'>30 %</option>
								<option value='40'>40 %</option>
								<option value='50'>50 %</option>
								<option value='60'>60 %</option>
								<option value='70'>70 %</option>
								<option value='80'>80 %</option>
								<option value='90'>90 %</option>
								<option value='100'>1000 %</option>
							</select>

						</td>
					</tr>
					<tr>
						<td width='200'>Notification</td>
						<td>
							<input type="checkbox" name="kirim" value="1"> Kirim WA
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_tagihan" value="<?php echo $id_tagihan; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('tagihan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>