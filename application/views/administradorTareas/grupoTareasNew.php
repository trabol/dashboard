<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default" data-collapsed="0"> 
			<div class="panel-heading">
				<div class="panel-title"><h3><center>Grupo de tareas \ nuevo grupo</center></h3></div>
				<div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				</div>
			</div> 
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
					<form action="<?php echo base_url();?>grupo-tareas/nuevo-grupo" method="POST" accept-charset="
					utf-8">
						<div class="form-group">
						    <label class="control-label col-sm-2" for="nombreGrupo">Ingrese nombre para identificar al grupo:</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="nombreGrupo" name="nombreGrupo" placeholder="ingrese nombre">
						    </div>
						  </div>
						<table class="table" id="tableTareas">
						<caption style="text-align: left;"><h3>Lista de tareas</h3></caption>
						<thead>
							<tr>
								<th>Descripción</th>
								<th>Empresa</th>
								<th>Responsable</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<textarea class="form-control" name="tareas[0][descripcion]"></textarea>
								</td>
								<td>
							      	<select name="tareas[0][sociedades]" class="form-control sociedades" name="sociedades"  tabindex="2">
							      		<option></option>
										<?php
											foreach ($sociedades as $key => $value) {
											?>
												<option value="<?php echo $value['SOCIEDAD'];?>"><?php echo  $value["NOMBRE"];?></option>
												<?php
											}
										?>
									</select>
									
								</td>
								<td>
									<select class="form-control userGrupos" name="tareas[0][userGrupo]"  tabindex="2">
							      		<option></option>
										<?php
											foreach ($userGrupo as $key => $value) {
												?>
												<option value="<?php echo $value["USR_UID"];?>"><?php echo $value["USR_USERNAME"]." ".$value["USR_FIRSTNAME"]." ".$value["USR_LASTNAME"];?></option>
												<?php
											}
										?>
									</select>

								</td>
							</tr>
						</tbody>
						</table>
					
						<div class="row">
							<div class="col-sm-6"> 
								<div class="invoice-left">
									<button class="btn btn-primary" id="nuevaFila" type="button">
									Añadir nueva fila
									<i class="entypo-list-add"></i> 
								</button>
								</div>
							</div>
							<div class="col-sm-6"> 
								
								<div class="invoice-right" style="text-align: right;">
								<a href="<?php echo base_url()?>grupo-tareas" class="btn btn-info">
								Volver
								<i class="entypo-list-add"></i> 
								</a>
								<button class="btn btn-success" id="btn-guardar" type="button">
									Guardar 
									<i class="entypo-list-add"></i> 
								</button>
								</div>
							</div> 
						</div>
					<input type="hidden" id="hidden_sociedades" value="<?php echo json_encode($sociedades);?>">
					<input type="hidden" id="hidden_userGrupo" value="<?php echo json_encode($userGrupo);?>">
					<input type="hidden" id="opcion" name="opcion" value="">
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="http://alxlit.name/bootstrap-chosen/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
var $ = jQuery;

$(document).ready(function () {

	$("#btn-guardar").click(function(event) {
		/* Act on the event */
		$("#opcion").val("guardar");
		$("form").submit();
	});

	$('.sociedades').chosen();
    $('.userGrupos').chosen();
    var counter = 1;
    var hidden_sociedades = <?php echo json_encode($sociedades);?>;
    var hidden_userGrupo  = <?php echo json_encode($userGrupo);?>;

    $("#nuevaFila").click(function(event){
        var newRow  = $("<tr>");
        var cols    = "";
        var sel_sociedad  = "sel_sociedad"+counter;
        var sel_user      = "sel_user"+counter;
        
        var sociedades = $("#hidden_sociedades").val();
        cols += '<td><textarea class="form-control" name="tareas['+counter+'][descripcion]"></textarea></td>';
        
        cols += '<td><select id="'+sel_sociedad+'" name="tareas['+counter+'][sociedades]" class="form-control sociedades" tabindex="2"><option value=""></option></select></td>';
       
        cols += '<td><select id="'+sel_user+'" name="tareas['+counter+'][userGrupo]" class="form-control userGrupos" tabindex="2"><option value=""></option></select></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("#tableTareas").append(newRow);
        
        for(var i=0; i < hidden_sociedades.length; i++){
		    var key  = hidden_sociedades[i]['SOCIEDAD'];
		    var text   = hidden_sociedades[i]['NOMBRE'];
		    $('.sociedades').append($("<option></option>").attr("value",key).text(text));
		}
		$('.sociedades').chosen();

		for(var i=0; i < hidden_userGrupo.length; i++){
		    var key    = hidden_userGrupo[i]['USR_UID'];
		    var text   = hidden_userGrupo[i]['USR_USERNAME']+" "+hidden_userGrupo[i]['USR_FIRSTNAME']+" "+hidden_userGrupo[i]['USR_LASTNAME'];
		    $('.userGrupos').append($("<option></option>").attr("value",key).text(text));
		}
		$('.userGrupos').chosen();
        counter++;
    });



    $("#tableTareas").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1;
    });


});


</script>

