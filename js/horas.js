/*=============================================
DATE RANGE
=============================================*/
$('#daterange-btn3').daterangepicker({

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

    $('#daterange-btn3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

    var fechaInicial = start.format('YYYY-M-D');   
    var fechaFinal = end.format('YYYY-M-D');
    var dniH = document.getElementById("dnirh").value;
    var apePH = document.getElementById("apellidosPH").value;
    var apeMH = document.getElementById("apellidosMH").value;
    var nombreH = document.getElementById("nombresH").value;
    
    var estado = document.getElementById("rh").checked;
    
    // SELECION DE DNI
    if(estado==true){
        if ( dniH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>El campo dni no puede ir vacio</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':fechaInicial, 'fechaFinal':fechaFinal},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });    
        }
    }
       
    // SELECION DE NOMBRES Y APELLIDOS
    if(estado==false){
        if ( nombreH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>Ingrese el nombre para la busqueda</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':fechaInicial, 'fechaFinal':fechaFinal},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });
        }
    }
       
  
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
    var dniH = document.getElementById("dnirh").value;
    var apePH = document.getElementById("apellidosPH").value;
    var apeMH = document.getElementById("apellidosMH").value;
    var nombreH = document.getElementById("nombresH").value;
    
    var estado = document.getElementById("rh").checked;
    
    // SELECION DE DNI
    if(estado==true){
        if ( dniH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>El campo dni no puede ir vacio</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':fechaDesde, 'fechaFinal':fechaHasta},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });    
        }
    }
       
    // SELECION DE NOMBRES Y APELLIDOS
    if(estado==false){
        if ( nombreH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>Ingrese el nombre para la busqueda</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':fechaDesde, 'fechaFinal':fechaHasta},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });
        }
    }
    
});

function radioS(){
    
    var condicion = document.getElementById("rh").checked;
    
    // SELECION DE DNI
    if(condicion==true){
        document.getElementById('apellidosyNombre').style.display = 'none';
		document.getElementById('solo_dni').style.display = 'block';
        $("#apellidosPH").val("");
        $("#apellidosMH").val("");
        $("#nombresH").val("");
    }
       
    // SELECION DE NOMBRES Y APELLIDOS
    if(condicion==false){
        document.getElementById('apellidosyNombre').style.display = 'block';
        document.getElementById('solo_dni').style.display = 'none';
        $("#dnirh").val("");
    } 
    

}

function buscarInfo(){
    var dniH = document.getElementById("dnirh").value;
    var apePH = document.getElementById("apellidosPH").value;
    var apeMH = document.getElementById("apellidosMH").value;
    var nombreH = document.getElementById("nombresH").value;
    
    var startD =moment($('#daterange-btn3').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
    var endD = moment($('#daterange-btn3').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
    
    var estado = document.getElementById("rh").checked;
    
    // SELECION DE DNI
    if(estado==true){
        if ( dniH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>El campo dni no puede ir vacio</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':startD, 'fechaFinal':endD},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });    
        }
    }
       
    // SELECION DE NOMBRES Y APELLIDOS
    if(estado==false){
        if ( nombreH === "") {
        $("#dataHoras").html("<p class='alert alert-danger'>Ingrese el nombre para la busqueda</p>");
        }else{
            $.ajax({
                type:'POST',
                url:'../Reportes/horasAsistencia.php',
                data: {'dniH':dniH,'apePH':apePH,'apeMH':apeMH,'nombreH':nombreH, 'fechaInicial':startD, 'fechaFinal':endD},
                success:function(data){   
                 $("#dataHoras").html(data);  
                }
            });
        }
    }
    
}

function descargareporteh(){
    var startD =moment($('#daterange-btn3').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
    var endD = moment($('#daterange-btn3').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
    var dni = document.getElementById("dnirh").value;
    if ( dni == "") {
        $("#dataHoras").html("<p class='alert alert-danger'>Ingrese un dni valido para poder descargar</p>");
    } else {
        window.location = "../Reportes/horasAExcel.php?dnia="+dni+"&&fechai="+startD+"&&fechaf="+endD;
    }
};

$('#dnirh,#apellidosPH,#apellidosMH,#nombresH').keypress(function(e){   
   if(e.which == 13){      
     buscarInfo();  
}   
});



