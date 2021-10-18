<?php


class CrearMenu
{

  public function ConsultaMenu($id_perfil,$id_padre)
  {
      include_once 'conexion.php';
      $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
      //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
      $con = $conexion->ObtenerConexionBD();
      $query = "SELECT * FROM MENU_APP WHERE ID_PERFIL = $id_perfil and id_padre = $id_padre ORDER BY orden ASC";

      $rst = sqlsrv_query($con,$query);
      $filas[] = null;
      if ($rst) {
        while ($rows = sqlsrv_fetch_array($rst,SQLSRV_FETCH_ASSOC)) {
          $filas[] = array('id_menu' => $rows['id_menu'],'id_padre' => $rows['id_padre'],
          'orden' => $rows['orden'],'nombre_menu' => $rows['nombre_menu'],'url_menu' => $rows['url_menu'],
        'estatus' => $rows['estatus']);
        }
        return $filas;
        $conexion->CerrarConexion($con);
      }
  }

  public function ConsultaMenu_Encabezados($id_perfil)
  {
      include_once 'conexion.php';
      $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
      //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
      $con = $conexion->ObtenerConexionBD();
      $query = "SELECT * FROM Menu_app WHERE id_perfil = $id_perfil AND id_padre = 0 ORDER BY orden ASC";

      $rst = sqlsrv_query($con,$query);
      if ($rst) {
        $filas[] = null;
        while ($rows = sqlsrv_fetch_array($rst,SQLSRV_FETCH_ASSOC)) {
          $filas[] = array('id_menu' => $rows['id_menu'],'id_padre' => $rows['id_padre'],
          'orden' => $rows['orden'],'nombre_menu' => $rows['nombre_menu'],'url_menu' => $rows['url_menu'],
        'estatus' => $rows['estatus']);
        }
        return $filas;
        $conexion->CerrarConexion($con);
      }
  }

  public function RenderMenu($id_perfil)
  {
    $menu = self::ConsultaMenu_Encabezados($id_perfil);
    $html[] = null;
    $posicion = 0;
    $html[$posicion] = "<ul class='navbar-nav mr-auto '>";
    for ($i = 0; $i <count($menu);$i++) {
      if ($menu[$i]["estatus"] == "A") {
        $posicion++;
        $html[$posicion] ="<li class='nav-item'><a class='nav-link' href='". $menu[$i]['url_menu']."'>". $menu[$i]['nombre_menu']."</a></li>";
        $submenu = self::ConsultaMenu($id_perfil,$menu[$i]["id_menu"]);
        if (count($submenu)-1 !=0) {
          $html[$posicion] = "<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='". $menu[$i]['url_menu']."'>".$menu[$i]['nombre_menu']."</a>
          <div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
          for ($j = 0; $j<count($submenu); $j++) {
            if ($submenu[$j]["estatus"] == "A") {
              $posicion++;
              $html[$posicion] = "<a class='dropdown-item bg-light' href='".$submenu[$j]['url_menu']."'>".$submenu[$j]['nombre_menu']."</a>";
              $subopcion = self::ConsultaMenu($id_perfil,$submenu[$j]["id_menu"]);
              if (count($subopcion)-1 !=0) {
                $posicion++;
                $html[$posicion] = "<div class='dropdown-divider'></div>";
                for ($m=0; $m <count($subopcion) ; $m++) {
                  if ($subopcion[$m]["estatus"] == "A") {
                    $posicion++;
                    $html[$posicion] = "<a class='dropdown-item' href='".$subopcion[$m]['url_menu']."'>".$subopcion[$m]['nombre_menu']."</a>";
                  }
                }
                $posicion++;
                $html[$posicion] = "<div class='dropdown-divider'></div>";
              }
            }
          }
          $posicion++;
          $html[$posicion] = "</div>
          </li>";
        }
      }
    }
  return $html;
  }

}


 ?>
