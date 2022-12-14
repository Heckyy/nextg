<?php
class view_house_owner
{

	function data_view($db, $e, $code)
	{

		$view = base64_decode($code);
		$view_population = $db->select('tb_population', 'code_population="' . $view . '"', 'id_population', 'DESC');

		if (mysqli_num_rows($view_population) > 0 && $_SESSION['house_owner'] == 1) {
			$v = mysqli_fetch_assoc($view_population);

			$acak = str_replace("=", "", base64_encode($v['id_population']));

			$rt = $db->select('tb_rt', 'id_cluster="' . $v['id_cluster'] . '"', 'number', 'ASC');
			$cluster = $db->select('tb_cluster', 'id_cluster', 'cluster', 'ASC');

?>
			<script src="<?php echo $e; ?>/src/house_owner/js/js_proses.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					hitung();
				});
			</script>

			<div class="app-card-header p-3 main-content container-fluid">
				<div class="row justify-content-between align-items-center line">
					<div class="col-auto">
						<h6 class="app-card-title">
							House owner
						</h6>
					</div>
				</div>
			</div>

			<div class="app-card-body pb-3 main-content container-fluid">
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Code
					</div>
					<div class="col-sm-3 col-lg-3">
						<input type="text" name="code_population" id="code_population" class="form-control square" value="<?php echo $view; ?>" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Name
					</div>
					<div class="col-sm-2 col-lg-3">
						<input type="text" name="name" id="name" class="form-control square" value="<?php echo $v['name']; ?>" required="required" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						KK
					</div>
					<div class="col-sm-2 col-lg-2">
						<input type="text" name="kk" id="kk" class="form-control square" value="<?php echo $v['kk']; ?>" required="required" disabled="disabled">
					</div>
					<div class="col-sm-2 col-lg-2" align="right">
						KTP/ID
					</div>
					<div class="col-sm-2 col-lg-2">
						<input type="text" name="ktp" id="ktp" class="form-control square" value="<?php echo $v['ktp']; ?>" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Cluster
					</div>
					<div class="col-sm-5 col-lg-5">
						<select id="cluster" name="cluster" class="choices form-select square bg-white" required="required" disabled="disabled">
							<option value="">Select</option>
							<?php
							foreach ($cluster as $key => $b) {
							?>
								<option value="<?php echo $b['id_cluster']; ?>" <?php if ($v['id_cluster'] == $b['id_cluster']) {
																					echo "selected";
																				} ?>><?php echo $b['code_cluster'] . ' - ' . $b['cluster']; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Type
					</div>
					<div class="col-sm-2 col-lg-2">
						<select id="type_property" name="type_property" class="choices form-select square bg-white" required="required" disabled="disabled">
							<option value="1" <?php if ($v['type_property'] == 1) {
													echo "selected";
												} ?>>Rumah</option>
							<option value="2" <?php if ($v['type_property'] == 2) {
													echo "selected";
												} ?>>Kavling</option>
						</select>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						RT
					</div>
					<div class="col-sm-2 col-lg-2">
						<select id="rt" name="rt" class="choices form-select square bg-white" required="required" disabled="disabled">
							<option value="">Select</option>
							<?php
							foreach ($rt as $key => $b) {
							?>
								<option value="<?php echo $b['id_rt']; ?>" <?php if ($v['id_rt'] == $b['id_rt']) {
																				echo "selected";
																			} ?>><?php echo $b['number']; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						House Number
					</div>
					<div class="col-sm-2 col-lg-1">
						<input type="text" name="number" id="number" class="form-control square" value="<?php echo $v['house_number']; ?>" required="required" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Address
					</div>
					<div class="col-sm-5 col-lg-5">
						<textarea name="address" id="address" class="form-control square textarea-edit" required="required" disabled="disabled"><?php echo $v['address']; ?></textarea>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Telp
					</div>
					<div class="col-sm-5 col-lg-5">
						<input type="text" name="telp" id="telp" class="form-control square" value="<?php echo $v['telp']; ?>" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Hp
					</div>
					<div class="col-sm-5 col-lg-5">
						<input type="text" name="hp" id="hp" class="form-control square" value="<?php echo $v['hp']; ?>" disabled="disabled">
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Note
					</div>
					<div class="col-sm-5 col-lg-5">
						<textarea name="note" id="note" class="form-control square textarea-edit" disabled="disabled"><?php echo $v['note']; ?></textarea>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Surface Area
					</div>
					<div class="col-sm-2 col-lg-2">
						<input type="text" name="surface_area" id="surface_area" class="form-control square" value="<?php echo number_format($v['surface_area'], 2, ',', '.'); ?>" disabled="disabled">
					</div>
					<div class="col-sm-2 col-lg-2" align="right">
						House Area
					</div>
					<div class="col-sm-2 col-lg-2">
						<input type="text" name="building_area" id="building_area" class="form-control square" value="<?php echo number_format($v['building_area'], 2, ',', '.'); ?>" disabled="disabled">
					</div>
				</div>
				<div class="col-lg-12" id="hitung"></div>
				<div class="space_line row">
					<div class="col-sm-2 col-lg-2">
						Status
					</div>
					<div class="col-sm-2 col-lg-2">
						<select id="status" name="status" class="choices form-select square bg-white" required="required" disabled="disabled">
							<option value="0" <?php if ($v['status'] == '0') {
													echo "selected";
												} ?>>Active</option>
							<option value="2" <?php if ($v['status'] == '2') {
													echo "selected";
												} ?>>Not Active</option>
						</select>
					</div>
				</div>
				<div class="space_line row">
					<div class="col-lg-12">
						<?php
						if ($_SESSION['house_owner_new'] == 1) {
						?>
							<a href="<?php echo $e; ?>/house-owner/new">
								<button type="button" class="btn btn-sm btn-success btn-custom">New</button>
							</a>
						<?php
						}
						if ($_SESSION['house_owner_edit'] == 1) {
						?>
							<a href="<?php echo $e; ?>/house-owner/edit/<?php echo $code; ?>">
								<button type="button" class="btn btn-sm btn-warning btn-custom">Edit</button>
							</a>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		<?php
		} else {
		?>
			<script type="text/javascript">
				document.location.href = localStorage.getItem('data_link') + "/house-owner";
			</script>
<?php
		}
	}
}
?>