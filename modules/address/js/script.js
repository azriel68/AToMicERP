function search_city(request, response, zipMode) {
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
				
				item.postalCode = 0;
				$.each(item.alternateNames, function(i, altN) {
					if(altN.lang=='post') item.postalCode = altN.name;
					
				});
				
				return {
					label: item.postalCode+', '+item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
					value: (zipMode)? item.postalCode : item.name,
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