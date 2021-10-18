<?php

if (isset($_POST["id_admin"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_admin = $_POST["id_admin"];
    $resultado_area = $resultado->Consulta_Subadmin($id_admin);
    $html[] = null;
    for ($i = 0; $i < count($resultado_area); $i++) {
        $contenido = "<option value='" . $resultado_area[$i]["id_sub_admin"] . "'>" . $resultado_area[$i]["nombre_sub_admin"] . "</option>";
        $html[$i] = $contenido;
    }
    echo "<option value='0'>Seleccionar Subadministración</option>";
    for ($i = 0; $i < count($html); $i++) {
      echo "$html[$i]";
    }
}elseif (isset($_POST["id_sub_admin"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_sub_admin = $_POST["id_sub_admin"];
    $resultado_dep = $resultado->Consulta_Depto_sub($id_sub_admin);
    if (is_array($resultado_dep)) {
      $html[] = null;
      for ($i = 0; $i < count($resultado_dep); $i++) {
          $contenido = "<option value='" . $resultado_dep[$i]["id_depto"] . "'>" . $resultado_dep[$i]["nombre_depto"] . "</option>";
          $html[$i] = $contenido;
      }
      $opcions =  "<option value='0'>Seleccionar Departamento</option>";
      for ($i = 0; $i < count($html); $i++) {
        $opcions .=  $html[$i];
      }
      echo $opcions;
    } else {
      $opcions =  "<option value='0'>$resultado_dep</option>";
      echo $opcions;
    }
  }
  if (isset($_POST['id_sub_admin1'])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_sub_admin = $_POST["id_sub_admin1"];
    $resultado_dep = $resultado->Consulta_Depto_sub($id_sub_admin);
    return $resultado_dep['nombre_depto'];

  }
  if (isset($_POST['nom_dep'])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $nom_dep = $_POST["nom_dep"];
    $resultado_dep = $resultado->Consulta_Depto_sub($nom_dep);
    return "value= '".$resultado_dep['nombre_depto']."'";

  }
  if (isset($_POST['id_autoridad'])) {
    include_once 'php/ConsultaContribuyentes.php';
    $consulta = new ConsultaContribuyentes();
    $id_autoridad = $_POST["id_autoridad"];
    $resultado = $consulta->Consulta_Autoridad_especifica($id_autoridad);
    return $resultado['nombre_autoridad'];

  }
  if (isset($_POST['nombre_emp'])) {
    include_once 'MetodosUsuarios.php';
    $consulta = new MetodosUsuarios();
    $nombre = $_POST["nombre_emp"];
    $resultado = $consulta->Consulta_usuarios_BUSQ($nombre);
    for ($i=0; $i < count($resultado) ; $i++) { 
      $opciones[$i]=" <option value='".$resultado[$i]['rfc_corto']."'></option>";
    }
    
    echo $opciones;

  }

  if (isset($_POST["id_obj"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_obj = $_POST["id_obj"];
    $resultado_area = $resultado->Consulta_situacion($id_obj);
    $html[] = null;
    for ($i = 0; $i < count($resultado_area); $i++) {
        $contenido = "<option value='" . $resultado_area[$i]["Id_situación "] . "'>" . $resultado_area[$i]["Situacion"] . "</option>";
        $html[$i] = $contenido;
    }
    echo "<option value='0'>Seleccionar Situacion</option>";
    for ($i = 0; $i < count($html); $i++) {
      echo $html[$i];
    }
}

if (isset($_POST["Etapa"])) {
  include_once 'MetodosUsuarios.php';
  $resultado = new MetodosUsuarios();
  $datos = $_POST["Etapa"];
$id_obj=$datos['id_obj'];
$id_sit = $datos['id_sit'];

  echo $id_sub_admin;
   $resultado_dep = $resultado->Consulta_etapa($id_sit,$id_obj);
   if (is_array($resultado_dep)) {
     $html[] = null;
     for ($i = 0; $i < count($resultado_dep); $i++) {
        $contenido = "<option value='" . $resultado_dep[$i]["id_etapa"] . "'>" . $resultado_dep[$i]["etapa"] . "</option>";
         $html[$i] = $contenido;
     }
     $opcions =  "<option value='0'>Seleccionar Etapa</option>";
    for ($i = 0; $i < count($html); $i++) {
       $opcions .=  $html[$i];
     }
     echo $opcions;
   }
}

if (isset($_POST["rfc"])) {
  $rfc = $_POST['rfc'];
  include_once 'ConsultaContribuyentes.php';
  $metodos = new ConsultaContribuyentes();
  $busqueda = $metodos->Consulta_RFC_contri($rfc);
  // echo $busqueda[0]['id_determinante'];
  echo  "  <option value='0'>Seleccionar Núm. determinante</option>";
  for ($i=0; $i < count($busqueda) ; $i++) { 
    echo "<option value='" . $busqueda[$i]["id_determinante"] . "'>" . $busqueda[$i]["num_determinante"] . "</option>";
  }
}
if (isset($_POST["info_det"])) {
  $id_det = $_POST['info_det'];
  include_once 'ConsultaContribuyentes.php';
  $metodos = new ConsultaContribuyentes();
  $busqueda = $metodos->Consulta_info_det($id_det);
  if (isset($busqueda)) {
    echo"
    <div class=' container-fluid' >
    <div class='card-header'>
    <p class = 'font-weight-bold'> Datos del Contribuyente</p>
    </div>
      <table class='table  text-center shadow p-1 bg-white rounded'>
      <thead>
        <tr>
          <th scope='col'><p class = 'font-weight-bold'> RFC:</p></th>
          <th scope='col'><p class = 'font-weight-bold'>Rázon social:</p></th>
          <th scope='col'><p class = 'font-weight-bold'>Núm determinante:</p></th>
          <th scope='col'><p class = 'font-weight-bold'>Fecha determinante:</p></th>
          <th scope='col'><p class = 'font-weight-bold'>Autoridad determinante:</p></th>
        </tr>
      </thead>
          <tbody>
              <tr>
                <td>".$busqueda[0]['rfc']."</th>
                <td>".$busqueda[0]['razon_social']."</td>
                <td>".$busqueda[0]['num_determinante']."</td>
                <td>".$busqueda[0]['fecha_determinante']->format('d/m/Y')."</td>
                <td>".$busqueda[0]['nombre_autoridad']."</td>
            </tr>
        </tbody>
    </table>
  </div>";
  }
  else {
    echo"Revisa que este contribuyente este registrado para tu cartera";
  }

}
if (isset($_POST["empleado"])) {
  include_once 'MetodosUsuarios.php';
  $consulta = new MetodosUsuarios();
  $resultado = $consulta->Consulta_usuarios_con_cartera();
  echo"<option value='0'>Seleccionar Opción</option>";
  for ($i=0; $i < count($resultado) ; $i++) { 
   echo $opciones[$i]=" <option value='".$resultado[$i]['id_empleado']."'>".$resultado[$i]['nombre_empleado']."</option>";
  }
  
}



