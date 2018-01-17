<?php

 include_once "../includes/conexion.php";
 include_once "modul_pes_fruites_verdures.php";
 $html='';

//---------------------------------------------------------------------------------------------------------------
//						LISTAR PRODUCTOS COMANDA
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="listar_productes_comanda")
{
	if ((!isset($_POST['id']))OR(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	$fecha = $_POST['fecha'];
	$idc = $_POST['id'];
	
	$sql = <<<SQL
	SELECT 
		comandes_carret.id as idcc,
		comandes_carret.id_producte as idp,
		altres_productes.text_cat as nom,
		altres_productes.supermercat as supermercat,
		altres_productes.marca as marca,
		altres_productes.a_pes as a_pes,
		comandes_carret.quantitat as quantitat,
		comandes_carret.comprats as comprats
	FROM comandes_carret
	JOIN altres_productes ON comandes_carret.id_producte = altres_productes.id
	WHERE comandes_carret.id_comanda = $idc
		  AND altres_productes.supermercat = 'mercatcamp'
		  AND altres_productes.marca = 'El comprador' 
	ORDER BY idp
SQL;
	$result = mysql_query($sql, $link);	
	$total = mysql_num_rows($result);

	$html = '';
	
	$html = $html . <<<HTML
		<script type='text/javascript' src='funciones_pes_fruites_verdures.js'></script>
		<script type='text/javascript'> 
			jQuery(document).ready(function() {		
				tablaComanda();
				x_editable();
			});
		</script>
HTML;
	
	$html = $html . <<<HTML
	<div class="container-fluid">
	 <div class="row">
	  <div class="col-sm-12">
	  
		<table id="tabla_comanda" class="table cell-border display compact table-responsive" style="font-size:16px">
		  <thead style="background-color:rgb(150,150,255); font-size:80%">
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Supermercat</th>
				<th>Marca</th>
				<th>A Pes</th>
				<th>Quantitat</th>
				<th>COMPRAT</th>      
			</tr>	
		</thead>
		<tfoot style="font-size:12px">
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Supermercat</th>
				<th>Marca</th>
				<th>A Pes</th>
				<th>Quantitat</th>
				<th>COMPRAT</th>
			</tr>
		</tfoot>
	   <tbody>
HTML;

	for($x=0;$x<$total;$x++){
		
		$idcc = mysql_result($result,$x,'idcc');
		$idp = mysql_result($result,$x,'idp');
		$nom = mysql_result($result,$x,'nom');
		$supermercat = mysql_result($result,$x,'supermercat');
		$marca = mysql_result($result,$x,'marca');
		$a_pes = mysql_result($result,$x,'a_pes');
		$quantitat = mysql_result($result,$x,'quantitat');
		$comprats = mysql_result($result,$x,'comprats');
		
	  $html = $html . <<<HTML
		<tr>
			<td>$idp</td>
			<td>$nom</td>
			<td>$supermercat</td>
			<td>$marca</td>
			<td>$a_pes</td>
			<td>$quantitat</td>
			<td class="info" idcc="$idcc"><a class= "peso_editable" apes="$a_pes"><b>$comprats</b><a></td>
		</tr>
HTML;
		
	}	

	$html = $html . <<<HTML
		</tbody>
		   </table>
		</div>   
	
	  </div>
	 </div>
	</div>
HTML;
	echo $html;
}

//---------------------------------------------------------------------------------------------------------------
//					GUARDAR PESO COMPRATS
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="guardar_peso")
{
	if ((!isset($_POST['id']))OR(!isset($_POST['peso'])))
	{
		echo -1; 
		exit(-1);
	}
	
	$id = $_POST['id'];
	$peso = $_POST['peso'];
	
	$consulta="UPDATE comandes_carret SET
				 comprats = $peso
			   WHERE id='$id'";
	
	$resultado=mysql_query($consulta,$link) or die (mysql_error());
	mysql_free_result($resultado);
	echo(1);
	exit();
}

//---------------------------------------------------------------------------------------------------------------
//					LEER BALANZA
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="leer_balanza")
{
	$servidor2 = '31.220.20.208';
	$sql_user2 = 'u390183179_vadur';
	$sql_password2 = 'puXaXuBaGe';
	$sql_db2 = 'u390183179_tysaz';
	$link2 = mysql_connect($servidor2, $sql_user2, $sql_password2) or die('No se pudo conectar: ' . mysql_error());
	mysql_set_charset('utf8',$link2);
	mysql_select_db($sql_db2) or die('No se pudo seleccionar la base de datos');
	
	$consulta = <<<SQL
		SELECT peso AS peso_balanza FROM peso
SQL;
	$resultado=mysql_query($consulta,$link2) or die (mysql_error());
	
	$peso_balanza = mysql_result($resultado,0,'peso_balanza');

	$html = <<<HTML
		$peso_balanza 
HTML;

	echo($html);	
	mysql_free_result($resultado);
	mysql_close($link2);
	exit();

}

?>