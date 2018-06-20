<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
	td b {
		color:#373e4a;
	}
	td a b:hover {
		text-decoration: underline;
		color: blue;
	}
	li {
	margin: 0px;
	padding: 0px;

	}
	ul {
	margin: 0px;
	padding: 0px;
	}
	.btn-icon.btn-sm.icon-left {
	    margin-bottom: 7px;
	    margin-top: 7px;
	}
</style>
<?php

if(!isset($doc_dt['rs_cant'])){	$doc_dt['rs_cant'] =0; }

if(!isset($inputTipo)){	$inputTipo ='';}   
if(!isset($inputDoc)){ $inputDoc  =''; }  
if(!isset($inputRut)){	$inputRut ='';}  
if(!isset($inputCaso)){	$inputCaso ='';} 
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				<div class="panel-title">
				<h3><center>Consultas Documentos</center></h3>
				</div>
			</div> 
			<div class="panel-body">
				<?php if($doc_dt['rs_cant'] == 0 ||  $doc_dt['rs_cant'] ==''){ ?>
				<div class="row" id="informacíon_block">
					<div class="col-md-12">
					<blockquote class="blockquote-blue">
						<p>
							<strong>informacíon de Ayuda</strong>
						</p>
						<p style="color: #0e0e0e;">
							Esta opción te permite buscar los documentos que están ingresados en CSC, soló debes completar los campos del formulario
						</p>
					</blockquote>
					</div>
				</div>
				<?php }?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-dark" data-collapsed="0"> 
							<div class="panel-heading" style="background-color: rgba(0, 140, 255, 0.66);">
								<div class="panel-title">
									<h4><center style="color: white;">Formurlario de busqueda</center></h4>
								</div>
								<div class="panel-options">
							
							<a id="down_form" href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							</div>
							</div>
							<div class="panel-body">
								<form method="POST" action="<?php echo base_url()?>consultas-documentos" class='form-horizontal form-groups-bordered'>
									<div class="form-group">
										<label class="col-sm-3 control-label">
										<b>Número caso:</b></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon"></span>
												<input name="inputCaso" id="inputCaso" type="text" class="form-control" placeholder="Ej 123" 
												value="<?php echo $inputCaso;?>">
											</div>
										</div>
									</div>
									<div class="form-group grupoRut">
										<label class="col-sm-3 control-label"><b>Rut proveedor:</b></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon"></span>
												<input id="inputRut" type="text" class="form-control" placeholder="Ej 12345678-9" name="inputRut" 
												value="<?php echo $inputRut;?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>Número Documento:</b></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon"></span>
												<input name="inputDoc" name="inputDoc" type="text" class="form-control" placeholder="Ej 123" 
												value="<?php echo $inputDoc;?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>Tipo Documetos:</b></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon">
												<i style="color:rgba(204, 19, 19, 0.76);" class='glyphicon glyphicon-asterisk'></i>
												</span>
												<select id="inputTipo" class="form-control" name="inputTipo">
													<?php
													$selec ='';
													if($inputTipo ==2){
														$selec ="selected=seleted";
													}
													?>
													<option  value="1">
													Facturas , Boletas o Notas crédito</option>
													<option <?php echo $selec?> value="2">
													Ordenes Compra</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>Opciones:</b></label>
										<div class="col-sm-2">
											<button id="btnBuscar" type="button" class="btn btn-info">
											Buscar</button>
										</div>
									</div>
								<input id="activoBusqueda" type="hidden" name="activoBusqueda" value="">
								<input id="doc_dt_cant" type="hidden"  value="<?php echo $doc_dt['rs_cant'];?>">
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php 
				?>
				<?php if($doc_dt['rs_cant'] > 0 ){ ?>
				<div class="row">
					<div class="col-md-12">
						<div class="table-resultado">
							<table class="table table-bordered datatable" id="table-1">
							<thead>
								<tr>
									<td>N° caso</td>
									<td>Rut Proveedor</td>
									<td>Nombre Proveedor</td>
									<td>Orden De Compra</td>
									<td>Facturas , Boletas o Notas Créditos</td>
								</tr>
								</thead>
								<tbody>
								<?php 
								foreach($doc_dt['documento'] as $key => $value){
									$orden    = "<span style='color:red;'>Sin orden</span>";
									$opcionOC = "";
									$mergeOC  = "#";
									if(count($value['ORDEN'])>0){
										$opcionOC = "<a tipoDoc='OC' ID_CASO ='".$value['ORDEN']['ID_CASO']."' class='ver_traza btn btn-info btn-sm btn-icon icon-left'><i class='entypo-info'></i> Pendiente</a>";

										$orden   ="Orden N° ".$value['ORDEN']['NUMERO_ORDEN'];
										
										if($value['ORDEN']['ORDEN_APROBADA'] ==1){
											$opcionOC = "<a tipoDoc='OC' ID_CASO ='".$value['ORDEN']['ID_CASO']."' class='ver_traza btn btn-success btn-sm btn-icon icon-left'><i class='entypo-check'></i> Aprobada</a>";
										}
										if($value['ORDEN']['ID_ESTADO'] ==3){
											$opcionOC = "<a tipoDoc='OC' ID_CASO ='".$value['ORDEN']['ID_CASO']."' class='ver_traza btn btn-danger btn-sm btn-icon icon-left'><i class='entypo-cancel'></i> Rechazada</a>";
										}
									}
									?>
									<tr>
										<td><b><?php echo $value['ID_CASO'];?></b></td>
										<td><b><?php echo 'Rut '.$value['RUT_PROVEEDOR'];?></b></td>
										<td><b><?php echo $value['NOMBRE_PROVEEDOR'];?></b></td>
										<td>
											<a><?php echo $opcionOC;?> 
											<b><?php echo $orden;?></b></a>
										</td>
										<td>
											<?php
											$tipo    = "<span style='color:red;'>Sin Documento</span>";
											if(count($value['DT'])>0){
												echo "<ul style='list-style: none;'>";
												foreach ($value['DT'] as $key => $DT){
													if($DT['ID_TIPO_DOCUMENTO']==1){
														$tipo ="Boleta";
													}
													if($DT['ID_TIPO_DOCUMENTO']==2){
														$tipo ="Factura";
													}
													if($DT['ID_TIPO_DOCUMENTO']==3){
														$tipo ="Nota de crédito";
													}

													if($DT['ID_TIPO_DOCUMENTO']==4){
														$tipo ="Nota de Débtio";
													}

													$estadoDT ="Pendiente";
													$btnicon  = "info";
													$btnColor = "info";

													if($DT['ID_ESTADO']==3){
													   $estadoDT = "Rechazada";
													   $btnicon  = "cancel";
													   $btnColor = "danger";
													}

													if($DT['ID_ESTADO']==2 && $DT['ASUNTO']=="APROBADO POR GERENCIA CSC"){
														$estadoDT ="Aprobada";
														$btnicon  = "check";
													    $btnColor = "success";
													}

												$opcionDT = "<a tipoDoc='DT' ID_CASO ='".$DT['ID_CASO']."' class='ver_traza btn btn-".$btnColor." btn-sm btn-icon icon-left'><i class='entypo-".$btnicon."'></i>".$estadoDT."</a>";
												echo  "<li><b>".$opcionDT." ".$tipo." N° ".$DT['NUMERO_DOCUMENTO']."</b></li>";
												}
												echo "</ul>";
											}else{
												echo $tipo;
											}
											?>
										</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade in" id="modal-1" aria-hidden="false">
	<div class="modal-dialog" style="width: 90%;">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Detalles del caso</h4>
			</div>
			<div class="modal-body" id="body_modal_traza">
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

<script src="<?php echo base_url();?>assets/js/loadingoverlay.min.js"></script>

<!-- JavaScripts initializations and stuff -->
<!-- Demo Settings -->

<script type="text/javascript">
jQuery(document).ready(function($)
{
	var table = $("#table-1").dataTable({
		"sPaginationType": "bootstrap",
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bStateSave": true
	});

	table.columnFilter({
		"sPlaceHolder" : "head:after"
	});
});
		
</script>
<script type="text/javascript">
var $ = jQuery;

$(function() {
	var doc_dt_cant = $("#doc_dt_cant").val();
	if(doc_dt_cant !="" && doc_dt_cant > 0 ){
		$(".page-container").addClass('sidebar-collapsed');
		$(".panel-dark").addClass('panel-collapse');
		$(".panel-dark .panel-body").css('display','none');
		$("#informacíon_block").css('display','none')
	}
});

$(".ver_traza").click(function(event) {
	/* Act on the event */
	var ID_CASO = $(this).attr("ID_CASO");
	var tipoDoc = $(this).attr("tipoDoc");
	
	$.ajax({
		url: '<?php echo base_url()?>consultas-documentos/traza/'+ID_CASO+'/'+tipoDoc,
		type: 'POST',
		dataType: 'html',
		beforeSend: function(){
	  		$.LoadingOverlay("show");
		},
		success: function(result){
	 		$.LoadingOverlay("hide");
	 		$("#body_modal_traza").html(result);
	 		$('#modal-1').modal('show');
		}
	});
});


function validarForm(){

	var estado = true;
	$(".form-group").removeClass('has-error');
	
	if($("#inputRut").val()!=""){
		if(!validarRut($("#inputRut").val())){
			alert("Ingrese rut valido con el siguente formato 12456789-9");
			$(".grupoRut").addClass('has-error');
			estado = false;
		}
	}

	return estado;
}


$("#btnBuscar").click(function() {
	
	if(validarForm()){
	   $("#activoBusqueda").val(1);
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
