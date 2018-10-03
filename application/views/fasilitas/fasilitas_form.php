<div class="content-wrapper">
	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA FASILITAS</h3>
			</div>
			<form action="
				<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<table class='table table-bordered'>    

	    
					<tr>
						<td width='200'>Nama Fasilitas 
							<?php echo form_error('nama_fasilitas') ?>
						</td>
						<td>
							<input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" placeholder="Nama Fasilitas" value="<?php echo $nama_fasilitas; ?>" />
                                
							</td>
						</tr>
                        <tr>
						<td width='200'>Upload Gambar 
							
						</td>
						<td>
							<input type="file" class="form-control" name="userFiles[]" multiple require/>
                                
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="hidden" name="id_fasilitas" value="<?php echo $id_fasilitas; ?>" />
									<button type="submit" class="btn btn-danger">
										<i class="fa fa-floppy-o"></i>
										<?php echo $button ?>
									</button>
									<a href="<?php echo site_url('fasilitas') ?>" class="btn btn-info">
										<i class="fa fa-sign-out"></i> Kembali
									</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>