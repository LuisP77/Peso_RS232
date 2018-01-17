<?php
/********************************************************************************************************************/
/*                                       FUNCIÓN RECEPCIÓN FECHA                                                    */
/********************************************************************************************************************/
function recepcion_fecha($today,$prox_semana,$op){
	//min="$hoy" max="$prox_semana"
	$html = '';
	$html = $html . <<<HTML
		<div id="div_fecha" class="row">

			<div class="col-sm-9">
				<strong>Data:</strong>  
				<input id="fecha" name="fecha" type="date" 
					   class="text ui-widget-content ui-corner-all"
					   required="required"  
					   onchange="updateFecha(this.value,$op)" 
					   style="font-weight:bold;" 
					   value="$today"></input>	   
			</div>		   

			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input id="toggle_balanza" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO">
						Llegir Balança
					</label>
				</div>			
			</div>		   

		</div>
HTML;
	return $html;
}
/********************************************************************************************************************/
/*                                       FUNCIÓN LISTA COMANDAS                                                  */
/********************************************************************************************************************/
function listar_comandas($link,$today)
{
	$html = '';
	
	$sql = <<<SQL
		SELECT 
			DISTINCT comandes_entrega.id_comanda as id
		FROM comandes_entrega
		JOIN comandes_carret ON comandes_entrega.id_comanda = comandes_carret.id_comanda
		JOIN altres_productes ON comandes_carret.id_producte = altres_productes.id
		WHERE 
			  comandes_entrega.dia = '$today'
		  AND altres_productes.supermercat = 'mercatcamp'
		  AND altres_productes.marca = 'El comprador'
		ORDER BY comandes_carret.id_comanda    
SQL;
	
    $result = mysql_query($sql,$link);
	$total = mysql_num_rows($result);
    if (!$result) {
		return 'No se pudo ejecutar la consulta: ' . mysql_error();
    }

	
	$html = $html . <<<HTML
	<div class="row">
		<table id="tabla_lista_comandas" class="table cell-border display compact table-responsive" style="font-size:16px">
		  <thead style="background-color:rgb(150,150,255); font-size:80%">
			<tr>
				<th>Veure</th>
				<th>ID</th>
				<th>Nom</th>
				<th>Franja</th>
				<th>Comentaris</th>      
			</tr>	
		</thead>
		<tfoot style="font-size:12px">
			<tr>
				<th> </th>
				<th>ID</th>
				<th>Nom</th>
				<th>Franja</th>
				<th>Comentaris</th>
			</tr>
		</tfoot>
	   <tbody>
HTML;

	for($x=0;$x<$total;$x++)
    {
		$id =  mysql_result($result,$x,"id");
		list($nom,$cognoms,$franja,$comentaris) = info_comanda($link,$id);
		$nombre = $nom.' '.$cognoms;
		
		$clase = pedido_completo($link,$id);
		
		$html = $html . <<<HTML
		<tr $clase>
			<td align="center"><a onclick="abrir_dialogo_comandas($id,'$nombre')"><span class="glyphicon glyphicon-list"></span></a></td>
			<td>$id</td>
			<td>$nombre</td>
			<td>$franja</td>
			<td>$comentaris</td>
		</tr>	
HTML;

	}

	$html = $html . <<<HTML
	   </tbody>
	   </table>
	</div>
HTML;

	return $html;
	
}
/********************************************************************************************************************/
/*                                       FUNCIÓN LISTA PRODUCTOS                                                  */
/********************************************************************************************************************/
function listar_productos($link,$today)
{
	$html = '';
	
	$sql = <<<SQL
		SELECT 
			comandes_carret.id as idcc,
			comandes_entrega.id_comanda as idc,
			comandes_carret.id_producte as idp,
			altres_productes.text_cat as nom,
			altres_productes.supermercat as supermercat,
			altres_productes.marca as marca,
			altres_productes.a_pes as a_pes,
			comandes_carret.quantitat as quantitat,
			comandes_carret.comprats as comprats
		FROM comandes_carret
		JOIN altres_productes ON comandes_carret.id_producte = altres_productes.id
		JOIN comandes_entrega ON comandes_carret.id_comanda = comandes_entrega.id_comanda
		WHERE comandes_entrega.dia = '$today'
		  AND altres_productes.supermercat = 'mercatcamp'
		  AND altres_productes.marca = 'El comprador' 
		ORDER BY idc,idp  
SQL;
	$result = mysql_query($sql, $link);	
	$total = mysql_num_rows($result);

	$html = $html . <<<HTML

	<div class="row">
	  <div class="col-sm-12">
	  
		<table id="tabla_lista_productes" class="table cell-border display compact table-responsive" style="font-size:16px">
		  <thead style="background-color:rgb(150,150,255); font-size:80%">
			<tr>
				<th>IDC</th>
				<th>IDP</th>
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
				<th>IDC</th>
				<th>IDP</th>
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
		$idc = mysql_result($result,$x,'idc');
		$idp = mysql_result($result,$x,'idp');
		$nom = mysql_result($result,$x,'nom');
		$supermercat = mysql_result($result,$x,'supermercat');
		$marca = mysql_result($result,$x,'marca');
		$a_pes = mysql_result($result,$x,'a_pes');
		$quantitat = mysql_result($result,$x,'quantitat');
		$comprats = mysql_result($result,$x,'comprats');
		
//		$clase = producto_completo($comprats);
		
		$html = $html . <<<HTML
			<tr $clase>
				<td>$idc</td>
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
HTML;

	return $html;
}
/********************************************************************************************************************/
/*                                       FUNCIÓN ESCRIBIR PANTALLA                                                  */
/********************************************************************************************************************/
function escribir_recepcion_dato($link,$today,$prox_semana,$op){

    $html_fecha = recepcion_fecha($today,$prox_semana,$op);

	if($op==1){
		$html_lista = listar_comandas($link,$today);
	}else{
		$html_lista = listar_productos($link,$today);
	}
	
	$html='';
	
	$html = $html . <<<HTML
		
	<div id="div_dato">
		<div class="row">		
			<div class="col-sm-11" style="font-size:17px; margin-left: 28px;">			
				$html_fecha
			</div>
		</div>
		<BR>
		<div class="row" style="margin-left: 28px;">
			<div id="busqueda_html" class="col-sm-11">
				$html_lista
			</div>
		</div>
	</div>
HTML;
	return $html;
}

//*******************************************************************************************************************
//*******************************************************************************************************************
//*******************************************************************************************************************

	$op=1;
	if(isset($_GET['op'])){
		$op = $_GET['op'];  
	}		
	
	$today = date("Y-m-d");
//	$today = strtotime(date("Y-m-d", strtotime($today)) . " +1 day");
//	$today = date("Y-m-d",$today);
	$prox_semana = strtotime(date("Y-m-d", strtotime($today)) . " +1 week");
	$prox_semana = date("Y-m-d",$prox_semana);
//	$today = "2016-06-28";
	if(isset($_GET['fecha'])){
		$today = $_GET['fecha'];  
	}


	
	$sec = "pes_fruites_verdures"; $pagact = "pes_fruites_verdures";
	
	include_once "../includes/header.php";
	include_once "../includes/conexion.php";
	include_once "modul_pes_fruites_verdures.php";
   
    $html = escribir_recepcion_dato($link,$today,$prox_semana,$op);
    
	mysql_close($link);
 ///FINAL DEL PHP
 ///////////////////////////////////////////////////////////////////////////////////////////// 
 ///////////////////////////////////////////////////////////////////////////////////////////// 
 /////////////////////////////////////////////////////////////////////////////////////////////
 //Inicio del HTML
?>
		
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<title>ACTDES - Lista de ventas</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	<script src = "https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript"></script>
	
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	
	<link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
	<script src = "https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
	<script src = "https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js" type="text/javascript"></script>
	<script src = "https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js" type="text/javascript"></script>
	<script src = "https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="funciones_pes_fruites_verdures.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/flick/jquery-ui.css">		
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>


	<script language=javascript>

		$(document).ready(function() {
			
			tablaVentas();
			
			$(window).load(function () {
				$(".loading").hide();
				$(".container-fluid").fadeIn("slow");
			});
			
		});
		
	</script>
	
</head>

<body>
	
<!-- -----------------------------  Contenido  --------------------------------------------- --> 	
	<div class="container-fluid" style="display:none">
		
		<div class="row">
			<div class="col-md-12 col-sm-12"> 
				<?php echo $html; ?>
			</div>	
		</div>
		
	</div>	
<!-- -----------------------------  Loading  --------------------------------------------- --> 
	<div class="loading">
		<p align="center" style="margin: 100px;"><img src="../img/page-loader.gif" alt="Cargando..."/></p> 
	</div>
		
</body>
</html>
