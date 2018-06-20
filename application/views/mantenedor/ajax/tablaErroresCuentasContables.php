<table class="table">
	<thead>
	<tr>
	<th>Errores</th>
	<th>Mensajes</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	
	$alerta =0;
	foreach($estadoCarga as $key => $v){
		if(isset($v["error"]) &&  count($v["error"])>0){
			
			?>
			<tr>
			<?php 
				if(count($v["error"])>0){
			    echo "<td>";
				echo count($v["error"]);
				echo "<input type='hidden' value='1' class='hayError'>";
				echo "</td>";
				}
			?>
			<?php 
			if(isset($v["error"]) && count($v["error"])>0){
				echo "<td>";
				foreach ($v["error"] as $error) {
					$alerta =1;
					echo $error."<br>";
				} 
				echo "</td>";  
			}
			?>
			</tr>
		    <?php
		}
	}
	if($alerta == 0){
		echo "<tr>";
			echo "<td>";
			echo 0;
			echo "</td>";
			echo "<td>";
			echo "No se encontro ningún error en el archivo";
			echo "</td>";
		echo "</tr>";
	}
	?>
	</tbody>
</table>
<input type="button" value="Upload file" class="btn btn-success" id="guardarDatos"/>
<div class="modal fade" id="modal-2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b>Solo puedo subir un archivo que no tenga errores</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">aceptar</button>
			</div>
		</div>
	</div>
</div>
<script>
if($('.hayError').attr('class')!=undefined){
   $("#fileExcel").val("");
}
$("#guardarDatos").click(function(event) {
	if($('.hayError').attr('class')==undefined){
		$("form").submit();
	}else{
		$("#modal-2").modal("show");
		$("#fileExcel").val("");
	}
});
</script>