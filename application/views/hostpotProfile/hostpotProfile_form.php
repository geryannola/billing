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
						<td><input type="text" class="form-control" name="name" id="name" placeholder="Nama Profile Hostpot" value="<?php echo $name; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Shared User <?php echo form_error('shared_users') ?></td>
						<td><input type="number" class="form-control" name="shared_users" id="shared_users" placeholder="Shared User" value="<?php echo $shared_users; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Rate Limit <?php echo form_error('rate_limit') ?></td>
						<td><input type="text" class="form-control" name="rate_limit" id="rate_limit" placeholder="Rate Limit" value="<?php echo $rate_limit; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Parent Queue <?php echo form_error('parent_queue') ?></td>
						<td><select class="form-control" name="parent_queue" id="parent_queue">
								<option value=''>-- Pilih --</option>
								<?php foreach ($parent_queue as $rows) { ?>
									<?php if ($parent_queue == $rows['parent_queue']) { ?>
										<option value="<?php echo $rows['parent_queue'] ?>" selected><?php echo $rows['parent_queue'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['parent_queue'] ?>"><?php echo $rows['parent_queue'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Status Profile <?php echo form_error('is_aktive') ?></td>
						<td>
							<select class="form-control" name="is_aktive">
								<?php $is_aktive = $data_cabang['is_aktive'] ?>
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
						<td><input type="hidden" name="id_profile_hostpot" value="<?php echo $id_profile_hostpot; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('mikrotik/hostpotProfile') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>