<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA BERITA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Judul Berita <?php echo form_error('judul_berita') ?></td><td><input type="text" class="form-control" name="judul_berita" id="judul_berita" placeholder="Judul Berita" value="<?php echo $judul_berita; ?>" /></td></tr>
	    
        <tr><td width='200'>Isi Berita <?php echo form_error('isi_berita') ?></td><td> <textarea class="form-control" rows="3" name="isi_berita" id="isi_berita" placeholder="Isi Berita"><?php echo $isi_berita; ?></textarea></td></tr>
	    <tr><td width='200'>Tanggal <?php echo form_error('tanggal') ?></td><td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" /></td></tr>
	    <tr><td width='200'>Foto Berita<?php echo form_error('image') ?></td><td> <input type="file" name="image"></td></tr>
        <!-- <tr><td width='200'>Image <?php echo form_error('image') ?></td><td><input type="text" class="form-control" name="image" id="image" placeholder="Image" value="<?php echo $image; ?>" /></td></tr> -->
	    <tr><td></td><td><input type="hidden" name="id_berita" value="<?php echo $id_berita; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('berita') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>