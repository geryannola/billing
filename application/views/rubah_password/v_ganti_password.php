
<div class="box-header with-border">
  <h3 class="box-title">Ubah Password</h3>
</div>
  <form action="<?php echo base_url(); ?>login/submit_ganti_password/<?php echo $this->session->userdata('id_username') ?>" method="post" enctype="multipart/form-data" role="form">
    <div class="box-body">
      <?php if ($this->session->userdata('level')!=1) { ?><!-- KOndisi ketika yang login level nya U ketika rumah password dia harus masukan password lama -->
      <div class="form-group">
        <label for="password">Password Lama</label>
        <input id="password" class="form-control" name="lama" type="password" placeholder="Password Lama">
      </div>
      <?php } else { ?>
      <?php }?>
      <div class="form-group">
        <label for="password">Password Baru</label>
        <input id="password" class="form-control" name="password" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Minimal 6 Karakter' : ''); if(this.checkValidity()) form.passcon.pattern = this.value;" placeholder="Password Baru" required>
      </div>
      <div class="form-group">
        <label for="passcon">Confimasi Password Baru</label>
        <input class="form-control" id="passcon" name="passcon" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Masukkan Password Yang Sama' : '');" placeholder="Verify Password" required>
      </div>
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-success nilai "  name="submit" value="Update Password" onClick="javascript: return confirm('Are you sure to Update Password');" title="Delete" onclick="return confirm('apakah anda yakin data ber id=<?php //ubah ?> ingin dihapus ?')">
    </div>
  </form>