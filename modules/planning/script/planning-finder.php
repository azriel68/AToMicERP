<?
	/*
	 * Script permettant la découverte de planning viable sur contrainte (par ex)
	 */

	require('../../../inc.php');
	
	$TJourFerie=array('2013-05-01','2013-08-15','2013-07-14',array('2013-07-16 8:00', '2013-07-16 12:00'));
	
	$TJourOuvre=array( 
		1=>array('08:00','12:00','14:00','18:00')
		,2=>array('08:00','12:00','14:00','18:00')
		,3=>array('08:00','12:00')
		,4=>array('08:00','12:00','14:00','18:00')
		,5 =>array('08:00','12:00','14:00','18:00')
	); //dulundi au vendredi

	$TEvenement=array(
		'mathematique'=>array(
				'@person'=>array(
					array(
						'name'=>'Aristid'
						,'unavailable'=>array(
							'2013-07-15'
							,array('2013-07-15 8:00', '2013-07-15 14:00')
					
						)
					)
				)
				,'3h'=>array(
					'duree'=>3
					,'nb'=>10	
				)
				,'1h'=>array(
					'duree'=>1
					,'nb'=>5	
				)
				,'3h30'=>array(
					'duree'=>3.5
					,'nb'=>1	
				)
		
		)
		,'français'=>array(
			'@person'=>array(
				array(
					'name'=>'françoise'
					,'unavailable'=>array(
						'2013-07-15'
						,array('2013-07-18 14:00', '2013-07-18 18:00')
					)
				)
				,array(
					'name'=>'fabien'
					,'unavailable'=>array(
						'2013-07-17'
						,array('2013-07-18 14:00', '2013-07-18 18:00')
					)
				)
			
			)
			,'2h'=>array(
				'duree'=>2
				,'nb'=>20
			)
		)
	
	);


	$t_start_planning = strtotime('2013-07-08');
	$t_end_planning = strtotime('2013-08-30');
	$TPlanning=getEmptyPlanning( $TJourFerie,$TJourOuvre, $t_start_planning, $t_end_planning);
	//pre($TPlanning);
	pre(find_planning($TPlanning, $TEvenement));
	
function find_planning($TPlanning, $TEvenement) {
	
	$TPlanning=array();
	$TEvenement = applyPLanning($TEvenement, $TPlanning);
	
	foreach($TEvenement as $name=>$event){
		print $name;
		pre($event);
		
		$Temp = $TPlanning;
		$THorairePossible = getHorairePossible($event, $TPlanning);
		
		
		
	
	}
	
	
	
	return $TPlanning;
	
}	

function getEmptyPlanning( $TJourFerie,$TJourOuvre, $t_start_planning, $t_end_planning) {

	$t_current = $t_start_planning;
	$TPlanning=array();
	
	while($t_current<=$t_end_planning) {
		
		$day = date('w', $t_current);
		$date = date('Y-m-d', $t_current);
	//	print $date;
		if(isset($TJourOuvre[$day])) {
			
			$day_current = $TJourOuvre[$day];
			$startPM = $endPM = null;
			
			if(count($day_current)==4) {
				list($startAM, $endAM, $startPM, $endPM) = $day_current;
				
			}
			elseif(count($day_current)==2) { 
				list($startAM, $endAM) = $day_current;
			}
			
			$plage = array(
				'start'=>strtotime( $date.' '. $startAM)
				,'end'=>strtotime( $date.' '. $endAM)
				,'date'=>$date
			);			

			if(!inJourFerie($TJourFerie, $plage)) {
				$TPlanning[] = $plage;	
			}
			

			if(!empty($startPM)) {
					$plage = array(
						'start'=>strtotime( $date.' '. $startPM)
						,'end'=>strtotime( $date.' '. $endPM)
						,'date'=>$date
					);			
					if(!inJourFerie($TJourFerie, $plage)) {
						$TPlanning[] = $plage;
						
					}
						
			}
			
		}
				
		$t_current = strtotime('+1 day', $t_current);
		
	}
	
	return $TPlanning;
	
}
function inJourFerie($TJourFerie, $plage) {
	
	foreach($TJourFerie as $jf) {
		if(!is_array($jf)) {
			$jf=array($jf.' 00:00:00', $jf.' 23:59:59');
		}
		
		$startJF = strtotime($jf[0]);
		$endJF = strtotime($jf[1]);
		
		if(($plage['start']>=$startJF && $plage['start']<=$endJF)
		||($plage['end']>=$endJF && $plage['end']<=$endJF)) {
			return true;
		}
		
	}
	
	return false;
	
}
function getHorairePossible($event, $TPlanning) {
	
	
	
}
function applyPLanning($TEvenement, $TPlanning) {
/*
 * Soustrait le planning déjà établis aux éléments restant à plannifier
 */	
	
	return $TEvenement;	
}
