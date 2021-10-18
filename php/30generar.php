<?php
require("fpdf.php");
require_once("barcode.inc.php");
$numero=$_GET["f"];
$llenar="00000".$numero;
new barCodeGenrator($llenar,1,'text.gif',190,130,1);
$pdf=new FPDF('P','cm',array(4,5));
$pdf->Addpage();
$pdf->SetFont('Arial','',7);
$info="1";
$pdf->Cell(3,9,$info,1,0,'L');
$pdf->image('text.gif',1,2,3,1);
$pdf->Output();
?>