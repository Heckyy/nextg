<?php
	class view_type_of_item{
		
		function data_view($db,$e,$code){

			$view=base64_decode($code);
			$view_type_of_item=$db->select('tb_type_of_item','code_type_of_item="'.$view.'"','id_type_of_item','DESC');

			if(mysqli_num_rows($view_type_of_item)>0 && $_SESSION['type_of_item']==1){
				$v=mysqli_fetch_assoc($view_type_of_item);
?>
				<script src="<?php echo $e; ?>/src/type_of_item/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Tipe Baranggggg
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_type_of_item" id="code_type_of_item" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Barang
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="type_of_item" id="type_of_item" class="form-control square" value="<?php echo $v['type_of_item']; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit" disabled><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<?php
									if($_SESSION['type_of_item_new']==1){
								?>
										<a href="<?php echo $e; ?>/type-of-item/new">
											<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
										</a>
								<?php
									}
									if($_SESSION['type_of_item_edit']==1){
								?>
										<a href="<?php echo $e; ?>/type-of-item/edit/<?php echo $code; ?>">
											<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
										</a>
								<?php
									}
								?>
							</div>
						</div>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/type-of-item";
				</script>
<?php
			}
		}

	}
?>