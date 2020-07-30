/*=============================================
DATE RANGE
=============================================*/

$('#daterange-btn2').daterangepicker({
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Buscar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "A",
        "customRangeLabel": "Rango Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
                                     
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().startOf('month'),
    endDate  : moment().endOf('month')

},
  
  function (start, end) {

    $('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

    var fechaInicial = start.format('YYYY-M-D');   
    var fechaFinal = end.format('YYYY-M-D');
    var fPeriodoId = document.getElementById("fPeriodo").value;
    var fGrupo = document.getElementById("fGrupo").value;
    $.ajax({
        type:'POST',
        url:'../Reportes/tablafechas.php',
        data: {'fPeriodoId':fPeriodoId,'fGrupo':fGrupo,'fechai':fechaInicial,'fechaf':fechaFinal},
        success:function(html){   
            $('#datafechas').html(html);   
        }
    });
       
});

$("li[data-range-key='Últimos 30 días']").click(function(){

    function sumarDias(fecha, dias){
      fecha.setDate(fecha.getDate() + dias);
      return fecha;
    }

    var fHasta = new Date();
    var fDesde = sumarDias(fHasta, -30);

    var mesHasta = fHasta.getMonth()+2;
    var diaHasta = fHasta.getDate();
    var añoHasta = fHasta.getFullYear();

    var fechaHasta = (añoHasta + '-' + mesHasta + '-' + diaHasta);  

    var mesDesde = fDesde.getMonth()+1;
    var diaDesde = fDesde.getDate();
    var añoDesde = fDesde.getFullYear(); 

    var fechaDesde = (añoDesde + '-' + mesDesde + '-' + diaDesde);  
    var fPeriodoId = document.getElementById("fPeriodo").value;
    var fGrupo = document.getElementById("fGrupo").value;

    $.ajax({
        type:'POST',
        url:'../Reportes/tablafechas.php',
        data: {'fPeriodoId':fPeriodoId,'fGrupo':fGrupo,'fechai':fechaDesde,'fechaf':fechaHasta},
        success:function(html){   
            $('#datafechas').html(html);   
        }
    });

});


/*=============================================
MOSTRAR GRUPOS AL SELECCIONAR UN PERIODO 
=============================================*/
$('#fPeriodo').on('change',function(){
    
    var sPeriodoId = document.getElementById("fPeriodo").value;
    $.ajax({
        type:'POST',
        url:'../ajax/grupohorario.ajax.php',
        data: {'sPeriodoId':sPeriodoId},
        success:function(html){   
            $('#fGrupo').html(html);   
        }
    }); 
});

$('#fGrupo').on('change',function(){
    
    var fPeriodoId = document.getElementById("fPeriodo").value;
    var fGrupo = document.getElementById("fGrupo").value;
    var startD =moment($('#daterange-btn2').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
    var endD = moment($('#daterange-btn2').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
    
    $.ajax({
        type:'POST',
        url:'../Reportes/tablafechas.php',
        data: {'fPeriodoId':fPeriodoId,'fGrupo':fGrupo,'fechai':startD,'fechaf':endD},
        success:function(html){   
            $('#datafechas').html(html);   
        }
    }); 
});

function descargar(){
    var fPeriodoId = document.getElementById("fPeriodo").value;
    var fGrupo = document.getElementById("fGrupo").value;
    var startD =moment($('#daterange-btn2').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
    var endD = moment($('#daterange-btn2').data('daterangepicker').endDate._d).format('YYYY-MM-DD');

    if ( fGrupo == 0) {
        $("#datafechas").html("<p class='alert alert-danger'>Selecciona un periodo y un grupo para descargar el reporte</p>");
    } else {
        window.location = "../Reportes/excelFechas.php?periodo="+fPeriodoId+"&&grupo="+fGrupo+"&&fechai="+startD+"&&fechaf="+endD;   
    }
};


