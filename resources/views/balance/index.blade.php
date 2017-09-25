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
<!--balance_total utiliza el chart entre otras cosas -->
<script src="{{ asset('js/funcionalidad/balance_total.js') }}"></script>


@endpush