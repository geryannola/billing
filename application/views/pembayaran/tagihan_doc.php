<!doctype html>
<html>

<head>
    <title>BILLING ABhostpot</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" />
    <style>
        .word-table {
            border: 1px solid black !important;
            border-collapse: collapse !important;
            width: 100%;
        }

        .word-table tr th,
        .word-table tr td {
            border: 1px solid black !important;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <h2>Kas List</h2>
    <table class="word-table" style="margin-bottom: 10px">
        <tr>
            <th>No</th>
            <th>Nama Cabang</th>
            <th>Nama Pelanggan</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Jumlah</th>
        </tr><?php
                foreach ($kas_data as $kas) {
                ?>
            <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $kas->cabang ?></td>
                <td><?php echo $kas->nama_pelanggan ?></td>
                <td><?php echo $kas->bulan ?></td>
                <td><?php echo $kas->tahun ?></td>
                <td><?php echo $kas->jml_tagihan ?></td>
            </tr>
        <?php
                }
        ?>
    </table>
</body>

</html>