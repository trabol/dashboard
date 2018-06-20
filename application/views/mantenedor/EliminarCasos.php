<style type="text/css">

b{color: black;}
.trTitulo th{text-align: center!important;}

</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Eliminación de casos Trancura</center></h3></div>
				 <div class="panel-options">
			  	 <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
			  	 <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
		 		<?php 

		 		if(count($pagos)>0 && $activoEliminacion ==1 ):?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success"><strong></strong>Caso eliminado del flujo exitosamente.</div>
					</div>
				</div>
			    <?php endif;?>

		 	    <?php if(count($pagos)<=0 && $activoBusqueda ==1 ):?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger"><strong>Alert!</strong> No se encontrarón registros.</div>
					</div>
				</div>
			    <?php endif;?>

		 		<form id="FORMFIND" role="form" class="form-horizontal form-groups-bordered" method="POST" action="">
		 			<div class="form-group" id="grupoRut">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Rut proveedor (opcional) </b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<input type="text" class="form-control inputRut" placeholder="Ej: 123456789-9" id="inputRut" name="inputRut" value="<?php echo $RUTPROV;?>">
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group" id="grupoRut">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Número caso (opcional) </b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<input type="text" class="form-control" id="numeroCaso" name="numeroCaso" value="<?php echo $PROCESO;?>">
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Empresa (opcional)</b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<select  class="form-control" name="empresa" id="empresa">
	 		 					<option <?php if(isset($SOCIEDAD) && $SOCIEDAD =="CL01"): echo "selected"; endif;?> value="CL01">ISAPRE BANMÉDICA</option>
	 		 					<option <?php if(isset($SOCIEDAD) && $SOCIEDAD =="CL24"): echo "selected"; endif;?> value="CL24">VIDA TRES</option>
	 		 				</select>
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group">
	 		 			<label for="field-2" class="col-sm-3 control-label"><b>Opciones</b></label>
	 		 			<div class="col-sm-2">
	 		 				<input type="button" class="btn btn-info" id="btnBuscar"  value="Buscar">
	 		 				<input type="hidden" name="hidden_busqueda"  id="hidden_busqueda" value="0">
	 		 			</div> 
	 		 		</div>
	 		    </form>

	 		    <?php if(count($pagos) >0 && $activoBusqueda ==1 ){?>
	 		    <table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr class="trTitulo">
			 		    	<th>N°caso</th>
			 		    	<th>Sociedad</th>
			 		    	<th>Rut</th>
			 		    	<th>Nombre</th>
			 		    	<th>Documento</th>
			 		    	<th>Total</th>
			 		    	<th>Solicitante</th>
			 		    	<th>Estado</th>
			 		    	<th>Opciones</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<?php foreach ($pagos as $key => $v) {

	 		    		$strinEstado =$v->ESTADO_DT;

	 		    		if($v->ESTADO_DT =="IN"){$strinEstado ="Ingresado";}
	 		    		if($v->ESTADO_DT =="RR"){$strinEstado ="Eliminado";}
	 		    		if($v->ESTADO_DT =="RP"){$strinEstado ="Repetido";}
	 		    		if($v->ESTADO_DT =="ER"){$strinEstado ="Devuelto";}
	 		    		if($v->ESTADO_DT =="RC" || $v->ESTADO_DT =="RE"){$strinEstado ="Rechazado";}
	 		    		if($v->ESTADO_DT =="A1" || $v->ESTADO_DT =="A2" || $v->ESTADO_DT =="A3"|| $v->ESTADO_DT =="A4"){$strinEstado ="Validado Genente";}

	 		    		if($v->ESTADO_DT =="AU"){$strinEstado ="Autorizado";}
	 		    		if($v->ESTADO_DT =="PA"){$strinEstado ="Pagado";}

	 		    		if($v->ESTADO_DT =="CO"){$strinEstado ="Validado Contabilidad";}


	 		    		$total = $v->VALOR_TOTAL;

	 		    		if($v->TIPO_DOCUMENTO == 'BO' ){$total = $v->VALOR_LIQUIDO;}

	 		    		?>



	 		    	<tr>
		 		    	<td><?php echo $v->ID_PROCESO;?></td>
		 		    	<td><?php echo $v->COD_EMPRESA;?></td>
		 		    	<td><?php echo $v->RUT_PROVEEDOR;?></td>
		 		    	<td><?php echo $v->NOMBRE_PROVEEDOR;?></td>
		 		    	<td><?php echo $v->TIPO_DOCUMENTO;?></td>
		 		    	<td>$<?php echo number_format(intval($total), 0 ,'','.'); ?></td>
		 		    	<td><?php echo $v->NOMBRE_SOLICITANTE;?></td>
		 		    	<td><?php echo $strinEstado;?></td>
		 		    	<td>
		 		    		<?php if($v->ESTADO_DT != "RR" ){?>
		 		    		<button class="btn btn-danger deletecaso" ID="<?php echo $v->ID_PROCESO;?>" SOCIEDAD="<?php echo $v->COD_EMPRESA;?>" ESTADO="<?php echo $v->ESTADO_DT;?>">
		 		    			Eliminar
		 		    		</button>
		 		    		<?php  }?>
		 		    	</td>
	 		    	</tr>
	 		    	<?php }?>
	 		    </table>
	 		    <?php }?>
			</div> 
		</div>
	</div>
</div>
<div class="modal fade" id="modalShowMensaje">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<b>No puedes eliminar un caso que se encuentra en estado "<span style="color: blue;">Autorizado o Pagado".</span><br>
					 Favor de contactar al administrador del sistema</b>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>

<!--la elimnacin de casos es muy lenta para el servidor por eso lo hacemos atra ves de post-->
<form action="<?php echo base_url();?>/mantenedor/eliminar-casos/delete" id="formDELETE" method="POST">
	<input type="hidden" name="CASO_ID_HIDDEN" 	 id="CASO_ID_HIDDEN"    value="0">
	<input type="hidden" name="SOCIEDA_HIDDEN" id="SOCIEDA_HIDDEN"      value="0">


	<input type="hidden" name="CASO_ID_FORM" id="CASO_ID_FORM"    value="0">
	<input type="hidden" name="SOCIEDA_FORM" id="SOCIEDA_FORM"    value="0">
	<input type="hidden" name="RUTPROV_FORM" id="RUTPROV_FORM"    value="0">
</form>



<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/TableTools.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">

<!-- Bottom scripts (common) -->

<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/lodash.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<!-- JavaScripts initializations and stuff -->
<!-- Demo Settings -->
<script src="<?php echo base_url();?>assets/js/jquery.Rut.js"></script>

<script type="text/javascript">
   

var responsiveHelper;
var breakpointDefinition = {
	tablet: 1024,
	phone : 480
};

var tableContainer;
jQuery(document).ready(function($){

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
});

</script>



<script type="text/javascript">
var $ = jQuery;

$('#inputRut').Rut({
  format_on: 'keyup'
});

$("#btnBuscar").click(function() {
	if(validarForm()){
	   var url ="<?php echo base_url();?>"+"mantenedor/eliminar-casos";
	   $("#hidden_busqueda").val(1);
	   $("#FORMFIND").attr("action",url);
	   $("#FORMFIND").submit();
	}
});

$(".deletecaso").click(function(event) {
	/* Act on the event */
	var SOCIEDAD    = $(this).attr("SOCIEDAD");
	var ID 		    = $(this).attr("ID");
	var ESTADO_DT   = $(this).attr("ESTADO");
	var RUT         = $(this).attr("RUT");

	if(ESTADO_DT =="AU" || ESTADO_DT =="PA"){
      $("#modalShowMensaje").modal('show');
	}
	else
	{

		$("#CASO_ID_HIDDEN").val(ID);
		$("#SOCIEDA_HIDDEN").val(SOCIEDAD);


		$("#CASO_ID_FORM").val($("#numeroCaso").val());
		$("#SOCIEDA_FORM").val($("#empresa").val());
		$("#RUTPROV_FORM").val($("#inputRut").val());

		$("#formDELETE").submit();
	}

});



function validarForm(){

	var estado = true;
		
	if($("#inputRut").val()!=""){
		if(!validarRut($("#inputRut").val())){
			alert("Ingrese rut valido con el siguente formato 12456789-9");
			$("#grupoRut").addClass('has-error');
			estado = false;
		}
	}
	return estado;
}

function validarRut(campo){
	if ( campo.length == 0 ){ return false; }
	if ( campo.length < 8 ){ return false; }
	 
	campo = campo.replace('-','')
	campo = campo.replace(/\./g,'')
	 
	var suma = 0;
	var caracteres = "1234567890kK";
	var contador = 0;
	for (var i=0; i < campo.length; i++){
	u = campo.substring(i, i + 1);
	if (caracteres.indexOf(u) != -1)
	contador ++;
	}
	if ( contador==0 ) { return false }
	var rut = campo.substring(0,campo.length-1)
	var drut = campo.substring( campo.length-1 )
	var dvr = '0';
	var mul = 2;
	for (i= rut.length -1 ; i >= 0; i--) {
	suma = suma + rut.charAt(i) * mul
	if (mul == 7) mul = 2
	else  mul++
	}
	res = suma % 11
	if (res==1) dvr = 'k'
	else if (res==0) dvr = '0'
	else {
	dvi = 11-res
	dvr = dvi + ""
	}
	if ( dvr != drut.toLowerCase() ) { return false; }
	else { return true; 
	}
}

</script>