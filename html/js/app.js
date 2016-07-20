overtime_criteria=[{
	"id" : "1", 
	"value" : "ot-loudness",
	"label" : "Loudness"
},
{
	"id" : "2", 
	"value" : "ot-genre-pop",
	"label" : "Genre Popularity"
},
{
	"id" : "3", 
	"value" : "ot-track-count",
	"label" : "Track Count"
}];

perc_criteria=[{
	"id" : "1", 
	"value" : "perc-by-year",
	"label" : "By Year",
},
{
	"id" : "2", 
	"value" : "perc-overall",
	"label" : "Overall"
}];

perc_overall=[{
	"id" : "1", 
	"value" : "genre-perc-song",
	"label" : "Song Genre",
},
{
	"id" : "2", 
	"value" : "genre-perc-artist",
	"label" : "Artist Genre"
}];

perc_by_year=[{
	"id" : "1", 
	"value" : "perc-year-genre-song",
	"label" : "Song Genre",
},
{
	"id" : "2", 
	"value" : "perc-year-genre-artist",
	"label" : "Artist Genre"
}];

years=new Array('2010','2009','2008','2007','2006','2005','2004','2003','2002','2001','2000',
	'1999','1998','1997','1996','1995','1994','1993','1992','1991','1990',
	'1989','1988','1987','1986','1985','1984','1983','1982','1981','1980',
	'1979','1978','1977','1976','1975','1974','1973','1972','1971','1970',
	'1969','1968','1967','1966','1965','1964','1963','1962','1961','1960',
	'1959','1958','1957','1956','1955','1954','1953','1952','1951','1950',
	'1949','1948','1947','1946','1945','1944','1943','1942','1941','1940',
	'1939','1938','1937','1936','1935','1934','1933','1932','1931','1930',
	'1929','1928','1927','1926');

function populateSelect(thisId){
	sel=$('#'+thisId).val();
	$('#'+sel).html('');


	if(sel==''){
		return;
	}

	// Loudness, Genre Popularity, Track Count
	if(sel=='overtime-criteria'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select Criteria:</option>');

		// Loop through JSON
		for (var key in overtime_criteria) {
			if (overtime_criteria.hasOwnProperty(key)) {
				$('#'+sel).append('<option value="'+overtime_criteria[key].value+'">'+overtime_criteria[key].label+'</option>');
			}
		}
	}


	// Overall, By Year
	if(sel=='perc-criteria'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Overall or By Year:</option>');

		// Loop through JSON
		for (var key in perc_criteria) {
			if (perc_criteria.hasOwnProperty(key)) {
				$('#'+sel).append('<option value="'+perc_criteria[key].value+'">'+perc_criteria[key].label+'</option>');
			}
		}
	}

	// Song Genre, Artist Genre
	if(sel=='perc-overall'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select Criteria:</option>');

		// Loop through JSON
		for (var key in perc_overall) {
			if (perc_overall.hasOwnProperty(key)) {
				$('#'+sel).append('<option value="'+perc_overall[key].value+'">'+perc_overall[key].label+'</option>');
			}
		}
	}

	// Song Genre, Artist Genre
	if(sel=='perc-by-year'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select Criteria:</option>');

		// Loop through JSON
		for (var key in perc_by_year) {
			if (perc_by_year.hasOwnProperty(key)) {
				$('#'+sel).append('<option value="'+perc_by_year[key].value+'">'+perc_by_year[key].label+'</option>');
			}
		}
	}


	// Years
	if(sel=='perc-year-genre-artist'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select a year:</option>');

		years.forEach(function(t) {
			$('#'+sel).append('<option value="'+t+'">'+t+'</option>');
		});
	}
	// Years
	if(sel=='perc-year-genre-song'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select a year:</option>');

		years.forEach(function(t) {
			$('#'+sel).append('<option value="'+t+'">'+t+'</option>');
		});
	}

}

function hide(divId)
{
	if(divId == "") {
		return;
	}
	if($('#'+divId).is(":visible")) {
		$("#"+divId).prop("disabled", false);
		$("#"+divId).hide();
	}
}

function show(divId)
{

	var newDiv = $('#'+divId).val();

	if(newDiv == "") {
		return;
	}

	if($('#'+newDiv).is(":hidden")) {
		$("#"+newDiv).show();
	}

	$("#"+divId).prop("disabled", true);
}