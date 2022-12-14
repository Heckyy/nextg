<?php
	class access_employee{
		
		function access_view($db,$e,$code){

			$view=base64_decode($code);
			$employee=$db->select('tb_employee','code_employee="'.$view.'"','id_employee','ASC');

			if(mysqli_num_rows($employee)>0 && $_SESSION['employee_access']==1){
				
				$v=mysqli_fetch_assoc($employee);

				$access=$db->select('tb_access','code_employee="'.$v['code_employee'].'"','id_access','ASC');
				$a=mysqli_fetch_assoc($access);
				$_SESSION['access_code_employee']=$v['code_employee'];
?>

				<script src="<?php echo $e; ?>/src/employee/js/js_proses_access.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Pengurus <b>( <?php echo $v['name']; ?> )</b>
							</h6>
						</div>
					</div>
				</div>

				<div class="app-card-body pb-3 main-content container-fluid">
					<div class="row line">
						<h6>
							<b>Data Pengurus</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Unit</td>
									<td width="50px">
										<input type="checkbox" name="unit" id="unit" value="1" onclick="access('unit')" <?php if($a['unit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="unit_new" id="unit_new" value="1" onclick="access('unit_new')" <?php if($a['unit_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="unit_edit" id="unit_edit" value="1" onclick="access('unit_edit')" <?php if($a['unit_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Posisi</td>
									<td width="50px">
										<input type="checkbox" name="position" id="position" value="1" onclick="access('position')" <?php if($a['position']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="position_new" id="position_new" value="1" onclick="access('position_new')" <?php if($a['position_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="position_edit" id="position_edit" value="1" onclick="access('position_edit')" <?php if($a['position_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Pekerjaan</td>
									<td width="50px">
										<input type="checkbox" name="type_of_work" id="type_of_work" value="1" onclick="access('type_of_work')" <?php if($a['type_of_work']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_work_new" id="type_of_work_new" value="1" onclick="access('type_of_work_new')" <?php if($a['type_of_work_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_work_edit" id="type_of_work_edit" value="1" onclick="access('type_of_work_edit')" <?php if($a['type_of_work_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Pengurus</td>
									<td width="50px">
										<input type="checkbox" name="employee" id="employee" value="1" onclick="access('employee')" <?php if($a['employee']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="employee_new" id="employee_new" value="1" onclick="access('employee_new')" <?php if($a['employee_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="employee_edit" id="employee_edit" value="1" onclick="access('employee_edit')" <?php if($a['employee_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Akses</td>
									<td width="50px">
										<input type="checkbox" name="employee_access" id="employee_access" value="1" onclick="access('employee_access')" <?php if($a['employee_access']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Kordinator</td>
									<td width="50px">
										<input type="checkbox" name="coordinator" id="coordinator" value="1" onclick="access('coordinator')" <?php if($a['coordinator']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="coordinator_new" id="coordinator_new" value="1" onclick="access('coordinator_new')" <?php if($a['coordinator_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="coordinator_edit" id="coordinator_edit" value="1" onclick="access('coordinator_edit')" <?php if($a['coordinator_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Kontraktor</td>
									<td width="50px">
										<input type="checkbox" name="contractor" id="contractor" value="1" onclick="access('contractor')" <?php if($a['contractor']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="contractor_new" id="contractor_new" value="1" onclick="access('contractor_new')" <?php if($a['contractor_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="contractor_edit" id="contractor_edit" value="1" onclick="access('contractor_edit')" <?php if($a['contractor_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

					</div>

					<div class="row line">
						<h6>
							<b>Data Akunting</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Akun</td>
									<td width="50px">
										<input type="checkbox" name="account" id="account" value="1" onclick="access('account')" <?php if($a['account']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="account_new" id="account_new" value="1" onclick="access('account_new')" <?php if($a['account_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="account_edit" id="account_edit" value="1" onclick="access('account_edit')" <?php if($a['account_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Kelompok Akun</td>
									<td width="50px">
										<input type="checkbox" name="group_account" id="group_account" value="1" onclick="access('group_account')" <?php if($a['group_account']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Tipe Akun</td>
									<td width="50px">
										<input type="checkbox" name="type_of_account" id="type_of_account" value="1" onclick="access('type_of_account')" <?php if($a['type_of_account']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Setting Akun</td>
									<td width="50px">
										<input type="checkbox" name="setting_account" id="setting_account" value="1" onclick="access('setting_account')" <?php if($a['setting_account']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Barang</td>
									<td width="50px">
										<input type="checkbox" name="type_of_item" id="type_of_item" value="1" onclick="access('type_of_item')" <?php if($a['type_of_item']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_item_new" id="type_of_item_new" value="1" onclick="access('type_of_item_new')" <?php if($a['type_of_item_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_item_edit" id="type_of_item_edit" value="1" onclick="access('type_of_item_edit')" <?php if($a['type_of_item_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Data Keungan</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Bank / Tunai</td>
									<td width="50px">
										<input type="checkbox" name="bank_cash" id="bank_cash" value="1" onclick="access('bank_cash')" <?php if($a['bank_cash']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="bank_cash_new" id="bank_cash_new" value="1" onclick="access('bank_cash_new')" <?php if($a['bank_cash_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="bank_cash_edit" id="bank_cash_edit" value="1" onclick="access('bank_cash_edit')" <?php if($a['bank_cash_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Pemasukan</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt" id="type_of_receipt" value="1" onclick="access('type_of_receipt')" <?php if($a['type_of_receipt']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt_new" id="type_of_receipt_new" value="1" onclick="access('type_of_receipt_new')" <?php if($a['type_of_receipt_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt_edit" id="type_of_receipt_edit" value="1" onclick="access('type_of_receipt_edit')" <?php if($a['type_of_receipt_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Pembayaran</td>
									<td width="50px">
										<input type="checkbox" name="type_of_payment" id="type_of_payment" value="1" onclick="access('type_of_payment')" <?php if($a['type_of_payment']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_payment_new" id="type_of_payment_new" value="1" onclick="access('type_of_payment_new')" <?php if($a['type_of_payment_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_payment_edit" id="type_of_payment_edit" value="1" onclick="access('type_of_payment_edit')" <?php if($a['type_of_payment_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Data Warga</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>RW</td>
									<td width="50px">
										<input type="checkbox" name="rw" id="rw" value="1" onclick="access('rw')" <?php if($a['rw']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="rw_edit" id="rw_edit" value="1" onclick="access('rw_edit')" <?php if($a['rw_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Data RT</td>
									<td width="50px">
										<input type="checkbox" name="rt" id="rt" value="1" onclick="access('rt')" <?php if($a['rt']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="rt_new" id="rt_new" value="1" onclick="access('rt_new')" <?php if($a['rt_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="rt_edit" id="rt_edit" value="1" onclick="access('rt_edit')" <?php if($a['rt_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Cluster</td>
									<td width="50px">
										<input type="checkbox" name="cluster" id="cluster" value="1" onclick="access('cluster')" <?php if($a['cluster']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="cluster_new" id="cluster_new" value="1" onclick="access('cluster_new')" <?php if($a['cluster_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="cluster_edit" id="cluster_edit" value="1" onclick="access('cluster_edit')" <?php if($a['cluster_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>House owner</td>
									<td width="50px">
										<input type="checkbox" name="house_owner" id="house_owner" value="1" onclick="access('house_owner')" <?php if($a['house_owner']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="house_owner_new" id="house_owner_new" value="1" onclick="access('house_owner_new')" <?php if($a['house_owner_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="house_owner_edit" id="house_owner_edit" value="1" onclick="access('house_owner_edit')" <?php if($a['house_owner_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Warga</td>
									<td width="50px">
										<input type="checkbox" name="population" id="population" value="1" onclick="access('population')" <?php if($a['population']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="population_new" id="population_new" value="1" onclick="access('population_new')" <?php if($a['population_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="population_edit" id="population_edit" value="1" onclick="access('population_edit')" <?php if($a['population_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<!-- <tr>
									<td>Delete</td>
									<td width="50px">
										<input type="checkbox" name="population_delete" id="population_delete" value="1" onclick="access('population_delete')" <?php //if($a['population_delete']=='1'){ echo "checked"; } ?>>
									</td>
								</tr> -->
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Dana Hiba</td>
									<td width="50px">
										<input type="checkbox" name="dues_type" id="dues_type" value="1" onclick="access('dues_type')" <?php if($a['dues_type']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="dues_type_new" id="dues_type_new" value="1" onclick="access('dues_type_new')" <?php if($a['dues_type_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="dues_type_edit" id="dues_type_edit" value="1" onclick="access('dues_type_edit')" <?php if($a['dues_type_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Data Gudang</b>
						</h6>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr style="display: none">
									<td>Warehouse</td>
									<td width="50px">
										<input type="checkbox" name="warehouse" id="warehouse" value="1" onclick="access('warehouse')" <?php if($a['warehouse']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="warehouse_new" id="warehouse_new" value="1" onclick="access('warehouse_new')" <?php if($a['warehouse_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="warehouse_edit" id="warehouse_edit" value="1" onclick="access('warehouse_edit')" <?php if($a['warehouse_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
						
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Item</td>
									<td width="50px">
										<input type="checkbox" name="item" id="item" value="1" onclick="access('item')" <?php if($a['item']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="item_new" id="item_new" value="1" onclick="access('item_new')" <?php if($a['item_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="item_edit" id="item_edit" value="1" onclick="access('item_edit')" <?php if($a['item_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Pemasukan</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt_wh" id="type_of_receipt_wh" value="1" onclick="access('type_of_receipt_wh')" <?php if($a['type_of_receipt_wh']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt_wh_new" id="type_of_receipt_wh_new" value="1" onclick="access('type_of_receipt_wh_new')" <?php if($a['type_of_receipt_wh_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_receipt_wh_edit" id="type_of_receipt_wh_edit" value="1" onclick="access('type_of_receipt_wh_edit')" <?php if($a['type_of_receipt_wh_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Tipe Pengeluaran</td>
									<td width="50px">
										<input type="checkbox" name="type_of_out_wh" id="type_of_out_wh" value="1" onclick="access('type_of_out_wh')" <?php if($a['type_of_out_wh']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="type_of_out_wh_new" id="type_of_out_wh_new" value="1" onclick="access('type_of_out_wh_new')" <?php if($a['type_of_out_wh_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="type_of_out_wh_edit" id="type_of_out_wh_edit" value="1" onclick="access('type_of_out_wh_edit')" <?php if($a['type_of_out_wh_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

					</div>
					
					<div class="row line">
						<h6>
							<b>Warehouse</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Item Receipt</td>
									<td width="50px">
										<input type="checkbox" name="item_receipt" id="item_receipt" value="1" onclick="access('item_receipt')" <?php if($a['item_receipt']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="item_receipt_new" id="item_receipt_new" value="1" onclick="access('item_receipt_new')" <?php if($a['item_receipt_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="item_receipt_edit" id="item_receipt_edit" value="1" onclick="access('item_receipt_edit')" <?php if($a['item_receipt_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="item_receipt_process" id="item_receipt_process" value="1" onclick="access('item_receipt_process')" <?php if($a['item_receipt_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="item_receipt_cancel" id="item_receipt_cancel" value="1" onclick="access('item_receipt_cancel')" <?php if($a['item_receipt_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Item Out</td>
									<td width="50px">
										<input type="checkbox" name="item_out" id="item_out" value="1" onclick="access('item_out')" <?php if($a['item_out']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="item_out_new" id="item_out_new" value="1" onclick="access('item_out_new')" <?php if($a['item_out_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="item_out_edit" id="item_out_edit" value="1" onclick="access('item_out_edit')" <?php if($a['item_out_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="item_out_process" id="item_out_process" value="1" onclick="access('item_out_process')" <?php if($a['item_out_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="item_out_cancel" id="item_out_cancel" value="1" onclick="access('item_out_cancel')" <?php if($a['item_out_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Pembelian</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Permintaan</td>
									<td width="50px">
										<input type="checkbox" name="request" id="request" value="1" onclick="access('request')" <?php if($a['request']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="request_new" id="request_new" value="1" onclick="access('request_new')" <?php if($a['request_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="request_edit" id="request_edit" value="1" onclick="access('request_edit')" <?php if($a['request_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="request_process" id="request_process" value="1" onclick="access('request_process')" <?php if($a['request_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="request_cancel" id="request_cancel" value="1" onclick="access('request_cancel')" <?php if($a['request_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Pembelian</td>
									<td width="50px">
										<input type="checkbox" name="purchasing" id="purchasing" value="1" onclick="access('purchasing')" <?php if($a['purchasing']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="purchasing_new" id="purchasing_new" value="1" onclick="access('purchasing_new')" <?php if($a['purchasing_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="purchasing_edit" id="purchasing_edit" value="1" onclick="access('purchasing_edit')" <?php if($a['purchasing_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="purchasing_process" id="purchasing_process" value="1" onclick="access('purchasing_process')" <?php if($a['purchasing_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="purchasing_cancel" id="purchasing_cancel" value="1" onclick="access('purchasing_cancel')" <?php if($a['purchasing_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Maintenance</td>
									<td width="50px">
										<input type="checkbox" name="maintenance" id="maintenance" value="1" onclick="access('maintenance')" <?php if($a['maintenance']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="maintenance_new" id="maintenance_new" value="1" onclick="access('maintenance_new')" <?php if($a['maintenance_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="maintenance_edit" id="maintenance_edit" value="1" onclick="access('maintenance_edit')" <?php if($a['maintenance_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="maintenance_process" id="maintenance_process" value="1" onclick="access('maintenance_process')" <?php if($a['maintenance_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="maintenance_cancel" id="maintenance_cancel" value="1" onclick="access('maintenance_cancel')" <?php if($a['maintenance_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>PO Maintenance</td>
									<td width="50px">
										<input type="checkbox" name="po_maintenance" id="po_maintenance" value="1" onclick="access('po_maintenance')" <?php if($a['po_maintenance']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="po_maintenance_new" id="po_maintenance_new" value="1" onclick="access('po_maintenance_new')" <?php if($a['po_maintenance_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="po_maintenance_edit" id="po_maintenance_edit" value="1" onclick="access('po_maintenance_edit')" <?php if($a['po_maintenance_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="po_maintenance_process" id="po_maintenance_process" value="1" onclick="access('po_maintenance_process')" <?php if($a['po_maintenance_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="po_maintenance_cancel" id="po_maintenance_cancel" value="1" onclick="access('po_maintenance_cancel')" <?php if($a['po_maintenance_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Keuangan</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Pemasukan</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt" id="cash_receipt" value="1" onclick="access('cash_receipt')" <?php if($a['cash_receipt']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr style="display: none;">
									<td>Pemasukan</td>
									<td width="50px">
										<input type="checkbox" name="receipt_from_population" id="receipt_from_population" value="1" onclick="access('receipt_from_population')" <?php if($a['receipt_from_population']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt_new" id="cash_receipt_new" value="1" onclick="access('cash_receipt_new')" <?php if($a['cash_receipt_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt_edit" id="cash_receipt_edit" value="1" onclick="access('cash_receipt_edit')" <?php if($a['cash_receipt_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt_process" id="cash_receipt_process" value="1" onclick="access('cash_receipt_process')" <?php if($a['cash_receipt_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Diketahui</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt_diketahui" id="cash_receipt_diketahui" value="1" onclick="access('cash_receipt_diketahui')" <?php if($a['cash_receipt_diketahui']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="cash_receipt_cancel" id="cash_receipt_cancel" value="1" onclick="access('cash_receipt_cancel')" <?php if($a['cash_receipt_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Pengeluaran</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment" id="cash_payment" value="1" onclick="access('cash_payment')" <?php if($a['cash_payment']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Pembayaran Pembelian</td>
									<td width="50px">
										<input type="checkbox" name="payment_for_purchasing" id="payment_for_purchasing" value="1" onclick="access('payment_for_purchasing')" <?php if($a['payment_for_purchasing']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Pembayaran Karyawan</td>
									<td width="50px">
										<input type="checkbox" name="payroll" id="payroll" value="1" onclick="access('payroll')" <?php if($a['payroll']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment_new" id="cash_payment_new" value="1" onclick="access('cash_payment_new')" <?php if($a['cash_payment_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment_edit" id="cash_payment_edit" value="1" onclick="access('cash_payment_edit')" <?php if($a['cash_payment_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Proses</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment_process" id="cash_payment_process" value="1" onclick="access('cash_payment_process')" <?php if($a['cash_payment_process']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Diketahui</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment_diketahui" id="cash_payment_diketahui" value="1" onclick="access('cash_payment_diketahui')" <?php if($a['cash_payment_diketahui']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="cash_payment_cancel" id="cash_payment_cancel" value="1" onclick="access('cash_payment_cancel')" <?php if($a['cash_payment_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-4 col-md-4 col-lg-4" style="display: none;">
							<table class="table">
								<tr>
									<td>Tagihan</td>
									<td width="50px">
										<input type="checkbox" name="invoice" id="invoice" value="1" onclick="access('invoice')" <?php if($a['invoice']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>New</td>
									<td width="50px">
										<input type="checkbox" name="invoice_new" id="invoice_new" value="1" onclick="access('invoice_new')" <?php if($a['invoice_new']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Edit</td>
									<td width="50px">
										<input type="checkbox" name="invoice_edit" id="invoice_edit" value="1" onclick="access('invoice_edit')" <?php if($a['invoice_edit']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Simpan</td>
									<td width="50px">
										<input type="checkbox" name="invoice_cancel" id="invoice_cancel" value="1" onclick="access('invoice_cancel')" <?php if($a['invoice_cancel']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<h6>
								<b>Report</b>
							</h6>
							<table class="table">
								<tr>
									<td>Report Finance Balance</td>
									<td width="50px">
										<input type="checkbox" name="report_finance_balance" id="report_finance_balance" value="1" onclick="access('report_finance_balance')" <?php if($a['report_finance_balance']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Report Bank / Cash</td>
									<td width="50px">
										<input type="checkbox" name="report_bank_cash" id="report_bank_cash" value="1" onclick="access('report_bank_cash')" <?php if($a['report_bank_cash']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Report Cash Receipt</td>
									<td width="50px">
										<input type="checkbox" name="report_cash_receipt" id="report_cash_receipt" value="1" onclick="access('report_cash_receipt')" <?php if($a['report_cash_receipt']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Report Cash Payment</td>
									<td width="50px">
										<input type="checkbox" name="report_cash_payment" id="report_cash_payment" value="1" onclick="access('report_cash_payment')" <?php if($a['report_cash_payment']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Akunting</b>
						</h6>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<table class="table">
								<tr>
									<td>Voucher Jurnal</td>
									<td width="50px">
										<input type="checkbox" name="journal_voucher" id="journal_voucher" value="1" onclick="access('journal_voucher')" <?php if($a['journal_voucher']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Tutup Buku</td>
									<td width="50px">
										<input type="checkbox" name="tutup_buku" id="tutup_buku" value="1" onclick="access('tutup_buku')" <?php if($a['tutup_buku']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Pemantauan</b>
						</h6>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<table class="table">
								<tr>
									<td>Pemantauan Pembelian</td>
									<td width="50px">
										<input type="checkbox" name="monitoring_purchasing" id="monitoring_purchasing" value="1" onclick="access('monitoring_purchasing')" <?php if($a['monitoring_purchasing']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="col-sm-6 col-md-6 col-lg-6" style="display: none;">
							<table class="table">
								<tr>
									<td>Pemantauan Tagihan</td>
									<td width="50px">
										<input type="checkbox" name="monitoring_invoice" id="monitoring_invoice" value="1" onclick="access('monitoring_invoice')" <?php if($a['monitoring_invoice']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Laporan</b>
						</h6>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<table class="table">
								<tr>
									<td>Laporan Barang</td>
									<td width="50px">
										<input type="checkbox" name="report_inventory" id="report_inventory" value="1" onclick="access('report_inventory')" <?php if($a['report_inventory']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<table class="table">
								<tr>
									<td>Laporan Saldo Rekening</td>
									<td width="50px">
										<input type="checkbox" name="report_account_balance" id="report_account_balance" value="1" onclick="access('report_account_balance')" <?php if($a['report_account_balance']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Laporan Buku Besar</td>
									<td width="50px">
										<input type="checkbox" name="report_general_ledger" id="report_general_ledger" value="1" onclick="access('report_general_ledger')" <?php if($a['report_general_ledger']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<tr>
									<td>Laporan Neraca Keuangan</td>
									<td width="50px">
										<input type="checkbox" name="report_balance_sheet" id="report_balance_sheet" value="1" onclick="access('report_balance_sheet')" <?php if($a['report_balance_sheet']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
								<!-- <tr>
									<td>Report Income Statement</td>
									<td width="50px">
										<input type="checkbox" name="report_income_statement" id="report_income_statement" value="1" onclick="access('report_income_statement')" <?php //if($a['report_income_statement']=='1'){ echo "checked"; } ?>>
									</td>
								</tr> -->
								<tr>
									<td>Laporan Keuangan</td>
									<td width="50px">
										<input type="checkbox" name="report_cash_flow_statement" id="report_cash_flow_statement" value="1" onclick="access('report_cash_flow_statement')" <?php if($a['report_cash_flow_statement']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row line">
						<h6>
							<b>Settings</b>
						</h6>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<table class="table">
								<tr>
									<td>Settings</td>
									<td width="50px">
										<input type="checkbox" name="settings" id="settings" value="1" onclick="access('settings')" <?php if($a['settings']=='1'){ echo "checked"; } ?>>
									</td>
								</tr>
							</table>
						</div>
					</div>

				</div>

<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/employee";
				</script>
<?php
			}
		}

	}
?>