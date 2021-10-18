
<?php
 include_once 'conexion.php';
 $conexion = new ConexionSQL();
 $con = $conexion->ObtenerConexionBD();
 session_start();
 $id_admin = $_SESSION["ses_id_admin"];
 $id_perfil = $_SESSION["ses_id_perfil"];
 $id_depto = $_SESSION["ses_id_depto"];
 $user = $_SESSION["ses_id_usuario"];
 $nom = $_SESSION["ses_rfc_corto"];
    if (isset($_POST['consulta'])) {
		$id = $_POST['consulta'];
		switch ($id_perfil) {
			case 1:
			$condicion ="";
			$prioridad = "<select class='form-control form-control-sm'  id ='prioridad'multiple>
			<option selected>Selecciona la prioridad</option>
			<option value='0'>Normal</option>
			<option value='1'>Urgente</option>
		  </select>
		  ";
			break;
			case 9:
			$condicion ="";
			$prioridad = "<select class='form-control form-control-sm'  id ='prioridad'multiple>
			<option selected>Selecciona la prioridad</option>
			<option value='0'>Normal</option>
			<option value='1'>Urgente</option>
		  </select>
		  ";
			break;
			case 10:
			$condicion ="";
			$prioridad = "<select class='form-control form-control-sm'  id ='prioridad'multiple>
					<option selected>Selecciona la prioridad</option>
					<option value='0'>Normal</option>
					<option value='1'>Urgente</option>
				  </select>
		  ";
			break;
		case 11:
			$condicion ="";
			$prioridad = "<select class='form-control form-control-sm'  id ='prioridad'multiple>
			<option selected>Selecciona la prioridad</option>
			<option value='0'>Normal</option>
			<option value='1'>Urgente</option>
			</select>
			";
			break;
				
		case 12:
			$condicion ="";
			$prioridad = "<select class='form-control form-control-sm'  id ='prioridad'multiple>
			<option selected>Selecciona la prioridad</option>
			<option value='0'>Normal</option>
			<option value='1'>Urgente</option>
			</select>
			";
			break;
			case 2:
			$condicion =" where 
			emp.id_empleado  = $user 
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
			OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
			$prioridad ="";
			
			break;
			case 4:

				$condicion =" where 
			emp.id_empleado  = $user 
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
			OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
			$prioridad ="";
			break;
			case 5:

				$condicion =" where 
			emp.id_empleado  = $user 
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
			OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
			OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
			$prioridad ="";
			break;
			
		}

		
		$query="SELECT * from
		(select 
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
			INNER JOIN Contribuyente c on c.id_contribuyente=expe.id_contribuyente $condicion
			) bus
					where
					num_determinante ='$id' or
					rfc ='$id' or
					razon_social like'%$id%')dos
					where
					dos.id_proc=1 or dos.id_proc=3
					";

        $resultado = sqlsrv_query($con, $query);

		$query2="SELECT count(*) total from
		(select 
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
			INNER JOIN Contribuyente c on c.id_contribuyente=expe.id_contribuyente $condicion
			) bus
					where
					num_determinante ='$id' or
					rfc = '$id' or
					razon_social like'%$id%' )dos
					where
					dos.id_proc=1 or dos.id_proc=3";

        $resultado2 = sqlsrv_query($con, $query2);
        while ($row = sqlsrv_fetch_array($resultado2, SQLSRV_FETCH_ASSOC)) {
            $total=$row["total"];
        }
    
        $salida = "";

        $salida.="
	<br>
	<form method='post' name='form' id='form'>
	<div class='form-row'>
		<div class='form-group col-md-6'>
			<strong>Total de resultados:  ".$total."</strong>
		</div>
		
		<div class='form-group col-md-3' align='right'>	
			<input class='btn btn-secondary' type='reset' name='cancel' id='cancel' value='Desmarcar todos'/>
		</div>
		<div class='form-group col-md-3' align='right'>	
			<select class='custom-select mr-sm-2' id='asunto' name='perfil_b'>
				<option value='0'>Asunto</option>
				<option value='1'>Baja</option>
				<option value='2'>Consulta en Bóveda</option>
				<option value='3'>Consulta en Área</option>
			</select>
		</div>
		<div class='form-group col-md-3' align='right'>	
		$prioridad
		</div>
	</div>
	<br>
	
			
				<table class='table table-striped shadow p-1 bg-white rounded' aling='center '>
				
					<tr class='table-info table table-hover mb-0'> 
					<td>
								<div class='letra2'><b>#</b>
						</td>
						<td>
							<div class='letra1'><b>
								<input type='radio' name='todo' onClick='seleccionar_todo()' id='todo'></b>
						</td>
						<td>
							<div class='letra1'><b>RFC</b>
						</td>
						<td>
							<div class='letra2'><b>Razón Social</b>
						</td>
						<td>
							<div class='letra1'><b>Determinante</b>
						</td>
						<td>
							<div class='letra2'><b>Fecha Det.</b>
						</td>
						<td>
								<div class='letra2'><b>Autoridad</b>
						</td>
					</tr> 
					";

$J = 1;

        while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $salida.="
							<tr>
							<td>".$J++."</td>
								<td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '" .  $fila["RDFDA"] . "'/></td>	
								<td id='rfc' class='td'>".$fila['rfc']."</td>
								<td>".$fila['razon_social']."</td>
								<td>".$fila['num_determinante']."</td>
								<td>".$fila['fecha_determinante']->format("Y/m/d")."</td>
								<td>".$fila['autoridad']."</td>
							</tr>";
        }


        $salida.="

				
						
				</table><br>
				</form>
                                            
	
		</div>
	</body>
	</html>";
        echo $salida;
    }	


	
	