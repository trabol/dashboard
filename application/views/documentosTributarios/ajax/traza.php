<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
	.td_titulo{
		color:white;
		font-size: 15px;
		text-align: left!important;
		background-color: rgba(0, 140, 255, 0.66)!important;
		font-weight: bold;
	}
	.tr_titulos{
	    background-color: #cccccc;
	    color: black;
    	font-weight: bold;
	}
	.dinero{
		text-align: right;
	}
</style>
<div class="row" >
	<div class="col-md-12">
		<div class="panel panel-gradient" id="tabFormuario1">
		<div class="panel-heading">
			<div class="panel-title"></div>
			<div class="panel-options">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#profile-1" data-toggle="tab">ver traza</a></li>
					<li><a href="#profile-2" data-toggle="tab">Documento PDF</a></li>
					<li><a href="#profile-3" data-toggle="tab">Información del documento</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-body">
			<div class="tab-content" >
				<div class="tab-pane active" id="profile-1">
					<table class="table table-bordered">
						<tr>
							<td class="td_titulo" colspan=7"">Traza Del Proceso</td>
						</tr>
						<tr class="tr_titulos">
							<td>N° Caso</td>
							<td>Sociedad</td>
							<td>Rut Usuario</td>
							<td>Nombre Usuario</td>
							<td>Comentarios</td>
							<td>Estado</td>
							<td>Fecha De Registro</td>
						</tr>
							<?php
							if(count($traza)>0){
								foreach ($traza as $key => $value) {?>
								<tr>
									<td><?php echo $value["PROCRESO"];?></td>
									<td><?php echo $value["EMPRESA"];?></td>
									<td><?php echo $value["RUT"];?></td>	
									<td><?php echo $value["NOMBRE_AUTORIZA"];?></td>	
									<td><?php echo $value["COMENTARIOS"];?></td>	
									<td><?php echo $value["ESTADO"];?></td>	
									<td><?php echo $value["FECHA"];?></td>		
								</tr>
								<?php
								}
							}
							?>
					</table>
				</div>
				<div class="tab-pane" id="profile-2">
					<div class="row">
						<div class="col-md-12">
						<?php if(isset($documentos) && count($documentos)>0){?>
							<div class="tabs-vertical-env">
								<ul class="nav tabs-vertical"><!-- available classes "right-aligned" -->
								<?php 
								$i =1;
									if(count($documentos)>0){
										foreach ($documentos as $key => $value) {
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
									if(count($documentos)>0){
										foreach ($documentos as $key => $value){
											$active2 ="";
											if($y==1){$active2="active";}
											?>
											<div class="tab-pane <?php echo $active2;?>" id="v-<?php echo $y;?>">
												<div class="embed-container">
													<iframe style="width: 100%;height: 500px;" src="<?php echo $value;?>" frameborder="0" 	allowfullscreen></iframe>
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
				<div class="tab-pane" id="profile-3">
					<?php 
					if($TIPO_VIEW =="OC"){ 
						if(count($infoOC)>0){?>
							<table class="table table-bordered">
								<tr>
									<td class="td_titulo" colspan="11" >Información Orden De Compra</td>
								</tr>
								<tr class="tr_titulos">
									<td>N° Caso</td>
									<td>N° Orden</td>
									<td>Tipo Orden</td>
									<td>Fecha Solicitud</td>
									<td>Rut Proveedor</td>
									<td>Nombre Proveedor</td>
									<td>Tipo Moneda</td>
									<td>Tipo Impuesto</td>
									<td>Neto</td>
									<td>Iva</td>
									<td>Total</td>
								</tr>
								<tr>
									<?php
									if($infoOC->tipoImpuesto =="E"){$infoOC->tipoImpuesto ='Exento';}
									if($infoOC->tipoImpuesto =="A"){$infoOC->tipoImpuesto ='Afecto';}

									if($infoOC->tipo =="I"){$infoOC->tipo ='Inversión';}
									if($infoOC->tipo =="G"){$infoOC->tipo ='Gasto';}

									if($infoOC->tipoMoneda =="PE"){$infoOC->tipoMoneda ='Peso';}
									if($infoOC->tipoMoneda =="UF"){$infoOC->tipoMoneda ='UF';}
									if($infoOC->tipoMoneda =="DO"){$infoOC->tipoMoneda ='DOLAR';}
									if($infoOC->tipoMoneda =="EU"){$infoOC->tipoMoneda ='EURO';}

									?>
									<td><?php echo $infoOC->idProceso;?></td>
									<td><?php echo $infoOC->nroOC;?></td>
									<td><?php echo $infoOC->tipo;?></td>
									<td><?php echo $infoOC->fechaSolicitud;?></td>
									<td><?php echo $infoOC->rutProveedor;?></td>
									<td><?php echo $infoOC->nombreProveedor;?></td>
									<td><?php echo $infoOC->tipoMoneda;?></td>
									<td><?php echo $infoOC->tipoImpuesto;?></td>
									<td class="dinero">$<?php echo number_format($infoOC->neto,2,',','.');?></td>
									<td class="dinero">$<?php echo number_format($infoOC->iva,2,',','.');?></td>
									<td class="dinero">$<?php echo number_format($infoOC->total,2,',','.');?></td>
								</tr>
							</table>
							<table class="table table-bordered">
							<br><br>
							<tr >
								<td class="td_titulo" colspan="5" >Detalles</td>
							</tr>
							<tr class="tr_titulos">
								<td>Codigo</td>
								<td>Descripción</td>
								<td>Cantidad</td>
								<td>Precio Unitario</td>
								<td>Total Neto</td>
							</tr>
							<?php
							if(!is_array($infoOC->listaDetallesOC->Detalle)){?>
							<tr>
								<td><?php echo $infoOC->listaDetallesOC->Detalle->codigo;?></td>
								<td><?php echo $infoOC->listaDetallesOC->Detalle->descripcion;?></td>
								<td><?php echo $infoOC->listaDetallesOC->Detalle->cantidad;?></td>
								<td class="dinero">$
								<?php echo number_format($infoOC->listaDetallesOC->Detalle->valUnitario,2,',','.');?>
								</td>
								<td class="dinero">$
								<?php echo number_format($infoOC->listaDetallesOC->Detalle->valTotalNeto,2,',','.');?>
								</td>
							</tr>
							<?php
							}else{
							foreach ($infoOC->listaDetallesOC->Detalle as $key => $v){?>
								<tr>
									<td><?php echo $v->codigo;?></td>
									<td><?php echo $v->descripcion;?></td>
									<td><?php echo $v->cantidad;?></td>
									<td class="dinero">
										<?php echo number_format($v->valUnitario,2,',','.');?></td>
									<td class="dinero">$
										<?php echo number_format($v->valTotalNeto,2,',','.');?></td>
								</tr>
								<?php
							}}?>
							</table>
							<br><br>
							<table class="table table-bordered">
								<tr>
									<td class="td_titulo" colspan="4">Distribución De Costos</td></tr>
								<tr class="tr_titulos">
									<td>Centro Costo</td>
									<td>Cuenta Contable</td>
									<td>Porcentaje</td>
									<td>Montos</td>
								</tr>
								<?php 
								if(!is_array($infoOC->listaDistribucionesOC->Distribucion)){?>
								<tr>
									<td><?php echo $infoOC->listaDistribucionesOC->Distribucion->centroCosto;?></td>
									<td><?php echo $infoOC->listaDistribucionesOC->Distribucion->cuentaContable;?></td>
									<td class="dinero"><?php echo $infoOC->listaDistribucionesOC->Distribucion->porcentaje;?></td>
									<td class="dinero">$
									<?php echo number_format($infoOC->listaDistribucionesOC->Distribucion->total,2,',','.');?>
									</td>
								</tr>
								<?php
								}
								else
								{
									foreach ($infoOC->listaDistribucionesOC->Distribucion as $key => $v) {?>
										<tr>
											<td><?php echo $v->centroCosto;?></td>
											<td><?php echo $v->cuentaContable;?></td>     
											<td class="dinero">%<?php echo $v->porcentaje;?></td>         
											<td class="dinero">
											$<?php echo number_format($v->total,2,',','.');?></td>              
										</tr>
									<?php
									}
								}
								?>
							</table>
							<?php
						}
					}?>

					<?php 
					if($TIPO_VIEW =='DT'){
						if(isset($infoDT->idProceso) && $infoDT->idProceso !=""){?>
						<table class="table table-bordered">
							<tr>
								<td colspan="14" class="td_titulo">Información Documento Tributario</td>
							</tr>
							<tr class="tr_titulos">
								<td>N° Caso</td>
								<td>Sociedad</td>
								<td>Rut Proveedor</td>
								<td>Nombre Proveedor</td>
								<td>N° Doc</td>
								<!--<td>Fecha Solicitud</td>-->
								<td>Activo Fijo</td>
								<td>Tipo Doc</td>
								<td>Estado</td>
								<td>SAP</td>
								<td>Total</td>
							</tr>
							<tr>
								<td><?php echo $infoDT->idProceso;?></td>
								<td><?php echo $infoDT->codEmpresa;?></td>
								<td><?php echo $infoDT->rutProveedor;?></td>
								<td><?php echo $infoDT->nombreProveedor;?></td>
								<td><?php echo $infoDT->nroDt;?></td>
								<!--<td><?php echo $infoDT->fechaSolicitud;?></td>-->
								<td><?php echo $infoDT->esActivoFijo;?></td>
								<td><?php echo $infoDT->claseDocSap;?></td>
								<td><?php echo $infoDT->estadoDt;?></td>
								<td><?php echo $infoDT->codComprobanteSap;?></td>
								<?php
								if($infoDT->claseDocSap !="BO"){
									echo "<td class='dinero'>$ ".number_format($infoDT->valorTotal,2,',','.')."</td>";
								}
								if($infoDT->claseDocSap =="BO"){
									echo "<td class='dinero'>$ ".number_format($infoDT->valorLiquido,2,',','.')."</td>";
								}
								?>
							</tr>
						</table>
						</br></br>
						<table class="table table-bordered">
							<?php
							$cuenta = "style='display:block'";
							$activo = "style='display:none'";
							 if($infoDT->esActivoFijo=="SI"){
							 	$cuenta = "style='display:none'";
								$activo = "style='display:block'";
							 }
							?>
							<tr>
								<td colspan="4" class="td_titulo">Distribución de Costos</td>
							</tr>
							<tr class="tr_titulos">
								<td>Centro Costo</td>
								<td <?php echo $cuenta;?>;">Cuenta Contable</td>
								<td <?php echo $activo;?>;">Activo Fijo</td>
								<td>Porcentaje</td>
								<td>Montos</td>
							</tr>
							<?php 
							if(count($infoDT_DIS)>0){
								foreach ($infoDT_DIS as $key => $value) {?>
									<tr>
										<td><?php echo $value['COD_CCOSTO'];?></td>
										<td><?php echo $value['CUENTA_CONTABLE'];?></td>
										<td class="dinero">% <?php echo $value['PORCENTAJE'];?></td>
										<td class="dinero">$ <?php echo number_format($value['TOTAL'],2,',','.');?></td>
									</tr>
									<?php
								}
							}
							?>
						</table>
						<?php
						}
					}
					?>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

