<?php
class tutup_buku
{

	function view_tutup_buku($db, $e, $library_class)
	{
		if ($_SESSION['tutup_buku'] == 1) {
			$thisMonth = date("F - Y");
			$realDate = date("d-m-Y");

			date_default_timezone_set("asia/jakarta");
			$realTime = date('H:i:s');


?>
			<div class="col-auto p-3">
				<h6 class="app-card-title">
					Close Book
				</h6>
			</div>
			<div class="px-3 d-flex">
				<h6 class="mt-1">Period (System)</h6>
				<div class="input ms-3 mt-0" style="width: 100px;">
					<input type="text" class="text-center" value="<?= $thisMonth; ?>" disabled="disabled">
				</div>
			</div>
			<div class="button p-3 d-flex">
				<button class="btn btn-warning">Close Book</button>
				<div class="date-text mt-1 ms-3"><?= $realDate; ?> / <?= $realTime; ?>
				</div>

			<?php
		} else {
			?>
				<script type="text/javascript">
					document.location.href = localStorage.getItem('data_link') + "/error-page";
				</script>
	<?php
		}
	}
}
	?>