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

genres=new Array('Pop_Rock','Reggae','Stage','Blues','Religious','New Age','Rap','Country','Jazz',
	'Vocal','Latin','Avant_Garde','International','Electronic','RnB','Comedy_Spoken','Folk',
	'Easy_Listening','Children','Classical','Holiday');

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

	// Genres
	if(sel=='ot-genre-pop'){
		$('#'+sel).append('<option style="display:none" selected="selected" value="">Select a genre:</option>');

		genres.forEach(function(t) {
			$('#'+sel).append('<option value="'+t+'">'+t+'</option>');
		});
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

function splitDropdown(divId) {
	sel=$('#'+divId).val();

	switch(sel) {
		case "ot-loudness":
		generatearea(sel);
		break;
		case "ot-track-count":
		generatearea(sel);
		break;
		case "ot-genre-pop":
		populateSelect(divId);
		show(divId);
		break;
	}
}

function showRecommendations(divId)
{
	if (window.XMLHttpRequest)
	{
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    		$('#'+divId).html(xmlhttp.responseText);
    	}
    };

    switch(divId) {
    	case "recommend-user":
    	xmlhttp.open("GET","php/recommend_user.php",true);
    	xmlhttp.send();
    	break;

    	case "recommend-song":
    	var song = $('#song').val();

    	if(song == "") {
    		$('#'+divId).html('<b>Please input a song</b>');
    		return;
    	}

    	xmlhttp.open("GET","php/recommend_song.php?song="+song,true);
    	xmlhttp.send();
    	break;

    	case "recommend-artist":
    	var artist = $('#artist').val();

    	if(artist == "") {
    		$('#'+divId).html('<b>Please input an artist</b>');
    		return;
    	}

    	xmlhttp.open("GET","php/recommend_artist.php?artist="+artist,true);
    	xmlhttp.send();
    	break;
    }
}

function showTagged(divId)
{
	if (window.XMLHttpRequest)
	{
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    		$('#'+divId).html(xmlhttp.responseText);
    	}
    };

    switch(divId) {
    	case "tagged-song":
    	var tag = $('#song-search-tag').val();

    	if(tag == "") {
    		$('#'+divId).html('<b>Please input an tag</b>');
    		return;
    	}
    	xmlhttp.open("GET","php/search_tag.php?search=song&tag="+tag,true);
    	xmlhttp.send();
    	break;

    	case "tagged-artist":
    	var tag = $('#artist-tag').val();

    	if(tag == "") {
    		$('#'+divId).html('<b>Please input a tag</b>');
    		return;
    	}

    	xmlhttp.open("GET","php/search_tag.php?search=artist&tag="+tag,true);
    	xmlhttp.send();
    	break;
    }
}

$(function() {
	showRecommendations('recommend-user');

	$.ajax({
		type: "GET",
		url: "http://localhost/php/update_stats.php",
		data: {stat: 'song-stat'},
		success: function(data) { $('#song-stat').html(data);}
	});

	$.ajax({
		type: "GET",
		url: "http://localhost/php/update_stats.php",
		data: {stat: 'artist-stat'},
		success: function(data) { $('#artist-stat').html(data);}
	});

	$.ajax({
		type: "GET",
		url: "http://localhost/php/update_stats.php",
		data: {stat: 'listener-stat'},
		success: function(data) { $('#listener-stat').html(data);}
	});

	$.ajax({
		type: "GET",
		url: "http://localhost/php/update_stats.php",
		data: {stat: 'tag-stat'},
		success: function(data) { $('#tag-stat').html(data);}
	});

});