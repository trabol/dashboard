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
				 	<center>Cargar Distribución / Editar Plantilla</center>
				 	</h3>
				 </div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
		 	<div class="panel-body">
				<p>1) Edite los datos antes de guardar</p>
				<div style="width: 50%;">
					<form>
						<div class="form-group">
							<label for="email">Nro Cliente</label>
							<input type="email" class="form-control" id="email" value="001">
						</div>
						<div class="form-group">
							<label for="pwd">Descripción de la planilla</label>
							<input type="text" class="form-control" id="pwd" value="Soló usar con cargas de Viña">
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<button style="float: right;margin-right: 1px;" class="btn btn-primary">
						<i class="entypo-list-add"></i> Agregar fila
						</button>
					</div>
				</div>
				<br>
				<table class="table table-striped">
					<tr>
						<td>Fila</td>
						<td>Rut</td>
						<td>Centro Costo</td>
						<td>Cuenta Contable</td>
						<td>Porcentaje</td>
						<td>Opción</td>
					</tr>
					<tr>
						<td><b>1</b></td>
						<td><b>96919050-8</b></td>
						<td>
							<select class="form-control">
								<option>CL01021171</option>
								<option>CL01021172</option>
								<option>CL01021173</option>
							</select>
						</td>
						<td>
						<select class="form-control">
								<option>4211130007</option>
						</select>
						</td>
						<td><b>% <input value="40"></b></td>
						<td><button class="btn btn-danger" type="button"><i class="entypo-cancel"></i>Eliminar fila</button></td>
					</tr>
					<tr>
						<td><b>2</b></td>
						<td><b>96919050-8</b></td>
						<td>
							<select class="form-control">
								<option>CL01021172</option>
								<option>CL01021173</option>
								<option>CL01021171</option>
							</select>
						</td>
						<td>
						<select class="form-control">
								<option>4211130007</option>
						</select>
						</td>
						<td><b>% <input value="30"></b></td>
						<td><button class="btn btn-danger" type="button"><i class="entypo-cancel"></i>Eliminar fila</button></td>
					</tr>
					<tr>
						<td><b>3</b></td>
						<td><b>96919050-8</b></td>
						<td>
							<select class="form-control">
								<option>CL01021173</option>
								<option>CL01021172</option>
								<option>CL01021171</option>
							</select>
						</td>
						<td>
						<select class="form-control">
								<option>4211130007</option>
						</select>
						</td>
						<td><b>% <input value="30"></b></td>
						<td><button class="btn btn-danger" type="button"><i class="entypo-cancel"></i>Eliminar Fila</button></td>
					</tr>
				</table>
				
				<div class="row">
					<div class="col-lg-12">
						<button class="btn btn-success">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $ = jQuery;
$(document).ready(function($) {
	
});
</script>