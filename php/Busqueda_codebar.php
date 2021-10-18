<?php

if (isset($_POST['consulta_code_bar'])) {
    $consulta = $_POST['consulta_code_bar'];
    //include_once "sesion.php";
    require "ConsultaContribuyentes.php";
    $metodos = new ConsultaContribuyentes();
    $buscar_consulta = $metodos->Consulta_code_bar($consulta);
    if (isset($buscar_consulta)) {
        //echo $datos = json_encode($buscar_consulta);
        echo "<table class='table text-center table-responsive table-sm  shadow p-1 bg-white rounded'>
           <thead>
             <tr>
               <th scope='col'>#</th>
               <th scope='col'>RFC</th>
               <th scope='col'>Num.Det</th>
               <th scope='col'>Razón social</th>
               <th scope='col'>fecha alta</th>
               <th scope='col'>Ticket</th>
               <th scope='col'>Estatus Ticket</th>
               <th scope='col'>Estatus determinante</th>
             </tr>
           </thead>
           <tbody>";
        $J = 1;
        for ($i=0; $i < count($buscar_consulta) ; $i++) {
            for ($i=0; $i < count($buscar_consulta) ; $i++) {
              $estatus =$buscar_consulta[$i]['id_proc'];
              $estatus_det =  $buscar_consulta[$i]['id_proc_det'];
                switch ($estatus) {
                        case 2:
                          $estatus = 'Solicitado';

                        break;
                        case 7:
                          $estatus = 'Busqueda';

                        break;
                        case 11:
                          $estatus = 'Disponible';

                        break;
                        case 12:
                          $estatus = 'Ticket Cancelado';

                        break;
                        case 8:
                          $estatus = 'Prestamo';

                        break;
                         case 5:
                          $estatus = 'Petición en devolución';

                        break;
                        case 4:
                          $estatus = 'Devuelto';

                        break;
                        case 9:
                          $estatus = 'Devolución parcial';
                          
                        break;
                         
                }
                switch ($estatus_det) {
                          case 2:
                            $estatus_det = 'Solicitado';

                          break;
                           case 7:
                             $estatus_det = 'Busqueda';
                           break;
                           case 11:
                             $estatus_det = 'Disponible';
                           break;
                           case 12:
                             $estatus_det = 'Ticket Cancelado';
                           break;
                           case 8:
                             $estatus_det = 'Prestamo';
                           break;
                            case 5:
                             $estatus_det = 'Petición en devolución';
                           break;
                           case 4:
                             $estatus_det = 'Devuelto';
                           break;
                           case 9:
                             $estatus_det = 'Devolución parcial';
                           break;
                }

                echo"<tr>
                        <th scope='row'>".$J++."</th>
                        <td>".$buscar_consulta[$i]['rfc']."</td>
                        <td>".$buscar_consulta[$i]['num_determinante']."</td>
                        <td>".$buscar_consulta[$i]['razon_social']."</td>
                        <td>".$buscar_consulta[$i]['fecha_alta']->format('d-m-Y')."</td>
                        <td>".$buscar_consulta[$i]['id_tiket']."</td>
                        <td>".$estatus."</td>
                        <td>".$estatus_det."</td> 
                       
                     
                </tr>";
            }
            echo"  
            </tbody>
            </table>";
        }
    } else {
        echo "";
    }
   
}
if (isset($_POST['user_mov'])) {
  require "ConsultaContribuyentes.php";
  $metodos = new ConsultaContribuyentes();
  $buscar_consulta = $metodos->Consulta_user_mov_x_dia();
  if (isset($buscar_consulta)) {
    echo "<table class='table text-center table-responsive table-sm shadow p-1 bg-white rounded'>
    <thead>
      <tr>
        <th scope='col'>#</th>
        <th scope='col'>RFC</th>
        <th scope='col'>Num.Det</th>
        <th scope='col'>Razón social</th>
        <th scope='col'>fecha alta</th>
        <th scope='col'>Ticket</th>
        <th scope='col'>Estatdo del ticket</th>
      </tr>
    </thead>
    <tbody>";
      $J = 1;
      for ($i=0; $i < count($buscar_consulta) ; $i++) {
          switch ($buscar_consulta[$i]['id_proc']) {
                case 7:
                  $estatus = 'Busqueda';
                break;
                case 11:
                  $estatus = 'Disponible';
                break;
                case 12:
                  $estatus = 'Ticket Cancelado';
                break;
                case 8:
                  $estatus = 'Prestamo';
                break;
                 case 5:
                  $estatus = 'Petición en devolución';
                break;
                case 4:
                  $estatus = 'Devuelto';
                break;
                case 9:
                  $estatus = 'Devolución parcial';
                break;
               
        }
        echo "<tr>
                 <td scope='row'>".$J++."</td>
                 <td>".$buscar_consulta[$i]['rfc']."</td>
                 <td>".$buscar_consulta[$i]['num_determinante']."</td>
                 <td>".$buscar_consulta[$i]['razon_social']."</td>
                 <td>".$buscar_consulta[$i]['fecha_alta']->format('d-m-Y H:i')."</td>
                 <td>".$buscar_consulta[$i]['id_tiket']."</td>
                 <td>".$estatus."</td>
             </tr>";
      }
      echo "  </tbody>
     </table>";
    
  } else {
    echo "";
    
  }
}
?>