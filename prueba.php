<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <script src="js/jquery-3.1.1.js"></script>
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src='js/toastr.min.js'></script>
  <link rel="stylesheet" href="css/toastr.min.css">

  <title>Hello, world!</title>
</head>

<body>
  <h1>Subir archivos prueba 3!</h1>
  <form class="form_example" enctype="multipart/form-data">

    <input type="file" id='archvioID' name="archvioID">
    <input type="button" id="subir" class="btn btn-outline-dark" value="Cargar">


  </form>


  <?php



class un{
  public function unir_arreglos(){
    $arra1 = [1,2,3,4,5,6];
$arra2 = [8,9,10,22,12];
    $antes = array_merge($arra2,$arra1);
    $datos = rsort($antes);
  
    echo $datos;
  
  
  }
}


$une = new un();
$une->unir_arreglos();


?>


  <script src="js/jquery-3.1.1.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/prueba_subida.js"></script>
  <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
</body>


</html>
