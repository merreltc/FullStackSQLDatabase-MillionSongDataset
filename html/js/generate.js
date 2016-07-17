$(function() {
	$.ajax({

		url: 'http://localhost/visualizedata.php',
		type: 'GET',
		success: function(data) {

			chartData = data;
			var chartProperties = {
				"caption": "Songs Released By Year",
				"startingangle": "120",
				"showlabels": "0",
				"showlegend": "1",
				"enablemultislicing": "0",
				"slicingdistance": "15",
				"showpercentvalues": "1",
				"showpercentintooltip": "0",
				"plottooltext": "Year: $label Total Songs: $datavalue",
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

function generatepi(sql,extra) {
	var sql_type = sql;
	var extra_data;
	switch(sql_type) {
		case "genre-perc-song":
		break;
		case "genre-perc-artist":
		break;
		case "perc-year-genre-song":
			extra_data = extra;
		break;
		case "perc-year-genre-artist":
			extra_data = extra;
		break;
	}
	$.ajax({
		url: 'http://localhost/visualizedata.php',
		type: 'GET',
		data: {sql_label: sql_type, extra: extra_data},
		success: function(data) {

			chartData = data;
			var chartProperties = {
				"caption": "SQL Query",
				"startingangle": "120",
				"showlabels": "0",
				"showlegend": "1",
				"enablemultislicing": "0",
				"slicingdistance": "15",
				"showpercentvalues": "1",
				"showpercentintooltip": "0",
				"plottooltext": "SomeVariable: $label OtherVariable: $datavalue",
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
}

function generatearea(sql,extra) {
	var sql_type = sql;
	var extra_data;
	switch(sql_type) {
		case "ot-loudness":
		break;
		case "ot-genre-pop":
		break;
		case "ot-track-count":
		break;
	}
	$.ajax({
		url: 'http://localhost/visualizedata.php',
		type: 'GET',
		data: {sql_label: sql_type, extra: extra_data},
		success: function(data) {

			chartData = data;
			var chartProperties = {
                "caption": "SQL Query",
                "subCaption": "SubCaption",
                "xAxisName": "SomeVariable",
                "yAxisName": "OtherVariable",
                "theme": "fint",
                //Setting gradient fill to true
                "usePlotGradientColor": "1",
                //Setting the gradient formation color
                "plotGradientColor": "#1aaf5d"
			};

			apiChart = new FusionCharts({
				type: 'area2d',
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
}