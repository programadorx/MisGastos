@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mi Clasificacion</h3>
	</div>
</div>
	
<div class="row">
	<div class="col s12 m12 l12">
		
		<table class="centered highlight">			
			@foreach($agrupados as $categoria)
			<thead>
				<tr>	
					{{Form::open(['url'=>'clasificacion','method'=>'POST','autocomplete'=>'off'])}}
					{{Form::token()}}
						
					<th><p>{{$categoria[0]->categoria->nombre}}</p>
						<input type="hidden" name="categoria" value="{{$categoria[0]->categoria_id}}">
					</th>
					<th>
						<div class="row">	
							<div class="input-field col s12 m12 l12">				
							    <select name="item" class="misitems" style="width:100%" required>
						    	<option value="" disabled selected>Agregue item..</option>		     
							     @foreach ($misItems as $item)	
						         <option value="{{$item->idItem}}">{{$item->nombre}}</option>
						         @endforeach
							    </select>	
						    </div>		   			
						</div>	
					</th>
					<th>
						<div class="col s12 m12 l12">
							<button class="btn btn-primary">Agregar</button>
						</div>
					</th>
					{{Form::close()}}
				</tr>
			</thead>
			<tbody>
				@foreach($categoria as $item)
				<tr>									
					<td><p>{{$item->item->nombre}}</p></td>
					<td>
					<a href="{{URL::action('ClasificacionController@destroy',$item->id)}}" onclick="return confirm('¿Seguro?')">
						<i class="material-icons">close</i>
					</a>
					</td>
					<td>				      				
					</td>
					
				</tr>
				@endforeach
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			@endforeach

		</table>


		
		<table class="centered">	
			@foreach($sinClasificacion as $categoria)	
			<thead>
				<tr>	
					{{Form::open(['url'=>'clasificacion','method'=>'POST','autocomplete'=>'off'])}}
					{{Form::token()}}
						
					<th>
						<p>{{$categoria->nombre}} </p>
						<input type="hidden" name="categoria" value="{{$categoria->idCategoria}}">
					</th>
					<th>
						<div class="input-field col s12 m12 l12">						
						    <select name="item" class="misitems" style="width:100%" required>
						    	<option value="" disabled selected>Agregue item..</option>		     
						    	 @foreach ($misItems as $item)	
					        	 <option value="{{$item->idItem}}">{{$item->nombre}}</option>
					       		 @endforeach
						    </select>			   			
						</div>	
					</th>
					<th>
						<div class="col s12 m12 l12">
							<button class="btn btn-primary">Agregar</button>
						</div>
					</th>
					{{Form::close()}}
				</tr>
			</thead>		
			@endforeach
		</table>


	</div>
</div>

@endsection

@push('scripts')
  <script>
	$(document).ready(function() {
	  $(".misitems").select2({
	  	placeholder: '+ items..',
	  	allowClear: true,
	  	maximumInputLength: 80
	  });
	});
  </script>
@endpush