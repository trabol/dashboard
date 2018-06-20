<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
	.dataTables_wrapper{
		overflow-x: scroll!important;
	}
	.destacado{
		color:blue;
		font-weight: bold;
		text-transform: uppercase;
		text-decoration: underline;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Tareas Expiradas</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			
		 	<div class="panel-body">
		 	    <div class="row">
		 	    	<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite ver las tareas que se encuentra atrasadas en su autorizacion.(Jefe zonal , sub gerente de aréa, gerente de aréa o general).
						</div>
					</div>
					<?php if(count($tareasExpiradas)==0):?>
					<!--<div class="col-md-12">
						<div class="alert alert-warning"><strong>mensaje: </strong>
							No se encontrarón tareas expiradas para este autorizador.
						</div>
					</div>-->
					<?php endif;?>
		 	    </div>
		 	    <div class="row">
		 	    	<div class="col-md-12">
						<form id="formSeach" method="POST" class="form-inline">
				        	<div class="form-group">
						   	 	<label for="autorzadores">
						   	 	<b style="color: black;font-size: 15px;">buscar por autorizador (actual)&nbsp&nbsp</b>
						   	 	</label>
						   	 	<select class="form-control" name="formAutorizador" id="formAutorizador">
						   	 		<!--<option value="">TODOS</option>-->
						   	 		<?php
						   	 		if(count($autorizadores)>0){
						   	 			foreach ($autorizadores as $key => $v){
						   	 				$sel ="";
						   	 				if($v['USER_UID'] ==$formAutorizador){
						   	 				   $sel ="selected ='selected'";
						   	 				}
						   	 				?>
						   	 				<option <?php echo $sel;?> value="<?php echo $v['USER_UID'];?>">
						   	 					<?php echo $v['NOMBRE'];?>
					   	 					</option>
						   	 				<?php
						   	 			}
						   	 		}
						   	 		?>
						   	 	</select>
		 					 </div>
		 					 <div class="form-group">
		 					 	<button type="button" class="btn_buscar btn btn-primary">Buscar</button>
		 					 </div>
		 					 <input type="hidden" id="POST_autorizador" value="<?php echo $formAutorizador;?>">
						</form>
		 	    	</div>
		 	    </div>
		 	    <hr>
		 	    <?php
		 	   

			 	if(count($tareasExpiradas)>0): ?>
				<table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>N° Caso</th>
		 		    		<th>Sociedad</th>
		 		    		<td>Rut <br> proveedor</td>
		 		    		<td>Monto<br> Total</td>
		 		    		<td>Fecha<br> Limite</td>
		 		    		<td>Pronto<br>Pago</td>
		 		    		<td>Días de atraso</td>
		 		    		<td>Autorizador<br> Original</td>
		 		    		<th>Autorizador<br> Reemplazo</th>
		 		    		<th>Autorizador<br> Actual</th>
		 		    		<th>Opciones</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<?php foreach ($tareasExpiradas as $key => $value): ?>
	 		    		<tr>
		 		    		<td><?php echo $value['APP_NUMBER'];?></td>
		 		    		<td><?php echo $value['APP_DATA']['c008'];?></td>
		 		    		<td><?php echo $value['APP_DATA']['c009'];?></td>
		 		    		<td><b>$<?php echo $value['APP_DATA']['c033'];?></b></td>
		 		    		<td><b><?php echo $value['DEL_TASK_DUE_DATE'];?></b></td>
		 		    		<td><b>
		 		    			<?php $estado ='NO';
		 		    			    if($value['APP_DATA']['c054']=='On'){ $estado ="SI";} 
		 		    				echo $estado;
		 		    			?>
		 		    			</b>
		 		    		</td>
		 		    		<td class="text-center"><?php echo $value['DIAS_ATRASO'];?></td>
		 		    		<td><?php 
		 		    			foreach ($value['USER_ORIGINAL'] as $cont1 => $u){
		 		    				echo 
		 		    				$u['USR_FIRSTNAME']."<br>".
		 		    			    $u['USR_LASTNAME']."<br>".
		 		    			    $u['USR_EMAIL']."<br><b>".
		 		    			    $u['USR_USERNAME']."</b>";
		 		    			}
		 		    			?>
	 		    			</td>
		 		    		<td>
		 		    			<?php 
		 		    			foreach ($value['USER_REMPLAZO'] as $cont2 => $z) {
		 		    				if(count($z)>0){
		 		    				echo $z['USR_FIRSTNAME']."<br>".
		 		    			    $z['USR_LASTNAME']."<br>".
		 		    			    $z['USR_EMAIL'];
		 		    			    }
		 		    			    else
		 		    			    {
		 		    			    echo "NO HAY<br>REEMPLAZO";
		 		    			    }
		 		    			}
		 		    			?>
		 		    		</td>
		 		    		<td>
		 		    			<?php 
		 		    			if(count($value['USER_ACTUAL'])>0){
			 		    			foreach ($value['USER_ACTUAL'] as $cont2 => $z) {
			 		    				if(count($z)>0){
			 		    				echo $z['USR_FIRSTNAME']."<br>".
			 		    			    $z['USR_LASTNAME']."<br>".
			 		    			    $z['USR_EMAIL'];
			 		    			    }
			 		    			}
		 		    			}
		 		    			?>
		 		    		</td>
		 		    		<td>
		 		    			<?php 
		 		    			if($value['FECHA_BLOQUEO']!=date("Y-m-d")){?>
		 		    				<button TAS_UID="<?php echo $value['TAS_UID'];?>"   DEL_INDEX="<?php echo $value['DEL_INDEX'];?>" APP_NUMBER="<?php echo $value['APP_NUMBER'];?>"  APP_UID="<?php echo $value['APP_UID'];?>" class="btn btn-success btn_reemplazo" id="<?php echo $value['USER_ACTUAL'][0]['USR_UID'];?>">
		 		    				Cambiar al <br> reemplazo
		 		    				</button>
		 		    			<?php 
		 		    			}else{
		 		    				?>
		 		    				<button class="btn_bloqueo btn btn-danger">Bloqueado</button>
		 		    				<?php
		 		    			}
		 		    			?>
		 		    		</td>
		 		    	</tr>
	 		    	<?php endforeach;?>
	 		    	</table>
				<?php endif;?>
			</div> 
		</div>
	</div>
</div>
<div class="modal fade" id="modalformRemplazo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #303641;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" style="color:white;">Reemplazo de tareas <b>expiradas</b></h5>
      </div>
        <div class="modal-body">
      	<p>Complete el formulario según las indicaciones.</p>
      	<form id="modalForm" method="POST">
        <div class="formgroup">
        	<div class="form-group">
		   	 	<label for="autorzadores"><b>Seleccione un autorizador de reemplazo</b></label>
		   	 	<select class="form-control" id="autorizadores" name="formAutorizador">
		   	 		<option>-- --</option>
		   	 		<?php

		   	 		if(count($autorizadores)>0){
		   	 			foreach ($autorizadores as $key => $v){?>
		   	 				<option style="text-align : justify;" value="<?php echo $v['USER_UID'];?>">
		   	 					<?php echo $v['NOMBRE'];?>
	   	 					</option>
		   	 				<?php
		   	 			}
		   	 		}
		   	 		?>
		   	 	</select>
		 	 </div>
		 	 <div class="form-group">
		   	 	<label for="autorzadores"><b style="    font-size: 12px; color: red;">¿Aplicar el reemplazo para todos los casos expirados que tiene?&nbsp&nbsp<span class="destacado"></span></b></label>
		   	 	<select class="form-control" id="TODOS">
		   	 		<option>NO</option>
		   	 		<option>SI</option>
		   	 	</select>
		   	 	<input type="hidden" class="destacado_USR_UID" value="">
		   	 	<input type="hidden" class="destacado_APP_UID" value="">

		   	 	<input type="hidden" class="destacado_APP_NUMBER" value="">
		   	 	<input type="hidden" class="destacado_TAS_UID"    value="">
		   	 	<input type="hidden" class="destacado_DEL_INDEX"  value="">
		 	 </div>
		 	 <div class="form-group">
		   	 	<label for="autorzadores">
		   	 		<b>¿Desea enviar una notificación por correo al usuario de reemplazo?</b>
		   	 	</label>
		   	 	<select class="form-control" id="CORREO">
		   	 		<option>NO</option>
		   	 		<option>SI</option>
		   	 	</select>
		   	 </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" disabled="disabled" id="guardarCambios">
        	Guardar cambios
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">salir</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalBloqueado">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #303641;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" style="color:white;">Información de  <b>Ayuda</b></h5>
      </div>
      <div class="modal-body">
      	<h5>Los cambios de reemplazo soló pueden ejecutarse una vez al dia, debes esperar hasta el proximo día para volver a cambiar el reemplazo.
      	<br><br>Para una excepción solicitar a sistemas el desbloqueo.</h5>
  	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">salir</button>
      </div>
    </div>
  </div>
</div>

<style type="text/css" media="screen">
	.control-label >b{
		color: black;
	}
</style>	
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/TableTools.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2.css">
<!-- Bottom scripts (common) -->
<script src ="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
<script src ="<?php echo base_url();?>assets/js/bootstrap-timepicker.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/daterangepicker/moment.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/TableTools.min.js"></script>
<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/lodash.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/select2/select2.min.js"></script>
<!-- JavaScripts initializations and stuff -->
<!-- Demo Settings -->

<script type="text/javascript">
    
		var responsiveHelper;
		var breakpointDefinition = {
		    tablet: 1024,
		    phone : 480
		};
		var tableContainer;


		var responsiveHelper2;
		var breakpointDefinition2 = {
		    tablet: 1024,
		    phone : 480
		};
		var tableContainer2;
		
			jQuery(document).ready(function($)
			{
				tableContainer = $("#table-1");
				
				tableContainer.dataTable({
					"sPaginationType": "bootstrap",
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"bStateSave": true,
					
		
				    // Responsive Settings
				    bAutoWidth     : false,
				    fnPreDrawCallback: function () {
				        // Initialize the responsive datatables helper once.
				        if (!responsiveHelper) {
				            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
				        }
				    },
				    fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				        responsiveHelper.createExpandIcon(nRow);
				    },
				    fnDrawCallback : function (oSettings) {
				        responsiveHelper.respond();
				    }
				});
				
				$(".dataTables_wrapper select").select2({
					minimumResultsForSearch: -1
				});
				/************************************************************************************/
				tableContainer2 = $("#table-2");
				
				tableContainer2.dataTable({
					"sPaginationType": "bootstrap",
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"bStateSave": true,
					
		
				    // Responsive Settings
				    bAutoWidth     : false,
				    fnPreDrawCallback: function () {
				        // Initialize the responsive datatables helper once.
				        if (!responsiveHelper2) {
				            responsiveHelper2 = new ResponsiveDatatablesHelper(tableContainer2, breakpointDefinition2);
				        }
				    },
				    fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				        responsiveHelper2.createExpandIcon(nRow);
				    },
				    fnDrawCallback : function (oSettings) {
				        responsiveHelper2.respond();
				    }
				});
				
				$(".dataTables_wrapper select").select2({
					minimumResultsForSearch: -1
				});
	});
</script>
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>

<script type="text/javascript">
var $ = jQuery;

$(".btn_buscar").click(function(event) {
	$("#formSeach").submit();
});

$(".btn_bloqueo").click(function(event) {
	/* Act on the event */
	$("#modalBloqueado").modal("show");
});

$(".btn_reemplazo").click(function(event) {
	var userID     = $(this).attr("id");
	var APP_UID    = $(this).attr("APP_UID");
	var APP_NUMBER = $(this).attr("APP_NUMBER");
	var TAS_UID    = $(this).attr("TAS_UID");
	var DEL_INDEX  = $(this).attr("DEL_INDEX");

	$('#autorizadores option:eq(0)').prop('selected', true);
	$("#guardarCambios").attr('disabled', 'disabled');

	$.ajax({
		url: '<?php echo base_url();?>tareas/expiradas/reemplazo',
		type: 'POST',
		dataType: 'HTML',
		data: {userID: userID},
		beforeSend: function(){
			$.LoadingOverlay("show");
		},
		success: function(response){
			$.LoadingOverlay("hide");
			var msj = $.parseJSON(response);
			$(".destacado").html(msj[0]['USR_FIRSTNAME']+" "+msj[0]['USR_LASTNAME']);
			$(".destacado_USR_UID").val(msj[0]['USR_UID']);
			$(".destacado_APP_UID").val(APP_UID);
			$(".destacado_APP_NUMBER").val(APP_NUMBER); 
			$(".destacado_TAS_UID").val(TAS_UID);
			$(".destacado_DEL_INDEX").val(DEL_INDEX);

			$("#modalformRemplazo").modal("show");

		}
	});
});

$("#guardarCambios").click(function(event){

	var APP_UID = $(".destacado_APP_UID").val();     //numero aplicacion
	var ID_REM  = $("#autorizadores").val();         //reemplaxzo
	var ID_ORI  = $(".destacado_USR_UID").val();     //original
	var TODOS   = $("#TODOS").val();
	var APP_NUMBER = $(".destacado_APP_NUMBER").val(); 
	var TAS_UID    = $(".destacado_TAS_UID").val();
	var DEL_INDEX  = $(".destacado_DEL_INDEX").val();

	var CORREO  = $("#CORREO").val();

	var DATOS ={

		APP_UID    : APP_UID    ,
		ID_REM     : ID_REM     ,
		ID_ORI     : ID_ORI     ,
		TODOS      : TODOS      ,
		APP_NUMBER : APP_NUMBER ,
		TAS_UID    : TAS_UID    ,
		DEL_INDEX  : DEL_INDEX  , 
		CORREO     : CORREO ,
	};

	$.ajax({
		url: '<?php echo base_url();?>tareas/expiradas/update',
		type: 'POST',
		dataType: 'html',
		data: DATOS,
		beforeSend: function(){
		   $.LoadingOverlay("show");
		},
		success: function(response){
			$("#modalForm").submit();
			$.LoadingOverlay("hide");
		}

	});

});

$("#autorizadores").change(function(event) {
	/* Act on the event */
	if($(this).val()!=""){
	   $("#guardarCambios").removeAttr('disabled');

	}

	if($(this).val()=="-- --")
	{
	   $("#guardarCambios").attr('disabled', 'disabled');
	}

	if($(".destacado_USR_UID").val() == $(this).val()){
	   $("#guardarCambios").attr('disabled', 'disabled');
	}
});
</script>
