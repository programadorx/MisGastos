@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mis Items</h3>
	</div>
</div>
	
<div class="row">
	<div class="col s12 m12 l12">

			<table class="centered bordered highlight">
			<thead>		
				<tr>		
				{{Form::open(['url'=>'item','method'=>'POST','autocomplete'=>'off'])}}
				{{Form::token()}}
				<th>
					<div class="row">
						<div class="input-field col s12 m12 l12">
							<input class="validate center-align" type="text" name="nombre" placeholder="Nombre..">	
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
				@foreach($misItems as $item)	
				<tr>					
					<td><p>{{$item->nombre}}</p></td>
					<td>						
						<a href="{{URL::action('ItemController@destroy',$item->idItem)}}" onclick="return confirm('¿Seguro?')">
							<i class="material-icons">close</i>
						</a>
					</td>					
				</tr>
				@endforeach
			</tbody>

			</table>
			<div class="center-align">
				{{$misItems->render()}} 
			</div>		
	</div>
</div>
@endsection
