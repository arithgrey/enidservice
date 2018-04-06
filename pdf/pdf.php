<?php 
set_time_limit(300);
ob_start();
require "autoload.php";
use Spipu\Html2Pdf\Html2Pdf;
$html2pdf = new Html2Pdf();
$contenido_pdf =  $_POST["contenido"];
try{
      $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3);
      $html2pdf->pdf->SetDisplayMode('fullpage');	   
      	$html2pdf->writeHTML($contenido_pdf);		
		$html2pdf->Output('PDF-CF.pdf');
}catch(HTML2PDF_exception $e) {    
    echo $e;
    exit;
}
?>