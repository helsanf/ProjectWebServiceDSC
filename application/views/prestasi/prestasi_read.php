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
        <h2 style="margin-top:0px">Prestasi Read</h2>
        <table class="table">
	    <tr><td>Nama Prestasi</td><td><?php echo $nama_prestasi; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td>Image</td><td><img src="<?php echo base_url();?>uploads/prestasi/<?php echo $image; ?>" alt="<?php echo $nama_prestasi ?>"width="100px" height="100px"></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('prestasi') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
    </div>
        </div>
        </div>
        </div>
</html>