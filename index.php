<?php
// error_reporting(0);
session_start();

include_once("core/file/function_proses.php");
include_once("core/file/library.php");
include_once("core/settings/settings.php");
include_once("core/settings/all_file.php");
include_once("src/themes/media.php");

$themes = new themes();
$db = new db();
$settings = new settings();
$all_file = new all_file();
$library_class = new library_class();

$e = mysqli_fetch_assoc($db->select('tb_settings', 'id_settings', 'id_settings', 'DESC'));

$link       = "";
$title      = "";
$body       = 'auth';
$session    = "";
$hal        = "home";
$get        = "";
$view       = "";
$page       = "";

if (!empty($e['link'])) {
    $link = $e['link'];
}
if (!empty($e['title'])) {
    $title = $e['title'];
}
if (!empty($_SESSION['id_employee'])) {
    $session = $_SESSION['id_employee'];
    $body = 'app';
}
if (!empty($_GET['hal'])) {
    $hal = mysqli_real_escape_string($db->query, str_replace('-', '_', $_GET['hal']));
}
if (!empty($_GET['view'])) {
    $view = mysqli_real_escape_string($db->query, $_GET['view']);
}
if (!empty($_GET['get'])) {
    $get = mysqli_real_escape_string($db->query, $_GET['get']);
}
if (!empty($_GET['page'])) {
    $page = mysqli_real_escape_string($db->query, $_GET['page']);
}

if (!empty($_SESSION['code_employee'])) {

    //get access from db
    $access = $db->select('tb_access', 'code_employee="' . $_SESSION['code_employee'] . '"', 'id_access', 'DESC');
    $acs = mysqli_fetch_assoc($access);
    // var_dump($acs);
    //var_dump($_SESSION);

    // Get Name Employee



    //setting session for grant access validation in each module
    $_SESSION['settings']   = $acs['settings'];
    $_SESSION['unit']       = $acs['unit'];
    $_SESSION['unit_new']   = $acs['unit_new'];
    $_SESSION['unit_edit']  = $acs['unit_edit'];
    $_SESSION['position']   = $acs['position'];
    $_SESSION['position_new']   = $acs['position_new'];
    $_SESSION['position_edit']  = $acs['position_edit'];
    $_SESSION['type_of_work']   = $acs['type_of_work'];
    $_SESSION['type_of_work_new']   = $acs['type_of_work_new'];
    $_SESSION['type_of_work_edit']  = $acs['type_of_work_edit'];
    $_SESSION['employee']   = $acs['employee'];
    $_SESSION['employee_new']   = $acs['employee_new'];
    $_SESSION['employee_edit']  = $acs['employee_edit'];
    $_SESSION['coordinator']    = $acs['coordinator'];
    $_SESSION['coordinator_new']    = $acs['coordinator_new'];
    $_SESSION['coordinator_edit']   = $acs['coordinator_edit'];
    $_SESSION['employee_access']    = $acs['employee_access'];
    $_SESSION['contractor'] = $acs['contractor'];
    $_SESSION['contractor_new'] = $acs['contractor_new'];
    $_SESSION['contractor_edit']    = $acs['contractor_edit'];
    $_SESSION['account']    = $acs['account'];
    $_SESSION['account_new']    = $acs['account_new'];
    $_SESSION['account_edit']   = $acs['account_edit'];
    $_SESSION['group_account']  = $acs['group_account'];
    $_SESSION['type_of_account']    = $acs['type_of_account'];
    $_SESSION['setting_account']    = $acs['setting_account'];
    $_SESSION['type_of_item']   = $acs['type_of_item'];
    $_SESSION['type_of_item_new']   = $acs['type_of_item_new'];
    $_SESSION['type_of_item_edit']  = $acs['type_of_item_edit'];
    $_SESSION['bank_cash']  = $acs['bank_cash'];
    $_SESSION['bank_cash_new']  = $acs['bank_cash_new'];
    $_SESSION['bank_cash_edit'] = $acs['bank_cash_edit'];
    $_SESSION['type_of_receipt']    = $acs['type_of_receipt'];
    $_SESSION['type_of_receipt_new']    = $acs['type_of_receipt_new'];
    $_SESSION['type_of_receipt_edit']   = $acs['type_of_receipt_edit'];
    $_SESSION['type_of_payment']    = $acs['type_of_payment'];
    $_SESSION['type_of_payment_new']    = $acs['type_of_payment_new'];
    $_SESSION['type_of_payment_edit']   = $acs['type_of_payment_edit'];
    $_SESSION['rw'] = $acs['rw'];
    $_SESSION['rw_edit']    = $acs['rw_edit'];
    $_SESSION['rt'] = $acs['rt'];
    $_SESSION['rt_new'] = $acs['rt_new'];
    $_SESSION['rt_edit']    = $acs['rt_edit'];
    $_SESSION['cluster']    = $acs['cluster'];
    $_SESSION['cluster_new']    = $acs['cluster_new'];
    $_SESSION['cluster_edit']   = $acs['cluster_edit'];
    $_SESSION['population'] = $acs['population'];
    $_SESSION['population_new'] = $acs['population_new'];
    $_SESSION['population_edit']    = $acs['population_edit'];
    $_SESSION['population_delete']  = $acs['population_delete'];
    $_SESSION['house_owner']    = $acs['house_owner'];
    $_SESSION['house_owner_new']    = $acs['house_owner_new'];
    $_SESSION['house_owner_edit']   = $acs['house_owner_edit'];
    $_SESSION['dues_type']  = $acs['dues_type'];
    $_SESSION['dues_type_new']  = $acs['dues_type_new'];
    $_SESSION['dues_type_edit'] = $acs['dues_type_edit'];
    $_SESSION['house_size'] = $acs['house_size'];
    $_SESSION['house_size_new'] = $acs['house_size_new'];
    $_SESSION['house_size_edit']    = $acs['house_size_edit'];
    $_SESSION['type_of_purchase']   = $acs['type_of_purchase'];
    $_SESSION['type_of_purchase_new']   = $acs['type_of_purchase_new'];
    $_SESSION['type_of_purchase_edit']  = $acs['type_of_purchase_edit'];
    $_SESSION['warehouse']  = $acs['warehouse'];
    $_SESSION['warehouse_new']  = $acs['warehouse_new'];
    $_SESSION['warehouse_edit'] = $acs['warehouse_edit'];
    $_SESSION['item']   = $acs['item'];
    $_SESSION['item_new']   = $acs['item_new'];
    $_SESSION['item_edit']  = $acs['item_edit'];
    $_SESSION['item_receipt']   = $acs['item_receipt'];
    $_SESSION['item_receipt_new']   = $acs['item_receipt_new'];
    $_SESSION['item_receipt_edit']  = $acs['item_receipt_edit'];
    $_SESSION['item_receipt_cancel']    = $acs['item_receipt_cancel'];
    $_SESSION['item_receipt_process']   = $acs['item_receipt_process'];
    $_SESSION['item_out']   = $acs['item_out'];
    $_SESSION['item_out_new']   = $acs['item_out_new'];
    $_SESSION['item_out_edit']  = $acs['item_out_edit'];
    $_SESSION['item_out_cancel']    = $acs['item_out_cancel'];
    $_SESSION['item_out_process']   = $acs['item_out_process'];
    $_SESSION['request']    = $acs['request'];
    $_SESSION['request_new']    = $acs['request_new'];
    $_SESSION['request_edit']   = $acs['request_edit'];
    $_SESSION['request_process']    = $acs['request_process'];
    $_SESSION['request_cancel'] = $acs['request_cancel'];
    $_SESSION['maintenance']    = $acs['maintenance'];
    $_SESSION['maintenance_new']    = $acs['maintenance_new'];
    $_SESSION['maintenance_edit']   = $acs['maintenance_edit'];
    $_SESSION['maintenance_process']    = $acs['maintenance_process'];
    $_SESSION['maintenance_cancel'] = $acs['maintenance_cancel'];
    $_SESSION['po_maintenance']    = $acs['po_maintenance'];
    $_SESSION['po_maintenance_new']    = $acs['po_maintenance_new'];
    $_SESSION['po_maintenance_edit']   = $acs['po_maintenance_edit'];
    $_SESSION['po_maintenance_process']    = $acs['po_maintenance_process'];
    $_SESSION['po_maintenance_cancel'] = $acs['po_maintenance_cancel'];
    $_SESSION['purchasing'] = $acs['purchasing'];
    $_SESSION['purchasing_new'] = $acs['purchasing_new'];
    $_SESSION['purchasing_edit']    = $acs['purchasing_edit'];
    $_SESSION['purchasing_process'] = $acs['purchasing_process'];
    $_SESSION['purchasing_cancel']  = $acs['purchasing_cancel'];
    $_SESSION['cash_receipt']   = $acs['cash_receipt'];
    $_SESSION['receipt_from_population']    = $acs['receipt_from_population'];
    $_SESSION['cash_receipt_new']   = $acs['cash_receipt_new'];
    $_SESSION['cash_receipt_edit']  = $acs['cash_receipt_edit'];
    $_SESSION['cash_receipt_process']   = $acs['cash_receipt_process'];
    $_SESSION['cash_receipt_diketahui'] = $acs['cash_receipt_diketahui'];
    $_SESSION['cash_receipt_cancel']    = $acs['cash_receipt_cancel'];
    $_SESSION['cash_payment']   = $acs['cash_payment'];
    $_SESSION['payment_for_purchasing'] = $acs['payment_for_purchasing'];
    $_SESSION['payroll']    = $acs['payroll'];
    $_SESSION['cash_payment_new']   = $acs['cash_payment_new'];
    $_SESSION['cash_payment_edit']  = $acs['cash_payment_edit'];
    $_SESSION['cash_payment_process']   = $acs['cash_payment_process'];
    $_SESSION['cash_payment_cancel']    = $acs['cash_payment_cancel'];
    $_SESSION['invoice']    = $acs['invoice'];
    $_SESSION['invoice_new']    = $acs['invoice_new'];
    $_SESSION['invoice_edit']   = $acs['invoice_edit'];
    $_SESSION['invoice_cancel'] = $acs['invoice_cancel'];
    $_SESSION['type_of_receipt_wh'] = $acs['type_of_receipt_wh'];
    $_SESSION['type_of_receipt_wh_new'] = $acs['type_of_receipt_wh_new'];
    $_SESSION['type_of_receipt_wh_edit']    = $acs['type_of_receipt_wh_edit'];
    $_SESSION['type_of_out_wh'] = $acs['type_of_out_wh'];
    $_SESSION['type_of_out_wh_new'] = $acs['type_of_out_wh_new'];
    $_SESSION['type_of_out_wh_edit']    = $acs['type_of_out_wh_edit'];
    $_SESSION['journal_voucher']    = $acs['journal_voucher'];
    $_SESSION['tutup_buku']    = $acs['tutup_buku'];
    $_SESSION['monitoring_purchasing']  = $acs['monitoring_purchasing'];
    $_SESSION['monitoring_invoice'] = $acs['monitoring_invoice'];
    $_SESSION['report_finance_balance']   = $acs['report_finance_balance'];
    $_SESSION['report_bank_cash']   = $acs['report_bank_cash'];
    $_SESSION['report_cash_receipt']    = $acs['report_cash_receipt'];
    $_SESSION['report_cash_payment']    = $acs['report_cash_payment'];
    $_SESSION['report_inventory']   = $acs['report_inventory'];
    $_SESSION['report_account_balance'] = $acs['report_account_balance'];
    $_SESSION['report_general_ledger']  = $acs['report_general_ledger'];
    $_SESSION['report_balance_sheet']   = $acs['report_balance_sheet'];
    $_SESSION['report_cash_flow_statement'] = $acs['report_cash_flow_statement'];
    $_SESSION['begining_balance'] = $acs['begining_balance'];
    $_SESSION['close_book'] = $acs['close_book'];
    $data = $db->select('tb_employee', 'code_employee = "' . $_SESSION['code_employee'] . '"', 'code_employee', 'ASC');
    $dt = mysqli_num_rows($data);
    $result_data = mysqli_fetch_assoc($data);
    $_SESSION['employee_name'] = $result_data['name'];
}



echo $themes->media($db, $link, $title, $body, $library_class, $session, $all_file, $settings, $hal, $get, $view, $page);
?>

<script>
    localStorage.setItem('data_link', '<?php echo $link; ?>');
</script>