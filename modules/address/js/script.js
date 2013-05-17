function search_city(request, response) {
	$.ajax({
		url: "http://ws.geonames.org/searchJSON",
		dataType: "jsonp",
		data: {
			featureClass: "P",
			style: "full",
			maxRows: 10,
			name_startsWith: request.term
		},
		success: function( data ) {
			response( $.map( data.geonames, function( item ) {
				return {
					label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
					value: item.name,
					data: item
				}
			}));
		}
	});
}

function search_zip(city, country) {
	$.ajax({
		url: "http://ws.geonames.org/postalCodeSearchJSON",
		dataType: "jsonp",
		data: {
			style: "full",
			maxRows: 1,
			placename: city
		},
		success: function( data ) {
			return data.postalCodes[0].postalCode;
		}
	});
}