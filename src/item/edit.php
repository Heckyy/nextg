<?php
	class edit_item{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_item=$db->select('tb_item','code_item="'.$view.'"','id_item','DESC');

			$type_of_item=$db->select('tb_type_of_item','id_type_of_item','type_of_item','ASC');
			
			if(mysqli_num_rows($view_item)>0 && $_SESSION['item_edit']==1){
				$v=mysqli_fetch_assoc($view_item);
?>
				<script src="<?php echo $e; ?>/src/item/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Barang
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_item" id="code_item" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Item
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="item" id="item" class="form-control square" value="<?php echo $v['item']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Tipe Barang
							</div>
							<div class="col-sm-2 col-lg-2">
								<select id="type_of_item" name="type_of_item" class="choices form-select square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($type_of_item as $key => $t) {
									?>
											<option value="<?php echo $t['id_type_of_item']; ?>" <?php if($v['type_of_item']==$t['id_type_of_item']){ echo "selected"; } ?>><?php echo $t['type_of_item']; ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					</form>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/item";
				</script>
<?php
			}
		}

	}
?>