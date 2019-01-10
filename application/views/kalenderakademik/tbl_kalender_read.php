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

<div class="box-body">
        <h2 style="margin-top:0px">Tbl_kalender Read</h2>
        <table class="table">
	    <tr><td>Nama Kalender</td><td><?php echo $nama_kalender; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td>Id Bulan</td><td><?php echo $id_bulan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kalenderakademik') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
    </div>
        </div>
        </div>
        </div>
</html>