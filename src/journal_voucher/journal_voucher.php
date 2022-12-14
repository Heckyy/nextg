<?php
	class journal_voucher{
		
		function view_journal_voucher($db,$e,$library_class,$view,$page){

			if($_SESSION['journal_voucher']==1){


?>
<h1>In Process</h1>

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