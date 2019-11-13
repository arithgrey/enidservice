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
        try {

            $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

        } catch (PdfReader\PdfReaderException $e) {

        }
        $pdf->addPage("P", "A4");
        $pdf->useImportedPage($pageId, 10, 10, 190);

        $beneficiario = $param["beneficiario"];
        $folio = $param["folio"];
        $monto = $param["monto"];
        $numero_cuenta = $param["numero_cuenta"];
        $concepto = $param["concepto"];


        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(46, 62, $concepto);

        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(53, 67.5, $beneficiario);

        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(35, 73.5, "#" . $folio);

        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Text(35, 110, $monto . " MXN");

        $pdf->Image("1.png", 28, 130, 50, 20, "png");
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Text(28, 160, $numero_cuenta);


        $pdf->Image("http://enidservices.com/inicio/img_tema/enid_service_logo.jpg",
            120,
            90,
            60,
            60,
            "jpg");

        $pdf->Output();
    }
}

$imprimir = new Imprimir();
$imprimir->genera_pdf($_POST);
