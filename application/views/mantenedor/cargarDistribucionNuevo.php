<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
	#tableEXCEL{
		display: none;
	}
	td b ,p{
		color: black;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title">
				 <h3>
				 	<center>Cargar Distribución / Nueva Plantilla</center>
				 	</h3>
				 </div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
		 	<div class="panel-body">
		 	    <p>
		 	    1) Para mayor seguridad utilice esta plantilla para cargar su distribución de costos</p>

		 		<a href="<?php echo base_url();?>assets/file/plantilla_cargar_distribucion.xlsx">
		 			<button type="button" class="btn btn-info">Descargar plantilla</button>
		 		</a>
				<hr>
				<p>2) Complete los datos</p>
				<div style="width: 50%;">
					<form>
						<div class="form-group">
							<label for="email">Nro Cliente</label>
							<input type="email" class="form-control" id="email">
						</div>
						<div class="form-group">
							<label for="pwd">Descripción de la planilla</label>
							<input type="text" class="form-control" id="pwd">
						</div>
					</form>
				</div>

		 		<p>3) Una vez editada la plantilla debe ser adjuntada </p>
				<div class="row">
					<div class="col-sm-12"> 
					 <div style="margin-top:20px"></div>
						<form action="<?php echo base_url();?>mantenedor/centro-costos/carga-masiva/guardar" method="post" enctype="multipart/form-data">
						    <input type="file"   name="file" id="fileExcel" />
						    <div class="ResultadoTabla">
						    </div>
						</form>
					</div>
				</div><br><br><hr>


				<div id="tableEXCEL">
				<table class="table table-bordered" >
					<tr>
						<td>Fila</td>
						<td>Rut</td>
						<td>Centro Costo</td>
						<td>Cuenta Contable</td>
						<td>Porcentaje</td>
					</tr>
					<tr class="success">
						<td><b>1</b></td>
						<td><b>96919050-8</b></td>
						<td><b>CL01021171<b></td>
						<td><b>4211130007</b></td>
						<td><b>% 40</b></td>
					</tr>
					<tr class="success">
						<td><b>2</b></td>
						<td><b>96919050-8</b></td>
						<td><b>CL01021172<b></td>
						<td><b>4211130007</b></td>
						<td><b>% 30</b></td>
					</tr>
					<tr class="success">
						<td><b>3</b></td>
						<td><b>96919050-8</b></td>
						<td><b>CL01021173<b></td>
						<td><b>4211130007</b></td>
						<td><b>% 30</b></td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalMensajeError">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mesaje de carga</h4>
			</div>
			<div class="modal-body">
				<h2><b>La distribución ha sido cargada correctamente.</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $ = jQuery;
$(document).ready(function($) {
	$("#fileExcel").change(function(event){
		$("#modalMensajeError").modal("show");
		$(this).val('');
		$("#tableEXCEL").css("display",'block');
	});
});
</script>