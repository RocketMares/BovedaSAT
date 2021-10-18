<?php
if (isset($_GET["id_tiket_integra"])) {
    include_once 'fpdf.php';
    include_once 'ConsultaContribuyentes.php';
    //include 'barcode.php';
    require_once("barcode.inc.php");
    $metodos = new ConsultaContribuyentes();
    $tiket= $_GET["id_tiket_integra"];
    $datos_TABLA=$metodos->Datos_de_imprecion_integracion($tiket); 
    $datos_GENERAL=$metodos->Datos_de_imprecion2_integracion($tiket); 
    $fecha = ($datos_GENERAL["fecha_alta"] != null) ? $datos_GENERAL["fecha_alta"]->format('d-m-Y') : "Sin validar";
    $correo = $datos_GENERAL["correo"];
    $admin_gen = $datos_GENERAL["nombre_admin"];
    $subAdmin = $datos_GENERAL["nombre_sub_admin"];
    $departamento = $datos_GENERAL["nombre_depto"];
    $Empleado = $datos_GENERAL['nombre_empleado'];
    $determinantes = $datos_GENERAL['num_determinante'];
    define('FPDF_FONTPATH', 'font/');
    $pdf=new FPDF('P','mm',array(4,5));
    $pdf->AddPage('Landscape','legal');
    $pdf->SetTitle(utf8_decode('Bóveda SAT | Ticket integración'));
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Text(19, 55, utf8_decode('Tiket de integración: '.$tiket));
    $pdf->Text(19, 60, utf8_decode('Fecha de solicitud: '.$fecha));
    $pdf->Text(240, 55, utf8_decode('Usuario petición: '.$Empleado));
    $pdf->Text(240, 60, utf8_decode('Departamento: '.$departamento));
    $pdf->Ln(60);
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(40,40,40);
    $pdf->SetDrawColor(88,88,88);
    //Texto anterior
 
      $pdf->Cell(4,10,'N',1,0,'C',0);
      $pdf->Cell(23,10,utf8_decode('RFC'),1,0,'C',0);
      $pdf->Cell(42,10,utf8_decode('Número Determinante'),1,0,'C',0);
      $pdf->Cell(160,10,utf8_decode('Razon Social'),1,0,'C',0);
      $pdf->Cell(25,10,utf8_decode('Estado del credito'),1,0,'C',0);
      $pdf->Cell(30,10,utf8_decode('Tipo de documento'),1,0,'C',0);
      $pdf->Cell(30,10,utf8_decode('Fecha del documento'),1,0,'C',0);
      $pdf->Cell(15,10,utf8_decode('Fojas'),1,0,'C',0);

     $pdf->Ln();
     $pdf->SetFontSize('10');
     $pdf->SetFont('Arial', '', 7);
     $pdf->SetMargins(10,50,0);

$j= 1;
 
  for ($i= 0 ; $i < count($datos_TABLA); $i++) {

    $pdf->Cell(4,10,$j++,1,0,'C',0);
    $pdf->Cell(23,10,utf8_decode($datos_TABLA[$i]['rfc']),1,0,'C',0);
    $pdf->Cell(42,10,utf8_decode($datos_TABLA[$i]['num_determinante']),1,0,'C',0);
    $pdf->Cell(160,10,utf8_decode($datos_TABLA[$i]['razon_social']),1,0,'C',0);
    $pdf->Cell(25,10,utf8_decode($datos_TABLA[$i]['estatus']),1,0,'C',0);
    $pdf->Cell(30,10,utf8_decode($datos_TABLA[$i]['tipo_doc_res']),1,0,'C',0);
    $pdf->Cell(30,10,utf8_decode($datos_TABLA[$i]['fecha_of']->format('d-m-Y')),1,0,'C',0);
    $pdf->Cell(15,10,utf8_decode($datos_TABLA[$i]['fojas']),1,0,'C',0);
    $pdf->Ln();

  }   


 
    $pdf->Close();
    ob_end_clean();

    $pdf->Output();

}
