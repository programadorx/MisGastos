@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mis Items</h3>
	</div>
</div> 
	
<div class="row">
	<div class="col s12 m12 l12"> 
			<div class="col s12 m12 l12">
				{{Form::open(['url'=>'item','method'=>'POST','autocomplete'=>'off'])}}
				{{Form::token()}}
				<div class="row">
					<div class="col s2 m2 l2"></div>
					<div class="input-field col s6 m6 l6">
						<input class="validate center-align" type="text" name="nombre" placeholder="Nombre..">	
					</div>				
					<div class="input-field col s4 m4 l4">							
						<button class="btn btn-primary right">Agregar</button>
					</div>	
				{{Form::close()}}
				</div>
			</div>
			<table id="data_table" class="centered bordered highlight">
				<thead>		
					<tr>
						<th>Item o Producto</th>
						<th></th>				
					</tr>					
				</thead>

				<tbody>
					@foreach($misItems as $item)	
					<tr>					
						<td><p>{{$item->nombre}}</p></td>
						<td>				
						    {{ Form::open(array('url' => 'item/'.$item->pivot->id)) }}
						    {{ Form::hidden("_method", "DELETE") }}							
						    <button onclick="return confirm('¿esta seguro?');" class="btn-flat waves-effect waves-light" type="submit" name="action">
								<i class="material-icons">close</i>
						    </button>					 
						    {{ Form::close() }}
						</td>					
					</tr>
					@endforeach
				</tbody>

			</table>

			<!--
			<div class="center-align">
				$misItems->render() 
			</div>		-->
	</div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
	
	$(document).ready(function() {
    	$('#data_table').DataTable({
    		"lengthChange": false,
	        "language": {
	            "lengthMenu": "Mostrar _MENU_ registros por pagina",
	            "zeroRecords": "Sin resultados",
	            "info": "Mostrando Pagina _PAGE_ de _PAGES_",
	            "infoEmpty": "No hay registros",
	            "infoFiltered": "(Filtrado sobre _MAX_ registros totales)",
	            "search": "Buscar..",
                "paginate": {
			      "previous": "Anterior",
			      "next": "Siguiente"
			    }          
        	}
    	});
	} );
</script>

@endpush
