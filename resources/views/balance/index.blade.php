@extends ('layout')

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mi Balance</h3>
	</div>
</div>

<div class="row">
	<div class="col s12 m12 l12">	

		<div class="col s12 m6 l6">
			<div class="card">
				<div class="card-content">
					<canvas id="myChart"></canvas>
				</div>				
			</div>
			
		</div>	

		<div class="col s12 m6 l6">
			<div class="card">
			<div class="card-content">
				<h5 class="center-align">Balance Historico</h5>
				<table class="centered ">
				<thead>
					<tr>
						<th>Descripcion</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ingresos</td>
						<td>$ {{$datos["balanceHistorico"]["ingreso"]}} </td>
					</tr>
					<tr>
						<td>Egresos</td>
						<td>$ {{$datos["balanceHistorico"]["egreso"]}}</td>
					</tr>
					@if( ( $datos["balanceHistorico"]["ingreso"] - $datos["balanceHistorico"]["egreso"] > 0 ) )
						<tr class="light-green lighten-4">
					@else
						<tr class="red lighten-2">
					@endif
						<td>Total</td>
						<td> $ {{ $datos["balanceHistorico"]["ingreso"] - $datos["balanceHistorico"]["egreso"]}}</td>
					</tr>
				</tbody>
				</table>	
			</div>
			</div>		
		</div>

	</div>
</div>

<div class='row'>
	<div class="col s12 m12 l12">
		<div class="card">
			<div class="card-content">
				<canvas id="chart_anual"></canvas>
			</div>
		</div>					
	</div>
	<div class="col s12 m12 l12">
		<div class="card">
			<div class="card-content">
				<canvas id="chart_evolucion_anual"></canvas>
			</div>
		</div>					
	</div>
</div>

<div class='row'>
	<div class="col s12 m12 l12">	
		<div class="col s12 m6 l6">
			<div class="card green lighten-2">
				<div class="card-content white-text">
              		<span class="card-title center-align">Mejor Balance</span>

					<p>Ocurrio el año {{$datos["mejorBalance"]["anio"]}}</p>
					<p>Con un total de $ {{$datos["mejorBalance"]["total"]}}</p>
				</div>
			</div>					
		</div>
		<div class="col s12 m6 l6">
			<div class="card red lighten-2">
				<div class="card-content white-text">
              		<span class="card-title center-align">Peor Balance</span>
					<p>Ocurrio el año {{$datos["peorBalance"]["anio"]}}</p>
					<p>Con un total de $ {{$datos["peorBalance"]["total"]}}</p>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

<!--incluyo los datos pasados a javascript -->
@include ('footer_grafico')


@push('scripts')

<script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>


<script>

var grafico = document.getElementById("myChart").getContext('2d');

var myChart = new Chart(grafico, {
    type: 'pie',
    data: {
        labels: ["Gastos","Ingresos"],
        datasets: [{
            data: [ misBalances.egreso, misBalances.ingreso],
            backgroundColor: [
                'rgba(237, 86, 86, 0.5)',
                'rgba(68, 176, 63, 0.5)'
            ],
            borderColor: [
                'rgba(237, 86, 86, 1)',
                'rgba(68, 176, 63, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Balance Historico'
        }

    }
});


var datos_grafico_anual = {
            labels: claves_anios,
            datasets: [{
                label: 'Gastos',
                backgroundColor:'rgba(237, 86, 86, 0.5)',
                borderColor:'rgba(237, 86, 86, 1)',
                borderWidth: 2,
                data: egresos_anios
            }, {
                label: 'Ingresos',
                backgroundColor:'rgba(68, 176, 63, 0.5)',
                borderColor:'rgba(68, 176, 63, 1)',
                borderWidth: 2,
                data: ingresos_anios
            }]

        };


var grafico_anual = document.getElementById("chart_anual").getContext('2d');
var chart_anual = new Chart(grafico_anual, {
    type: 'bar',
    data: datos_grafico_anual,
    options:{
	    responsive: true,
	    legend: {
	        position: 'top',
	    },
	    title: {
	        display: true,
	        text: 'Egresos e Ingresos Anuales'
	    }
    }
});


var grafico_evolucion_anual = document.getElementById("chart_evolucion_anual").getContext('2d');
var chart_evolucion_anual = new Chart(grafico_evolucion_anual, {
    type: 'line',
    data: datos_grafico_anual,
    options:{
	    responsive: true,
	    legend: {
	        position: 'top',
	    },
	    title: {
	        display: true,
	        text: 'Evolucion Egresos e Ingresos Anuales'
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


</script>


@endpush