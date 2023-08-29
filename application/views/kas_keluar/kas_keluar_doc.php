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
            <th>Tgl Km</th>
            <th>Uraian Km</th>
            <th>Keluar</th>
            <th>Cara Bayar</th>

        </tr><?php
                foreach ($kas_keluar_data as $kas_keluar) {
                ?>
            <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $kas_keluar->tgl_km ?></td>
                <td><?php echo $kas_keluar->uraian_km ?></td>
                <td><?php echo $kas_keluar->keluar ?></td>
                <td><?php echo $kas_keluar->cara_bayar ?></td>
            </tr>
        <?php
                }
        ?>
    </table>
</body>

</html>