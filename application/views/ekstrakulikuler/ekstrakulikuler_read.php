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
        <h2 style="margin-top:0px">Ekstrakulikuler Read</h2>
        <table class="table">
	    <tr><td>Nama Ekstra</td><td><?php echo $nama_ekstra; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td>Image</td><td><img src="<?php echo base_url();?>uploads/ekstrakulikuler/<?php echo $image; ?>" alt="<?php echo $nama_ekstra ?>"width="100px" height="100px"></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('ekstrakulikuler') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
    </div>
        </div>
        </div>
        </div>
</html>