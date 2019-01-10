<!doctype html>
<html>
<div class="content-wrapper">
<section class="content">
<div class="row">
<div class="col-lg-12">
      <div class="box box-warning box-solid">

          <div class="box-header">
              <h3 class="box-title">DATA</h3>
          </div>

<div class="box-body"
        <h2 style="margin-top:0px">Profil_guru Read</h2>
        <table class="table">
	    <tr><td>Nama Guru</td><td><?php echo $nama_guru; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Mapel</td><td><?php echo $mapel; ?></td></tr>
	    <tr><td>Kelas Ajar</td><td><?php echo $kelas_ajar; ?></td></tr>
	    <tr><td>Jabatan</td><td><?php echo $jabatan; ?></td></tr>
	    <tr><td>Image</td><td><img src="<?php echo base_url();?>uploads/guru/<?php echo $image; ?>" alt="<?php echo $nama_guru ?>"width="100px" height="100px"></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('profilguru') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
    </div>
        </div>
        </div>
        </div>
</html>