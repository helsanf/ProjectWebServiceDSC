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
        <h2>Prestasi List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Prestasi</th>
		<th>Tanggal</th>
		<th>Keterangan</th>
		<th>Image</th>
		
            </tr><?php
            foreach ($prestasi_data as $prestasi)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $prestasi->nama_prestasi ?></td>
		      <td><?php echo $prestasi->tanggal ?></td>
		      <td><?php echo $prestasi->keterangan ?></td>
		      <td><?php echo $prestasi->image ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>