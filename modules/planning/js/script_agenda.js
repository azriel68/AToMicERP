$(document).ready(function(){	
	var une_date = new Date();
	var clickDate = "";
	var clickAgendaItem = "";
	/**
	 * Initializes calendar with current year & month
	 * specifies the callbacks for day click & agenda item click events
	 * then returns instance of plugin object
	 */
	var jfcalplugin = $("#mycal").jFrontierCal({
		date: new Date(),
		dayClickCallback: myDayClickHandler,
		agendaClickCallback: myAgendaClickHandler,
		agendaDropCallback: myAgendaDropHandler,
		agendaMouseoverCallback: myAgendaMouseoverHandler,
		applyAgendaTooltipCallback: myApplyTooltip,
		agendaDragStartCallback : myAgendaDragStart,
		agendaDragStopCallback : myAgendaDragStop,
		dragAndDropEnabled: true
	}).data("plugin");
	
	/**
	 * Do something when dragging starts on agenda div
	 */
	function myAgendaDragStart(eventObj,divElm,agendaItem){
		// destroy our qtip tooltip
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}	
	};
	
	/**
	 * Do something when dragging stops on agenda div
	 */
	function myAgendaDragStop(eventObj,divElm,agendaItem){
	};
	
	/**
	 * Custom tooltip - use any tooltip library you want to display the agenda data.
	 * for this example we use qTip - http://craigsworks.com/projects/qtip/
	 *
	 * @param divElm - jquery object for agenda div element
	 * @param agendaItem - javascript object containing agenda data.
	 */
	function myApplyTooltip(divElm,agendaItem){
		// Destroy currrent tooltip if present
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}
		
		var displayData = "";
		
		var title = agendaItem.title;
		var startDate = agendaItem.startDate;
		var endDate = agendaItem.endDate;
		var allDay = agendaItem.allDay;
		var data = agendaItem.data;
		displayData += "<br><b>" + title+ "</b><br><br>";
		if(allDay){
			displayData += "(All day event)<br><br>";
		}else{
			displayData += "<b>Starts:</b> " + startDate + "<br>" + "<b>Ends:</b> " + endDate + "<br><br>";
		}
		for (var propertyName in data) {
			displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
		}
		// use the user specified colors from the agenda item.
		var backgroundColor = agendaItem.displayProp.backgroundColor;
		var foregroundColor = agendaItem.displayProp.foregroundColor;
		var myStyle = {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark" // other style properties are inherited from dark theme		
		};
		if(backgroundColor != null && backgroundColor != ""){
			myStyle["backgroundColor"] = backgroundColor;
		}
		if(foregroundColor != null && foregroundColor != ""){
			myStyle["color"] = foregroundColor;
		}
		// apply tooltip
		divElm.qtip({
			content: displayData,
			position: {
				corner: {
					tooltip: "bottomMiddle",
					target: "topMiddle"			
				},
				adjust: { 
					mouse: true,
					x: 0,
					y: -15
				},
				target: "mouse"
			},
			show: { 
				when: { 
					event: 'mouseover'
				}
			},
			style: myStyle
		});

	};

	/**
	 * Make the day cells roughly 3/4th as tall as they are wide. this makes our calendar wider than it is tall. 
	 */
	jfcalplugin.setAspectRatio("#mycal",0.43);

	/**
	 * Called when user clicks day cell
	 * use reference to plugin object to add agenda item
	 */
	function myDayClickHandler(eventObj){
		// Get the Date of the day that was clicked from the event object
		var date = eventObj.data.calDayDate;
		// store date in our global js variable for access later
		clickDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
		// open our add event dialog
		$('#add-event-form').dialog('open');
	};
	
	/**
	 * Called when user clicks and agenda item
	 * use reference to plugin object to edit agenda item
	 */
	function myAgendaClickHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;		
		// pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		clickAgendaItem = agendaItem;
		$("#display-event-form").dialog('open');
	};
	
	/**
	 * Called when user drops an agenda item into a day cell.
	 */
	function myAgendaDropHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;
		// date agenda item was dropped onto
		var date = eventObj.data.calDayDate;
		// Pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		
		//Update data in database
		$.ajax({
            url: './script/interface.php',
            dataType: "json",
            crossDomain: true,
            data: {
            	put : "update_date_event",
            	json: 1,
                id_event: agendaItem.displayProp.id_event,
                only_date: true,
                TEvent_data: {
                	date: date.getTime()
                }
            }
       });
	};
	
	/**
	 * Called when a user mouses over an agenda item	
	 */
	function myAgendaMouseoverHandler(eventObj){
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		//alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
	};
	/**
	 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
	 */
	$("#dateSelect").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd'
	});
	
	/**
	 * Set datepicker to current date
	 */
	$("#dateSelect").datepicker('setDate', new Date());
	/**
	 * Use reference to plugin object to a specific year/month
	 */
	$("#dateSelect").bind('change', function() {
		var selectedDate = $("#dateSelect").val();
		var dtArray = selectedDate.split("-");
		var year = dtArray[0];
		// jquery datepicker months start at 1 (1=January)		
		var month = dtArray[1];
		// strip any preceeding 0's		
		month = month.replace(/^[0]+/g,"")		
		var day = dtArray[2];
		// plugin uses 0-based months so we subtrac 1
		jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
	});	
	/**
	 * Initialize previous month button
	 */
	$("#BtnPreviousMonth").button();
	$("#BtnPreviousMonth").click(function() {
		jfcalplugin.showPreviousMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		une_date.setMonth(une_date.getMonth()-1);
		_init_data($('#id_planning').val(),une_date);
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
		return false;
	});
	
	
	/*
	 * Initialize action onChange calendar selection
	 */
	$('#BtnSelect_calendar').click(function(){
		$('#id_planning').val($('#select_calendar').val());
		_init_data($('#select_calendar').val(),new Date());
	});
	
	/**
	 * Initialize next month button
	 */
	$("#BtnNextMonth").button();
	$("#BtnNextMonth").click(function() {
		jfcalplugin.showNextMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		une_date.setMonth(une_date.getMonth()+1);
		_init_data($('#id_planning').val(),une_date);
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);		
		return false;
	});

	/**
	 * Initialize add event modal form
	 */
	$("#add-event-form").dialog({
		autoOpen: false,
		width: 400,
		modal: true,
		buttons: {
			'Add Event': function() {
				
				var what = jQuery.trim($("#add-event-form #what").val());
			
				if(what == ""){
					alert("Please enter a short event description into the \"what\" field.");
				}else{
				
					var startDate = $("#add-event-form #startDate").val();
					var startDtArray = startDate.split("-");
					var startYear = startDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var startMonth = startDtArray[1];		
					var startDay = startDtArray[2];
					// strip any preceeding 0's		
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var startHour = jQuery.trim($("#add-event-form #startHour").val());
					var startMin = jQuery.trim($("#add-event-form #startMin").val());
					var startMeridiem = jQuery.trim($("#add-event-form #startMeridiem").val());
					startHour = parseInt(startHour.replace(/^[0]+/g,""));
					if(startMin == "0" || startMin == "00"){
						startMin = 0;
					}else{
						startMin = parseInt(startMin.replace(/^[0]+/g,""));
					}
					if(startMeridiem == "AM" && startHour == 12){
						startHour = 0;
					}else if(startMeridiem == "PM" && startHour < 12){
						startHour = parseInt(startHour) + 12;
					}

					var endDate = $("#add-event-form #endDate").val();
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var endMonth = endDtArray[1];		
					var endDay = endDtArray[2];
					// strip any preceeding 0's		
					endMonth = endMonth.replace(/^[0]+/g,"");

					endDay = endDay.replace(/^[0]+/g,"");
					var endHour = jQuery.trim($("#add-event-form #endHour").val());
					var endMin = jQuery.trim($("#add-event-form #endMin").val());
					var endMeridiem = jQuery.trim($("#add-event-form #endMeridiem").val());
					endHour = parseInt(endHour.replace(/^[0]+/g,""));
					if(endMin == "0" || endMin == "00"){
						endMin = 0;
					}else{
						endMin = parseInt(endMin.replace(/^[0]+/g,""));
					}
					if(endMeridiem == "AM" && endHour == 12){
						endHour = 0;
					}else if(endMeridiem == "PM" && endHour < 12){
						endHour = parseInt(endHour) + 12;
					}
					
					//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

					// Dates use integers
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);
					
					//add event in database
					$.ajax({
			            url: './script/interface.php',
			            dataType: "json",
			            crossDomain: true,
			            data: {
			            	put : "add_event",
			            	json:1,
			                TEvent_data : {
			                	status: $('#add-event-form #status').val(),
			                	label: $('#add-event-form #what').val(),
			                	note: $('#add-event-form #note').val(),
			                	dt_deb: startDateObj.getTime()/1000,
			                	dt_fin: endDateObj.getTime()/1000,
			                	id_planning: 1,
			                	bgcolor: $('#add-event-form #colorBackground').val(),
			                	txtcolor: $('#add-event-form #colorForeground').val()
			                }
			            }
			        })
			        .then(function(res){
			        	// add new event to the calendar
			        	jfcalplugin.addAgendaItem(
							"#mycal",
							what,
							startDateObj,
							endDateObj,
							false,
							{
								fname: "Santa",
								lname: "Claus",
								leadReindeer: "Rudolph",
								myDate: new Date(),
								myNum: 42
							},
							{
								backgroundColor: $("#add-event-form #colorBackground").val(),
								foregroundColor: $("#add-event-form #colorForeground").val(),
								id_event: res
							}
						);
			        });
					
					
					$(this).dialog('close');

				}
				
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		open: function(event, ui){
			// initialize start date picker
			$("#add-event-form #startDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
			// initialize end date picker
			$("#add-event-form #endDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
			// initialize with the date that was clicked
			$("#add-event-form #startDate").val(clickDate);
			$("#add-event-form #endDate").val(clickDate);
			// initialize color pickers
			$("#add-event-form #colorSelectorBackground").ColorPicker({
				color: "#333333",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#add-event-form #colorSelectorBackground div").css("backgroundColor", "#" + hex);
					$("#add-event-form #colorBackground").val("#" + hex);
				}
			});
			//$("#colorBackground").val("#1040b0");		
			$("#add-event-form #colorSelectorForeground").ColorPicker({
				color: "#ffffff",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#add-event-form #colorSelectorForeground div").css("backgroundColor", "#" + hex);
					$("#add-event-form #colorForeground").val("#" + hex);
				}
			});
			//$("#colorForeground").val("#ffffff");				
			// put focus on first form input element
			$("#what").focus();
		},
		close: function() {
			// reset form elements when we close so they are fresh when the dialog is opened again.
			$("#add-event-form #startDate").datepicker("destroy");
			$("#add-event-form #endDate").datepicker("destroy");
			$("#add-event-form #startDate").val("");
			$("#add-event-form #endDate").val("");
			$("#add-event-form #startHour option:eq(0)").attr("selected", "selected");
			$("#add-event-form #startMin option:eq(0)").attr("selected", "selected");
			$("#add-event-form #startMeridiem option:eq(0)").attr("selected", "selected");
			$("#add-event-form #endHour option:eq(0)").attr("selected", "selected");
			$("#add-event-form #endMin option:eq(0)").attr("selected", "selected");
			$("#add-event-form #endMeridiem option:eq(0)").attr("selected", "selected");			
			$("#add-event-form #what").val("");
			$("#add-event-form #note").val("");
			//$("#colorBackground").val("#1040b0");
			//$("#colorForeground").val("#ffffff");
		}
	});
	
	/**
	 * Initialize display event form.
	 */
	$("#display-event-form").dialog({
		autoOpen: false,
		width: 400,
		modal: true,
		buttons: {		
			Cancel: function() {
				$(this).dialog('close');
			},
			'Edit': function() {
				$("#update-event-form").dialog('open');
				$(this).dialog('close');
			},
			'Delete': function() {
				if(confirm("Are you sure you want to delete this agenda item?")){
					if(clickAgendaItem != null){
						//add event in database
						$.ajax({
				            url: './script/interface.php',
				            dataType: "json",
				            crossDomain: true,
				            data: {
				            	put : "del_event",
				            	json:1,
				             	id_event: clickAgendaItem.displayProp.id_event
				            }
				        })
				        .then(jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId));
						//jfcalplugin.deleteAgendaItemByDataAttr("#mycal","myNum",42);
					}
					$(this).dialog('close');
				}
			}			
		},
		open: function(event, ui){
			if(clickAgendaItem != null){
				var title = clickAgendaItem.title;
				var startDate = clickAgendaItem.startDate;
				var endDate = clickAgendaItem.endDate;
				var allDay = clickAgendaItem.allDay;
				var data = clickAgendaItem.data;
				// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
				$("#display-event-form").append(
					"<br><b>" + title+ "</b><br><br>"		
				);				
				if(allDay){
					$("#display-event-form").append(
						"(All day event)<br><br>"				
					);				
				}else{
					$("#display-event-form").append(
						"<b>Starts:</b> " + startDate + "<br>" +
						"<b>Ends:</b> " + endDate + "<br><br>"				
					);				
				}
				for (var propertyName in data) {
					$("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
				}			
			}		
		},
		close: function() {
			// clear agenda data
			$("#display-event-form").html("");
		}
	});	 
	
	
	/**
	 * Initialize update event form.
	 */
	$("#update-event-form").dialog({
		autoOpen: false,
		width: 400,
		modal: true,
		buttons: {		
			Cancel: function() {
				$(this).dialog('close');
			},
			'Save': function() {
				//Traitement du formulaire de modification
				
				var what = jQuery.trim($("#update-event-form #what").val());
			
				if(what == ""){
					alert("Please enter a short event description into the \"what\" field.");
				}else{
				
					var startDate = $("#update-event-form #startDate").val();
					var startDtArray = startDate.split("-");
					var startYear = startDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var startMonth = startDtArray[1];		
					var startDay = startDtArray[2];
					// strip any preceeding 0's		
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var startHour = jQuery.trim($("#update-event-form #startHour").val());
					var startMin = jQuery.trim($("#update-event-form #startMin").val());
					var startMeridiem = jQuery.trim($("#update-event-form #startMeridiem").val());
					startHour = parseInt(startHour.replace(/^[0]+/g,""));
					if(startMin == "0" || startMin == "00"){
						startMin = 0;
					}else{
						startMin = parseInt(startMin.replace(/^[0]+/g,""));
					}
					if(startMeridiem == "AM" && startHour == 12){
						startHour = 0;
					}else if(startMeridiem == "PM" && startHour < 12){
						startHour = parseInt(startHour) + 12;
					}

					var endDate = $("#update-event-form #endDate").val();
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var endMonth = endDtArray[1];		
					var endDay = endDtArray[2];
					// strip any preceeding 0's		
					endMonth = endMonth.replace(/^[0]+/g,"");

					endDay = endDay.replace(/^[0]+/g,"");
					var endHour = jQuery.trim($("#update-event-form #endHour").val());
					var endMin = jQuery.trim($("#update-event-form #endMin").val());
					var endMeridiem = jQuery.trim($("#update-event-form #endMeridiem").val());
					endHour = parseInt(endHour.replace(/^[0]+/g,""));
					if(endMin == "0" || endMin == "00"){
						endMin = 0;
					}else{
						endMin = parseInt(endMin.replace(/^[0]+/g,""));
					}
					if(endMeridiem == "AM" && endHour == 12){
						endHour = 0;
					}else if(endMeridiem == "PM" && endHour < 12){
						endHour = parseInt(endHour) + 12;
					}
					
					//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

					// Dates use integers
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);
					
					jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
					//add event in database
					$.ajax({
			            url: './script/interface.php',
			            dataType: "json",
			            crossDomain: true,
			            data: {
			            	put : "update_event",
			            	json:1,
			            	id_event: clickAgendaItem.displayProp.id_event,
			                TEvent_data : {
			                	status: $('#update-event-form #status').val(),
			                	label: $('#update-event-form #what').val(),
			                	note: $('#update-event-form #note').val(),
			                	dt_deb: startDateObj.getTime()/1000,
			                	dt_fin: endDateObj.getTime()/1000,
			                	id_planning: 1,
			                	bgcolor: $('#update-event-form #colorBackground').val(),
			                	txtcolor: $('#update-event-form #colorForeground').val()
			                }
			            }
			        })
			        .then(function(res){
			        	// add new event to the calendar
			        	jfcalplugin.addAgendaItem(
							"#mycal",
							what,
							startDateObj,
							endDateObj,
							false,
							{
								fname: "Santa",
								lname: "Claus",
								leadReindeer: "Rudolph",
								myDate: new Date(),
								myNum: 42
							},
							{
								backgroundColor: $("#update-event-form #colorBackground").val(),
								foregroundColor: $("#update-event-form #colorForeground").val(),
								id_event: res
							}
						);
			        });
					
					
					$(this).dialog('close');
				
				}
			}
		},
		open: function(event, ui){
			if(clickAgendaItem != null){
				$.ajax({
		            url: './script/interface.php',
		            dataType: "json",
		            crossDomain: true,
		            data: {
		            	get : "get_event",
		            	json:1,
		             	id_event: clickAgendaItem.displayProp.id_event
		            }
		        })
		        .then(function(TEvent_data){
		        	//update html form creation
		        	$('#add-event-form').children().clone().appendTo($('#update-event-form'));
		        	
		        	// initialize start date picker
					$("#update-event-form #startDate").datepicker({
						showOtherMonths: true,
						selectOtherMonths: true,
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						dateFormat: 'yy-mm-dd'
					});
					// initialize end date picker
					$("#update-event-form #endDate").datepicker({
						showOtherMonths: true,
						selectOtherMonths: true,
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						dateFormat: 'yy-mm-dd'
					});
					// initialize with the date that was clicked
					dt_deb = new Date(TEvent_data.dt_deb*1000);
					dt_fin = new Date(TEvent_data.dt_fin*1000);
					$("#update-event-form #startDate").val(dt_deb.getUTCFullYear()+"-"+(dt_deb.getMonth()+1)+"-"+dt_deb.getDate());
					$("#update-event-form #endDate").val(dt_fin.getUTCFullYear()+"-"+(dt_fin.getMonth()+1)+"-"+dt_fin.getDate());
					// initialize color pickers
					$("#update-event-form #colorSelectorBackground").ColorPicker({
						color: TEvent_data.bgcolor,
						onShow: function (colpkr) {
							$(colpkr).css("z-index","10000");
							$(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							$(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							$("#update-event-form #colorSelectorBackground div").css("backgroundColor", "#" + hex);
							$("#update-event-form #colorBackground").val("#" + hex);
						}
					});
							
					$("#update-event-form #colorSelectorForeground").ColorPicker({
						color: TEvent_data.txtcolor,
						onShow: function (colpkr) {
							$(colpkr).css("z-index","10000");
							$(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							$(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							$("#update-event-form #colorSelectorForeground div").css("backgroundColor", "#" + hex);
							$("#update-event-form #colorForeground").val("#" + hex);
						}
					});
					
					$("#update-event-form #colorSelectorBackground").ColorPicker({
						color: TEvent_data.bgcolor,
						onShow: function (colpkr) {
							$(colpkr).css("z-index","10000");
							$(colpkr).fadeIn(500);
							return false;
						},
						onHide: function (colpkr) {
							$(colpkr).fadeOut(500);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							$("#update-event-form #colorSelectorBackground div").css("backgroundColor", "#" + hex);
							$("#update-event-form #colorBackground").val("#" + hex);
						}
					});
					$("#update-event-form #colorSelectorBackground div").css("backgroundColor", TEvent_data.bgcolor);
					$("#update-event-form #colorSelectorForeground div").css("backgroundColor", TEvent_data.txtcolor);
					$("#update-event-form #colorForeground").val(TEvent_data.txtcolor);
					$("#update-event-form #colorBackground").val(TEvent_data.bgcolor);
					$("#update-event-form #what").val(TEvent_data.label);
					$("#update-event-form #note").val(TEvent_data.note);
					$("#update-event-form #status[option]").each(function(i,option){
						if($(this).val() == TEvent_data.status)
							$(this).attr('selected','selected');
					});
					$("#update-event-form #startHour option").each(function(i,option){
						if($(this).val() == dt_deb.getHours() || $(this).val() == dt_deb.getHours() - 12)
							$(this).attr('selected','selected');
					});
					$("#update-event-form #startMin option").each(function(i,option){
						if($(this).val() == dt_deb.getMinutes())
							$(this).attr('selected','selected');
					});
					$("#update-event-form #startMeridiem option").each(function(i,option){
						if(dt_deb.getHours() > 12 && $(this).val() == "PM")
							$(this).attr('selected','selected');
						else if(dt_deb.getHours() <= 12 && $(this).val() == "AM")
							$(this).attr('selected','selected');
					});
					$("#update-event-form #endHour option").each(function(i,option){
						if($(this).val() == dt_fin.getHours() || $(this).val() == dt_fin.getHours() - 12)
							$(this).attr('selected','selected');
					});
					$("#update-event-form #endMin option").each(function(i,option){
						if($(this).val() == dt_fin.getMinutes())
							$(this).attr('selected','selected');
					});
					$("#update-event-form #endMeridiem option").each(function(i,option){
						if(dt_fin.getHours() > 12 && $(this).val() == "PM")
							$(this).attr('selected','selected');
						else if(dt_fin.getHours() <= 12 && $(this).val() == "AM")
							$(this).attr('selected','selected');
					});				
					// put focus on first form input element
					$("#update-event-form #what").focus();
		        	
		        });
			}
		},
		close: function() {
			// clear agenda data
			$(this).dialog('close');
		}
	});
	

	/**
	 * Initialize our tabs
	 */
	$("#tabs").tabs({
		/*
		 * Our calendar is initialized in a closed tab so we need to resize it when the example tab opens.
		 */
		show: function(event, ui){
			if(ui.index == 1){
				jfcalplugin.doResize("#mycal");
			}
		}	
	});
	
	/*
	 * 
	 * Formatage de date façon PHP
	 */
	function dateFormat(format, date) {
		if (date == undefined) {
			date = new Date();
		}
		if (typeof date == 'number') {
			time = new Date();
			time.setTime(date);
			date = time;
		} else if (typeof date == 'string') {
			date = new Date(date);
		}
		var fullYear = date.getYear();
		if (fullYear < 1000) {
			fullYear = fullYear + 1900;
		}
		var hour = date.getHours();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var minute = date.getMinutes();
		var seconde = date.getSeconds();
		var milliSeconde = date.getMilliseconds();
		var reg = new RegExp('(d|m|Y|H|i|s)', 'g');
		var replacement = new Array();
		replacement['d'] = day < 10 ? '0' + day : day;
		replacement['m'] = month < 10 ? '0' + month : month;
		replacement['Y'] = fullYear;
		replacement['Y'] = fullYear;
		replacement['H'] = hour < 10 ? '0' + hour : hour;
		replacement['i'] = minute < 10 ? '0' + minute : minute;
		replacement['s'] = seconde < 10 ? '0' + seconde : seconde;
		return format.replace(reg, function($0) {
			return ($0 in replacement) ? replacement[$0] : $0.slice(1,
					$0.length - 1);
		});
	}
	
	
	/*
	 * Initialize data from database
	 */
	function _init_data(id_planning,une_date){
		$('.JFrontierCal-Day-Cell').empty();
		$.ajax({
            url: './script/interface.php',
            dataType: "json",
            crossDomain: true,
            data: {
            	get : "all_events",
            	json:1,
            	planning: id_planning,
                dt_deb: dateFormat("Y-m-d H:i:s",new Date(une_date.getFullYear(), une_date.getMonth(), 1)),
                dt_fin: dateFormat("Y-m-d H:i:s",new Date(une_date.getFullYear(), une_date.getMonth()+1, 0)),
            }
       })
       .then(function(TEvents_data){
       		$.each( TEvents_data, function ( i, un_event ) {
       			jfcalplugin.addAgendaItem(
					"#mycal",
					un_event.label,
					new Date(un_event.dt_deb*1000),
					new Date(un_event.dt_fin*1000),
					false,
					{
						fname: "Santa",
						lname: "Claus",
						leadReindeer: "Rudolph",
						myExampleDate: new Date()
					},
					{
						backgroundColor: un_event.bgcolor,
						foregroundColor: un_event.txtcolor,
						id_event: i
					}	
				);
       		});
       });
	}
	
	_init_data($('#id_planning').val(),une_date);
});