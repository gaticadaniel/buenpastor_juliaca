$('#fechai, #fechap,#fechas').datepicker({
autoclose: true,
format: "yyyy/mm/dd"
})
/*=============================================
MOSTRAR GRUPOS AL SELECCIONAR UN PERIODO 
=============================================*/
$('#jPeriodo').on('change',function(){
    
    var jPeriodo = document.getElementById("jPeriodo").value;
    var fecha = document.getElementById("fechai").value;

    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'peridoId':jPeriodo,'nivelId':1},
        success:function(html){   
            $('#jiGrupo').html(html);   
        }
    });
    
    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'peridoId':jPeriodo,'nivelId':2},
        success:function(html){   
            $('#jpGrupo').html(html);   
        }
    });
    
    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'peridoId':jPeriodo,'nivelId':3},
        success:function(html){   
            $('#jsGrupo').html(html);   
        }
    });
    
});

$('#jiGrupo').on('change',function(){
    
    document.getElementById("jiHorario").value=0;
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jiGrupo = document.getElementById("jiGrupo").value;
    var condicioni = document.getElementById("condicioni").value;
    var fecha = document.getElementById("fechai").value;
    
    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"/"+(f.getMonth()+1)+"/"+f.getDate();
        document.getElementById('fechai').value=fecha;
    }
    
    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'grupoId':jiGrupo,'peridoId':jPeriodo,'fecha':fecha},
        success:function(html){  
            $('#jiHorario').html(html);   
        }
    });
    
    var horario = document.getElementById("jiHorario").value;
    
    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionI.php',
        data: {'jPeriodo':jPeriodo,'jiGrupo':jiGrupo,'condicioni':condicioni,'fecha':fecha,'horario':horario},
        success:function(html){   
           
            $('#tablainicial').html(html);   
        }
    }); 
    
    
});

$('#condicioni , #jiHorario, #fechai').on('change',function(){
    document.getElementById("jiHorario").value=0;
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jiGrupo = document.getElementById("jiGrupo").value;
    var condicioni = document.getElementById("condicioni").value;
    var fecha = document.getElementById("fechai").value;
    var horario = document.getElementById("jiHorario").value;
    
    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"/"+(f.getMonth()+1)+"/"+f.getDate();
        document.getElementById('fechai').value=fecha;
    }
    
    
    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionI.php',
        data: {'jPeriodo':jPeriodo,'jiGrupo':jiGrupo,'condicioni':condicioni,'fecha':fecha,'horario':horario},
        success:function(html){   
            $('#tablainicial').html(html);   
        }
    }); 
    
    document.getElementById("jiHorario").value = 0 ;
    
});

/*=============================================
MOSTRAR GRUPOS AL SELECCIONAR UN PERIODO PRIMARIA
=============================================*/

$('#jpGrupo').on('change',function(){
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jpGrupo = document.getElementById("jpGrupo").value;
    var condicionp = document.getElementById("condicionp").value;
    var fecha = document.getElementById("fechap").value;
    var horariop = document.getElementById("jpHorario").value;
    
    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
        document.getElementById('fechap').value=fecha;
    }
    
    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'grupoId':jpGrupo,'peridoId':jPeriodo,'fecha':fecha},
        success:function(html){   
            $('#jpHorario').html(html);   
        }
    });
        

    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionP.php',
        data: {'jPeriodo':jPeriodo,'jpGrupo':jpGrupo,'condicionp':condicionp,'fecha':fecha,'horario':horariop},
        success:function(html){   
            $('#tablaprimaria').html(html);   
        }
    }); 
    
    document.getElementById("jpHorario").value = 0; /// IMPORTANTE CAMBIAR EN TODOS A 0

});

$('#condicionp , #jpHorario, #fechap ').on('change',function(){
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jpGrupo = document.getElementById("jpGrupo").value;
    var condicionp = document.getElementById("condicionp").value;
    var fecha = document.getElementById("fechap").value;
    var horariop = document.getElementById("jpHorario").value;
    
    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
        document.getElementById('fechap').value=fecha;
    }
    

    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionP.php',
        data: {'jPeriodo':jPeriodo,'jpGrupo':jpGrupo,'condicionp':condicionp,'fecha':fecha,'horario':horariop},
        success:function(html){   
            $('#tablaprimaria').html(html);   
        }
    }); 
    
    document.getElementById("jpHorario").value = 0; /// IMPORTANTE CAMBIAR EN TODOS A 0

});

/*=============================================
MOSTRAR GRUPOS AL SELECCIONAR UN PERIODO SECUNDARIA
=============================================*/

$('#jsGrupo').on('change',function(){
    document.getElementById("jsHorario").value = 0;
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jsGrupo = document.getElementById("jsGrupo").value;
    var condicions = document.getElementById("condicions").value;
    var fecha = document.getElementById("fechas").value;
    var horario = document.getElementById("jsHorario").value;
    
    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
        document.getElementById('fechas').value=fecha;

    }
    
    $.ajax({
        type:'POST',
        url:'../ajax/asistencias.ajax.php',
        data: {'grupoId':jsGrupo,'peridoId':jPeriodo,'fecha':fecha},
        success:function(html){   
            $('#jsHorario').html(html);   
        }
    });
    
    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionS.php',
        data: {'jPeriodo':jPeriodo,'jsGrupo':jsGrupo,'condicions':condicions,'fecha':fecha,'horario':horario},
        success:function(html){   
            $('#tablasecundaria').html(html);   
        }
    }); 
    
    document.getElementById("jsHorario").value= 0;
});

$('#condicions , #jsHorario , #fechas').on('change',function(){
    document.getElementById("jsHorario").value = 0;
    var jPeriodo = document.getElementById("jPeriodo").value;
    var jsGrupo = document.getElementById("jsGrupo").value;
    var condicions = document.getElementById("condicions").value;
    var fecha = document.getElementById("fechas").value;
    var horario = document.getElementById("jsHorario").value;

    if(fecha==""){
        f =new Date();
        fecha = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
        document.getElementById('fechas').value=fecha;
    }
    $.ajax({
        type:'POST',
        url:'../Reportes/justificacionS.php',
        data: {'jPeriodo':jPeriodo,'jsGrupo':jsGrupo,'condicions':condicions,'fecha':fecha,'horario':horario},
        success:function(html){   
            $('#tablasecundaria').html(html);   
        }
    }); 
    
    document.getElementById("jsHorario").value= 0;

});

function fechas() {
  var jPeriodo = document.getElementById("jPeriodo").value;
  var jsGrupo = document.getElementById("jsGrupo").value;
  var condicions = document.getElementById("condicions").value;
  var fecha = document.getElementById("fechas").value;
  var horario = document.getElementById("jsHorario").value;


  $.ajax({
    type:'POST',
    url:'../Reportes/justificacionS.php',
    data: {'jPeriodo':jPeriodo,'jsGrupo':jsGrupo,'condicions':condicions,'fecha':fecha,'horario':horario},
    success:function(html){   
        $('#tablasecundaria').html(html);   
    }
  }); 

}


