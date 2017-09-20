@extends ('layout')

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Filtrar Balance Total</h3>
	</div>
</div>

<div class="row">
	<div class="col s12 m12 l12">	
		<div class="col s4 m4 l4	">
			<div class="input-field col s12"> <!-- Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<select name="filtro" id="filtro">
				<option value="" disabled selected></option>
				<option value="diario">Diario</option>
				<option value="mensuales">Mensual</option>
				<option value="mensual">Por Mes</option>
				<option value="anual">Por Año</option>
				</select>
				<label>Filtro:</label>
			</div>

		</div>
		<div class="col s3 m3 l3">
			<div class="input-field col s12 hide" id="divaño"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<select name="año" id="año">
				<option value="" disabled selected>Seleccione año</option>
				@foreach ( $mis_años as $año)
						<option value="{{$año}}">{{$año}}</option>
				@endforeach
				</select>
				<label>Año:</label>
			</div>

			<div class="input-field col s12 hide " id="divmes"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<select name="mes" id="mes">
				<option value="" disabled selected>Seleccione mes</option>				
				@foreach ( $meses as $mes)					
						<option value="{{$loop->iteration}}">{{$mes}}</option>
				@endforeach
				</select>
				<label>Mes:</label>
			</div>
			<div class="input-field col s12 hide " id="divdesde"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<input type="text" class="datepicker" name="desde" id="desde">
				<label>Desde:</label>
			</div>


		</div>
		<div class="col s3 m3 l3">
			<div class="input-field col s12 hide" id="divañohasta"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<select name="añohasta" id="añohasta">
				<option value="" disabled selected>Seleccione año</option>
				@foreach ( $mis_años as $año)
						<option value="{{$año}}">{{$año}}</option>
				@endforeach
				</select>
				<label>Hasta Año:</label>
			</div>
			<div class="input-field col s12 hide" id="divhasta"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<input type="text" class="datepicker" name="hasta" id="hasta">
				<label>Hasta:</label>
			</div>

		</div>	
		<div class="col s2 m2 l2">
			<button class="btn btn-primary" id="filtrobtn">Filtrar</button>
		</div>
		
		
	</div>	

	<div class='row'>
		<div class="col s12 m12 l12">
			<div class="card">
				<div id='respuesta'></div>
				<div class="card-content" id="graph-container">
					<canvas id="chart_filtro"></canvas>
				</div>
			</div>					
		</div>
		<div class="col s12 m12 l12">
		<div class="card">
			<div class="card-content" id="graph-container2">
				<canvas id="chart_filtro_evolucion"></canvas>
			</div>
		</div>					
	</div>
	</div>

</div>



@endsection



@push('scripts')

<script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>

<script type="text/javascript">
	
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


</script>


@endpush
