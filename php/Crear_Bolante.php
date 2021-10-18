<?php
if (isset($_GET["id_tiket"])) {
    include_once 'fpdf.php';
    include_once 'ConsultaContribuyentes.php';
    //include 'barcode.php';
    require_once("barcode.inc.php");
    $metodos = new ConsultaContribuyentes();
    $tiket= $_GET["id_tiket"];
    $datos_TABLA=$metodos->Datos_de_imprecion($tiket); 
    $datos_GENERAL=$metodos->Datos_de_imprecion2($tiket); 
    $fecha = ($datos_GENERAL["fecha_valida"] != null) ? $datos_GENERAL["fecha_valida"]->format('d-m-Y') : "Sin validar";
    $correo = $datos_GENERAL["correo"];
    $admin_gen = $datos_GENERAL["nombre_admin"];
    $subAdmin = $datos_GENERAL["nombre_sub_admin"];
    $departamento = $datos_GENERAL["nombre_depto"];
    $RDFDA = $datos_GENERAL['RDFDA'];
    $Empleado = $datos_GENERAL['nombre_empleado'];
    $determinantes = $datos_GENERAL['num_determinante'];
    define('FPDF_FONTPATH', 'font/');
    //$pdf = new FPDF(); 
    //$pdf=new FPDF();
    $pdf=new FPDF('P','mm',array(4,5));

    $pdf->AddPage('landscape', 'legal');
    $pdf->SetTitle(utf8_decode('Bóveda SAT |  Volante Ticket'));

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Text(19, 55, utf8_decode('Tiket Número: '.$tiket));
    $pdf->Text(19, 60, utf8_decode('Fecha Validación: '.$fecha));
    $pdf->Text(240, 55, utf8_decode('Usuario petición: '.$Empleado));
    $pdf->Text(240, 60, utf8_decode('Departamento: '.$departamento));
    $pdf->Ln(60);
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(40,40,40);
    $pdf->SetDrawColor(88,88,88);
    $pdf->SetMargins(10,10,0);
   
    //Texto anterior
    $pdf->Cell(4,10,'N',1,0,'C',0);
    $pdf->Cell(23,10,utf8_decode('RFC'),1,0,'C',0);
    $pdf->Cell(42,10,utf8_decode('Número Determinante'),1,0,'C',0);
    $pdf->Cell(160,10,utf8_decode('Razon Social'),1,0,'C',0);
    $pdf->Cell(10,10,utf8_decode('Estado'),1,0,'C',0);
    $pdf->Cell(20,10,utf8_decode('Ubicacioón'),1,0,'C',0);
    $pdf->Cell(58,10,utf8_decode('Codigo Bar'),1,0,'C',0);
    $pdf->Cell(20,10,utf8_decode('Fojas'),1,0,'C',0);
    $pdf->SetDrawColor(61,174,233);
    $pdf->Ln();
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(40,40,40);
    $pdf->SetDrawColor(88,88,88);
    $pdf->Ln(0);


$pdf->SetFont('Arial');

$j= 1;


$y=81;
  for ($i= 0 ; $i < count($datos_TABLA); $i++) {
    if($y>190){
      $y=11;
    }

    $llenar=$datos_TABLA[$i]['id_determinante'];

    new barCodeGenrator($llenar,1,'text1'.$i.'.gif',600,90,1);


       switch ($datos_TABLA[$i]['ESTATUS']) {
          case 'A':
          $ubcacion = 'Anaqueles';
          break;
          case 'B':
          $ubcacion = 'Naves';
          break;
          case 'N':
          $ubcacion = 'Naves';
          break;
       }
      $pdf->Cell(4,10, $j++, 1, 0, 'C', 0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(23, 10, utf8_decode($datos_TABLA[$i]['rfc']), 1, 0, 'C', 0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(42, 10, utf8_decode($datos_TABLA[$i]['num_determinante']), 1, 0, 'C', 0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(160, 10, utf8_decode($datos_TABLA[$i]['razon_social']), 1, 0, 'C', 0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(10, 10, utf8_decode($datos_TABLA[$i]['ESTATUS']), 1, 0, 'C', 0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(20, 10,utf8_decode($ubcacion),1,0,'C',0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(58,10, $pdf->Code39(285,$y,$llenar,.6,4), 1, 0, 'C',0);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(20, 10,utf8_decode($datos_TABLA[$i]['FOJ']), 1, 0, 'C', 0);

      $pdf->Ln();
      $y=$y+10;
  }   



    ob_end_clean();
    $pdf->Output();
}
