<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style type="text/css">
	#inputComentarios{
		resize:none;
	}
	.contenMsjSuces{
		width: 78%;
		margin: 0 auto;
	}
	.ms-list{
		width: 200px!important;
	}
	b{
		color:black;
		font:15px;
	}
	#input_borrar{
		float: right;
		margin-right: 40px;
	}
	.embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
	}
	.embed-container iframe {
	    position: absolute;
	    top:0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	}
	.centerTD{
		text-align: center;
	}
	.btn-bigger{
		width: 140px!important;
		height: 40px!important;
		
	}
	.btn-bigger p{
		font-weight: bold!important;
		font-size: 20px!important;
		padding-bottom: 5px;
	}
	#tabFormuario2 , #tabFormuario3{
		display: none;;
	}
	table {
    border-collapse: separate;
    border-spacing: 0 5px;
}

thead th {
    background-color: #006DCC;
    color: white;
}

tbody td {
    background-color: #EEEEEE;
}

tr td:first-child,
tr th:first-child {
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
}

tr td:last-child,
tr th:last-child {
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
}
.textCenter{
	text-align: center;
}
.linkCenter{
	margin:  0 auto;
}
.contenMsjOrange , .contenMsjSuces , .contenMsjWarning{
	display: none;
}
#overflow-contabildad{
	height: 500px!important;
	overflow-y: visible!important;
    overflow-x: hidden;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Contabilidad / Tareas por hacer</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
				<div class="row" >
					<div class="col-md-12">
					<div class="panel panel-gradient" id="tabFormuario1">
						<div class="panel-heading">
							<div class="panel-title"><h4><b>Validar caso número:<?php echo $numCaso;?></b></h4></div>
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#profile-1" data-toggle="tab">Documento PDF</a></li>
									<li><a href="#profile-2" data-toggle="tab">Formulario</a></li>
									<li><a href="#profile-3" data-toggle="tab">Anexos</a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" >
								<div class="tab-pane active" id="profile-1">
								
									<div class="embed-container">
										<iframe width="560" height="315" src="<?php echo $DOC_PDF["urlFile"];?>" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
								<div class="tab-pane" id="profile-2">
									<form class="form-horizontal" id="overflow-contabildad">
									    <div class="form-group">
									        <div class="col-xs-12">
									    	<table class="table table-bordered">
									    	    <tr> <td colspan="4"><h4 class="centerTD"><h3><b>Proveedor</b></h3></td></tr>
									    		<tr>
									    			<td><b>Rut Proveedor</b></td>
									    			<td><b>Rut Nombre</b></td>
									    			<td><b>Formar de Pago</b></td>
									    			<td><b>Proveedor de Confianza</b></td>
									    		</tr>
									    		<tr>
									    			<td><?php echo $cabecera["RUT_PROVEEDOR"];?></td>
									    			<td><?php echo $cabecera["NOMBRE_PROVEEDOR"];?></td>
									    			<td><?php echo $cabecera["FORMA_PAGO"];?></td>
									    			<td>SI</td>
									    		</tr>
									    	</table>
									    	</div>
									    </div>
									    <!--datis-->
									    <div class="form-group">

									        <div class="col-xs-12">
									    	<table class="table table-bordered">
									    	    <tr> <td colspan="10"><h4 class="centerTD"><h3><b>Datos del documento</b></h3></td></tr>
									    		<tr>
									    			<td><b>Sociedad</b></td>
									    			<td><b>Tipo Impuesto</b></td>
									    			<td><b>Tipo Documento</b></td>
									    			<td><b>Nro Documento</b></td>
									    			<td><b>Fec.Emisión</b></td>
									    			<td><b>Fec.Recepción</b></td>
									    			<td><b>Fec.Pago</b></td>
									    			<td><b>Pronto Pago</b></td>
									    			<td><b>Doc Elec</b></td>
									    			<td><b>Activo Fijo</b></td>
									    		</tr>
									    		<tr>
									    			<td><?php echo $cabecera["COD_EMPRESA"];?></td>
									    			<td><?php echo $cabecera["TIPO_IMPUESTO"];?></td>
									    			<td><?php echo $cabecera["TIPO_DOCUMENTO"];?></td>
									    			<td><?php echo $cabecera["NUMERO_DOCUMENTO"];?></td>
									    			<td><?php echo $cabecera["FECHA_EMISION"];?></td>
									    			<td><?php echo $cabecera["FECHA_RECEPCION"];?></td>
									    			<td><?php echo $cabecera["FECHA_PAGO"];?></td>
									    			<td><?php echo $cabecera["ES_PRONTO_PAGO"];?></td>
									    			<td><?php echo $cabecera["ES_ELECTRONICO"];?></td>
									    			<td><?php echo $cabecera["ES_ACTIVO_FIJO"];?></td>
									    		</tr>
									    	</table>
									    	</div>
									    </div>
									    <!--<div class="form-group">

									        <div class="col-xs-12">
									    	<table class="table table-bordered">
									    	    <tr> <td colspan="10"><h4 class="centerTD"><h3><b>Montos del documento</b></h3></td></tr>
									    		<tr>
									    			<td><b>Otros impuestos</b></td>
									    			
									    		</tr>
									    		<tr>
									    			<td> $<?php echo $cabecera["VALOR_OTR_IMP"];?></td>
									    		</tr>
									    	</table>
									    	</div>
									    </div>-->
									    <!--datis-->
									    <div class="form-group">
									        <div class="col-xs-12">
									    	<table class="table table-bordered">
									    	    <tr> <td colspan="4"><h4 class="centerTD"><h3><b>Distribución</b></h3></td></tr>
									    		<tr>
									    			<td><b>Cuenta Contable</b></td>
									    			<td><b>Centro de Costo</b></td>
									    			<td><b>Distribución (%)</b></td>
									    			<td><b>Monto</b></td>
									    		</tr>
									    		<?php 
									    		if(count($distribucion)>0){
									    			foreach ($distribucion as $key => $value) {?>
										    		<tr>
										    			<td><?php echo $value["CUENTA_CONTABLE"];?></td>
										    			<td><?php echo $value["COD_CCOSTO"];?></td>
										    			<td><?php echo $value["PORCENTAJE"];?></td>
										    			<td><?php echo number_format($value["TOTAL"],0,"",".");?></td>
										    		</tr>
									    		<?php }}?>
									    	</table>
									    	</div>
									    </div>
									    <div class="form-group">
									        <div class="col-xs-12">
									    	<table class="table table-bordered">
									    	    <tr> <td colspan="8"><h4 class="centerTD"><h3><b>Precomprobante Contable</b></h3></td></tr>
									    		<tr>
									    			<td><b>Proveedor</b></td>
									    			<td><b>Deudor</b></td>
									    			<td><b>Cuenta (%)</b></td>
									    			<td><b>Texto</b></td>
									    			<td><b>CodImpuesto</b></td>
									    			<td><b>Centro de Costo</b></td>
									    			<td><b>Referencia</b></td>
									    			<td><b>Monto</b></td>
									    		</tr>
									    		<?php if(count($Comprobante)>0){
									    			foreach ($Comprobante as $key => $value) {
								    				?>
										    		<tr>
										    			<td><?php echo $value["VENDOR_NO"];?></td>
										    			<td><?php echo $value["CUSTOMER"];?></td>
										    			<td><?php echo $value["HKONT"];?></td>
										    			<td><?php echo $value["SGTXT"];?></td>
										    			<td><?php echo $value["TAX_CODE"];?></td>
										    			<td><?php echo $value["COSTCENTER"];?></td>
										    			<td><?php echo $value["ALLOC_NMBR"];?></td>
										    			<td><?php echo number_format($value['AMT_DOCCUR'],0,"",".");?></td>
										    		</tr>
									    		<?php }}?>
									    	</table>
									    	</div>
									    </div>
									    <br>
									    <div class="form-group">
									        <div class="col-xs-12">
									        	<center>
									        		<button id="btnContinuarF1" type="button" class="btn-bigger btn btn-success"><p>Continuar</p></button>
									        	</center>
									        </div>
									    </div>
									</form>
								</div>
								<div class="tab-pane" id="profile-3">
								<div class="row">
									<div class="col-md-12">
									<?php if(count($anexos)>0){?>
										<div class="tabs-vertical-env">
											<ul class="nav tabs-vertical"><!-- available classes "right-aligned" -->
											<?php 
											$i =1;
												if(count($anexos)>0){
													foreach ($anexos as $key => $value) {
														$active ="";
														if($i==1){$active="active";}?>
														<li class="<?php echo $active;?>">
															<a href="#v-<?php echo $i;?>" data-toggle="tab">ANEXO <?php echo $i;?></a>
														</li>
													<?php 
												$i++;
												}
											}?>
											</ul>
											<div class="tab-content">
											<?php
												$y =1;
												if(count($anexos)>0){
													foreach ($anexos as $key => $value){
														$active2 ="";
														if($y==1){$active2="active";}
														?>
														<div class="tab-pane <?php echo $active2;?>" id="v-<?php echo $y;?>">
															<div class="embed-container">
															<iframe width="560" height="315" src="<?php echo trim($value["input"]);?>" frameborder="0" allowfullscreen></iframe>
															</div>
														</div>									
														<?php
														$y++;
													}
												}
											?>
											</div>
										</div>	
									<?php
									}
									else
									{
									?>
										<div class="alert alert-warning"><strong>Información!</strong>
											este caso no contiene anexos adicionales
										</div>
									<?php 
									} 
									?>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
					<!--uno-->
					<div class="panel panel-gradient" id="tabFormuario2">
						<div class="panel-heading">
							<div class="panel-title"><h4><b>Validar caso Número:<?php echo $numCaso;?></b></h4></div>
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#profile-1" data-toggle="tab">Autorización</a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" >
								<div class="tab-pane active" id="subprofile-1">
									
								<label><b>Ingrese su datos de acceso para validar su autorizacíon</b></label>
								<br>
								<form class="form-horizontal" method="POST" id="FormConfirmacion">
									<div class="form-group">
										<label class="control-label col-sm-2" for="userCont"> <b>Usuario:</b></label>
										<div class="col-sm-8">
										<input disabled type="text" class="form-control" id="userCont" value="<?php echo $_SESSION['USER_NAME'];?>" name="username">
										</div>
									</div>
									<div class="form-group" id="grupo_pwd">
										<label class="control-label col-sm-2" for="pwd"><b>Password:</b></label>
										<div class="col-sm-8"> 
										<input name="password" type="password" class="form-control" id="pwd" placeholder="Ingrese su contraseña">
										</div>
									</div>
									<div class="form-group" id=grupo_opcion>
										<label class="control-label col-sm-2"><b>Opción:</b></label>
										<div class="col-sm-8"> 
										<select  class="form-control" id="input_opcion">
											<option></option>
											<option value="D">Devolver</option>
											<option value="A">Aprobar</option>
										</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="pwd"><b>Comentarios:</b></label>
										<div class="col-sm-8"> 
										<textarea class="form-control" id="inputComentarios" name="comentarios">
										</textarea>
										</div>
									</div>
									<br>
									<br>
									<div class="form-group"> 
										<div class="col-sm-offset-2 col-sm-10">
											<button type="button" class="btn-bigger btn btn-info" id="btnVolverFormu1">
											<p>Volver</p></button>
											<button type="button" class="btn-bigger btn btn-success" id="btnSendSave">
											<p>Guardar</p></button>
										</div>
									</div>
									<input type="hidden" ID="TASK_UID" value="<?php echo $delegacion["UID_TASK"];?>">
									<input type="hidden" ID="APP_UID" value="<?php echo $delegacion["APP_UID"];?>">
									<input type="hidden" ID="nextUser" value="<?php echo $delegacion["nextUser"];?>">
									<input type="hidden" ID="DEL_INDEX" value="<?php echo $delegacion["DEL_INDEX"];?>">
								</form>
								</div>
							</div>
						</div>
					</div>
					<!--anexos-->

					<div class="panel panel-gradient" id="tabFormuario3">
						<div class="panel-heading">
							<div class="panel-title"><h4><b>Validar caso Número:<?php echo $numCaso;?></b></h4></div>
							<div class="panel-options">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#profile-3" data-toggle="tab">Envio de tarea</a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
							<div class="tab-content" >
								<div class="tab-pane active" id="subprofile-3">
									<div class="row">
										<div class="col-sm-12">
											<div class="contenMsjSuces">
												<div class="tile-stats tile-green">
													<div class="icon">
														<i class="entypo-paper-plane"></i>
													</div>
													<div class="textCenter num">Tarea Enviada</div>
													<h3 class="textCenter">El caso número <?php echo $numCaso;?></h3>
													<p class="textCenter"> 
														<b class="proximoUSER"></b>
													</p>
												</div>
												<center>
												<a class="linkCenter" href="<?php echo base_url();?>contabilidad/tarea-por-hacer">
													<button type="button" class="btn-bigger btn btn-info" id="btnsalirFormu1">
													<p>Salir</p>
													</button>
												</a>
												</center>
											</div> 
											<div class="contenMsjOrange">
												<div class="tile-stats tile-orange">
													<div class="icon">
														<i class="entypo-paper-plane"></i>
													</div>
													<div class="textCenter num">Tarea devuelta</div>
													<h3 class="textCenter">El caso número <?php echo $numCaso;?></h3>
													<p class="textCenter"> 
														<b class="TXT_COMENTARIOS_CONT"></b>
													</p>
												</div>
												<center>
												<a class="linkCenter" href="<?php echo base_url();?>contabilidad/tarea-por-hacer">
													<button type="button" class="btn-bigger btn btn-info" id="btnsalirFormu1">
													<p>Salir</p>
													</button>
												</a>
												</center>
											</div> 
											<div class="contenMsjWarning">
												<div class="tile-stats tile-warning">
													<div class="icon">
														<i class="entypo-paper-plane"></i>
													</div>
													<h3 class="textCenter">El caso número <?php echo $numCaso;?></h3>
													<p class="textCenter">ha sido detenido debido a un error en la jerarquía de autorización, por favor contáctese con el área de informática: 
														<b class="proximoUSER"></b>
													</p>
												</div>
												<center>
												<a class="linkCenter" href="<?php echo base_url();?>contabilidad/tarea-por-hacer">
													<button type="button" class="btn-bigger btn btn-info" id="btnsalirFormu1">
													<p>Salir</p>
													</button>
												</a>
												</center>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
<!-- Modal 1 (Basic)-->
<div class="modal fade" id="modal-1">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de error</h4>
			</div>
			
			<div class="modal-body">
				<h2><b>La password ingresada es incorrecta</b></h2>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b>Los datos ingresados son incorrectos</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-core.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-theme.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-forms.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">

<script src="assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.css">
<!-- Bottom scripts (common) -->
<script src="<?php echo base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/joinable.js"></script>
<script src="<?php echo base_url();?>assets/js/resizeable.js"></script>
<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/polaris/polaris.css">

<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/typeahead.min.js"></script>
<script src="<?php echo base_url();?>assets/js/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url();?>assets/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url();?>assets/js/neon-chat.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>

<script type="text/javascript">
var $ = jQuery;

$(document).ready(function($) {

	$("#input_guardar").click(function(event) {
		if(validarGuardado()){
 		   $('#modal-1').modal('show');
		}
		else
		{
			$("#modal-2").modal("show");
		}
	});

	$("#btnContinuarF1").click(function(event) {
		/* Act on the event */
		$("#tabFormuario1").fadeOut('400', function() {
			$("#tabFormuario2").fadeIn('200', function() {
			});
		});
	});

	$("#btnVolverFormu1").click(function(event) {
		/* Act on the event */
		$("#tabFormuario2").fadeOut('400', function() {
			$("#tabFormuario1").fadeIn('200', function() {
			});
		});
	});

	//ajaz de validacion
	$("#btnSendSave").click(function(event) {
		/* Act on the event */
		var usewr =$("#userCont").val();
		var pwd   =$("#pwd").val();
		
		var data  =
		{
			 username :usewr,
			 password :pwd
		}

		if(validarform()){
		
			$.ajax({
			   url: '<?php echo base_url();?>/ajax/login',
			   type: 'POST',
			   dataType: 'html',
			   data: data ,

			    beforeSend: function(){
			    	//$.LoadingOverlay("show");
			    },
			    complete: function(){
		    		//$.LoadingOverlay("hide");
					
				},
			    success: function(response){

			    	//$.LoadingOverlay("hide");
					   	var response = JSON.parse(response);
						var Q_login_status = response.login_status;
						var sessionId = response.sessionId;


						if(Q_login_status == 'invalid')
						{
							$("#modal-1").modal("show");
						}

						if(Q_login_status == 'success')
						{
							/*envia el caso para delegar el caso*/
							delegarCasoContabilidad(sessionId);
						}
	            },
			});
		}//fin validacio fobrm

	});//fin btn_enviar


}); //fin query 


function validarform(){
	var estado = true;
	var password = $("#pwd").val();
	var opcion   = $("#input_opcion").val();
	
	$(".form-group").removeClass('has-error');

	if(password==""){
		alert("Ingrese password");
		estado = false;
		$("#grupo_pwd").addClass('has-error');
	}else
	if(opcion==""){
		alert("seleccione una opción");
		$("#grupo_opcion").addClass('has-error');
		estado = false;
	}

	return estado;
}

function delegarCasoContabilidad(sessionID){

	$.ajax({
		url: '<?php echo base_url();?>/contabilidad/tarea-por-hacer/delegar',
		method: 'POST',
		dataType: 'json',
		data: 
		{ 
			numero_caso: '<?php echo $numCaso;?>',
			accion_caso: $("#input_opcion").val(),
			comentarios_caso: $("#inputComentarios").val(),
			sessionID_caso : sessionID,
			TASK_UID  : $("#TASK_UID").val(),
			APP_UID   : $("#APP_UID").val() ,
			nextUser  : $("#nextUser").val(),
			DEL_INDEX : $("#DEL_INDEX").val(),
			password  : $("#pwd").val(),


		},

	    beforeSend: function(){
	    	$.LoadingOverlay("show");
	    },
	    complete: function(){
    		//$.LoadingOverlay("hide");
			
		},
	    success: function(response){
	    	setTimeout(function(){
			
		    	$.LoadingOverlay("hide");

		    	$(".proximoUSER").html("");

		    	if(response === "D"){

		    		$(".TXT_COMENTARIOS_CONT").html($("#inputComentarios").val());

			        $(".contenMsjOrange").css('display', 'block');
				    $("#tabFormuario2").fadeOut('400', function() {
						$("#tabFormuario3").fadeIn('200', function(){
							var messaje = JSON.parse(response);
						});
					});

		    	}
		    	else
		    	{
			        
			        $(".contenMsjSuces").css('display', 'block');
			            $("#tabFormuario2").fadeOut('400', function() {
							$("#tabFormuario3").fadeIn('200', function(){
							var messaje = "Esta tarea fue derivada";
						});
					});
				}
				
		    	/*else
		    	{
		        	//error en routing
		        	$(".contenMsjWarning").css('display', 'block');
		        	$(".contenMsjOrange").css('display' , 'none');
		        	$(".contenMsjSuces").css('display',   'none');

		        	$("#tabFormuario2").fadeOut('400', function() {
						$("#tabFormuario3").fadeIn('200', function(){
							var messaje = JSON.parse(response);
						});
					});
		    	}*/

	    	}, 1500);

        },
	});
	return false;
}

function validarGuardado(){
	return true;
}
</script>

