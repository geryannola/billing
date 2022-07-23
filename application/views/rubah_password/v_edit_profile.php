
      <div class="box-header with-border">
        <h3 class="box-title">Edit Profile</h3>
      </div>
      <style type="text/css">
      .warna{color: #FF0000;}
      </style>
        <form action="<?php echo base_url() ?>login/update_edit_profile/<?php echo $this->session->userdata('id_username') ?>" method="post" enctype="multipart/form-data" role="form">
          <div class="box-body">
                <div class="form-group">
                   <input type="hidden" name="id_username" value="<?php echo $data_user['id_username'] ?>">
                  <label for="exampleInputEmail1">Username</label>
                  <input readonly="" type="text" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['username']?>" >
                <div class="warna"><?php echo form_error('username');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Lengkap</label>
                  <input  type="text" name="nama" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['nama']?>" >
                <div class="warna"><?php echo form_error('nama');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input  type="text" name="email" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['email']?>" >
                <div class="warna"><?php echo form_error('email');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Alamat</label>
                  <input  type="text" name="alamat" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['alamat']?>" >
                <div class="warna"><?php echo form_error('alamat');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kota</label>
                  <input  type="text" name="kota" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['kota']?>" >
                <div class="warna"><?php echo form_error('kota');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Provinsi</label>
                  <input  type="text" name="provinsi" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['provinsi']?>" >
                <div class="warna"><?php echo form_error('provinsi');?></div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Telepon</label>
                  <input  type="number" name="telepon" class="form-control" id="exampleInputtext1" placeholder="" required="" value="<?= $data_user['telepon']?>" >
                <div class="warna"><?php echo form_error('telepon');?></div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-success btn"><i class="fa fa-paper-plane"></i>Save</button>
              </div>
            </form>
