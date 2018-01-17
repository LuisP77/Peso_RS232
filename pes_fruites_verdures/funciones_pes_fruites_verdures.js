var peso_balanza = 0;

/* ******************************************************************************************* */
/*                       ACTUALIZAR FECHA
/* ******************************************************************************************* */
	function updateFecha(fecha,op){
		window.location.href='pes_fruites_verdures.php?op='+op+'&fecha='+fecha;
	}  

/* ******************************************************************************************* */
/*                  TABLA DE COMANDAS - DATA TABLES
/* ******************************************************************************************* */
	function tablaComanda(){
	  
	  var tabla_comanda = $('#tabla_comanda').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": -1,
 	    "aaSorting": [],		
		"oLanguage": {
            "sProcessing":     "Processant...",
            "sLengthMenu":     "Mostrar _MENU_ registres",
            "sZeroRecords":    "No s’han trobat resultats",
            "sEmptyTable":     "No hi ha dades disponibles en aquesta taula",
            "sInfo":           "Mostrant registres del _START_ al _END_ d’un total de _TOTAL_ registres",
            "sInfoEmpty":      "Mostrant registres del 0 al 0 d’un total de 0 registres",
            "sInfoFiltered":   "(Filtratge d’un total de _MAX_ registres)",
            "sInfoPostFix":    "",
            "sSearch":         "Cercar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Carregant…",
            "oPaginate": {
            "sFirst":    "Primer",
            "sLast":     "Últim",
            "sNext":     "Següent",
            "sPrevious": "Anterior"
            },
          "fnInfoCallback": null,
        }
      });
	  
	// Añadir input para filtro en cada footer
    $('#tabla_comanda tfoot th').each( function (i) {
        var title = $('#tabla_comanda thead th').eq( $(this).index() ).text();
		if(title=='ID'){
			$(this).html( '<input type="text" size="5" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Nom'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Supermercat'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Marca'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='A Pes'){
			$(this).html( '<input type="text" size="5" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Quantitat'){
			$(this).html( '<input type="text" size="10" placeholder="'+title+'" data-index="'+i+'" />' );			
		}else if(title=='COMPRAT'){
			$(this).html( '<input type="text" size="10" placeholder="'+title+'" data-index="'+i+'" />' );	
		}else{
			$(this).html( '<input type="text" size="4" placeholder="'+title+'" data-index="'+i+'" />' );
		}	
		
    } );
  
    // Evento para manejar Filtro de Columnas
    $( tabla_comanda.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_comanda
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
		
	};
/* ******************************************************************************************* */
/*                       TABLA LISTA DE PRODUCTOS POR DÍA - DATA TABLES
/* ******************************************************************************************* */
	function tablaListaProductes(){
	  
	  var tabla_productes = $('#tabla_lista_productes').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": -1,
 	    "aaSorting": [],		
		"oLanguage": {
            "sProcessing":     "Processant...",
            "sLengthMenu":     "Mostrar _MENU_ registres",
            "sZeroRecords":    "No s’han trobat resultats",
            "sEmptyTable":     "No hi ha dades disponibles en aquesta taula",
            "sInfo":           "Mostrant registres del _START_ al _END_ d’un total de _TOTAL_ registres",
            "sInfoEmpty":      "Mostrant registres del 0 al 0 d’un total de 0 registres",
            "sInfoFiltered":   "(Filtratge d’un total de _MAX_ registres)",
            "sInfoPostFix":    "",
            "sSearch":         "Cercar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Carregant…",
            "oPaginate": {
            "sFirst":    "Primer",
            "sLast":     "Últim",
            "sNext":     "Següent",
            "sPrevious": "Anterior"
            },
          "fnInfoCallback": null,
        }
      });
	  
	// Añadir input para filtro en cada footer
    $('#tabla_lista_productes tfoot th').each( function (i) {
        var title = $('#tabla_lista_productes thead th').eq( $(this).index() ).text();
		if(title=='IDC'){
			$(this).html( '<input type="text" size="5" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='IDP'){
			$(this).html( '<input type="text" size="5" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Nom'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Supermercat'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Marca'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='A Pes'){
			$(this).html( '<input type="text" size="5" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Quantitat'){
			$(this).html( '<input type="text" size="10" placeholder="'+title+'" data-index="'+i+'" />' );			
		}else if(title=='COMPRAT'){
			$(this).html( '<input type="text" size="10" placeholder="'+title+'" data-index="'+i+'" />' );	
		}else{
			$(this).html( '<input type="text" size="4" placeholder="'+title+'" data-index="'+i+'" />' );
		}	
		
    } );
  
    // Evento para manejar Filtro de Columnas
    $( tabla_productes.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_productes
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
		
	};
	
/* ******************************************************************************************* */
/*                       TABLA LISTA COMANDAS - DATA TABLES
/* ******************************************************************************************* */
	function tablaListaComandas(){
	  
	  var tabla_lista_comandas = $('#tabla_lista_comandas').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		"columnDefs": [{ "orderable": false, "targets": 0}],
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": -1,
 	    "aaSorting": [],		
		"oLanguage": {
            "sProcessing":     "Processant...",
            "sLengthMenu":     "Mostrar _MENU_ registres",
            "sZeroRecords":    "No s’han trobat resultats",
            "sEmptyTable":     "No hi ha dades disponibles en aquesta taula",
            "sInfo":           "Mostrant registres del _START_ al _END_ d’un total de _TOTAL_ registres",
            "sInfoEmpty":      "Mostrant registres del 0 al 0 d’un total de 0 registres",
            "sInfoFiltered":   "(Filtratge d’un total de _MAX_ registres)",
            "sInfoPostFix":    "",
            "sSearch":         "Cercar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Carregant…",
            "oPaginate": {
            "sFirst":    "Primer",
            "sLast":     "Últim",
            "sNext":     "Següent",
            "sPrevious": "Anterior"
            },
          "fnInfoCallback": null,
        }
      });
	  
	// Añadir input para filtro en cada footer
    $('#tabla_lista_comandas tfoot th').each( function (i) {
        var title = $('#tabla_lista_comandas thead th').eq( $(this).index() ).text();
		
		if(title!='Veure'){
			if(title=='ID'){
				$(this).html( '<input type="text" size="2" placeholder="'+title+'" data-index="'+i+'" />' );
			}else if(title=='Nom'){
				$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
			}else if(title=='Franja'){
				$(this).html( '<input type="text" size="2" placeholder="'+title+'" data-index="'+i+'" />' );
			}else if(title=='Comentaris'){
				$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
			}else{
				$(this).html( '<input type="text" size="4" placeholder="'+title+'" data-index="'+i+'" />' );
			}	
		}	
    } );
  
    // Evento para manejar Filtro de Columnas
    $( tabla_lista_comandas.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_lista_comandas
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
		
	};
	
/* ******************************************************************************************* */
/*                        ABRIR DIÁLOGO COMANDAS                                               */ 
/* ******************************************************************************************* */
function abrir_dialogo_comandas(id,nombre){
	$('#dialogo_comandas_header').text('Llista de Productes - Comanda '+ id + ', '+ nombre.toUpperCase());
	$('#dialogo_comandas_contenido').html("Carregant...<p align='center' style='margin: 80px;'><img src='../img/page-loader.gif' alt='Carregant...'/>");

	var request = $.ajax({
						url: "ajax_pes.php",
						type: "POST",
						data: {accio: "listar_productes_comanda", 
							   fecha: $("#fecha").val(),
							   id: id
							  },
						dataType: "html"
					});	
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
							$('#dialogo_comandas_contenido').html(msg);
						}	
					});
	
	$("#dialogo_comandas").modal();	
}
	
/* ******************************************************************************************* */
/*                       X-EDITABLE
/* ******************************************************************************************* */
function x_editable(){	

	$.fn.editable.defaults.mode = 'inline';

	$('.peso_editable').editable({
		emptytext: ' ',
		type: 'number',
		//placement:'left',
		success: function(response, newValue) {
			var id_comandes_carret = $(this).closest('td').attr('idcc');
			var request = $.ajax({
						url: "ajax_pes.php",
						type: "POST",
						data: { accio: "guardar_peso", 
								id: id_comandes_carret,
								peso: newValue
							  },
						dataType: "html"
					});	
					request.done(function(msg){
						if (parseInt(msg)==-1){
							alert('ERROR!!!');
						}	
					});
		}
	});

	$('.peso_editable').editable('option','validate', function (peso) {
		if ($.trim(peso) < 0) { 
			return "D'introduir un valor major o igual a zero"; 
		};
		if ($.isNumeric(peso) == '') {
			return 'Només es permeten valors numèrics';
		}
	});
	
	$('.peso_editable').on('shown', function(e, editable) {

		var a_pes = $( this ).attr( 'apes' );
		a_pes = a_pes.toUpperCase()
	
		var lee_balanza = $("#toggle_balanza").is(':checked');
		
		if((a_pes=="SI")&&(lee_balanza)){
			editable.input.$input.val('');
			leer_balanza();
			setTimeout(function(){
				editable.input.$input.val(peso_balanza);
			},500);	
		}
	});
}		
	
/* ******************************************************************************************* */
/*                       LEER BALANZA
/* ******************************************************************************************* */
function leer_balanza(){
//	return 32;
	var peso;
	var request = $.ajax({
					url: "ajax_pes.php",
					type: "POST",
					data: { accio: "leer_balanza"
						  },
					dataType: "html"
					});	
					request.done(function(msg){
						if (parseInt(msg)==-1){
							alert('ERROR!!!');
						}	
						else{
							peso = msg;
							peso_balanza = parseInt(peso);
						}
					});
}	

