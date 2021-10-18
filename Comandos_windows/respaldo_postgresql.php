<?php

/*
En el caso de este servidor no ocupa la contraseña, pero si lo llegase a necesitar se puede usar este:
$resultado = shell_exec("pg_dump -i -h localhost -p 5432 -U postgres -W @nalisis_123 -d BDSistema -F c -b -v -f \"D:\respaldos_cartera\respaldo_cartera_20190808.backup\"");
*/
date_default_timezone_set('America/Mexico_City');
$hoy = date_create('now');
$resultado = exec("pg_dump -i -h 99.85.26.227 -p 5432 -U postgres -d BDSistema -F c -b -v -f \"D:\\respaldos_cartera\\respaldo_cartera_".$hoy->format('dmY').".backup\"");
print "Salida: $resultado\n"; 

?>