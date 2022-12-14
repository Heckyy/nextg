<?php
class upload_invoice
{

    function view_upload_invoice($db, $e, $library_class)
    {


        if ($_SESSION['cash_receipt_new'] == 1) {

?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#tanggal_bank").datepicker({
                        dateFormat: "dd-mm-yy",
                        changeMonth: true
                    });
                });
            </script>

            <script src="<?php echo $e; ?>/src/invoice/js/js_upload_proses.js"></script>

            <div class="app-card-header p-3 main-content container-fluid">
                <div class="row justify-content-between align-items-center line">
                    <div class="col-auto">
                        <h6 class="app-card-title">
                            <b id="">Upload Tagihan
                        </h6>
                    </div>
                </div>
            </div>

            <div class="app-card-body pb-3 main-content container-fluid">
                <form method="POST" id="upload" enctype="multipart/form-data">
                    <div class="space_line row">
                        <div class="col-sm-6 col-lg-6">
                            <table class="table">
                                <tr class="bg-white">
                                    <td colspan="2">Unggah (Excel . xlsx)</td>
                                </tr>
                                <tr class="bg-white">
                                    <td>
                                        <input type="text" name="tanggal_bank" id="tanggal_bank" value="" class="form-control square" autocomplete="off">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="bg-white">
                                    <td>
                                        <input type="file" name="file_excel" id="file_excel" class="form-control square bg-white" required="required">
                                    </td>
                                    <td>
                                        <button type="submit" id="btn" class="btn btn-success">
                                            Unggah
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="col-lg-12" id="data_view"></div>
            </div>
        <?php
        } else {
        ?>
            <script type="text/javascript">
                document.location.href = localStorage.getItem('data_link') + "/invoice";
            </script>
<?php
        }
    }
}
?>