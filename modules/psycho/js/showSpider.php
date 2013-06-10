<?php
	
	require('../../../inc.php');
	
	$id_div=__get('container', 'psycho-profile');
	
	
/*	$db=new TPDOdb;
	//Ancienne valeurs et/ou valeurs toute entreprise
	$psycho=new TPsycho;
	$psycho->loadByContact($db, (int)$_REQUEST['id_contact']);
	
	foreach ($TMood as $name => $limits) {
		if(!empty($_REQUEST[$name])) $psycho->{$name} = $_REQUEST[$name];
	}*/
	
?>
$(document).ready(function() {
		var chart;
        chart = new Highcharts.Chart({
            chart: {
                renderTo: '<?=$id_div ?>',
                polar: true,
		        type: 'line',
		        spacingTop:0,
		        spacingBottom:0,
		        spacingLeft:0,
   		        spacingRight:0
				,width:300
				,marginLeft:0
				,marginRight:0
		    },
		    
		    title: {
		    	
		        text: '',
		        x: -80
		    },
		    
		    pane: {
		    	size: '80%'
		    },
		    
		    xAxis: {
		        categories: [<?=$_REQUEST['categories'] ?>],
		        tickmarkPlacement: 'on',
		        lineWidth: 0
		    },
		        
		    yAxis: {
		        gridLineInterpolation: 'polygon',
		        lineWidth: 0,
		        min: 0
		        ,max:5
		    },
		    
		    tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y ;
                }
            },
		    
		    legend: {
		    	enabled:false,
		        align: 'right',
		        verticalAlign: 'top',
		        y: 5,
		        layout: 'vertical'
		    },
		    
		    series: [{
		        name: '<?=$user->name() ?>',
		        data: [<?=$_REQUEST['values'] ?>],
		        pointPlacement: 'on'
		    }]
		    
		     ,credits: {
                enabled: false
             }
		
		});
	
});	