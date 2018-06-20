<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	
	.color-white{
		color: white;
	}

	.link1{
		cursor: pointer;
	}
	textarea{
		resize: none;
	}
	.form-wizard > ul > li.active a span,
	.form-wizard > ul > li.current a span {
	  background: #c5c5c5!important;
	  background: #00a651!important;
	  color: #f5f5f6!important;
	  -moz-box-shadow: 0px 0px 0px 5px #ebebeb!important;
	  -webkit-box-shadow: 0px 0px 0px 5px #ebebeb!important;
	  box-shadow: 0px 0px 0px 5px #ebebeb!important;
	}
	.form-wizard .steps-progress .progress-indicator {
  background: #ebebeb!important;
  width: 0%;
  height: 10px;
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  -moz-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.pager li > a,
.pager li > span {
  display: inline-block;
  padding: 5px 14px;
  background-color: #303641!important;
  border: 1px solid #dddddd;
  border-radius: 3px;
  color: white !important;
}
.pager li > a:hover,
.pager li > a:focus {
  text-decoration: none;
  background-color: #303641!important;
}
.bigger{
	width: 75px;
	margin-left: 30px;
}
.chosen-container{
	width: 100%!important;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Nuevo Proveedores ISAPRES</center></h3></div>
				 <div class="panel-options">
				  	  <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			<form method="POST" action="<?php echo base_url();?>mantenedor/proveedores/nuevo" id="formularioCarga">
			 	<div class="panel-body">
			 	    <div class="row">
			 	    	<div class="col-md-12">
							<div id="rootwizard" method="post" action="" class="form-horizontal form-wizard">

							<div class="steps-progress" style="margin-left: 7.14286%; margin-right: 7.14286%;">
								<div class="progress-indicator" style="width: 0px;"></div>
							</div>
							<ul>
								<li class="completed" id="proveedor_LI">
									<a href="#tab1" data-toggle="tab"><span>1</span>Proveedor</a>
								</li>
								<li class="" id="proveedor_LI2">
									<a href="#tab2" data-toggle="tab"><span>2</span>Cuentas</a>
								</li>
								<li class="">
									<a href="#tab3" data-toggle="tab"><span>3</span>Resultado</a>
								</li>
							</ul>

							<div class="tab-content">
								<!--FORM PROVEEDOR-->
								<div class="tab-pane active" id="tab1">
								<div class="form-wizard validate" method="POST" id="form_serialize">

										<div class="form-group" id="grupoApellido">
											<label class="col-sm-4 control-label"><b>Sociedad(s)</b></label>
											<div class="col-sm-5">
												<div class="input-group">
												   <select class="form-control" name="sociedad" id="SOCIEDAD">
												        <option value="">-</option>
												        <option value="AMBAS" <?php if(isset($_POST['sociedad']) && $_POST["sociedad"] =="AMBAS"){echo "selected";}?>>ISAPRES-BANMEDICA - VIDA TRES</option>
					<option value="CL01" <?php if(isset($_POST['sociedad']) && $_POST["sociedad"] =="CL01"){echo "selected";}?>>ISAPRES BANMEDICA</option>
					<option value="CL24" <?php if(isset($_POST['sociedad']) && $_POST["sociedad"] =="CL24"){echo "selected";}?>>VIDA TRES</option>
												   </select>
												</div>
											</div>
										</div>

										<div class="form-group" id="grupoNombre">
											<label class="col-sm-4 control-label"><b>Rut</b></label>
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">-</span>
													<input data-validate="required" placeholder="EJ 12345678-9"  name="RUT" id="RUT" type="text" class="form-control" >
												</div>
											</div>
											<div class="col-lg-1">
												<button type="button" class="btn btn-defauly btn_validaRut">
												Validar en SAP
												</button>
											</div>
										</div>
										<div class="form-group" id="grupoNombre">
											<label class="col-sm-4 control-label"><b>Nombre</b></label>
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">-</span>
													<input  name="nombre" id="NOMBRE" type="text" class="form-control">
												</div>
											</div>
										</div>
										
										<div class="form-group" id="grupoApellido">
											<label class="col-sm-4 control-label"><b>E-MAIL</b></label>
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">-</span>
													<input name="MAIL" id="MAIL" type="text" class="form-control" >
												</div>
											</div>
										</div>

										<div class="form-group" id="grupoApellido">
											<label class="col-sm-4 control-label"><b>AGENCIA</b></label>
											<div class="col-sm-3">
												<div class="input-group">
													<select ID="AGENCIA" class="form-control" name="AGENCIA">
														<option></option>
														<option value="229">229</option>
														<option value="499">499</option>
														<option value="225">225</option>
														<option value="115">115</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group" id="grupoApellido">
											<label class="col-sm-4 control-label"><b>BANCO - PROPIO</b></label>
											<div class="col-sm-3">
												<div class="input-group">
													<select class="form-control" name="BANCO" ID="BANCO">
														<option></option>
														<option value="COR01">COR01</option>
														<option value="CHI04">CHI04</option>
														<option value="SAN06">SAN06</option>
														<option value="EST02">EST02</option>
														<option value="SAN16">SAN16</option>
														<option value="BCI03">BCI03</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group" id="grupoApellido">
											<label class="col-sm-4 control-label"><b>TIPO- PAGO</b></label>
											<div class="col-sm-3">
												<div class="input-group">
													<select class="form-control" name="TIPO_P" ID="TIPO_P">
														<option></option>
														<option value="C">CHEQUE</option>
														<option value="V">VALE VISTA</option>
														<option value="T">TRANSFERENCIA</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group" id="grupoRecurrente">
											<label class="col-sm-4 control-label"><b>¿Es recurrente?</b></label>
											<div class="col-sm-3">
												<div class="input-group">
													<select class="form-control" name="RECURRENTE" id="RECURRENTE">
														<option value="N">NO</option>
														<option value="S">SI</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group" id="grupoMontoTope">
											<label class="col-sm-4 control-label"><b>Monto Tope</b></label>
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">$</span>
													<input name="MONTO_TOPE" id="MONTO_TOPE" type="text" class="form-control" data-mask="fdecimal" placeholder="ingrese monto en pesos" data-dec="," data-rad="." maxlength="10" value=""/>
												</div>
											</div>
										</div>
								</div>
								</div>
								<!--FORM CUENTAS-->
								<div class="tab-pane" id="tab2">
									<h2>Agregar cuentas</h2>
									<div class="row">
										<div class="col-sm-6">
											<select tabindex="2" class="form-control chosen_cuentas" name="chosen_cuentas">
													<option value=""></option>
													<?php
													 if(count($cuentaSAP)>0){
													 	foreach ($cuentaSAP as $key => $value) {
	echo "<option value='".$value['CODIGO']."-".$value["NOMBRE"]."'>".$value['CODIGO']." ".$value["NOMBRE"]."</option>";
													 	}

													 }
													?>
											</select>	
										</div>
										<div class="col-sm-6"> 
											<div class="pull-left">
												<button class="btn btn-primary pull-right" id="nuevaFila" type="button">
												Añadir nueva fila
												<i class="entypo-list-add"></i> 
											</button>
											</div>
										</div>
									</div>
									<hr>
									
										<div class="row">
											<div class="col-md-12">
												<form method="POST">
													<table class="table table-bordered" id="tbl2">
													<thead class="thead-inverse">
													<tr class="table-info">
														<td>CODIGO CUENTA</td>
														<td>DESCRIPCIÓN CUENTA</td>
														<td>OPCIONES</td>
													</tr>
													</thead>
													</table>
												</form>
											</div>
										</div>
									
								</div>
								<!--FORM confirmacion-->

								<div class="tab-pane" id="tab3">
								 	
								 	<div class="row">
								 		<div class="col-md-12">
								 			<div style="width: 50%;margin: 0 auto;">
												<div class="tile-block tile-blue">
													<div class="tile-header">
														<i class="glyphicon glyphicon-bullhorn"></i>
														<h2 class="color-white">Confirmar Información</h2>
													</div>
													<div class="tile-content">
														<p>Si esta seguro de crear al nuevo proveedor, por favor presione el boton<br><b>"Guardar datos"</b>.</p>
													</div>
													<br>
													<center>
														<button id="btn_guardar" style="border-color:#00a651!important;margin-bottom:10px;background-color: #00a651!important;" type="button" class="btn btn-success">Guadar Datos</button>
													</center>
												</div>
											</div>
								 		</div>
								 	</div>
								</div>

								<div style="width: 22%; float: right;">
									<ul class="pager wizard">
										<li class="previous disabled primary">
											<a href="#"><i class="entypo-left-open"></i> Previous</a>
										</li>
										<li class="next primary">
											<a href="#">Next <i class="entypo-right-open"></i></a>
										</li>
									</ul>
								</div>
							</div>
							</div>
			 	    	</div>
			 	    </div>
				</div> 
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modalExito">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de información</h4>
			</div>
			<div class="modal-body">
				<h2><b>El proveedor ha sido  registrado exitosamente.</b></h2>
				<h3>¿Desea volver al menú principal de proveedores?</h3>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url();?>mantenedor/proveedores">
					<button type="button" class="btn btn-primary bigger">Si</button>
				</a>
				<button type="button" class="btn btn-info bigger" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalErrorSAP">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de Error</h4>
			</div>
			<div class="modal-body">
				<h2><b id="errorSAP"></b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalExitoSAP">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de información</h4>
			</div>
			<div class="modal-body">
				<h2>
				<b>El proveedor cumple con las condiciones necesarias para ser creado.</b></h2>
				<h4>Por favor continue con el resto del formulario, para finalizar el registro.</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info bigger" data-dismiss="modal">continuar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalError">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de Error</h4>
			</div>
			<div class="modal-body">
				<h2><b>Error. Ya existe un proveedor con este rut y sociedad </b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalErrorChosen">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de Error</h4>
			</div>
			<div class="modal-body">
				<h2><b>Para agregar una fila, antes debe seleccionar una cuenta de la lista.</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalErrorChosenDuplicado">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de Error</h4>
			</div>
			<div class="modal-body">
				<h2><b>No puede  ingresar la mismas cuenta dos veces para el mismo proveedor</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>



<style type="text/css" media="screen">
	.control-label >b{
		color: black;
	}
</style>	
<!-- Bottom scripts (common) -->
<script src="<?php echo base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url();?>assets/js/joinable.js"></script>
<script src="<?php echo base_url();?>assets/js/resizeable.js"></script>
<script src="<?php echo base_url();?>assets/js/neon-api.js"></script>


<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>

<script src="<?php echo base_url();?>assets/js/loadingoverlay.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://alxlit.name/bootstrap-chosen/bootstrap.css">
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

<script type="text/javascript">
var $ = jQuery;

$(document).ready(function($) {
 $("#MONTO_TOPE").val("0");
 $("#MONTO_TOPE").attr('disabled', 'disabled');

 $("#SOCIEDAD").change(function(event) {
 	/* Act on the event */
 	if($(this).val()!=""){
 	   $("#formularioCarga").submit();	
 	}

 });

 $("#MONTO_TOPE").focusin(function(event) {
 	/* Act on the event */
 	$(this).val("");
 });

 $("#RECURRENTE").change(function(event) {
 	/* Act on the event */
 	if($(this).val()=="N"){
 	   $("#MONTO_TOPE").val("0");
 	   $("#MONTO_TOPE").attr('disabled', 'disabled');	
 	}
 	else
 	{
 		$("#MONTO_TOPE").removeAttr('disabled');
 	}

 });
 
 $('.chosen_cuentas').chosen();
//cargar pagina uno directamenet
 $("#proveedor_LI > a > span").trigger('click');	

 $("#btn_guardar").click(function(event) {
 	/* Act on the event */

 	var cuentas =$("form").serialize();

 	

 	var tbl2 =$("#tbl2 textarea").serializeArray();

 	var data= {};
   	var x   = 1;
	$('.ccuentas').each(function(i,el){
		var cl = $(this).attr('ct');
    	var row = {
        	CUENTA: $(".cuentas"+cl).val().trim(),
        	DESCRIPCION: $(".descripcion"+cl).val().trim(),
       	};
       	data[x]= row;
       	x++;
    });
   
 	
	var RUT    = $("#RUT").val().trim();
	var NOMBRE = $("#NOMBRE").val().trim();
	var MAIL   = $("#MAIL").val().trim();
	var AGENCIA   = $("#AGENCIA").val().trim();
	var BANCO   = $("#BANCO").val().trim();
	var TIPO_P   = $("#TIPO_P").val().trim();
	var SOCIEDAD = $("#SOCIEDAD").val();
	var MONTO_TOPE = $("#MONTO_TOPE").val().trim();
	var RECURRENTE = $("#RECURRENTE").val();

	var arreglo ={

		RUT: RUT,
		NOMBRE: NOMBRE,
		MAIL: MAIL,
		AGENCIA: AGENCIA,
		BANCO: BANCO,
		TIPO_P: TIPO_P,
		CUENTAS :data,
		SOCIEDAD :SOCIEDAD,
		MONTO_TOPE : MONTO_TOPE,
		RECURRENTE : RECURRENTE,
 	};

 	if(validarProveedor(SOCIEDAD,RUT,NOMBRE,MAIL,AGENCIA,BANCO,TIPO_P,data,RECURRENTE,MONTO_TOPE)){

		$.ajax({

		 	url: '<?php echo base_url();?>mantenedor/proveedores/nuevo/insert',
		 	type: 'POST',
		 	dataType: 'json',
		 	data: arreglo, 

		  	beforeSend: function(){
		  		$.LoadingOverlay("show");
		 	},
		 	success: function(response){
		 		$.LoadingOverlay("hide");

		 		if(response.estado=="0" || response.estado ==0){
		 		   $("#modalExito").modal("show");
		 		}
		 		if(response.estado=="1" || response.estado ==1){
		 			$("#modalError").modal("show");
		 		}
		 		if(response.estado=="2" || response.estado ==2){
		 			$("#errorSAP").html(response.mensaje);
		 			$("#modalErrorSAP").modal("show");
		 		}

		 	}
		 	
		});
	}
	 
});
 
	

	///aggrae nueva fila a la tabla
	var counter =1;

	$("#nuevaFila").click(function(event){


		var chosen_cuentas = $(".chosen_cuentas").val();


		if(chosen_cuentas !=""){


			
			//separa la cuenta del codigo
			var separacion = chosen_cuentas.split('-');
			//validsr que no se repitan esta cuentas
			var exites =false;
			$('.ccuentas').each(function(i,el){
				var cl = $(this).attr('ct');
		    	
		        if(separacion[0] == $(".cuentas"+cl).val()){
		        	exites = true;
		        	$("#modalErrorChosenDuplicado").modal("show");
		        }
		        
		    });

			if(!exites){
		        var newRow  = $("<tr>");
		        var cols    = "";
		        var sel_sociedad  = "sel_sociedad"+counter;
		        var sel_user      = "sel_user"+counter;
		        cols += '<td><textarea  readonly="readonly" value ="'+separacion[0]+'" class="form-control ccuentas cuentas'+counter+'" ct='+counter+'>'+separacion[0]+'</textarea></td>';
		        cols += '<td><textarea value ="'+separacion[1]+'" readonly="readonly" class="form-control descripcion'+counter+'" ct='+counter+'>'+separacion[1]+'</textarea></td>';
		        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
		        newRow.append(cols);
		        $("#tbl2").append(newRow);
		        counter++;
	    	}
    	}
    	else
    	{

    		$("#modalErrorChosen").modal("show");
    	}


    });



    $("#tbl2").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        //counter -= 1;
    });


});	


$('#RUT').keypress(function (e) {
    if (e.which == '13') {
    	$(".btn_validaRut").trigger('click');
    }
});

$(".btn_validaRut").click(function(event) {
	/* Act on the event */
	var RUT      = $("#RUT").val().trim();
	var SOCIEDAD = $("#SOCIEDAD").val();

	if(RUT ==""){
	   alert("Ingrese el campo rut");
	}
	else if(SOCIEDAD ==""){
	   alert("Seleccione el campo la Sociedad(s)");
	}
	else
	{
	    
	  if(validarRut(RUT)){
         ValidarProveedorSAP(RUT,SOCIEDAD);
	  }
	  else
	  {
	    alert("ingrese un rut valido");
	  }
	}

});

function ValidarProveedorSAP(RUT,SOCIEDAD){

	var arreglo ={
		RUT: RUT,
		SOCIEDAD :SOCIEDAD,
 	};

		$.ajax({
		 	url: '<?php echo base_url();?>mantenedor/proveedores/nuevo/validarSAP',
		 	type: 'POST',
		 	dataType: 'json',
		 	data: arreglo, 

		  	beforeSend: function(){
		  		$.LoadingOverlay("show");
		 	},
		 	success: function(response){
		 		$.LoadingOverlay("hide");

		 		if(response.estado=="0" || response.estado ==0){
		 		   $("#modalExitoSAP").modal("show");
		 		}
		 		if(response.estado=="1" || response.estado ==1){
		 			$("#modalError").modal("show");
		 		}
		 		if(response.estado=="2" || response.estado ==2){
		 			$("#errorSAP").html(response.mensaje);
		 			$("#modalErrorSAP").modal("show");
		 		}
		 	}
		});
	
}



function validarProveedor(SOCIEDAD,RUT,NOMBRE,MAIL,AGENCIA,BANCO,TIPO_P,data,RECURRENTE,MONTO_TOPE){
	
	var estado = true;
	var paso1  = false;
	var paso2  = false;
	var errorDato = false;

	if(SOCIEDAD ==""){
		alert("Seleccione una sociedad");
		estado = false;
		paso1  = true;
	}
	else if(!validarRut(RUT)){
		alert("Ingrese un rut valido");
		estado = false;
		paso1  = true;

	}else if(NOMBRE==""){
		alert("Ingrese un nombre valido");
		estado = false;
		paso1  = true;

	}else if(MAIL != ""){

		if(!validarMail(MAIL)){
			alert("Ingrese un mail valido");
			estado = false;
			paso1  = true;
		}

	}else if(AGENCIA ==""){
		alert("Seleccione una agenia");
		estado = false;
		paso1  = true;
	}else if(BANCO ==""){
		alert("Seleccione un banco");
		estado = false;
		paso1  = true;
	}else if(TIPO_P ==""){
		alert("Seleccione un  tipo de pago");
		estado = false;
		paso1  = true;
	}else if(RECURRENTE =="S" && MONTO_TOPE ==""){
		alert("Debe ingresar un monto mayor  a cero ");
		estado = false;
		paso1  = true;
	}else if(RECURRENTE =="S" && MONTO_TOPE == 0){
		alert("Debe ingresar un monto mayor  a cero ");
		estado = false;
		paso1  = true;
	}


	if(estado){
		if(countProperties(data) > 0){
		}
		else
		{
			alert("Debe ingresar al menos una cuenta contable asociada al proveedor para continuar");
			estado = false;
			paso2  = true;
		}
	}

	if(paso1==true){
	   $(".form-wizard > ul > li#proveedor_LI a span").trigger('click');
	}

	if(paso2==true){
	   alert("Debe siempre ingresar el codigo de cuenta junto con su descripción");	
	   $(".form-wizard > ul > li#proveedor_LI2 a span").trigger('click');
	}
	if(errorDato ==true){
		alert("Solo puede ingresar una cuenta contable de 10 digitos");	
	    $(".form-wizard > ul > li#proveedor_LI2 a span").trigger('click');
	}

    return estado;
}

function countProperties (obj) {
    var count = 0;

    for (var property in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, property)) {
            count++;
        }
    }

    return count;
}

function soloNumeros(numero){
	var estado = true;
	if(!/^([0-9])*$/.test(numero)){
	 	estado = false;
	}
	return estado;
}


function validarMail(mail){
	var emailRegex =/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	var estado = false;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if(emailRegex.test(mail)) {
       estado = true;
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
	else { return true; }
}

</script>
