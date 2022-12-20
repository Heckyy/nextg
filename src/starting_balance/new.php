<?php
	class new_inv_purchasing{
		
		function new_view($db,$e,$library_class){
			

			if($_SESSION['purchasing']==1){

				
				$tanggal 	= $library_class->tanggal();
				$bulan 		= $library_class->bulan();
				$tahun 		= $library_class->tahun();
				$date 		= $tahun.'-'.$bulan.'-'.$tanggal;
				$tahun_potong= substr($tahun,2,2);
				$explode_date =explode('-',$date);
				$bulan_potong=$explode_date[0] .'-'. $explode_date[1];
				$tahun= $explode_date[0];
				$tahun_potong = substr($tahun,2,2);
				$cekUrut=$db->select('tb_inv_purchasing','tanggal LIKE "%'.$bulan_potong.'%"','urut','DESC');
				if(mysqli_num_rows($cekUrut)>0)
				{
					$c=mysqli_fetch_assoc($cekUrut);
					$tambah = $c['urut']+1;
					$urut = $tambah;
					$number = 'TGH/'.$explode_date[1].'/'.$tahun_potong.'/'.$tambah;
					$urut = $tambah;
				}else{
					$number = 'TGH/'.$explode_date[1].'/'.$tahun_potong.'/1';
					$urut="1";
				}
				

				$item=$db->select('tb_item','id_item','item','ASC');
				$purchasing=$db->select('tb_purchasing','status="1"','id_purchasing','ASC');
				$query= "SELECT * FROM ";
				$delivery_order=$db->selectAll($query);
				$type_of_item=$db->select('tb_type_of_item','id_type_of_item','type_of_item','ASC');
				$position=$db->select('tb_position','id_position','position','ASC');
				$cluster=$db->select('tb_cluster','id_cluster','cluster','ASC');
				$employee=$db->select('tb_employee','id_employee','name','ASC');

			



?>
				<script src="<?php echo $e; ?>/src/inv_purchasing/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bills From Supplier
							</h6>
						</div>
					</div>
				</div>


				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="new" action="proses.php">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Number
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text" name="number" id="number" class="form-control square" required="required" disabled="disabled" >
							</div>
							<div class="col-sm-2 col-lg-2" align="right">
								Date
							</div>
							
							 <div class="col-sm-2 col-lg-2">
								<input type="date" name="tanggal" id="tanggal"  class="form-control square" required="required"  onchange="pilihTanggal()">
							</div> 
							 
						</div>
			
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Supplier
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="supplier" name="supplier" class="form-control square bg-white supplier" onchange="from_po()">
									<option value="">Select</option>
							       		<?php
							             	foreach ($purchasing as $key => $sp) {
							       		?>

							                    <option name="supplier"   value="<?php echo $sp['supplier'];?>" >
							                    	<?php echo $sp['supplier']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       </select>
							</div>
							
						</div>
						
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Delivery Order
							</div>
							<div class="col-sm-2 col-lg-3">
								<select id="delivery_order" name="delivery_order" class="form-control square bg-white" onchange="from_do()">
									<option value="" >Select</option>
						       			<?php
							             	foreach ($delivery_order as $key => $do) {
							       		?>

							                    <option value="<?php echo $do['number_purchasing']; ?>">
							                    	<?php echo $do['number_purchasing']; ?>
							                    </option>

							           <?php
							           		}
							       		?>
						       </select>
							</div>
						</div>
					
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Invoice
							</div>
							<div class="col-sm-2 col-lg-3">
								<input type="text"  name="keterangan" id="invoice" class="form-control square textarea-edit"></input>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit"></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn-save" class="btn btn-sm btn-success btn-custom ">Save</button>
							</div>
						</div>
					</form>

					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td width="250px">Item</td>
								<td width="200px">Qty</td>
								<td>Price</td>
								<td width="200px">Total</td>
								<td width="150px" align="center">Aksi</td>
							</tr>
						</thead>
						<tbody id="datalist">
							<tr><td colspan="6">Data not found!</td></tr>
						</tbody>
					</table>
				</div>



				<div class="modal fade" id="tambah_barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
						<form method="POST" id="new_barang">
					      <div class="modal-body">
							<div class="space_line row">
								<div class="col-sm-6 col-lg-6">
									Code
								</div>
								<div class="col-sm-6 col-lg-6">
									<input type="text" name="code_item" id="code_item" class="form-control square" required="required" disabled="disabled">
								</div>
							</div>
							<div class="space_line row">
								<div class="col-sm-6 col-lg-6">
									Item
								</div>
								<div class="col-sm-6 col-lg-6">
									<input type="text" name="barang" id="barang" class="form-control square" required="required">
								</div>
							</div>
										
				      </div>
				      <div class="modal-footer">
				        <button type="submit" id="btn_item" class="btn btn-primary" name="save">Save</button>
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				      </div>
					</form>
				    </div>
				  </div>
				</div>

<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/error-page";
				</script>
<?php
			}
		}

	}
?>


