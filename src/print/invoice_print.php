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

    $invoice=$db->select('tb_invoice','number_invoice="'.$ubah.'"','id_invoice','DESC');
    $i=mysqli_fetch_assoc($invoice);

    $tanggal=substr($i['tanggal'], 8,2);
    $bulan=substr($i['tanggal'], 5,2);
    $tahun=substr($i['tanggal'], 0,4);
    $date=$tanggal."/".$bulan."/".$tahun;

    $sampai_tanggal=substr($i['till_date'], 8,2);
    $sampai_bulan=substr($i['till_date'], 5,2);
    $sampai_tahun=substr($i['till_date'], 0,4);
    $till_date=$sampai_tanggal."/".$sampai_bulan."/".$sampai_tahun;

    $population=$db->select('tb_population INNER JOIN tb_cluster ON tb_population.id_cluster=tb_cluster.id_cluster','tb_population.id_population="'.$i['id_population'].'"','tb_population.id_population','DESC','tb_population.name,tb_population.address,tb_cluster.cluster');
    $p=mysqli_fetch_assoc($population);

    $html = '
      <style>
        @font-face {
            font-family: "time new roman";           
            font-weight: normal;
            font-style: normal;
        }        
        body{
            font-family: "time new roman", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;   
            font-size: 9px;     
            line-height: 12px;  
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
          padding: 5px;
        }
      </style>
      <html>
        <body>
          <table border="0" width="100%">
            <tr>
              <td width="37.5%" valign="top">
                <img src="'.$link_ubah.'/assets/images/logo/logo_wilayah.jpg"><br>
                <b>'.$s['title_print'].'</b><br>
                <b>'.$s['title_print2'].'</b><br>
                '.$s['alamat'].'   
              </td>
              <td width="25%" valign="top"></td>
              <td width="37.5%" valign="top">
                <b>'.strtoupper($p['name']).'</b><br>
                <b>'.strtoupper($p['cluster']).'</b><br>
                <b>'.strtoupper($p['address']).'</b><br>
                <b>UP : '.strtoupper($p['name']).'</b><br>
                <table border="0" class="table">
                  <tr>
                    <td width="50%">Tanggal Tagihan</td>
                    <td width="50%">: '.$date.'</td>
                  </tr>
                  <tr>
                    <td>Nomor Tagihan</td>
                    <td>: '.$i['number_invoice'].'</td>
                  </tr>
                  <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td>: '.$till_date.'</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td align="center" style="font-size:10px;">
                <b>TAGIHAN</b>
              </td>
              <td width="18.8%" align="center">
                Jumlah (Rp)
              </td>
            </tr>
            <tr>
              <td>
                '.$i['dues_type'].'
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
          Terbilang "# '.terbilang($i['amount']).' #"<br>
          '.$s['cara_pembayaran'].'
        </body>
      </html>
    ';

  }

  require_once("../../assets/vendors/dompdf/autoload.inc.php");


  $filename = "newpdffile";

  use Dompdf\Dompdf;

  $dompdf = new Dompdf();

  $dompdf->loadHtml($html);

  $dompdf->setPaper('A4', 'potrait');

  $dompdf->render();

  $dompdf->stream($filename);
