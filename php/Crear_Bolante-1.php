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
    date_default_timezone_set('America/Mexico_City');
    $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      
    $Fecha_hoy=date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
    $pdf->AddPage('landscape', 'letter');
    $pdf->SetTitle('Bóveda SAT |  Volante Ticket');
    $pdf->Code39(20,10,$tiket,1,10);/////////////////////////////CREA CODIGO BARRAS
    $pdf->Image('../img/logo.png', 150, 5, 90, 17);
    //$pdf->Image('../recursos/img/shcp.jpg',140,2, 70,30);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Text(150, 32, utf8_decode('Administración Desconcentrada de Recaudación'));
    $pdf->Text(150, 36, utf8_decode($admin_gen));
    $pdf->Text(150, 40, utf8_decode('Ciudad de Mexico a '.$Fecha_hoy));
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Text(19, 55, utf8_decode('Tiket Numero: '.$tiket));
    $pdf->Text(19, 60, utf8_decode('Fecha Validacion: '.$fecha));
    $pdf->Text(150, 55, utf8_decode('Usuario peticion: '.$Empleado));
    $pdf->Text(150, 60, utf8_decode('Departamento: '.$departamento));
    $pdf->Ln(60);
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(40,40,40);
    $pdf->SetDrawColor(88,88,88);
    //Texto anterior
     $pdf->Cell(4,10,'N',1,0,'C',1);
     $pdf->Cell(23,10,utf8_decode('RFC'),1,0,'C',1);
     $pdf->Cell(31,10,utf8_decode('Número Determinante'),1,0,'C',1);
     $pdf->Cell(120,10,utf8_decode('Razon Social'),1,0,'C',1);
     $pdf->Cell(10,10,utf8_decode('Estado'),1,0,'C',1);
     $pdf->Cell(20,10,utf8_decode('Ubicacioón'),1,0,'C',1);
     $pdf->Cell(60,10,utf8_decode('Codigo Bar'),1,0,'C',1);
    $pdf->SetDrawColor(61,174,233);
    $pdf->Ln();
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(40,40,40);
    $pdf->SetDrawColor(88,88,88);
    $pdf->Ln(0);
   // require('WriteHTML.php');

$pdf->SetFont('Arial');

$j= 1;

// $barcodeType='code128';
// $barcodeDisplay='horizontal';
// $barcodeSize=20;
// $printText="true";
$y=81;
  for ($i= 0 ; $i < count($datos_TABLA); $i++) {
    if($y>190){
      $y=11;
    }
    $llenar=$datos_TABLA[$i]['RDFDA'];
    //$llenar=$datos_TABLA[$i]['num_determinante'];
    //$llenar=$datos_TABLA[$i]['id_etapa'];
    new barCodeGenrator($llenar,1,'text1'.$i.'.gif',600,90,1);

       if($datos_TABLA[$i]['estatus'] == 'A'){
         $ubcacion = 'Anaqueles';
         $estado = 'A';
       }else{
         $ubcacion = 'Naves';
         $estado = 'B';
       }
      $pdf->Cell(4,10, $j++, 1, 0, 'C', 1);
      $pdf->Cell(23, 10, utf8_decode($datos_TABLA[$i]['rfc']), 1, 0, 'C', 1);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(31, 10, utf8_decode($datos_TABLA[$i]['num_determinante']), 1, 0, 'C', 1);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(120, 10, utf8_decode($datos_TABLA[$i]['razon_social']), 1, 0, 'C', 1);
      $pdf->SetFont('Arial', '', 7);
      $pdf->Cell(10, 10, utf8_decode($estado), 1, 0, 'C', 1);
      $pdf->Cell(20, 10,utf8_decode($ubcacion),1,0,'C',1);
      $pdf->Cell(60,10,'',1,0,'L');
     // $pdf->cell(60, 10, '' ,1,0,'C',1);
      $pdf->image('text1'.$i.'.gif',220,$y,65,8);
    //  $pdf->Text($pdf->html(60, 10,('<h4>hola</h4>') , 1, 0, 'C', 1));
    
      $pdf->Ln();
      $y=$y+10;
  }   



    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(180, 200, utf8_decode('_______________________________'));
    $pdf->Text(190, 205, utf8_decode('FIRMA DEL SOLICITANTE'));
    $pdf->Close();
    ob_end_clean();
    $pdf->Output();
}
