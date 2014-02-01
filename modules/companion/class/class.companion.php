<?php

class TCompanion {
	
	static function hook($className, $pageName, &$TParameters) {
		
		ob_start();
		
		if($className=='Notify' && $pageName=='error') {
			?>
			<script type="text/javascript">
				$(document).ready(function () { showCompanion('sad', "<?=addslashes($TParameters['message'])  ?>"); });
			</script>
			
			<?
		}
		elseif($className=='Notify' && $pageName=='success') {
			?>
			<script type="text/javascript">
				$(document).ready(function () { showCompanion('happy', "<?=addslashes($TParameters['message'])  ?>"); });
			</script>
			
			<?
		}
		elseif($className=='TProduct' && $pageName=='product/product') {
			
			$message=__tr('YouCanAddCustomPriceWithPriceTab');
			
			?>
			<script type="text/javascript">
				$(document).ready(function () { showCompanion('tip', "<?=addslashes($message)  ?>"); });
			</script>
			<?
			
		}
		
	
		return ob_get_clean();	
	}
	
}
