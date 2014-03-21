<?php
	
	require('../../../inc.php');
	
	$id_div=__get('container', 'psycho-profile');
	
	if(!empty($_REQUEST['id_company'])) {
		$db=new TPDOdb;	
			
		$company=new TCompany;
		$company->load($db, $_REQUEST['id_company']);	
		$company_name = $company->name;	
			
		$average = implode(',', TPsycho::getAverageValue($db, $company->id ) );
		
		$db->close();
	}
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
                renderTo: '<?php echo $id_div ?>',
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
		        categories: [<?php echo $_REQUEST['categories'] ?>],
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
		    
		    series: [<?
		    	if(!empty($average)) {
		    		?>
		    		{
				        name: '<?php echo addslashes($company_name) ?>',
				        data: [<?php echo $average ?>],
				        pointPlacement: 'on',
				        color:'#aaa'
				    },
		    		<?
		    	}
		    ?>{
		        name: '<?php echo addslashes($_REQUEST['name_contact']) ?>',
		        data: [<?php echo $_REQUEST['values'] ?>],
		        pointPlacement: 'on'
		    }]
		    
		     ,credits: {
                enabled: false
             }
		
		});
	
});	