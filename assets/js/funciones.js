$(document).ready(function(){
    
    $('#Inputfecha').datepicker({
                    format: "dd/mm/yyyy"
                    
    });

	$(".input-usuario").click(function(){
		var error = 0;
		console.debug(2);
		var input_nombre   = $(".input_nombre").val();
		var input_apellido = $(".input_apellido").val();

		if(input_nombre == ""){

			$(".form-usuario").removeAttr("method");
			error = error+1;
		}
		if(input_apellido ==""){

			$(".form-usuario").removeAttr("method");
			error = error+1;
		}

		if(error == 0){

			if(!$("form").attr("method")){

				$(".form-usuario").attr("method","POST");
				// $(".form-usuario").submit();
			}
			else
			{
				// $(".form-usuario").submit();	
			}
			

		}
	});
	//Generar un malla 
	$("#id_select_compania").change(function(event) {
		/* Act on the event */

		var id_select_compania = $(this).val();

		if(id_select_compania>0){
		
			$.ajax({
			        data:  {id_select_compania:id_select_compania},
	                url:   '../../ajax/ajax_malla_turno/ajax_sucursal_selecionada.php',
	                type:  'post',
	                beforeSend: function () {
	                        $(".ajax_sucursal").html("Procesando, espere por favor...");
	                },
	                success:  function (response) {
	                        $(".ajax_sucursal").html(response);
	                }

			});
		}

	});
	//buscar cargos segun la compañia
	$("#id_compania_cargo").change(function(event) {
		/* Act on the event */

		var id_compania_cargo = $(this).val();

		if(id_compania_cargo){
		
			$.ajax({
			        data:  {id_compania_cargo:id_compania_cargo},
	                url:   '../../ajax/ajax_cargos/buscar_cargo.php',
	                type:  'post',
	                beforeSend: function () {
	                        $(".ajax_cargo").html("Procesando, espere por favor...");
	                },
	                success:  function (response) {
	                        $(".ajax_cargo").html(response);
	                }

			});
		}

		
	});

	$(".select_empresa").change(function(event) {
		/* Act on the event */
		var id_compania = $(this).val();

		$.ajax({
		        data:  {id_compania:id_compania},
                url:   '../../ajax/ajax_empresas/buscar_sucurales.php',
                type:  'post',
                beforeSend: function () {
                        $(".ajax-mantenedor-compania").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $(".ajax-mantenedor-compania").html(response);
                }
		});

	});

	

});

function set_cargo(){

		/* Act on the event */
		var id_compania_cargo = $(".id_compania").val();
		var nom_cargo         = $(".nom_cargo").val();
		var id_max_cargo      = $(".max_id").val();

		var parametros ={
							id_compania_cargo :id_compania_cargo ,
							nom_cargo   :nom_cargo     ,
							id_max_cargo:id_max_cargo 
						}

		$.ajax({
		        data:  parametros,
                url:   '../../ajax/ajax_cargos/buscar_cargo.php',
                type:  'post',
                beforeSend: function () {
                        $(".ajax_cargo").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $(".ajax_cargo").html(response);
                }
		});
}

function Eliminar_cargo(id_cod_cargo, id_compania_cargo){
    
    var borrar_cargo ="borrar_cargo"; 
	var parametros ={
						borrar_cargo : borrar_cargo  , 
						id_cod_cargo : id_cod_cargo , 
						id_compania_cargo : id_compania_cargo
					}
	$.ajax({
		        data:  parametros,
                url:   '../../ajax/ajax_cargos/buscar_cargo.php',
                type:  'post',
                beforeSend: function () {
                        $(".ajax_cargo").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $(".ajax_cargo").html(response);
                }
		});

}
function eliminar_sucursal(id_compania,id_sucursal){

	var accion="borrar";

	var parametros = {	id_compania:id_compania ,
						id_sucursal:id_sucursal ,
						accion : accion

					}

	$.ajax({
		        data:  parametros,
                url:   '../../ajax/ajax_empresas/buscar_sucurales.php',
                type:  'post',
                beforeSend: function () {
                        $(".ajax-mantenedor-compania").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $(".ajax-mantenedor-compania").html(response);
                }

		});

}




