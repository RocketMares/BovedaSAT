<?php

class Vist_Expedientes{
    public function Busqueda_filtrada(){
        include_once 'php/conexion.php';
 $conexion = new ConexionSQL();
 $con = $conexion->ObtenerConexionBD();
 $id_admin = $_SESSION["ses_id_admin"];
 $id_perfil = $_SESSION["ses_id_perfil"];
 $user = $_SESSION["ses_id_usuario"];
    if (isset($_POST['consulta'])) {
		$id = $_POST['consulta'];
		if ($id_perfil== 1) {
			$condicion ="";
		}else{
			$condicion =" where 
			emp.id_empleado  = $user 
				 OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user AND id_admin = $id_admin)
				 OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo =$user ) AND id_admin =  $id_admin )
				 OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user))) ";
		}
		$query="		
		
		select 
		bus.id_proc,
		bus.id_empleado,
			bus.RDFDA,
			bus.rfc,
			bus.razon_social,
			bus.num_determinante,
			bus.fecha_determinante,
			bus.autoridad
			from(select 
			emp.id_empleado,
			id_proc,
			id_determinante,
			RDFDA,
			rfc,
			razon_social,
			num_determinante,
			fecha_determinante,
			(SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
			from [Determinante] det
			INNER JOIN Empleado emp on emp.id_empleado=det.id_empleado
			INNER JOIN Expediente expe on expe.id_expediente=det.id_expediente
			INNER JOIN Contribuyente c on c.id_contribuyente=expe.id_contribuyente $condicion ";
			$resultado = $query;
	
			if(isset($resultado)){
				echo" 
				<table class='table'>
				<thead class='table-dark'>
						<tr>
							<th scope='col'>#</th>
							<th scope='col'>RFC</th>
							<th scope='col'>Razon Social</th>
							<th scope='col'>Fecha Determinante</th>
							<th scope='col'>Autoridad</th>
							<th scope='col'>Estatus</th>
						</tr>
				</thead>
				<tbody>
						";
			while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
				$salida.="
								<tr>
									<td id='rfc' class='td'>".$fila['rfc']."</td>
									<td>".$fila['razon_social']."</td>
									<td>".$fila['num_determinante']."</td>
									<td>".$fila['fecha_determinante']->format("Y/m/d")."</td>
									<td>".$fila['autoridad']."</td>
								</tr>";
			}
		
				echo"	</table>";
			}else{
				echo" 
				<table class='table'>
				<thead class='table-dark'>
						<tr>
							<th scope='col'>#</th>
							<th scope='col'>RFC</th>
							<th scope='col'>Razon Social</th>
							<th scope='col'>Fecha Determinante</th>
							<th scope='col'>Autoridad</th>
							<th scope='col'>Estatus</th>
						</tr>
				</thead>
				<tbody>";
			}
			

    }	
    }
}

