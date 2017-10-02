@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mis Clasificaciones</h3>
	</div>
</div>
	
<div class="row">
	<div class="col s12 m12 l12">
		@if($agrupados->count()>0)
			<div class="col s12 m12 l12"><i>Categorias que ya poseen items</i></div>
			<hr>
			<ul class="collapsible" data-collapsible="accordion">		
			@foreach($agrupados as $categoria)
				<li>
				<div class="collapsible-header">	
					{{Form::open(['url'=>'clasificacion','method'=>'POST','autocomplete'=>'off','class'=>'col s12 m12 l12'])}}
					{{Form::token()}}

					<div class="input-field col s4 m4 l4">
						<b>{{$categoria[0]->categoria->nombre}}</b>
						<input type="hidden" name="categoria" value="{{$categoria[0]->categoria_id}}">
					</div>				
		
					<div class="input-field col s5 m5 l5">				
					    <select name="item" class="misitems" style="width:100%" required>
				    	<option value="" disabled selected>Agregue item..</option>		     
					     @foreach ($misItems as $item)	
				         <option value="{{$item->idItem}}">{{$item->nombre}}</option>
				         @endforeach
					    </select>	
				    </div>		   			
					<div class="input-field col s3 m3 l3 center-align">
						<button class="btn btn-primary">Agregar</button>
					</div>
					
					{{Form::close()}}
				</div>
				<div class="collapsible-body">				
					@foreach($categoria as $item)
					<div class="row">
						<div class="col s2 m2 l2"></div>												
						<div class="col s6 m6 l6">
							<p>{{$item->item->nombre}}</p>
						</div>
						<div class="col s4 m4 l4">
							<a href="{{URL::action('ClasificacionController@destroy',$item->id)}}" onclick="return confirm('¿Seguro?')">
							<i class="material-icons">close</i>
							</a>
						</div>
					</div>					
					@endforeach					
				</div>
				</li>
			@endforeach
			</ul> 

			<div class="center-align">
				{{$agrupados->render() }}
			</div>		
		@endif

		<br><br>
		@if($sinClasificacion->count()>0)

			<div class="col s12 m12 l12"><i>Categorias sin items asociados</i></div>
			<hr>
			
			<ul>	
				@foreach($sinClasificacion as $categoria)	
				<li>
					<div class="col s12 m12 l12 ">
						{{Form::open(['url'=>'clasificacion','method'=>'POST','autocomplete'=>'off'])}}
						{{Form::token()}}					
						<div class="input-field col s4 m4 l4">
							<b>{{$categoria->nombre}} </b>
							<input type="hidden" name="categoria" value="{{$categoria->idCategoria}}">
						</div>
					
						<div class="input-field col s5 m5 l5">							
						    <select name="item" class="misitems" style="width:100%" required>
						    	<option value="" disabled selected>Agregue item..</option>		     
						    	@foreach ($misItems as $item)	
					        	<option value="{{$item->idItem}}">{{$item->nombre}}</option>
					       		@endforeach
						    </select>			   			
						</div>	

						<div class="input-field col s3 m3 l3 center-align">
							<button class="btn btn-primary">Agregar</button>
						</div>

						{{Form::close()}}
					</div>
				</li>		
				@endforeach
			</ul>
	
		@endif


	</div>
</div>

@endsection

@push('scripts')
  <script>
	$(document).ready(function() {
	  $(".misitems").select2({
	  	placeholder: 'Agregar items..',
	  	allowClear: true,
	  	maximumInputLength: 80
	  });
	   $('.collapsible').collapsible();
	});
  </script>
@endpush