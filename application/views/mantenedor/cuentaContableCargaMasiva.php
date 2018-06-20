<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Cuentas contables / Carga masiva</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
		 	<div class="panel-body">
		 	    
		 	    <p>Para mayor seguridad utilice esta plantilla para cargar las cuentas contables</p>

		 		<a href="<?php echo base_url();?>assets/file/Autorizador_cuenta_plantillas.xlsx" target="_blank">
		 			<button type="button" class="btn btn-info">Descargar plantilla</button>
		 		</a>
				<hr>
		 		<p>una vez editada la plantilla debe ser adjuntada </p>
				<div class="row">
					<div class="col-sm-12"> 
					 <div style="margin-top:20px"></div>
						<form action="<?php echo base_url();?>mantenedor/cuentas-contables/carga-masiva/guardar" method="post" enctype="multipart/form-data">
						    <input type="file"   name="file" id="fileExcel" />
						    <div class="ResultadoTabla">
						    </div>
						</form>
						
					</div>
				</div>
				<input type="hidden" name="mensajeFinal" id="mensajeFinal" value="<?php echo $mensajeFinal;?>">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalErrores">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b class="mesanjeError"></b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">aceptar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalMensajeOK">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b>Las cuentas contables fuerón cargadas correctamente</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">aceptar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $ = jQuery;
$(document).ready(function($) {

	
	setTimeout(function(){
	  	if($("#mensajeFinal").val() == 1){
		   $("#modalMensajeOK").modal("show");
		   $("#mensajeFinal").val(0);
		}
	}, 500);

	$("#fileExcel").change(function(event){
		/* Act on the event */
		//obtenemos un array con los datos del archivo
        var file          = $("#fileExcel")[0].files[0];
        var fileName      = file.name;
        var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize      = file.size;
        var fileType      = file.type;
		var formData 	  = new FormData($("form")[0]);

		if(fileExtension=="xlsx"){
			$.ajax({
				url: '<?php echo base_url();?>mantenedor/cuentas-contables/carga-masiva/cargar',
				type: 'POST',
				dataType: 'html',
				data: formData,
	    	    cache: false,
	    		contentType: false,
	    		processData: false,

				beforeSend: function(){
					$(".ResultadoTabla").html("...cargando");	
				},
				success :function(response){
				$(".ResultadoTabla").html(response);
				}
			});
		}else{
			$(".mesanjeError").html("Debe adjuntar un archivo de tipo excel con extesion xlsx (se recomienda usar la plantilla)");
			$("#modalErrores").modal("show");
			$(this).val('');
		}
	});
});
</script>