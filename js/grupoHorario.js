/*=============================================
SELECCIONADOR DINAMICO CON SELECT2
=============================================*/
$('.select2').select2();

/*=============================================
MOSTRAR GRUPOS HORARIOS AL SELECCIONAR UN ID PERIODO Y GRUPO
=============================================*/
$('#periodo').on('change',function(){
    
    var idPeriodoG = document.getElementById("periodo").value; 
    $.ajax({
        type:'POST',
        url:'../ajax/grupohorario.ajax.php',
        data: {'idPeriodoG':idPeriodoG},
        success:function(html){   
            window.location = "vista.php";   
        }
    }); 
});

$('#grupo').on('change',function(){
    
    var idGrupoL = document.getElementById("grupo").value; 
    $.ajax({
        type:'POST',
        url:'../ajax/grupohorario.ajax.php',
        data: {'idGrupoL':idGrupoL},
        success:function(r){   
            window.location = "vista.php";   
        }
    }); 
});

/*=============================================
MOSTAR CHECKBOX DE GRUPO AL SELECCIONAR PERIODO O NIVEL (MODAL)
=============================================*/
$('#nPeriodo').on('change',function(){
    
    var idPeriodo = document.getElementById("nPeriodo").value;
    var idNivel = document.getElementById("nNivel").value;
        $.ajax({
            type:'POST',
            url:'../ajax/grupohorario.ajax.php',
            data: {'idPeriodo':idPeriodo, 'idNivel':idNivel},
            success:function(html){   
             $('#checkgrupo').html(html);   
            }
        }); 
});

$('#nNivel').on('change',function(){
    
    var idPeriodo = document.getElementById("nPeriodo").value;
    var idNivel = document.getElementById("nNivel").value;  
        $.ajax({
            type:'POST',
            url:'../ajax/grupohorario.ajax.php',
            data: {'idPeriodo':idPeriodo, 'idNivel':idNivel},
            success:function(html){   
             $('#checkgrupo').html(html);   
            }
        }); 

});
/*=============================================
MOSTRAR HORARIO AL SELECCIONAR NIVEL (MODAL)
=============================================*/
$('#nNivel').on('change',function(){
 
    var nivelId = document.getElementById("nNivel").value;
    
        $.ajax({
            type:'POST',
            url:'../ajax/grupohorario.ajax.php',
            data: {'nivelId':nivelId},
            success:function(html){   
             $('#ngHorario').html(html);   
            }
        }); 
});

/*=============================================
ELIMINAR GRUPOHORARIO
=============================================*/
$(".btnEliminarGrupoHorario").click(function(){

  var idGrupoHorario = $(this).attr("idGrupoHorario");

  swal({
    title: '¿Está seguro de borrar el grupo y su horario?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar grupo y horario!'
  }).then((result)=>{

    if(result.value){

      window.location = "vista.php?idGrupoHorario="+idGrupoHorario;

    }

  })

});

/*=============================================
EDITAR GRUPO HORARIO
=============================================*/
$(".btnEditarGrupoHorario").click(function(){

  var idGrupoHorario = $(this).attr("idGrupoHorario");
  var comentario = $(this).attr("comentario");
  var grupoId = $(this).attr("grupo_id");
  var denominacion = $(this).attr("denominacion");
  var hororioId = $(this).attr("horario_id");
  var fecha = $(this).attr("fecha");
  var idgrupoh = $(this).attr("idgrupoh");
  console.log("hororioId :: ",hororioId);
  console.log("denominacion :: ",denominacion);
  console.log("grupoId :: ",grupoId);
  console.log("comentario :: ",comentario);
  console.log("fecha :: ",fecha);
  console.log("idgrupoh :: ",idgrupoh);
    var datos = new FormData();
	datos.append("idGrupoHorario", idGrupoHorario);
    $("#editGrupo").val(grupoId);
    $("#editGrupo").html(comentario);
    $("#editHorario").val(hororioId);
    $("#editHorario").html(denominacion);
    $("#editfecha").val(fecha);
    $("#idghorario").val(idgrupoh);
});
          
             
    

