
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
    $('#formadd').submit(function() { 

  	 	if ($('#fecha').val() == '') {

  	 		$('#fecha').attr('readonly', false);
  	 		$('#fecha').attr('required', true);
 	 		return false;
  		} else {
  			return true;
	 	}
	});

