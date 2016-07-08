$(function() {
	$.ajax({

		url: 'http://localhost/visualizedata.php',
		type: 'GET',
		success: function(data) {

			chartData = data;
			var chartProperties = {
				"caption": "User Demographics: Gender",
				"startingangle": "120",
				"showlabels": "0",
				"showlegend": "1",
				"enablemultislicing": "0",
				"slicingdistance": "15",
				"showpercentvalues": "1",
				"showpercentintooltip": "0",
				"plottooltext": "Age group : $label Total visit : $datavalue",
				"theme": "zune"
			};

			apiChart = new FusionCharts({
				type: 'pie3d',
				renderAt: 'visual-container',
				width: '750',
				height: '750',
				dataFormat: 'json',
				dataSource: {
					"chart": chartProperties,
					"data": chartData
				}
			});
			apiChart.render();
		}
	});
});
