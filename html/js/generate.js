$(function() {
	$.ajax({

		url: 'http://localhost/php/visualize_data.php',
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
	var cap;
	var subcap;
	var somevar;
	var othervar;
	switch(sql_type) {
		case "genre-perc-song":
			cap = "Genre Percentage Overtime";
			subcap = "in Songs";
			somevar = "Genre";
			othervar = "% of Songs";
		break;
		case "genre-perc-artist":
			cap = "Genre Percentage Overtime";
			subcap = "in Artists";
			somevar = "Genre";
			othervar = "% of Artists";
		break;
		case "perc-year-genre-song":
			cap = "Genre Percentage in " + extra;
			subcap = "in Songs";
			somevar = "Genre";
			othervar = "% of Songs";
			extra_data = extra;
		break;
		case "perc-year-genre-artist":
			cap = "Genre Percentage in " + extra;
			subcap = "in Artists";
			somevar = "Genre";
			othervar = "% of Artists";
			extra_data = extra;
		break;
	}
	$.ajax({
		url: 'http://localhost/php/visualize_data.php',
		type: 'GET',
		data: {sql_label: sql_type, extra: extra_data},
		success: function(data) {

			chartData = data;
			var chartProperties = {
				"caption": cap,
				"subCaption": subcap,
				"startingangle": "120",
				"showlabels": "0",
				"showlegend": "1",
				"enablemultislicing": "0",
				"slicingdistance": "15",
				"showpercentvalues": "1",
				"showpercentintooltip": "0",
				"plottooltext": somevar + ": $label "+othervar+": $datavalue",
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
	var cap;
	var subcap;
	var xvar;
	var yvar;
	var extra_data;
	switch(sql_type) {
		case "ot-loudness":
		cap = "Loudness Overtime";
		subcap = "";
		xvar = "Year";
		yvar = "Loudness";
		break;
		case "ot-genre-pop":
		extra_data = extra;
		cap = "Genre Popularity Overtime";
		subcap = "Genre: " + extra_data;
		xvar = "Year";
		yvar = "Hotttnesss (Index)";
		break;
		case "ot-track-count":
		cap = "Total Tracks Overtime";
		subcap = "";
		xvar = "Year";
		yvar = "# of Tracks";
		break;
	}
	$.ajax({
		url: 'http://localhost/php/visualize_data.php',
		type: 'GET',
		data: {sql_label: sql_type, extra: extra_data},
		success: function(data) {

			chartData = data;
			var chartProperties = {
				"caption": cap,
				"subCaption": subcap,
                "xAxisName": xvar,
                "yAxisName": yvar,
                "theme": "zune",
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