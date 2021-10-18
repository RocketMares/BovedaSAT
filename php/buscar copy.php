
<?php
 include_once 'conexion.php';
 $conexion = new ConexionSQL();
 $con = $conexion->ObtenerConexionBD();

    $salida = "";

//    $query = "SELECT * FROM jugadores WHERE Name NOT LIKE '' ORDER By Id_no LIMIT 25";

    if (isset($_POST['consulta'])) {
        $id = $_POST['consulta'];
        $query = "select 
		RDFDA,
		rfc,
		razon_social,
		num_determinante,
		fecha_determinante,
		(SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
		from [Determinante] det
		INNER JOIN Expediente expe on expe.id_expediente=det.id_expediente
		INNER JOIN Contribuyente c on c.id_contribuyente=expe.id_contribuyente
		where
		num_determinante='$id' or
		rfc='$id' or
		razon_social='$id' or
		rfc like '%$id%'
		";
        $resultado = sqlsrv_query($con, $query);
		
		$query2 = "
		select
		count(*) total
		from [Determinante] det
		INNER JOIN Expediente expe on expe.id_expediente=det.id_expediente
		INNER JOIN Contribuyente c on c.id_contribuyente=expe.id_contribuyente
		where
		num_determinante='$id' or
		rfc='$id' or
		razon_social='$id' or
		rfc like '%$id%'
		";
		$resultado2 = sqlsrv_query($con, $query2);
        while ($row = sqlsrv_fetch_array($resultado2, SQLSRV_FETCH_ASSOC)) {
			$total=$row["total"];
		}
        // $resultado = $con->query($query);
		
        if ($resultado != null) {
			$salida.="
			<br>
			<strong>Total de Resultadosss:  ".$total."</strong>
			<br>
			<table class='table table-striped' id='eventsTable' >
    			<thead>
					<tr id='titulo' class='table-info table table-hover mb-0'>
						<td scope='col'>
						<input type='checkbox' name='todo' onClick='seleccionar_todo()' id='todo'>
						</td>
    					<td scope='col'>RFC</td>
    					<td scope='col'>Razon Social</td>
    					<td scope='col'>Determinante</td>
    					<td scope='col'>Fecha Det</td>
    					<td scope='col'>Autoridad</td>
    				</tr>

    			</thead>
    			

    	<tbody>";

		while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
				$salida.="<tr>
						<td><input type='checkbox' name='checkbox[]' id='precio_<?php echo i++?>_td' onClick='paso(this.id, this.checked)'/></td>	
    					<td>".$fila['rfc']."</td>
    					<td>".$fila['razon_social']."</td>
    					<td>".$fila['num_determinante']."</td>
    					<td>".$fila['fecha_determinante']->format("Y/m/d")."</td>
    					<td>".$fila['autoridad']."</td>
    				</tr>";
            }
            $salida.="</tbody></table>";
        } else {
            $salida.="NO HAY DATOS :(";
        }


        echo $salida;

    }


?>