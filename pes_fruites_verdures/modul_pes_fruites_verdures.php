<?php
	include_once "../includes/conexion.php";

//---------------------------------------------------------------------------------------------------------------
//				DETERMINAR SI PEDIDO DE VERDURAS Y FRUTAS ESTÁ COMPLETO
//---------------------------------------------------------------------------------------------------------------
function pedido_completo($link,$id)
{
	$sql = <<<SQL
		SELECT 
			comandes_carret.comprats AS comprats
		FROM comandes_carret
		JOIN altres_productes ON comandes_carret.id_producte = altres_productes.id
		WHERE comandes_carret.id_comanda = $id
		  AND altres_productes.supermercat = 'mercatcamp'
		  AND altres_productes.marca = 'El comprador' 
SQL;
	$result = mysql_query($sql, $link);
	$total = mysql_num_rows($result);

	$salida = 'class="success"';
	
	for($x=0;$x<$total;$x++)
	{
		$comprats = mysql_result($result,$x,'comprats');
		if(($comprats == 0)OR(is_null($comprats))){
			$salida = '';
			//$salida = 'class="warning"';
		}
	}
	
	if ($salida=='class="warning"'){
		for($x=0;$x<$total;$x++)
		{	
			$comprats = mysql_result($result,$x,'comprats');
			if(is_null($comprats)){
				$salida = '';
		}
	}
	}
	return $salida;
}
	
//---------------------------------------------------------------------------------------------------------------
//						PREPARAR INFO POR COMANDA
//---------------------------------------------------------------------------------------------------------------
function info_comanda($link,$id)
{
	$sql = <<<SQL
		SELECT 
			comandes_entrega.franja as franja,
			usuaris.nom as nom, 
			usuaris.cognoms as cognoms,
			comandes.comentaris as comentaris
		FROM comandes
		JOIN comandes_entrega ON comandes.id = comandes_entrega.id_comanda
		JOIN usuaris ON comandes.id_usuari = usuaris.id
		WHERE comandes.id = $id
SQL;

	$result = mysql_query($sql, $link);
	$total = mysql_num_rows($result);
	
	for($x=0;$x<$total;$x++)
	{
		$nom = mysql_result($result,0,'nom');
		$cognoms = mysql_result($result,0,'cognoms');
		$franja = mysql_result($result,0,'franja');
		$comentaris= mysql_result($result,0,'comentaris');
	}
	
	if ($total>0){
			return array($nom,$cognoms,$franja,$comentaris);
	}	
	mysql_free_result($result);
}

?>
