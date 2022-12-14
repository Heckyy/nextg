<?php
  session_start();
  if(!empty($_SESSION['id_employee']) && !empty($_GET['view'])){
    include_once "../../core/file/function_proses.php";
    include_once "../../core/settings/terbilang.php";
    $db = new db();

    $settings=$db->select('tb_settings','id_settings','id_settings','DESC');
    $s=mysqli_fetch_assoc($settings);

    $link_ubah=str_replace('https', 'http', $s['link']);
    
    $ubah=base64_decode($_GET['view']);

    $invoice=$db->select('tb_cash_receipt_payment','number="'.$ubah.'" && status="1" && type="i"','id_cash_receipt_payment','DESC');
    $i=mysqli_fetch_assoc($invoice);

    $u=mysqli_fetch_assoc($db->select('tb_employee','id_employee="'.$i['input_data'].'"','id_employee','DESC'));
    $ap=mysqli_fetch_assoc($db->select('tb_employee','code_employee="'.$i['approved'].'"','id_employee','DESC'));
    $ket=mysqli_fetch_assoc($db->select('tb_employee','code_employee="'.$i['diketahui'].'"','id_employee','DESC'));

    $tanggal=substr($i['tanggal'], 8,2);
    $bulan=substr($i['tanggal'], 5,2);
    $tahun=substr($i['tanggal'], 0,4);
    $date=$tanggal."/".$bulan."/".$tahun;


    $html = '
      <style>
        @page { margin: 10px 30px; }
        @font-face {
            font-family: "time new roman";           
            font-weight: normal;
            font-style: normal;
        }        
        body{
            font-family: "time new roman", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;   
            font-size: 12px;     
            margin:0px;
        }
        img{
          margin-bottom:10px;
        }
        .table{
          margin-top: 5px;
          border-collapse: collapse;
          border: thin solid #333333;
          width: 100%;
        }
        .table tr td{
          border: thin solid #333333;
          padding: 3px;
        }
        .table_no_border{
          margin-top: 10px;
          border: none;
          width: 100%;
        }
        .bingkai{
          width:100%;
          float:left;
        }
      </style>
      <html>
        <body>
          <table class="bingkai">
            <tr>
              <td height="49%">
                <table border="0" width="100%">
                  <tr>
                    <td width="36%" valign="top">
                      <img src="'.$link_ubah.'/assets/images/logo/logo_wilayah.jpg" width="100px"><br>
                      <b>'.$s['title_print'].'</b><br>
                      <b>'.$s['title_print2'].'</b><br>
                      '.$s['alamat'].'   
                    </td>
                    <td width="25%" valign="top"></td>
                    <td width="39%" valign="top">

                      <table border="0" class="table">
                        <tr><td colspan="2" align="center"><b>PEMASUKAN</b></td></tr>
                        <tr>
                          <td width="50%">Date</td>
                          <td width="50%">: '.$date.'</td>
                        </tr>
                        <tr>
                          <td>Nomor Transaksi</td>
                          <td>: '.$i['number'].'</td>
                        </tr>
                        <tr>
                          <td>From</td>
                          <td>: '.$i['dari'].'</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                <table class="table">
                  <tr>
                    <td align="center" style="font-size:10px;">
                      <b>TRANSAKSI</b>
                    </td>
                    <td width="18.8%" style="font-size:11px;" align="center">
                      Jumlah (Rp)
                    </td>
                  </tr>
                  <tr>
                    <td>
                      '.$i['note'].'
                    </td>
                    <td align="right">
                      '.number_format($i['amount'],2,',','.').'
                    </td>
                  </tr>
                  <tr>
                    <td align="center" style="font-size:10px;">
                      <b>TOTAL</b>
                    </td>
                    <td align="right">
                      '.number_format($i['amount'],2,',','.').'
                    </td>
                  </tr>
                </table>
                <br><br>
                Terbilang "# '.terbilang($i['amount']).' Rupiah #"<br>
                '.$s['cara_pembayaran'].'<br>

            </td>
          </tr> 
          <tr>
              <td height="49%">
                <table class="table_no_border" border="0">
                    <tr>
                      <td width="25%" align="center">Dibuat</td>
                      <td width="25%" align="center">Disetujui</td>
                      <td width="25%" align="center">Diketahui</td>
                      <td width="25%" align="center">Diterima</td>
                    </tr>
                    <tr>
                      <td colspan="3" height="39px"></td>
                    </tr>
                    <tr>
                      <td align="center">( '.$u['name'].' )</td>
                      <td align="center">( '.$ap['name'].' )</td>
                      <td align="center">( '.$ket['name'].' )</td>
                      <td align="center">( ............ )</td>
                    </tr>
                </table>
            </td>
        </tr>
      </table>
    </body>
    </html>';

  }

  require_once("../../assets/vendors/dompdf/autoload.inc.php");


  $filename = "newpdffile";

  use Dompdf\Dompdf;

  $dompdf = new Dompdf();

  $dompdf->loadHtml($html);

  $customPaper = array(0,0,470.95,595.28);
  $dompdf->set_paper($customPaper,'landscape');


  $dompdf->render();

  $dompdf->stream($filename);

?>