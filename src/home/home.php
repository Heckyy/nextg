<?php
class home
{
    function view_home($db, $e, $library_class, $view, $page)
    {

        $library_class = new library_class();

        $bulan      = $library_class->bulan();
        $tahun      = $library_class->tahun();

        $priod = $tahun . '-' . $bulan;

        $in = 0;
        $out = 0;
        $input = $db->select('tb_cash_receipt_payment', 'tanggal LIKE "%' . $priod . '%" && status="1"', 'id_cash_receipt_payment', 'ASC');
        foreach ($input as $key => $i) {
            if ($i['type'] == 'i') {
                $in = $in + $i['amount'];
            } else {
                $out = $out + $i['amount'];
            }
        }

        $perPage = 10;

        //$result = $db->select_app('tb_report', 'id_report', 'id_report', 'DESC');

        // $totalRecords = mysqli_num_rows($result);
        // $totalPages = ceil($totalRecords / $perPage);
        $totalPages = "";

        $cek_error = "";

        // if ($totalRecords == 0) {
        //     $cek_error = '<tr><td colspan="6">Data not found!</td></tr>';
        // }
?>
        <script src="<?php echo $e; ?>/src/home/js/jsproses.js"></script>
        <div class="app-card-header p-3 main-content container-fluid">
            <div class="row justify-content-between align-items-center line">
                <div class="col-auto">
                    <h6 class="app-card-title">
                        Dashboard
                    </h6>
                </div>
            </div>
        </div>

        <div class="app-card-body pb-3 main-content container-fluid">
            <section class="section">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class='card-heading' align="center">
                                    This Month's Income
                                </h3>
                            </div>
                            <div class="card-body" align="center">
                                <h2>
                                    Rp.<?php echo number_format($in, 2, ',', '.'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" align="center">
                                <h3 class='card-heading'>
                                    This month's release
                                </h3>
                            </div>
                            <div class="card-body" align="center">
                                <h2>
                                    Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="app-card-header p-3 main-content container-fluid" style="display: none;">
                <div class="row justify-content-between align-items-center line">
                    <div class="col-auto">
                        <h6 class="app-card-title">
                            Laporan Warga
                        </h6>
                    </div>
                </div>
            </div>
            <section class="section" style="display: none;">
                <div class="app-card-body pb-3 main-content container-fluid">
                    <div class="scroll">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <td width="50px" align="center">No</td>
                                    <td width="200px">No Tiket</td>
                                    <td width="250px">Date</td>
                                    <td width="200px">Kategori</td>
                                    <td width="250px">Name</td>
                                    <td>Deskripsi</td>
                                    <td>Lokasi</td>
                                    <td width="80px">Status</td>
                                </tr>
                            </thead>
                            <tbody id="data_view"><?php echo $cek_error; ?></tbody>
                        </table>
                    </div>
                </div>

                <input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">

                <div class="row">
                    <div id="pagination"></div>
                </div>
            </section>
        </div>
<?php
    }
}
?>