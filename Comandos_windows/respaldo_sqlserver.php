<?php

/*
En el caso de este servidor no ocupa la contraseña, pero si lo llegase a necesitar se puede usar este:
$resultado = shell_exec("pg_dump -i -h localhost -p 5432 -U postgres -W @nalisis_123 -d BDSistema -F c -b -v -f \"D:\respaldos_cartera\respaldo_cartera_20190808.backup\"");
*/

$resultado = exec("sqlcmd -S 99.85.26.227 -U Analisis -P Malitos18 -i D:\\QuerysBD\\respaldos_227.sql -o D:\\QuerysBD\\respaldos_227.txt");
print "Salida: $resultado\n"; 

$resultado2 = exec("sqlcmd -S 99.85.25.255 -U gestorUser -P \"Alva%1999\" -i D:\\QuerysBD\\respaldos_255.sql -o D:\\QuerysBD\\respaldos_255.txt");
print "Salida: $resultado2\n"; 

$resultado3 = exec("sqlcmd -S 99.85.25.254 -U sa -P \"@nalsiisadrdf4\" -i D:\\QuerysBD\\respaldos_254.sql -o D:\\QuerysBD\\respaldos_res_254.txt");
print "Salida: $resultado3\n"; 

?>