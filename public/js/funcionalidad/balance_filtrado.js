
	
	var datos_grafico;
	var claves=[];
	var egresos=[]; 
	var ingresos=[];


	$(document).ready(function(){

		$('select').material_select();

		$( "#filtrobtn" ).click(function() {

			var filtro=$("#filtro option:selected").val();		 	
			switch(filtro) {
			    case 'diario':
			    	var desde=$("#desde").val();
			    	var hasta=$("#hasta").val();
			      	
			      	if (desde !='' && hasta !=''){
 	
 						$.ajax({
							url: '/balance/filtrado/diario/'+desde+'/'+hasta,
							type: 'GET',
							data: { 
								desde: $("#desde").val(),
								hasta: $("#hasta").val()},
							dataType: 'JSON',
							beforeSend: function() {
								$("#respuesta").html('Cargando...');
							},
							error: function() {
								$("#respuesta").html('<div> Ha surgido un error. </div>');
							},
							success: function(respuesta) {
								if (respuesta){
									cargarGrafico(respuesta); 
									$("#respuesta").html('<div></div>');
								}else{
									$("#respuesta").html('<div> No hay datos </div>');
								}
							}
						});

			    	}else{
			    		alert("Falta elegir una fecha");
			    	}

			        break;
			    case 'anual':
			    	var anio=$("#año").val();
			    	if (anio !=null) {

						$.ajax({
							url: '/balance/filtrado/poranio/'+anio,
							type: 'GET',
							data: {anio: $("#año").val()},
							dataType: 'JSON',
							beforeSend: function() {
								$("#respuesta").html('Cargando...');
							},
							error: function() {
								$("#respuesta").html('<div> Ha surgido un error. </div>');
							},
							success: function(respuesta) {
								if (respuesta){
									cargarGrafico(respuesta); 
									$("#respuesta").html('<div></div>');
								}else{
									$("#respuesta").html('<div> No hay datos </div>');
								}
							}
						});
			    					    		
			    	}else{
		    			alert('Seleccione Año');
			    	}
			        break;
			    case 'mensual':
			    	var mes=$("#mes").val();			    	
			    	if (mes !=null){

			    		$.ajax({
							url: '/balance/filtrado/pormes/'+mes,
							type: 'GET',
							data: {mes: $("#mes").val()},
							dataType: 'JSON',
							beforeSend: function() {
								$("#respuesta").html('Cargando...');
							},
						  	error: function() {
						    	$("#respuesta").html('<div> Ha surgido un error. </div>');
							},
						    success: function(respuesta) {
								if (respuesta){
									cargarGrafico(respuesta); 
						        	$("#respuesta").html('<div></div>');
						      	}else{
						        	$("#respuesta").html('<div> No hay datos </div>');
						        }
						   	}
						});
			    	}else{
						alert('Seleccione Mes');
			    	}			    	
			    	break;
			    case 'mensuales':
			    	var aniodesde=$("#año").val();
			    	var aniohasta=$("#añohasta").val();			    
			    	if (aniodesde !=null && aniohasta !=null && aniodesde<=aniohasta) {

			    		$.ajax({
							url: '/balance/filtrado/mensual/'+aniodesde+'/'+aniohasta,
							type: 'GET',
							data: {
								aniodesde: $("#año").val(),
								aniohasta: $("#añohasta").val()},
							dataType: 'JSON',
							beforeSend: function() {
								$("#respuesta").html('Cargando...');
							},
							error: function() {
								$("#respuesta").html('<div> Ha surgido un error. </div>');
							},
							success: function(respuesta) {
								if (respuesta){
									cargarGrafico(respuesta); 
									$("#respuesta").html('<div></div>');
								}else{
									$("#respuesta").html('<div> No hay datos </div>');
								}
							}
						});
			    					    		
			    	}else{
		    			alert('Seleccione ambos años.[Desde no puede ser mayor que hasta]');
			    	}
			    	break;
			    default:
			        alert('Seleccione un filtro');
			}

		});
	});

	function cargarGrafico(respuesta){
		// actualizamos la grafica:
		$('#chart_filtro').remove();
		// al crear un nuevo canvas crea un iframe y para que no se acumulen hay que borrar los viejos primero:
		$('iframe.chartjs-hidden-iframe').remove();
		$('#graph-container').append('<canvas id="chart_filtro"><canvas>');

		claves=[];
		egresos=[]; 
		ingresos=[];

		$.each(respuesta, function(i, item) {
			claves.push(i);
			egresos.push(respuesta[i].egreso);
			ingresos.push(respuesta[i].ingreso);
		});
		

		datos_grafico={
			labels: claves,
			datasets: [{
					label: 'Gastos',
					backgroundColor:'rgba(237, 86, 86, 0.5)',
					borderColor:'rgba(237, 86, 86, 1)',
					borderWidth: 2,
					data: egresos
				},{
					label: 'Ingresos',
					backgroundColor:'rgba(68, 176, 63, 0.5)',
					borderColor:'rgba(68, 176, 63, 1)',
					borderWidth: 2,
					data: ingresos
			}]
		};

		var grafico_anual = document.getElementById("chart_filtro").getContext('2d');
		var chart_filtro = new Chart(grafico_anual, {
			type: 'bar',
			data: datos_grafico,
			options:{
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Egresos e Ingresos'
				}
			}
		});


		// actualizamos la  2 grafica:
		$('#chart_filtro_evolucion').remove();
		// al crear un nuevo canvas crea un iframe y para que no se acumulen hay que borrar los viejos primero:
		$('iframe.chartjs-hidden-iframe').remove();
		$('#graph-container2').append('<canvas id="chart_filtro_evolucion"><canvas>');

		var grafico_evolucion_anual = document.getElementById("chart_filtro_evolucion").getContext('2d');
		var chart_filtro_evolucion = new Chart(grafico_evolucion_anual, {
    		type: 'line',
   			data: datos_grafico,
    		options:{
			    responsive: true,
			    legend: {
			        position: 'top',
			    },
			    title: {
			        display: true,
			        text: 'Evolucion Egresos e Ingresos'
			    },
			    tooltips: {
		            mode: 'index',
		            callbacks: {
		                // Use the footer callback to display the sum of the items showing in the tooltip
		                footer: function(tooltipItems, data) {
		                    var balance = 0;                    
		                    tooltipItems.forEach(function(tooltipItem) {
		                    	balance= data.datasets[1].data[tooltipItem.index] - data.datasets[0].data[tooltipItem.index];

		                    });
		                    return 'Balance: ' + balance;
		                },
		            },
		            footerFontStyle: 'normal'
		        },
    		}
		});

	}

	/* Seleccionar id del DOM  con # */
	//$("#idelemento");
	$("#filtro").change(function(){
		
		$( "#filtro option:selected" ).each(function() {
			if( $( this ).val()== "mensual"){
				$("#divaño").addClass( "hide" );
				$("#divañohasta").addClass( "hide" );
				$("#divdesde").addClass( "hide" );
				$("#divhasta").addClass( "hide" );
				$( "#divmes" ).removeClass( "hide" )
			}
			if( $( this ).val()== "anual"){
				$("#divmes").addClass( "hide" );
				$("#divdesde").addClass( "hide" );
				$("#divhasta").addClass( "hide" );
				$("#divañohasta").addClass( "hide" );
				$( "#divaño" ).removeClass( "hide" )
			}
			if( $(this).val()== "diario"){
				$("#divmes").addClass( "hide" );
				$("#divaño").addClass( "hide" );
				$("#divañohasta").addClass( "hide" );
				$( "#divdesde" ).removeClass( "hide" );
				$( "#divhasta" ).removeClass( "hide" )
			}
			if( $(this).val()== "mensuales"){
				$("#divmes").addClass( "hide" );
				$("#divdesde").addClass( "hide" );
				$("#divhasta").addClass( "hide" );
				$( "#divaño" ).removeClass( "hide");
				$( "#divañohasta" ).removeClass( "hide")
			}
		});
		
	});


	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 20, // Creates a dropdown of 15 years to control year,
		format: 'yyyy-mm-dd',
		container: 'body',
		closeOnSelect: true // Close upon selecting a date,
	});


	// ***********funcionalida del date picker desde hasta *******
	var from_$input = $('#desde').pickadate(),
	    from_picker = from_$input.pickadate('picker')

	var to_$input = $('#hasta').pickadate(),
	    to_picker = to_$input.pickadate('picker')


	// Check if there’s a “from” or “to” date to start with.
	if ( from_picker.get('value') ) {
	  to_picker.set('min', from_picker.get('select'))
	}
	if ( to_picker.get('value') ) {
	  from_picker.set('max', to_picker.get('select'))
	}

	// When something is selected, update the “from” and “to” limits.
	from_picker.on('set', function(event) {
	  if ( event.select ) {
	    to_picker.set('min', from_picker.get('select'))    
	  }
	  else if ( 'clear' in event ) {
	    to_picker.set('min', false)
	  }
	})
	to_picker.on('set', function(event) {
	  if ( event.select ) {
	    from_picker.set('max', to_picker.get('select'))
	  }
	  else if ( 'clear' in event ) {
	    from_picker.set('max', false)
	  }
	})
