<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PRESTASI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Prestasi <?php echo form_error('nama_prestasi') ?></td><td><input type="text" class="form-control" name="nama_prestasi" id="nama_prestasi" placeholder="Nama Prestasi" value="<?php echo $nama_prestasi; ?>" /></td></tr>
	    <tr><td width='200'>Tanggal <?php echo form_error('tanggal') ?></td><td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" /></td></tr>
	    
        <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td> <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea></td></tr>
	    <tr><td width='200'>Foto Berita<?php echo form_error('image') ?></td><td> <input type="file" name="image"></td></tr>
        <!-- <tr><td width='200'>Image <?php echo form_error('image') ?></td><td><input type="text" class="form-control" name="image" id="image" placeholder="Image" value="<?php echo $image; ?>" /></td></tr> -->
	    <tr><td></td><td><input type="hidden" name="id_prestasi" value="<?php echo $id_prestasi; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('prestasi') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>