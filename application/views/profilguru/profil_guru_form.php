<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PROFIL_GURU</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Guru <?php echo form_error('nama_guru') ?></td><td><input type="text" class="form-control" name="nama_guru" id="nama_guru" placeholder="Nama Guru" value="<?php echo $nama_guru; ?>" /></td></tr>
	    <tr><td width='200'>Email <?php echo form_error('email') ?></td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" /></td></tr>
	    <tr><td width='200'>Mapel <?php echo form_error('mapel') ?></td><td><input type="text" class="form-control" name="mapel" id="mapel" placeholder="Mapel" value="<?php echo $mapel; ?>" /></td></tr>
	    <tr><td width='200'>Kelas Ajar <?php echo form_error('kelas_ajar') ?></td><td><input type="text" class="form-control" name="kelas_ajar" id="kelas_ajar" placeholder="Kelas Ajar" value="<?php echo $kelas_ajar; ?>" /></td></tr>
	    <tr><td width='200'>Jabatan <?php echo form_error('jabatan') ?></td><td><input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php echo $jabatan; ?>" /></td></tr>
	    <tr><td width='200'>Image <?php echo form_error('image') ?></td><td><input type="file" class="form-control" name="image" id="image" placeholder="Image" value="<?php echo $image; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_guru" value="<?php echo $id_guru; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('profilguru') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>