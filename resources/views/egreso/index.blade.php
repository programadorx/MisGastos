@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mis Egresos</h3>
	</div>
</div>

<!-- Comienza modal -->

  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Agregar</a>

  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
		<div class="center-align">
	    	<h4>Nuevo Egreso</h4>
		</div>

		<div class="row">
			{{Form::open(['url'=>'egreso','method'=>'POST','autocomplete'=>'off','id'=>'formadd'])}}
			{{Form::token()}}
	    	<div class="col s12">
	      		
	      		<div class="row">
					<div class="input-field col s6">	        
	          			<input placeholder="Ingrese fecha" id="fecha" name="fecha" type="text" class="datepicker" required>
	          			<label for="fecha">Fecha</label>
	        		</div>
	       			
					<div class="input-field col s6">	        	
		   				 <select name="clasificacion" style="width: 100%" class="misclasi" required>
							<option value="" disabled selected>Seleccione producto</option>
			   				@foreach ($misClasificaciones as $cate)
								<optgroup label="{{$cate[0]->categoria->nombre}}">
									@foreach ($cate as $clasi)
			        				<option value="{{$clasi->id}}">{{$clasi->item->nombre}}</option>
									@endforeach
								</optgroup>
							@endforeach
						</select>			    
	        		</div>
	      		</div>
	      
	      		<div class="row"> 
					<div class="input-field col s4">
						<input id="cantidad" name="cantidad" value="1" type="number" min="1" onChange="calculo(this.value,precio_unitario.value);" required>
						<label for="cantidad">Cantidad</label>
					</div>

					<div class="input-field col s4">
						<input id="precio_unitario" name="precio_unitario" type="number" min="0" step="0.05" onChange="calculo(cantidad.value,this.value);" required>
						<label for="precio_unitario">Precio Unitario</label>
					</div>

					<div class="input-field col s4">
						<input value="0" name="monto" id="monto" type="number" placeholder="Precio Total" readonly>
						<label for="monto">Monto</label>
					</div>
				</div>


				<div class="row">
					<div class="col s12">
						<label for="descripcion">Descripcion (Opcional)</label>
						<textarea id="descripcion" name="descripcion" class="materialize-textarea" maxlength="190"></textarea>
					</div>
				</div>
			</div>

		</div><!--row -->


    </div> <!-- modal conten -->
    <div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
		<button class="waves-effect waves-green btn-flat " type="reset">Borrar</button>
		<button class="btn btn-primary">Agregar</button>
    </div>    
     {{Form::close()}}
  </div> <!-- cierra modal -->

<!-- Termina modal -->

<div class="row">
	<div class="col s12 m12 l12">
		
		<table class="centered bordered highlight">
		<thead>
			<tr>				
				<th>Fecha</th>
				<th>Categoria</th>	
				<th>Item</th>
				<th>Descripcion</th>
				<th>Cantidad</th>
				<th>Precio<br> Unitario</th>
				<th>Total</th>
				<th>Opciones</th>
			</tr>	
		</thead>				
		<tbody>
		@foreach($misEgresos as $egre)	
		<tr>					
			<td>
				{{date('d-m-Y', strtotime($egre->fecha))}}
		    </td>
			<td>
				{{$egre->clasificacion->categoria->nombre}}
			</td>
			<td>
				{{$egre->clasificacion->item->nombre}}
			</td>
			<td>{{$egre->descripcion}}</td>
			<td>{{$egre->cantidad}}</td>
			<td>{{$egre->precio_unitario}}</td>
			<td>{{$egre->monto}}</td>
			<td>
			    {{ Form::open(array('url' => 'egreso/'.$egre->id)) }}
			    {{ Form::hidden("_method", "DELETE") }}							
			    <button  onclick="return confirm('¿esta seguro de eliminar el egreso?');" class="btn-flat waves-effect waves-light" type="submit" name="action">
					<i class="material-icons">close</i>
			    </button>					 
			    {{ Form::close() }}
			</td>				
		</tr>
		@endforeach

		</tbody>
		</table>
		<div class="center-align">
			{{$misEgresos->render()}} 
		</div>

	</div>
</div>

@endsection




@push('scripts')
<script src="{{ asset('js/funcionalidad/egreso.js') }}"></script>
@endpush
