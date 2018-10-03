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
        <h2 style="margin-top:0px">Profil_guru Read</h2>
        <table class="table">
	    <tr><td>Nama Guru</td><td><?php echo $nama_guru; ?></td></tr>
	    <tr><td>Mapel</td><td><?php echo $mapel; ?></td></tr>
	    <tr><td>Kelas Ajar</td><td><?php echo $kelas_ajar; ?></td></tr>
	    <tr><td>Jabatan</td><td><?php echo $jabatan; ?></td></tr>
	    <tr><td>Image</td><td><?php echo $image; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('profilguru') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>