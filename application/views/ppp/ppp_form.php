<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA</h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>
					<tr>
						<td width='200'>Nama <?php echo form_error('name') ?></td>
						<td><input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="<?php echo $name; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Password <?php echo form_error('password') ?></td>
						<td><input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" /></td>
					</tr>
					<!-- <tr>
						<td width='200'>Comment <?php echo form_error('comment') ?></td>
						<td><input type="text" class="form-control" name="comment" id="comment" placeholder="Comment" value="<?php echo $comment; ?>" /></td>
					</tr> -->
					<tr>
						<td width='200'>Profile <?php echo form_error('profile') ?></td>
						<td><select class="form-control" name="profile" id="profile">
								<option value=''>-- Pilih --</option>
								<?php foreach ($profile_data as $rows) { ?>
									<?php if ($profile == $rows['name']) { ?>
										<option value="<?php echo $rows['name'] ?>" selected><?php echo $rows['name'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['name'] ?>"><?php echo $rows['name'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Status User <?php echo form_error('is_aktive') ?></td>
						<td>
							<select class="form-control" name="is_aktive">
								<?php $is_aktive = $data_ppp['is_aktive'] ?>
								<?php if ($is_aktive == 1) { ?>
									<option value="1" selected>Aktive</option>
									<option value="2">Non Aktive</option>
								<?php } else if ($is_aktive == 2) { ?>
									<option value="1">Aktive</option>
									<option value="2" selected>Non Aktive</option>
								<?php } else { ?>
									<option value="">-- Pilih --</option>
									<option value="1">Aktive</option>
									<option value="2">Non Aktive</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_ppp" value="<?php echo $id_ppp; ?>" />
							<input type="hidden" name="id_mikrotik" value="<?php echo $id_mikrotik; ?>" />
							<input type="hidden" name="id" value="<?php echo $id; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('mikrotik/ppp') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>