<?php
	use Cake\I18n\FrozenTime;

	if (!isset($format)) {
		$format = 'yyyy-MM-dd, hh:mm:ss aa zzz';
	}
	
	if (!is_null($time)) {
		$outTime = new FrozenTime($time);
		// $outTime->setTimezone = $userPreferences->user_timezone;

		// echo $outTime->format('Y-m-d, g:i:s A T');
		echo $outTime->i18nFormat($format, $userPreferences->user_timezone);
	} else {
		echo "---";
	}
	// echo $outTime->format('U');
?>
