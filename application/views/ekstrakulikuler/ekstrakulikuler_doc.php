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
        <h2>Ekstrakulikuler List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Ekstra</th>
		<th>Keterangan</th>
		<th>Image</th>
		
            </tr><?php
            foreach ($ekstrakulikuler_data as $ekstrakulikuler)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $ekstrakulikuler->nama_ekstra ?></td>
		      <td><?php echo $ekstrakulikuler->keterangan ?></td>
		      <td><?php echo $ekstrakulikuler->image ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>