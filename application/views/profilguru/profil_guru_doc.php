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
        <h2>Profil_guru List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Guru</th>
		<th>Mapel</th>
		<th>Kelas Ajar</th>
		<th>Jabatan</th>
		<th>Image</th>
		
            </tr><?php
            foreach ($profilguru_data as $profilguru)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $profilguru->nama_guru ?></td>
		      <td><?php echo $profilguru->mapel ?></td>
		      <td><?php echo $profilguru->kelas_ajar ?></td>
		      <td><?php echo $profilguru->jabatan ?></td>
		      <td><?php echo $profilguru->image ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>