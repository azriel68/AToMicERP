<?php

class TCompanion {
	
	static function hook($className, $pageName, &$TParameters) {
		
		$action = __val($TParameters['action'], 'none');
		
		ob_start();
		
		if($className=='Notify' && $pageName=='error') {
			$message = $TParameters['message'];
			$mood='sad';
		}
		elseif($className=='Notify' && $pageName=='success') {
			$message = $TParameters['message'];
			$mood='happy';
		}
		else {
			
			if($action=='save') {
				$message=__tr('YourItemIsRegister');
				$mood='welldone';	
			}
			elseif($action=='view') {
				
				$message=TCompanion::tip($className, $pageName);
				if(!empty($message)) $mood='tip';				
			}
		
		}
		
		if(!empty($mood)) {
			?>
			<script type="text/javascript">
				$(document).ready(function () { showCompanion('<?php echo $mood ?>', "<?php echo addslashes($message)  ?>"); });
			</script>
			
			<?
			
		}
	 
	
		return ob_get_clean();	
	}
	static function tip($className, $pageName) {
		$TTip=array(
				'Home'=>array(
					'home'=>array(
						'ThisCentralDashBoard'
					)
				)
				,'TProduct'=>array(
					'product/product'=>array(
						'YouCanAddCustomPriceWithPriceTab'
						,'YouCanAddAnotherPictureWithPictureTab'
						,'TheBasePrice'
					)
				)
		);
		
		
		if(!empty($TTip[$className][$pageName])) {

			foreach($TTip[$className][$pageName] as $tip) {
				
				$cookiename = 'TCompanion_'.$className.'_'.md5($pageName.$tip);
				
				if(!isset($_COOKIE[$cookiename])) {
					
					setcookie($cookiename, $tip,time() + 86400*30);
					
					return __tr($tip);
				}
				
			}		

			
		}
		 
	}

}
