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
        <h2 style="margin-top:0px">Berita Read</h2>
        <table class="table">
	    <tr><td>Judul Berita</td><td><?php echo $judul_berita; ?></td></tr>
	    <tr><td>Isi Berita</td><td><?php echo $isi_berita; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td>Image</td><td><?php echo $image; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('berita') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>