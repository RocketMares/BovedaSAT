<?php


class Vista_Expedientes{


    public function vista_general(){
        include_once "sesion.php";
        include_once "ConsultaContribuyentes.php";
        $metodos = new ConsultaContribuyentes();

        $cabeceras = $metodos->Cabecera_vistas();
        $universo_de_datos = $metodos->universo_datos_expedientes();
        $resultado = $universo_de_datos[0]['total'] / 100;
        $oficio_por_pagina = 100;
        $paginas_por_vista = ceil($resultado);
        switch ($_GET) {
                case isset($_GET['pagina']):
                        $num = $_GET['pagina'];
                break;
                case isset($_GET['estructura']):
                        $num = $_GET['estructura'];
                break;
                case isset($_GET['Usuario']):
                        $num = $_GET['Usuario'];
                break;
                case isset($_GET['RFC']):
                        $num = $_GET['RFC'];
                break;
                case isset($_GET['num_det']):
                        $num = $_GET['num_det'];
                break;
                case isset($_GET['Cred']):
                        $num = $_GET['Cred'];
                break;
                case isset($_GET['razon']):
                        $num = $_GET['razon'];
                break;
        }
                if ($num==1) {
                $inicio = 1;
                $datos_vista = $metodos->busqueda_Tabla_Expedientes_VISTA($inicio);
                }
                else {
                $pagina = $num-1 ;
                $inicio = ($pagina * $oficio_por_pagina) + 1;
                $datos_vista = $metodos->busqueda_Tabla_Expedientes_VISTA($inicio);
                }
                self::pagina_responsiva($paginas_por_vista);
                if (isset($datos_vista)) {
                for ($i=0; $i < count($datos_vista) ; $i++) {
                    if ($datos_vista[$i]['estatus_cred'] == "A") {
                        $estatus = 'ACTIVO';
                    }
                    else{
                        $estatus = 'BAJA';
                    }
          
                    echo"
                    <tr>
                    <th scope='row'>".$datos_vista[$i]['seq']."</th>
                    <td>".$datos_vista[$i]['rfc']."</td>
                    <td>".$datos_vista[$i]['razon_social']."</td>
                    <td>".$datos_vista[$i]['num_determinante']."</td>
                    <td>".$datos_vista[$i]['autoridad']."</td>
                    <td>$estatus</td>
                    <td>".$datos_vista[$i]['nombre_admin']."</td>
                    <td>".$datos_vista[$i]['nombre_sub_admin']."</td>
                    <td>".$datos_vista[$i]['nombre_depto']."</td>
                    <td>".$datos_vista[$i]['nombre_empleado']."</th>
                    <td>".$datos_vista[$i]['fecha_determinante']->format('d/m/Y')."</td>
                    <td>";
                    //<button type='button' class='btn btn-outline-primary' onclick='vista_comentarios_vis(\"".$datos_vista[$i]['RDFDA']."\")'>Ver interacciones</button>
                
                    echo"
                    <div class='dropdown'>
                    <button class='btn btn-info dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Acciones
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <a class='dropdown-item' onclick='vista_comentarios_vis(\"".$datos_vista[$i]['RDFDA']."\")' >Ver Interacciones</a>
                    <a class='dropdown-item' onclick='integra(\"".$datos_vista[$i]['RDFDA']."\")' > Integracion</a>
                    </div>
                </div>
                    </td>
                    </tr>";
                }
            
              
               echo" </tbody>
                </table>
        
                ";
        
                self::pagina_responsiva($paginas_por_vista);
        }
        else{
                $cabeceras;
                echo" </tbody>
                </table>
        
                ";
               echo "<h1 class='display-4 text-center'>No hay datos</h1>";
        }
        
        
        }
        
        public function pagina_responsiva($paginas_por_vista){
                
        
        switch ($_GET) {
                case isset($_GET['pagina']):
                        $page =$_GET['pagina'];
                        $nombre_get = "pagina";
                break;
                case isset($_GET['estructura']):
                        $page =$_GET['estructura'];
                        $nombre_get = "estructura";
                break;
                case isset($_GET['Usuario']):
                        $page =$_GET['Usuario'];
                        $nombre_get = "Usuario";
                break;
                case isset($_GET['RFC']):
                        $page =$_GET['RFC'];
                        $nombre_get = "RFC";
                break;
                case isset($_GET['num_det']):
                        $page =$_GET['num_det'];
                        $nombre_get = "num_det";
                break;
                case isset($_GET['Cred']):
                        $page =$_GET['Cred'];
                        $nombre_get = "Cred";
                break;
                case isset($_GET['razon']):
                        $page =$_GET['razon'];
                        $nombre_get = "razon";
                break;

        }
                $pagina_responsiva = $page + 10;
                $anterior = $page - 1;
                $siguiente = $page + 1;
        
                if ($page == 1) {
                        $condicion = "disabled";
                }
                else{
                        $condicion = "";
                }
                echo "<nav aria-label='Page navigation example '>
                <ul class='pagination justify-content-center'>
                <li class='page-item $condicion'><a class='page-link' href='Expedientes.php?$nombre_get=1'>Inicio</a></li>
                <li class='page-item $condicion'><a class='page-link' href='Expedientes.php?$nombre_get=".$anterior."'>anterior</a></li>";
                $k = 1;
                $m = 1;
                if ($paginas_por_vista < 10) {
             
                for ($i=0; $i < $paginas_por_vista ; $i++) { 
                        if ($page == $m) {
                                $active = 'active';
                          }
                          else {
                                  $active = '';
                          }
                        echo"<li class='page-item $active'><a class='page-link' href='Expedientes.php?$nombre_get=".$m++."'>".$k++."</a></li>";
                }
                }
                elseif ($paginas_por_vista > 10) {
                for ($i=$page; $i < $pagina_responsiva ; $i++) { 
                    if ($page == $i) {
                        $active = 'active';
                  }
                  else {
                          $active = '';
                  }
                        echo"<li class='page-item $active'><a class='page-link' href='Expedientes.php?$nombre_get=".$i."'>".$i."</a></li>";
                        
                }
                echo"<li class='page-item disabled '><a class='page-link' href='Expedientes.php?$nombre_get=".($i)."'>...</a></li>";
                } 
                if ($page == $paginas_por_vista) {
                        $condicion1 = "disabled";  
                }
                else{
                        $condicion1 = "";
                }
                 echo" <li class='page-item $condicion1'><a class='page-link' href='Expedientes.php?$nombre_get=".$siguiente."'>siguiente</a></li>
                 <li class='page-item $condicion1'><a class='page-link' href='Expedientes.php?$nombre_get=".$paginas_por_vista."'>Final</a></li>
                </ul>
              </nav>";
        }

   

       
}