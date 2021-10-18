

    function reporte(local) {
        //alert(local);
        var id_loc = local;
        location.href="php/analisis/genera_Excel.php?id_admin="+id_loc 
    }
    function Reporte_Bloqueos(local) {
        //alert(local);
        var id_loc = local;
       location.href="php/analisis/genera_Excel.php?Bloqueos="+id_loc 
    }
    function reporte_Notificados(Local) {
        //alert(Local);
        
        var localizados = Local;
        location.href="php/analisis/genera_Excel.php?localizados="+localizados
    }
    function reporte_Desvirtuados(Local) {
        //alert(Local);
        var Desvirtuados = Local;
        location.href="php/analisis/genera_Excel.php?Desvirtuados="+Desvirtuados
    }
    function reporte_por_year(local){
        var years = $("#years").val();
        //var years = document.querySelector('#years')
        //alert(years);
        var id_local = local
        var  Num_year = years ;
        location.href="php/analisis/genera_Excel.php?year="+Num_year+"&local="+id_local
    }

    function reporte_Asistencias(local) {
        var years2 = $("#years2").val();
        //alert(years2);
        var id_local = local
        var Num_year2 = years2;
        location.href="php/analisis/genera_Excel.php?Asistencia="+Num_year2+"&local="+id_local

    }
    function reporte_Regurlarizados(local){
    var years3 = $("#years3").val();
    //alert(years3);
    var id_local = local
    var Num_year3 = years3;
    location.href="php/analisis/genera_Excel.php?Regularizados="+Num_year3+"&local="+id_local

    }
    function graf_loc_no_loc(loc,noloc,sinnotif){

        //alert(loc);
        document.write("<canvas id=\"myChart\" class='my-8 w-100 chartjs-render-monitor' style='height:25%vh'></canvas>");
        var ctx = document.getElementById('myChart').getContext('2d');
        var col1=Math.floor(Math.random() * (255 - 1)) + 1;
        var col2=Math.floor(Math.random() * (255 - 1)) + 1;
        var col3=Math.floor(Math.random() * (255 - 1)) + 1;
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Localizado', 'No Localizado', 'Sin Notificar'],
                datasets: [{
                    label: '',
                    data: [loc, noloc, sinnotif,],
                    backgroundColor: [
                        'rgba('+col1+', '+col2+', 132, 0.4)',
                        'rgba(54, '+col1+',  '+col2+', 0.4)',
                        'rgba('+col3+', 206, '+col1+', 0.4)'
                    ],
                    borderColor: [
                        'rgba('+col1+', '+col2+', 132, 1)',
                        'rgba(54, '+col1+',  '+col2+', 1)',
                        'rgba( '+col3+', 206, '+col1+', 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
  }
  function graf_Asis_no_Asis(Asistencias,No_asistencia,No_notificiado){
    //alert('hola');
    document.write("<canvas id=\"myChart3\" class='my-8 w-100 chartjs-render-monitor' style='height:25%vh'></canvas>");
    var ctx = document.getElementById('myChart3').getContext('2d');
    var col1=Math.floor(Math.random() * (255 - 1)) + 1;
    var col2=Math.floor(Math.random() * (255 - 1)) + 1;
    var col3=Math.floor(Math.random() * (255 - 1)) + 1;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Asistencias', 'No Asistencias', 'No Notificados'],
            datasets: [{
                label: 'Asistencias',
                data: [Asistencias, No_asistencia, No_notificiado   ,],
                backgroundColor: [
                    'rgba('+col1+', 179, '+col2+', 0.4)',
                    'rgba('+col2+', 215, '+col1+', 0.4)',
                    'rgba('+col1+', 160, '+col3+', 0.4)'
                ],
                borderColor: [
                    'rgba(60, 179, 113, 1)',
                    'rgba(255, 215, 0, 1)',
                    'rgba( 255, 160, 122, .2)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
function graf_Regularizados(Regularizados,Total_sin_regular,Total_Desvirtuados){
    //alert('hola');
    document.write("<canvas id=\"myChart2\" class='my-8 w-100 chartjs-render-monitor' style='height:25%vh'></canvas>");
    var ctx = document.getElementById('myChart2').getContext('2d');
    var col1=Math.floor(Math.random() * (255 - 1)) + 1;
    var col2=Math.floor(Math.random() * (255 - 1)) + 1;
    var col3=Math.floor(Math.random() * (255 - 1)) + 1;
    var col4=Math.floor(Math.random() * (255 - 1)) + 1;
    var col5=Math.floor(Math.random() * (255 - 1)) + 1;
    var col6=Math.floor(Math.random() * (255 - 1)) + 1;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Regularizados', 'Total_sin_regular','Total_Desvirtuados'],
            datasets: [{
                label: 'Total Regulados',
                data: [Regularizados, Total_sin_regular,Total_Desvirtuados],
                backgroundColor: [
                    'rgba('+col1+', '+col2+', 132,0.4)',
                    'rgba(54, '+col1+',  '+col2+', 0.4)',
                    'rgba('+col3+', 206, '+col1+', 0.4)',
                    'rgba('+col4+', '+col4+', 132, 0.4)',
                    'rgba(54, '+col5+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)'
                ],
                borderColor: [
                    'rgba('+col1+', '+col2+', 132, 0.4)',
                    'rgba(54, '+col1+',  '+col2+', 0.4)',
                    'rgba('+col3+', 206, '+col1+', 0.4)',
                    'rgba('+col1+', '+col4+', 132, 0.4)',
                    'rgba(54, '+col1+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)'
                ],
           
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
function graf_Regularizados2(
    Total_Regulados_Dentro_de_Plazo_10
    ,Total_Regulados_Dentro_de_Plazo_30
    ,Total_Regulados_Fuera_de_Plazo
    ,Total_Regulados_Antes_de_Plazo
    ,Total_Desvirtuados){
    //alert('hola');
    document.write("<canvas id=\"myChart5\" class='my-8 w-100 chartjs-render-monitor' style='height:25%vh'></canvas>");
    var ctx = document.getElementById('myChart5').getContext('2d');
    var col1=Math.floor(Math.random() * (255 - 1)) + 1;
    var col2=Math.floor(Math.random() * (255 - 1)) + 1;
    var col3=Math.floor(Math.random() * (255 - 1)) + 1;
    var col4=Math.floor(Math.random() * (255 - 1)) + 1;
    var col5=Math.floor(Math.random() * (255 - 1)) + 1;
    var col6=Math.floor(Math.random() * (255 - 1)) + 1;
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Total_Regulados_Dentro_de_Plazo_10',
             'Total_Regulados_Dentro_de_Plazo_30'
            ,'Total_Regulados_Fuera_de_Plazo'
            ,'Total_Regulados_Antes_de_Plazo'
            ,'Total_Desvirtuados'],
            datasets: [{
                label: 'Total Regulados',
                data: [Total_Regulados_Dentro_de_Plazo_10
                    , Total_Regulados_Dentro_de_Plazo_30
                    ,Total_Regulados_Fuera_de_Plazo
                    ,Total_Regulados_Antes_de_Plazo
                    ,Total_Desvirtuados],
                backgroundColor: [
                    'rgba('+col1+', '+col2+', 132,0.4)',
                    'rgba(54, '+col1+',  '+col2+', 0.4)',
                    'rgba('+col3+', 206, '+col1+', 0.4)',
                    'rgba('+col4+', '+col4+', 132, 0.4)',
                    'rgba(54, '+col5+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)'
                ],
                borderColor: [
                    'rgba('+col1+', '+col2+', 132, 0.4)',
                    'rgba(54, '+col1+',  '+col2+', 0.4)',
                    'rgba('+col3+', 206, '+col1+', 0.4)',
                    'rgba('+col1+', '+col4+', 132, 0.4)',
                    'rgba(54, '+col1+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)'
                ],
           
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
/*
function graf_Comparativa_Bimestral(
    Enero_feb,
    Marzo_Abril,
    Mayo_Junio,
    Julio_Agosto,
    Septiembre_Octubre,
    Noviembre_Diciembre)
    
    {
    document.write("<canvas id=\"myChart1\" class='my-8 w-100 chartjs-render-monitor' style='height:25%vh'></canvas>");
    var ctx = document.getElementById('myChart1').getContext('2d');
    var col1=Math.floor(Math.random() * (255 - 1)) + 1;
    var col2=Math.floor(Math.random() * (255 - 1)) + 1;
    var col3=Math.floor(Math.random() * (255 - 1)) + 1;
    var col4=Math.floor(Math.random() * (255 - 1)) + 1;
    var col5=Math.floor(Math.random() * (255 - 1)) + 1;
    var col6=Math.floor(Math.random() * (255 - 1)) + 1;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
            'Enero_feb',
            'Marzo_Abril',
            'Mayo_Junio',
            'Julio_Agosto',
            'Septiembre_Octubre',
            'Noviembre_Diciembre'],
            datasets: [{
                data: [
                    Enero_feb,
                    Marzo_Abril,
                    Mayo_Junio,
                    Julio_Agosto,
                    Septiembre_Octubre,
                    Noviembre_Diciembre],
                backgroundColor: [
                    'rgba('+col1+', '+col2+', 132,0.4)',
                    'rgba(54, '+col1+',  '+col2+', 0.4)',
                    'rgba('+col3+', 206, '+col1+', 0.4)',
                    'rgba('+col4+', '+col4+', 132, 0.4)',
                    'rgba(54, '+col5+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)',
                ],
                borderColor: [
                    'rgba('+col1+', '+col2+', 132, 0.4)',
                   'rgba(54, '+col1+',  '+col2+', 0.4)',
                   'rgba('+col3+', 206, '+col1+', 0.4)',
                   'rgba('+col1+', '+col4+', 132, 0.4)',
                   'rgba(54, '+col1+',  '+col5+', 0.4)',
                    'rgba('+col5+', 206, '+col6+', 0.4)'
                ],
           
               borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                       beginAtZero: true
                   }
                }]
            }
        }
    });
}*/
/*
function prueva(año) {
alert(año);
//$('#res').datagrid('reload');
var Year = año
createCookie('year',Year,1)
$('#res').datagrid('reload');
//location.href="LocNoLoc.php";
}*/