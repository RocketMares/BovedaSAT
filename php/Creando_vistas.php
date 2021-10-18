<?php
class Vistas_de_Usuarios
{
    
function vistaGeneral(){
        include_once 'php/ConsultaContribuyentes.php';
        $busqueda = new ConsultaContribuyentes();
        if (isset($_GET['consulta_tik_pet'])) {
            $consulta_pet = $_GET['consulta_tik_pet'];
        }else{
            $consulta_pet = "";
        }
        if (isset($_GET['consulta_tik_prest'])) {
            $consulta_prest= $_GET['consulta_tik_prest'];
        }else{
            $consulta_prest = "";
        }
        if (isset($_GET['consulta_tik_dev'])) {
            $consulta_dev= $_GET['consulta_tik_dev'];
        }else{
            $consulta_dev = "";
        }
        
        $datos_pet = $busqueda->bus_peticion_tikets($consulta_pet);
        $datos_prest = $busqueda->bus_prestamos_tikets($consulta_prest);
        $datos_dev = $busqueda->bus_peticion_tikets_Devolucion($consulta_dev);
        
        $id_perfil = $_SESSION['ses_id_perfil'];
        echo"
        <div class='row py-3 mx-lg-n5' id='contenido1'>
        <div class='col py-3 px-lg-3'>
            <div class='container'>
                <div class='row'>
                    <div class='col text-center'>
                    <h2 style='color:#907b04;' class='display-6'>Peticiones</h2>
                    </div>";
                    $Total_pedidos = $busqueda->contador_det_por_usu();
                   if( $id_perfil == 5 || $id_perfil == 11 || $id_perfil == 12){
                       if($Total_pedidos['total'] < 100){
                        $restatntes_sub=100-$Total_pedidos['total'];
                        echo"
                        <div class='col-6'>

                            <button type='submit' id='agregar_peticion' class='btn btn-primary' >
                            <i class='fas fa-plus'></i></button>
                        </div>
                      
                        <div class='col-6'>Puedes Solicitar ".$restatntes_sub." expedientes</div>
                        ";
                   }
                   else{
                        echo"
                        <div class='col-6'>
                        Llegaste al maximo de prestamos
                        </div>";
                   }
                   } 
                   
                   if($id_perfil == 1|| $id_perfil == 2|| $id_perfil == 9 || $id_perfil == 10|| $id_perfil == 4|| $id_perfil == 7 ){
                       if($Total_pedidos['total'] < 25){
                            $restatntes=25-$Total_pedidos['total'];
                            echo"
                            <div class='col-6'>
                                <button type='submit' id='agregar_peticion' class='btn btn-primary'><i
                                        class='fas fa-plus'></i></button>
                            </div>
                            <div class='col-6'>Puedes Solicitar ".$restatntes." expedientes</div>
                            ";
                       }
                       else{
                            echo"
                            <div class='col-6'>
                            Llegaste al maximo de prestamos
                            </div>";
                       }
                        
                   }
                    echo"
                </div>
            </div>
        </div>
        <div class='col py-3 px-lg-3 text-center'> <h2 class='display-6' style='color:#907b04';>Préstamos</h2></div>
        <div class='col py-3 px-lg-3 text-center '><h2 class='display-6' style='color:#907b04';> Devoluciones</h2></div>
    </div>
    <div class='row table text-center' id='contenido2'>";
        //------------------------------------TABLA DE SOLICITUDES ACTIVAS/EN BUSQUEDA/DISPONIBLES-----------------------------------------
        if ($datos_pet != null) {
        echo "
        <div class='col-4 table table-responsive vh-50'>
        <nav class='navbar navbar-expand-lg  navbar-dark  bd-navbar'>
        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm-2 letras'placeholder='Buscar Tikets' type='text' name='consulta_tik_pet' id='consulta_tik_pet'></input>
        </form>
        </nav>
            <table class='table table-sm table-striped table-hover  shadow p-1 bg-white rounded'>
                <thead class='table table-danger sticky-top'>
                    <tr>
                        <th>Ticket</th>
                        <th>Fecha Pet.</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                    </tr>";
                    echo"
                </thead>
                <tbody id='developers'class=' text-center'>";
                    for ($i = 0; $i < count($datos_pet); $i++) {
                        if ($datos_pet[$i]["id_proc"]==2) {
                            $semaforo='spinner-grow text-danger' ;
                            $Texto='Petición en <br> Curso' ;
                            
                            $Fecha=$datos_pet[$i]["fecha_mov"]->format('d/m/Y');
                        }
                        if ($datos_pet[$i]["id_proc"]==7) {
                            $semaforo='spinner-grow text-warning' ;
                            $Texto='Busqueda' ;
                            $Fecha=$datos_pet[$i]["fecha_valida"]->format('d/m/Y');
                        }
                        if ($datos_pet[$i]["id_proc"]==11) {
                            $semaforo='spinner-grow text-success' ;
                            $Texto='Petición Lista' ;
                            $Fecha=$datos_pet[$i]["fecha_dispone"]->format('d/m/Y');
                        }
                        $prioridad = $datos_pet[$i]["Prioridad"];
                        if ($prioridad == 1) {
                           $color = "class='bg-dark text-white'";
                        }
                        elseif ($prioridad == 0) {
                            $color = "class='table-light'";
                        }
                        else{
                            $color = "class='table-light'";
                        }

                            echo "
                        <tr $color>
                            <td>
                            ";

                            if ($id_perfil == 1 ) {
                                echo"<div class='btn-group dropright'>
                                <button type='button' class='btn btn-outline-info ' onclick='detalle_tiket_peticion(".$datos_pet[$i]["id_tiket"] . ")'>
                                " . $datos_pet[$i]["id_tiket"] . "
                                </button>
                                <button type='button' class='btn btn-outline-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                  <span class='sr-only'>Toggle Dropright</span>
                                </button>
                                <div class='dropdown-menu'>
                                <a class='dropdown-item' onclick='Abre_modal_reasinga( ".$datos_pet[$i]["id_tiket"] .")'>Reasingar Ticket</a>
                                </div>
                                </div> ";
                            }
                            else{
                                echo"<a class='btn btn-outline-info' href='#'onclick='detalle_tiket_peticion(" . $datos_pet[$i]["id_tiket"] . ")'>" .$datos_pet[$i]["id_tiket"] . "</a>";
                            }
                           
                         echo" </td>
                            <td>" . $Fecha . "</td>
                            <td>
                                <div class='$semaforo' role='status'>
                                    <span class='sr-only'>Loading...</span>
                                </div>
                            </td>
                            <td>
                                <p> $Texto </p>
                            </td>
                        </tr>";
                       
                    }
               echo "</tbody>
            </table>    
        </div> ";
       
        } else {
    
        echo "
        <div class='col-4  table-responsive vh-50'>
        <nav class='navbar navbar-expand-lg  navbar-light bg-light'>
        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm-2 letras'placeholder='Buscar Tikets' type='text' name='consulta_tik_pet' id='consulta_tik_pet'></input>
        </form>
        </nav>
            <table class='table table-sm table-striped table-hover shadow p-1 bg-white rounded'>
                <thead class='table table-sm table-danger sticky-top'>
                    <tr>
                        <th>Ticket</th>
                        <th>Fecha Pet.</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tr>
                    <td>S/N</td>
                    <td>S/N</td>
                    <td>S/N</td>
                    <td>S/N</td>
                </tr>
                </tbody>
            </table>
        </div> ";
        }
        //---------------------------------------TABLA DE PRESTAMOS ACTIVOS-----------------------------------------
        if ($datos_prest != null) {
        echo "
        <div class='col-4 table-responsive vh-50'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>

        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm' type='search' placeholder='Buscar Tikets' aria-label='Search'name='consulta_tik_prest' id='consulta_tik_prest'>
        </form>
        </nav>
            <table class='table table-sm table-striped table-hover shadow p-1 bg-white rounded'>
                <thead class='table table-warning sticky-top'>
                    <tr>
                        <th>Tiket</th>
                        <th>Fecha Prest.</th>
                        <th>Días vigentes de Prest.</th>
                    </tr>
                </thead>
                <tbody id='developers'>";
                    for ($i = 0; $i < count($datos_prest); $i++) { $Fecha_prest=$datos_prest[$i]["fecha_prest"]->format("d/m/Y");
                        $contador_horas_prest = $busqueda->bus_tiket_de_dias_dispo_en_prest($datos_prest[$i]['id_tiket']);
                        $horas_prest = $contador_horas_prest[0]['diferencia'];
                        $dia_semana_ingl = $contador_horas_prest[0]['dia_sem'];
                        $horas_prest = $contador_horas_prest[0]['diferencia'];

                        
                        $horas_prest = ($horas_prest  - 48);
                        if ($horas_prest < 0) {
                           $Resultado = 0;
                        }
                        else {
                            $Resultado = $horas_prest;
                        }
                        
                        $divid_x_dias = (intdiv($Resultado,24));
                        if ($divid_x_dias >= 5) {
                            $color = "table-danger";
                        }
                        elseif($divid_x_dias >= 3) {
                            $color = "table-warning";
                        }else  {
                            $color = "";
                        }

                                                
                        echo "
                        <tr class='$color' >
                            <td>";
                            if ($id_perfil == 1 ) {
                                echo"<div class='btn-group dropright'>
                                <button type='button' class='btn btn-outline-info ' onclick='detalle_tiket_pestamo(".$datos_prest[$i]["id_tiket"] . ")'>
                                " . $datos_prest[$i]["id_tiket"] . "
                                </button>
                                <button type='button' class='btn btn-outline-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                  <span class='sr-only'>Toggle Dropright</span>
                                </button>
                                <div class='dropdown-menu'>
                                <a class='dropdown-item' onclick='Abre_modal_reasinga( ".$datos_prest[$i]["id_tiket"] .")'>Reasingar Ticket</a>
                                </div>
                                </div> ";
                            }
                            else{
                                echo"<a class='btn btn-outline-info' href='#'onclick='detalle_tiket_pestamo(" . $datos_prest[$i]["id_tiket"] . ")'>" .$datos_prest[$i]["id_tiket"] . "</a>";
                            }
                           echo" </td>
                            <td>" . $Fecha_prest . "</td>
                            <td>". $divid_x_dias  ."  de 5 días  </td>
                        </tr>";
                        }
                        echo "
                </tbody>
            </table>
        </div>";
        } else {
        echo "
        <div class='col-4 table table-responsive vh-50'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>

        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm' type='search' placeholder='Buscar Tikets' aria-label='Search'name='consulta_tik_prest' id='consulta_tik_prest'>
        </form>
        </nav>
        <table class='table table-sm table-striped table-hover shadow p-1 bg-white rounded'>
                <thead class='table table-warning sticky-top'>
                    <tr>
                        <th>Ticket</th>
                        <th>Fecha Prest.</th>
                        <th>Días vigentes de Prest.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>S/N</td>
                        <td>S/N</td>
                        <td>S/N</td>
                    </tr>
                </tbody>
            </table>
        </div>
        ";
        }
    
        if ($datos_dev != null) {
        //------------------------------------TABLA DE DEVOLUCIONES EN PROCESO/PARCIALES/CONCRETAS-----------------------------------------
      
        echo "
        <div class='col-4 table-responsive vh-50'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light '>
        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm' type='search' placeholder='Buscar Tikets' aria-label='Search'name='consulta_tik_dev' id='consulta_tik_dev'>
        </form>
        </nav>
            <table class='table table-sm table-striped table-hover shadow p-1 bg-white rounded' >
                <thead class='table table-success sticky-top'>
                    <tr>
                        <th>Ticket</th>
                        <th>Fecha Dev.</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody id='developers'>";
                    for ($i = 0; $i < count($datos_dev); $i++) { 
                        $Resultado = $busqueda->Contador_determinantes_por_tiket($datos_dev[$i]["id_tiket"]);

                        //$datos_muestra = json_encode($Resultado);
                        $Fecha_pet_dev = ($datos_dev[$i]["fecha_pet_dev"] != null) ? $datos_dev[$i]["fecha_pet_dev"]->format('d/m/Y') : null;
                        $Fecha_recive_com = ($datos_dev[$i]["fecha_recive_comp"] != null) ? $datos_dev[$i]["fecha_recive_comp"]->format('d/m/Y') : null;
                        $Fecha_reciv_par = ($datos_dev[$i]["fecha_recive_par"] != null) ? $datos_dev[$i]["fecha_recive_par"]->format('d/m/Y') : null;
                        if ($datos_dev[$i]["id_proc"]==5) {
                        $semaforo='spinner-grow text-danger' ; $Texto2='Proceso de Devolución' ; 
                        $Fecha = $Fecha_pet_dev;
                    } if
                        ($datos_dev[$i]["id_proc"]==9) { $semaforo='spinner-grow text-warning' ;
                        $Texto2='Devolución Parcial' ; 
                        $Fecha = $Fecha_reciv_par;
                    } 
                     if ($datos_dev[$i]["id_proc"]==4) 
                        {
                        $semaforo='spinner-grow text-success' ; $Texto2='Devuelto' ; 
                        $Fecha = $Fecha_recive_com;
                        } 

                        $proceso = $datos_dev[$i]["id_proc"];
                        echo "
                        <tr>

                            <td>";
                            switch ($proceso) {
                                case 9:
                                    if ($id_perfil == 1  ) {
                                        echo"<div class='btn-group dropright'>
                                        <button type='button' class='btn btn-outline-info ' onclick='detalle_tiket_dev(".$datos_dev[$i]["id_tiket"] . ")'>
                                        " . $datos_dev[$i]["id_tiket"] . "
                                        </button>
                                        <button type='button' class='btn btn-outline-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                          <span class='sr-only'>Toggle Dropright</span>
                                        </button>
                                        <div class='dropdown-menu'>
                                        <a class='dropdown-item' onclick='Abre_modal_reasinga( ".$datos_dev[$i]["id_tiket"] .")'>Reasingar Ticket</a>
                                        </div>
                                        </div> ";
                                    }
                                    else{
                                        echo"<a class='btn btn-outline-info' href='#'onclick='detalle_tiket_dev(" . $datos_dev[$i]["id_tiket"] . ")'>" .$datos_dev[$i]["id_tiket"] . "</a>";
                                    }
                                break;
                                case 5:
                                    if ($id_perfil == 1  ) {
                                        echo"<div class='btn-group dropright'>
                                        <button type='button' class='btn btn-outline-info ' onclick='detalle_tiket_dev(".$datos_dev[$i]["id_tiket"] . ")'>
                                        " . $datos_dev[$i]["id_tiket"] . "
                                        </button>
                                        <button type='button' class='btn btn-outline-info dropdown-toggle dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                          <span class='sr-only'>Toggle Dropright</span>
                                        </button>
                                        <div class='dropdown-menu'>
                                        <a class='dropdown-item' onclick='Abre_modal_reasinga( ".$datos_dev[$i]["id_tiket"] .")'>Reasingar Ticket</a>
                                        </div>
                                        </div> ";
                                    }
                                    else{
                                        echo"<a class='btn btn-outline-info' href='#'onclick='detalle_tiket_dev(" . $datos_dev[$i]["id_tiket"] . ")'>" .$datos_dev[$i]["id_tiket"] . "</a>";
                                    }
                                break;
                                
                                default:

                                    echo"<a class='btn btn-outline-info' href='#'onclick='detalle_tiket_dev(" . $datos_dev[$i]["id_tiket"] . ")'>" .$datos_dev[$i]["id_tiket"] . "</a>";
                                
                                break;
                            }

                           echo" </td>
                            <td>" . $Fecha . "</td>
                            <td>
                                <div class='$semaforo' role='status'>
                                    <span class='sr-only'>Loading...</span>
                                </div>
                            </td>
                            <td>
                                <p>$Texto2</p>
                                <p>".$Resultado['devueltos']."/".$Resultado['total_det']."</p>
                            </td>
                            
                        </tr>
                        ";
                    
                        }
                        echo" </tbody>
            </table>
            </div>
            </div>
            </div>";

        } else {
        echo "
        <div class='col-4 table'>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>
        <form class='form-inline my-2 my-lg-0'>
        <input class='form-control mr-sm' type='search' placeholder='Buscar Tikets' aria-label='Search'name='consulta_tik_dev' id='consulta_tik_dev'>
        </form>
        </nav>
            <table class='table table-sm table-hover table-striped shadow p-1 bg-white rounded'>
                <thead class='table table-success'>
                    <tr>
                        <th>Ticket</th>
                        <th>Fecha Dev.</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                    </tr>";
                    echo"
                </thead>
                <TBODY>
                    <tr>
                        <td>S/N</td>
                        <td>S/N</td>
                        <td>S/N</td>
                        <td>S/N</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>";
        }

    }

}
?>
