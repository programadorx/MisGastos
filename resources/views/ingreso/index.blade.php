@extends ('layout') 

@section ('contenido')

<div class="row">
	<div class="col s12 m12 l12 center-align">
		<h3>Mis Ingresos</h3>
	</div>
</div>

<!-- Comienza modal -->

  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Agregar</a>

  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
		<div class="center-align">
	    	<h4>Nuevo Ingreso</h4>
		</div>

		<div class="row">
			{{Form::open(['url'=>'ingreso','method'=>'POST','autocomplete'=>'off'])}}
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
		@foreach($misIngresos as $ing)	
		<tr>					
			<td>
				{{date('d-m-Y', strtotime($ing->fecha))}}
		    </td>
			<td>
				{{$ing->clasificacion->categoria->nombre}}
			</td>
			<td>
				{{$ing->clasificacion->item->nombre}}
			</td>
			<td>{{$ing->descripcion}}</td>
			<td>{{$ing->cantidad}}</td>
			<td>{{$ing->precio_unitario}}</td>
			<td>{{$ing->monto}}</td>
			<td>
				<i class="material-icons">edit</i>
				<i class="material-icons">close</i>
				
			</td>				
		</tr>
		@endforeach

		</tbody>
		</table>
		<div class="center-align">
			{{$misIngresos->render()}} 
		</div>

	</div>
</div>
@endsection


@push('scripts')
  <script>
	$(document).ready(function() {


	  $('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 20, // Creates a dropdown of 15 years to control year,
	  //  format: 'dd/mm/yyyy', 
		format: 'yyyy-mm-dd',
	    container: 'body', //Hace que funcione bien, pq le dice q esta contenido en body y no en el modal
	    closeOnSelect: true, // Close upon selecting a date,
	    clear:false,


	  });

	  $(".misclasi").select2({
	  	placeholder: 'Seleccione producto... ',
	  	allowClear: true,
	  	maximumInputLength: 80
	  });


	   $('.modal').modal();

	});


    function calculo(cantidad,precio){
       //	console.log('cantidad es :',cantidad," y unitario ",precio);
     	total=cantidad*precio;
     	//console.log("total es ",total);
     	monto.value=total;
		
    }


    /* 
	el datepicker tiene atributo readonly, para lograr el requerid
	lo soluciono cuando se envia el form
    */
    $('form').submit(function() { 

  	 	if ($('#fecha').val() == '') {

  	 		$('#fecha').attr('readonly', false);
  	 		$('#fecha').attr('required', true);
 	 		return false;
  		} else {
  			return true;
	 	}
	});

  </script>
@endpush