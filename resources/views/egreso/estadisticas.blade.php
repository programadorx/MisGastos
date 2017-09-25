@extends ('layout')

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Estadisticas Egresos</h3>
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
				<option value="categoria">Por Categoria</option>
				<option value="producto">Por Producto</option>
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

			<div class="input-field col s12 hide " id="divcate"> <!-- hide Acomodar el 		inpuutttttttttttttttttttttttttttttt -->
				<select name="categoria" id="categoria">
				<option value="" disabled selected>Categoria..</option>
				@foreach ( $catego as $cate)
						<option value="{{$cate->idCategoria}}">{{$cate->nombre}}</option>
				@endforeach
				</select>
				<label>Categoria:</label>
			</div>

			<div class="input-field col s12 hide" id="divclasi">	        	
				<select name="clasificacion" id="clasificacion" class="clasificacion" style="width: 100%">
				<option value="" disabled selected>Seleccione producto</option>
   				@foreach ($misClasificaciones as $cate)
					<optgroup label="{{$cate[0]->categoria->nombre}}">
						@foreach ($cate as $clasi)
        				<option value="{{$clasi->id}}">{{$clasi->item->nombre}}</option>
						@endforeach
					</optgroup>
				@endforeach
				</select>
				<label>Item:</label>			    
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

			<div class="input-field col s12 hide" id="divtipo"> <!-- hide Acomodar el inpuutttttttttttttttttttttttttttttt -->
				<select name="tipoclasi" id="tipoclasi">
				<option value="" disabled selected>Seleccione Tipo</option>
					<option value="todo">Todo</option>
					<option value="evolucion">Evolucion</option>
				</select>
				<label>Tipo:</label>
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

<!--egreso_estadisticas utiliza el chart entre otras cosas -->
<script src="{{ asset('js/funcionalidad/egreso_estadisticas.js') }}"></script>

@endpush

