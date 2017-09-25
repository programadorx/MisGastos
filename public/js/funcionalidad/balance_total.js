

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
