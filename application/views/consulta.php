<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Consulta de pagos</center></h3></div>
				 <div class="panel-options">
			  	 <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
			  	 <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
		 	    <?php 
		 	    if(count($pagos)<=0 && $activoBusqueda ==1 ):?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-warning"><strong>Alert!</strong> No se encontrarón registros.</div>
					</div>
				</div>
			    <?php endif;?>

		 		<form role="form" class="form-horizontal form-groups-bordered" method="POST" action="">
		 			<div class="form-group" id="formFechaPago">
		 				<label class="col-sm-3 control-label"><b>Fecha de Pago (opcional)</b></label>
		 				<label class="col-sm-1 control-label"><b>Desde:</b></label>
		 				<div class="col-md-2">
		 					<input type="text" class="form-control datepicker" id="FechaPagoInc" data-format="dd/mm/yyyy" data-start-view="2" name="FechaPagoInc" value="<?php echo $FechaPagoInc;?>">
		 				</div>
		 				<label class="col-sm-1 control-label"><b>Hasta:</b></label>
		 				<div class="col-md-2">
		 					<input type="text" class="form-control datepicker" id="FechaPagoFin" data-format="dd/mm/yyyy" data-start-view="2" name="FechaPagoFin" value="<?php echo $FechaPagoFin;?>">
		 				</div>
		 			</div>

		 			<div class="form-group" id="formFechaEmision">
		 				<label class="col-sm-3 control-label"><b>Fecha de emisión (opcional)</b></label>
		 				<label class="col-sm-1 control-label"><b>Desde:</b></label>
		 				<div class="col-md-2">
		 					<input type="text" class="form-control datepicker" id="FechaEmiInc" data-format="dd/mm/yyyy" data-start-view="2" name="FechaEmiInc" value="<?php echo $FechaEmiInc;?>">
		 				</div>
		 				<label class="col-sm-1 control-label"><b>Hasta:</b></label>
		 				<div class="col-md-2">
		 					<input type="text" class="form-control datepicker" id="FechaEmiFin" data-format="dd/mm/yyyy" data-start-view="2" name="FechaEmiFin" value="<?php echo $FechaEmiFin;?>">
		 				</div>
		 			</div>

	 		 		<div class="form-group" id="grupoRut">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Ingrese rut (opcional) </b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<input type="text" class="form-control inputRut" placeholder="Ej: 123456789-9" id="inputRut" name="inputRut" value="<?php echo $inputRut;?>">
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Empresa</b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<select  class="form-control" name="empresa">
	 		 					<option <?php if(isset($empresa) && $empresa =="CL01"): echo "selected"; endif;?> value="CL01">ISAPRE BANMÉDICA</option>
	 		 					<option <?php if(isset($empresa) && $empresa =="CL24"): echo "selected"; endif;?> value="CL24">VIDA TRES</option>
	 		 				</select>
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group">
	 		 			<label for="field-1" class="col-sm-3 control-label"><b>Estado pago</b></label>
	 		 			<div class="col-sm-6"> 
	 		 				<select  class="form-control" name="estadoPago">
	 		 					<option <?php if(isset($estadoPago) && $estadoPago =="todos"): echo "selected"; endif;?> value="todos">Todos</option>
	 		 					<option <?php if(isset($estadoPago) && $estadoPago =="RC"):    echo "selected"; endif;?> value="RC">Rechazados</option>
	 		 					<option <?php if(isset($estadoPago) && $estadoPago =="AU"):    echo "selected"; endif;?> value="AU">Autorizados</option>
	 		 					<option <?php if(isset($estadoPago) && $estadoPago =="IN"):    echo "selected"; endif;?> value="IN">Ingresados</option>
	 		 					<option <?php if(isset($estadoPago) && $estadoPago =="PA"):    echo "selected"; endif;?> value="PA">Pagados</option>
	 		 				</select>
	 		 			</div>
	 		 		</div>
	 		 		<div class="form-group">
	 		 			<label for="field-2" class="col-sm-3 control-label"><b>Opciones</b></label>
	 		 			<div class="col-sm-2">
	 		 				<input type="button" class="btn btn-info" id="btnBuscar"  value="Buscar">
	 		 			</div> 
	 		 			
	 		 		</div>
	 		 		<input type="hidden" name="hidden_busqueda" value="<?php echo $activoBusqueda;?>" id="hidden_busqueda">
	 		 		<input type="hidden" value="<?php echo count($pagos);?>" id="cant_pagos">
	 		    </form>
	 		    <hr>
	 		    <?php 
	 		    if(count($pagos)>0 ):?>
	 		    <div class="row">
	 		    	<span class="col-sm-3"><h4><b>Información pago proveedor<b></h4></span>
	 		    	<div class="col-sm-2">
	 		 			<input type="button" class="btn btn-success" id="btnExportar" value="Exportar Excel">
	 		 		</div>
	 		    </div>
	 		    
	 		    <table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>NÚM CASO</th>
		 		    		<th>EMP</th>
		 		    		<th>RUT PROV</th>
		 		    		<th>NOM PROV</th>
		 		    		<th>NRO DOC</th>
		 		    		<th>DOC</th>
		 		    		<th>SAP</th>
		 		    		<th>ESTADO</th>
		 		    		<th>SOLICITANTE</th>
		 		    		<th>MONTO</th>
		 		    		<th>V PAGO</th>
		 		    		<th>BCO PRO</th>
		 		    		<!--<th>AGENCIA</th>-->
		 		    		<th>USUARIO ACTUAL</th>
		 		    		<th>FECHA PAGO</th>
		 		    		<th>FECHA PAGO SAP</th>
		 		    		<th>url DT</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<!--los campos estan mapeados por eso no coinciden con las cabeceras-->
	 		    	<?php 
	 		    	foreach ($pagos as $key => $value): 	
	 		    			if($value->idProceso == ""){$value->idProceso = 0;}
	 		    			if($value->valorTotal == ""){$value->valorTotal = 0;}  	 	 ?>
		 		    	<tr>
		 		    	   <!--NÚMERO CASO<-->
		 		    		<td>
		 		    			<?php if(isset($value->idProceso)):?>
			 		    			<button class="btn btn-danger ver_traza" id_pro="<?php echo $value->idProceso;?>" cod_emp="<?php echo $value->codEmpresa;?>">
			 		    				<?php echo $value->idProceso;?>	ver traza </button>
		 		    			<?php endif;?>
		 		    			 
		 		    		</td>
		 		    		<!--EMPRESA<-->
							<td>
						    	<?php 
						    	if(isset($value->codEmpresa)): echo $value->codEmpresa; endif;?>
						    </td>
						    <!--RUT PROV.-->
							<td>
								<?php if(isset($value->rutProveedor)): echo $value->rutProveedor; endif;?>
							</td>
							<!--NOMBRE PROV.-->
							<td>
								<?php if(isset($value->nombreProveedor)): echo $value->nombreProveedor;endif;?>
							</td>
							<!--NRO. DOC.-->
							<td>
								<?php if(isset($value->nroDt)): echo $value->nroDt;endif;?>
							</td>
							<!--tipo DOC.-->
							<td>
								<?php if(isset($value->claseDocSap)): echo $value->claseDocSap;endif;?>
							</td>
							<!--tipo SAP.-->
							<td>
								<?php if(isset($value->codComprobanteSap)): echo $value->codComprobanteSap;endif;?>
							</td>
							<!--ESTADO-->
							<td>
								<?php if(isset($value->estadoDt)): echo $value->estadoDt;endif;?>
							</td>
							<!--Ingresado por-->
							<td>
								<?php if(isset($value->ingresador)): echo $value->ingresador;endif;?>
							</td>
							<!--MONTO-->
							<td>
								<?php if(isset($value->valorTotal)): echo "$".number_format($value->valorTotal,0, '','.');endif;?>
							</td>
							<!--VIA PAGO-->
							<td>
								<?php if(isset($value->totalDistrib)): echo $value->totalDistrib;endif;?>
							</td> 
							<!--BCO. PROPIO-->
							<td>
							<?php if(isset($value->porcDistrib)): echo $value->porcDistrib;endif;?>
							</td> 
							<!--AGENCIA
							<td>
							<?php //if(isset($value->porcDistrib)): echo $value->porcDistrib;endif;?>
							</td> 
							-->
							<!--Usuuarios actual-->
							<td>

								<?php echo $value->usuarioActual;?>
							</td>
							<!--fecha pago-->
							<td>
							<?php if(isset($value->fechaSolicitud)): echo str_replace("0:00:00","",$value->fechaSolicitud);endif;?>
							</td> 
							<!--fecha Pago sap-->
							<td>
							<?php 
							if(isset($value->fechaAutoriza)): echo str_replace("0:00:00","",$value->fechaAutoriza);endif;?>
							</td> 
							<!--URL-->
							<td>
								<?php if(isset($value->urlFile)): echo "<a href='".$value->urlFile."' target='_blank'>DTE</a>";
								endif;?>
							</td>
		 		    	</tr>
	 		    	<?php endforeach ?>
	 		    </table>
	 			<?php endif;?>
			</div> 
		</div>
	</div>
</div>
<div class="modal fade" id="modalShowTraza">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Traza del proceso</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<div id="showData"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>

<style type="text/css" media="screen">
	.control-label >b{
		color: black;
	}
	#table-1_wrapper{
		overflow-x: auto;
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

<link rel="stylesheet" type="text/css" href="http://alxlit.name/bootstrap-chosen/bootstrap.css">
<script src="<?php echo base_url();?>assets/js/loadingoverlay.min.js"></script>
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

				
	});
</script>
<script type="text/javascript">
var $ = jQuery;


$('#inputRut').Rut({
  format_on: 'keyup'
});

var cant_pagos = $("#cant_pagos").val();
if(cant_pagos > 0){
   $(".page-container").addClass('sidebar-collapsed');
}

		 		    			 
$(".ver_traza").click(function(event) {
	/* Act on the event */
	var id_pro  = $(this).attr("id_pro");
	var cod_emp = $(this).attr("cod_emp");
		
	$.ajax({
		url: '<?php echo base_url()?>consultapagos/ver-traza',
		type: 'POST',
		dataType: 'json',
		data: {id_pro: id_pro, cod_emp ,cod_emp},
		beforeSend: function(){
	  		$.LoadingOverlay("show");
		},
		success: function(response){
	 		$.LoadingOverlay("hide");
	 		CreateTableFromJSON(response);
		}
	});
	
});
function CreateTableFromJSON(response) {
        var myBooks = response;

        // EXTRACT VALUE FOR HTML HEADER. 
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < myBooks.length; i++) {
            for (var key in myBooks[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.createElement("table");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < myBooks.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                tabCell.innerHTML = myBooks[i][col[j]];
            }
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        var divContainer = document.getElementById("showData");
        divContainer.innerHTML = "";
        divContainer.appendChild(table);
        $("#showData > table").addClass('table').addClass('table-striped'); 
        $(".modal-dialog").css('width', '70%');
        $("#modalShowTraza").modal("show");
    }

function validarForm(){

	var estado = true;
	$(".form-group").removeClass('has-error');
	//fecha pago
	/*Fecha pafgo*/
	if($("#inputRut").val() == "" ){
		if($("#FechaPagoInc").val() =="" && $("#FechaEmiInc").val()==""){
			alert("Ingrese una fecha de inicio (Emisión o de Pago)");
			//$("#formFechaPago").addClass('has-error');
			estado = false;
		}
	}

	if($("#FechaPagoFin").val() !="" && $("#FechaPagoInc").val()==""){
		alert("Ingrese la fecha pago Desde");
		$("#formFechaPago").addClass('has-error');
		estado = false;
	}

	if($("#FechaPagoInc").val() !="" && $("#FechaPagoFin").val() !="" && estado == true){
		
		var S1 = $("#FechaPagoInc").val().split("/");
		var S2 = $("#FechaPagoFin").val().split("/");

		var f1 = new Date(S1[2], S1[1], S1[0]); //31 de diciembre de 2015
		var f2 = new Date(S2[2], S2[1], S2[0]); //30 de noviembre de 2014
		//feha de inicio es mayor afehca de fin
		if(f1 > f2){
			alert("La fecha de inicio no puede ser mayor a la fecha de Fin");
			$("#formFechaPago").addClass('has-error');
			estado = false;
		}
	}

	/*fecha de emision*/
	if($("#FechaEmiFin").val() !="" && $("#FechaEmiInc").val()==""){
		alert("Ingrese la fecha emisión Desde");
		$("#formFechaEmision").addClass('has-error');
		estado = false;
	}

	if($("#FechaEmiInc").val() !="" && $("#FechaEmiFin").val() !="" && estado == true){
		
		var Z1 = $("#FechaEmiInc").val().split("/");
		var Y2 = $("#FechaEmiFin").val().split("/");

		var ff1 = new Date(Z1[2], Z1[1], Z1[0]); //31 de diciembre de 2015
		var ff2 = new Date(Y2[2], Y2[1], Y2[0]); //30 de noviembre de 2014
		//feha de inicio es mayor afehca de fin
		if(ff1 > ff2){
			alert("La fecha de inicio no puede ser mayor a la fecha de Fin");
			$("#formFechaEmision").addClass('has-error');
			estado = false;
		}
	}
	
	if($("#inputRut").val()!=""){
		if(!validarRut($("#inputRut").val())){
			alert("Ingrese rut valido con el siguente formato 12456789-9");
			$("#grupoRut").addClass('has-error');
			estado = false;
		}
	}

	return estado;
}


$("#btnBuscar").click(function() {
	
	if(validarForm()){
	   var url ="<?php echo base_url();?>"+"consultapagos";
	   $("#hidden_busqueda").val(1);
	   $("form").attr("action",url);
	   $("form").submit();
	}
});

$("#btnExportar").click(function(event) {
	
	if(validarForm()){
	 	var url ="<?php echo base_url();?>"+"consultapagos/setExcel";
	   $("form").attr("action",url);
	   $("form").submit();
	}
});

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
	else { return true; }
}
</script>

