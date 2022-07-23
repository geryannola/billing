<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Kas_masjid Read</h2>
        <table class="table">
	    <tr><td>Tgl Km</td><td><?php echo $tgl_km; ?></td></tr>
	    <tr><td>Uraian Km</td><td><?php echo $uraian_km; ?></td></tr>
	    <tr><td>Masuk</td><td><?php echo $masuk; ?></td></tr>
	    <tr><td>Keluar</td><td><?php echo $keluar; ?></td></tr>
	    <tr><td>Jenis</td><td><?php echo $jenis; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('rekap_kas_masjid') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>