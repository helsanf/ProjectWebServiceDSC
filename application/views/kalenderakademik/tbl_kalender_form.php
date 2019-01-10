<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA TBL_KALENDER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Kalender <?php echo form_error('nama_kalender') ?></td><td><input type="text" class="form-control" name="nama_kalender" id="nama_kalender" placeholder="Nama Kalender" value="<?php echo $nama_kalender; ?>" /></td></tr>
	    <tr><td width='200'>Tanggal <?php echo form_error('tanggal') ?></td><td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" /></td></tr>

		 <tr>
			<td width='200'> Pilih Bulan
			</td>
			<td><select class="form-control" name="bulan" id="bulan" required>
			<option value="">--PILIH BULAN--</option>
			<?php
				foreach($bulan as $get){ ?>
					<option value="<?php echo $get->id_bulan ?>" <?php echo $id_bulan == $get->id_bulan? "selected" : "" ?>> <?php echo $get->nama_bulan ?> </option>
				<?php } ?>
			</select>

		</tr>

	    <!-- <tr><td width='200'>Id Bulan <?php echo form_error('id_bulan') ?></td><td><input type="text" class="form-control" name="id_bulan" id="id_bulan" placeholder="Id Bulan" value="<?php echo $id_bulan; ?>" /></td></tr> -->
	    <tr><td></td><td><input type="hidden" name="id_kalender" value="<?php echo $id_kalender; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('kalenderakademik') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>