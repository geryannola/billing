<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Kas_masjid List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl Km</th>
		<th>Uraian Km</th>
		<th>Keluar</th>
		
            </tr><?php
            foreach ($kas_masjid_keluar_data as $kas_masjid_keluar)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $kas_masjid_keluar->tgl_km ?></td>
		      <td><?php echo $kas_masjid_keluar->uraian_km ?></td>
<!-- 		      <td><?php echo $kas_masjid_keluar->masuk ?></td> -->
		      <td><?php echo $kas_masjid_keluar->keluar ?></td>
	<!-- 	      <td><?php echo $kas_masjid_keluar->jenis ?></td>	 -->
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>