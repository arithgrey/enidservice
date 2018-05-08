<?php
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('fpdf/fpdf.php');
require_once('src/autoload.php');

class Imprimir
{
	
	function genera_pdf($param)
	{
		
		$pdf = new Fpdi();
		$pageCount = $pdf->setSourceFile('ordern_pago.pdf');
		$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
		$pdf->addPage("P","A4");
		$pdf->useImportedPage($pageId, 10, 10, 190 );
		/**/
		$beneficiario =  $param["beneficiario"];
		$folio =  $param["folio"];
		$monto =  $param["monto"];
		$numero_cuenta =  $param["numero_cuenta"];
		$concepto =  $param["concepto"];



		$pdf->SetFont('Arial','B',14);
		
		$pdf->SetTextColor(255 , 255, 255);
		$pdf->Text(46, 62, $concepto);


		$pdf->SetTextColor(255 , 255, 255);
		$pdf->Text(53, 67.5, $beneficiario);

		
		$pdf->SetTextColor(255 , 255, 255);
		$pdf->Text(35, 73.5, "#".$folio);


		$pdf->SetFont('Arial','B',20);
		$pdf->SetTextColor(0,0,0);
		$pdf->Text(35, 110, $monto." MXN");

		
		$pdf->Image("1.png", 28 ,130 , 50 , 20, "png");
		$pdf->Output();	
	}
}

$imprimir =  new Imprimir();
$imprimir->genera_pdf($_POST);

