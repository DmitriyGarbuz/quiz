<?php

function iniGa($KEY_FILE_LOCATION,$stat1,$stat2,$alsee) {		
	
	require_once APPPATH.'ThirdParty/googleapiclient/vendor/autoload.php';
	$analytics = initializeAnalytics($KEY_FILE_LOCATION);
	$profile = getFirstProfileId($analytics);
	
	if (!is_object($profile)) {
		if ($alsee==1) {
			$data = array ('status' => 'alsee', 'text' => $stat1, 'text1' => $stat2);
			return $data;
		} else {
			$data = array ('status' => 'ok', 'text' => 'cool', 'alsee' =>1);
			return $data;
		}
	} else {
		$profile = (array)$profile;
		$data = array ('status' => 'error', 'text' => 'Error: '.$profile["\0*\0".'message']);
		return $data;
	}
	
}

function initializeAnalytics($KEY_FILE_LOCATION) {
	
	$client = new Google_Client();
	$client->setApplicationName("Hello Analytics Reporting");
	$client->setAuthConfig($KEY_FILE_LOCATION);
	$client->setScopes('https://www.googleapis.com/auth/analytics.readonly');
	$analytics = new Google_Service_Analytics($client);
	return $analytics;
}

function getFirstProfileId($analytics) {
	
	$accounts = $analytics->management_accounts->listManagementAccounts();
	if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
		$firstAccountId = $items[0]->getId();
		$properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
		if (count($properties->getItems()) > 0) {
			$items = $properties->getItems();
			$firstPropertyId = $items[0]->getId();
			$profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);
			if (count($profiles->getItems()) > 0) {
				$items = $profiles->getItems();
				return $items[0]->getId();
			} else {
				return new Exception('No views (profiles) found for this user.');
			}
		} else {
			return new Exception('No properties found for this user.');
		}
	} else {
		return new Exception('No accounts found for this user.');
	}
}

function getSvgGraph($KEY_FILE_LOCATION,$date1, $date2) {
	
	require_once APPPATH.'ThirdParty/googleapiclient/vendor/autoload.php';
	$analytics = initializeAnalytics($KEY_FILE_LOCATION);
	$profile = getFirstProfileId($analytics);
	$results_byusers = getResults_byusers($analytics, $profile, $date1, $date2);
	$allcount = count($results_byusers);
	$max = 1;
	foreach ($results_byusers as $one):
		if ($one[1]>$max) { $max=$one[1]; }
	endforeach;
	$string = '';
	$y=$max;
	$coef = 400/$max;
	$width = $_POST['width']-32;
	$string = $string.'
	<div class="home--stat--graph--div">';
	$string = $string.'<div style="position:absolute; left:29px;">';
	for ($i=0;$i<6;$i++) {
		if ($i!=5) {
			$string = $string.'<div style="position:absolute; left:-26px; top:'.((400/5)*$i).'px">'.round($max-($max/5)*$i).'</div>';
		}
	}
	$string = $string.'</div>';
	$string = $string.'<svg width="'.($_POST['width']-32).'px" height="406px">';
	$string = $string.'<polygon points="';
	$x=0;$i=0;
	$firstpoint=0;
	foreach ($results_byusers as $one): 
		$string = $string.$x.','.round(($y-$one[1])*$coef+6).' ';
		if ($i==0) {
			$firstpoint = $x.','.round(($y-$one[1])*$coef+6).' ';
		}
		$x=$x+round($width/($allcount-1));
		$i++;
	endforeach; 
	$string = $string.$x.','.($y*$coef+6).' 0,'.($y*$coef+6).' '.$firstpoint.'" class="polyclass"  />';
	$string = $string.'<line x1="0" y1="0" x2="0" y2="406" stroke-width="2" class="lineclass" />';
	$x=0;
	foreach ($results_byusers as $one): 
		$datesee = substr($one[0],4);
		$datesee = substr($datesee,0,2).'/'.substr($datesee,2);
		$string = $string.'<circle id="circleinfo" info="'.Date_.': '.$datesee.'. '.Visits.': '.$one[1].'." cx="'.$x.'" cy="'.round(($y-$one[1])*$coef+6).'" r="4.5" class="circleclass" stroke="none" stroke-width="2" ></circle>';
		$x=$x+round($width/($allcount-1));
	endforeach;
	$string = $string.'</svg>';
	$string = $string.'<div class="stat--graph--dates" style="width:'.($_POST['width']-32).'px; margin: 0 auto;">';
	$o=0;
	foreach ($results_byusers as $one): 
		$string = $string.'<div style="';
		if ($o==0) { $string = $string.'justify-content: left !important;  flex-grow: 1; flex-shrink: 1; '; }
		if ($o==count($results_byusers)-1) { $string = $string.'justify-content: right !important; flex-grow: 1; flex-shrink: 1; '; }
		if (($o!=count($results_byusers)-1)AND($o!=0)) { $string = $string.'justify-content: center !important; flex-basis:'.(100/(count($results_byusers)-1)).'%;'; }
		$string = $string.' position:relative; ">';
		$datesee = substr($one[0],4);
		$string = $string.substr($datesee,0,2).'/'.substr($datesee,2);
		$string = $string.'</div>';
		$o++;
	endforeach;
	$string = $string.'</div></div>';
	return $string;
		
}

function getResults_byusers($analytics, $profileId, $date1, $date2) {
	
	return $analytics->data_ga->get(
	   'ga:' . $profileId,
	   date('Y-m-d',$date1), 
		date('Y-m-d',$date2), 
		'ga:sessions',
		array('dimensions' => 'ga:date'),
		array('sort' => 'ga:date'),
		array('max-results' => '100')
	);
}

function getResults($analytics, $profileId,$optParams,$metrics, $date1, $date2) {
	
	return $analytics->data_ga->get(
	'ga:' . $profileId,
	date('Y-m-d',$date1), 
	date('Y-m-d',$date2), 
	$metrics,
	$optParams);
	
}
	
function changeGraphStatView($KEY_FILE_LOCATION,$stattype,$date1,$date2) {
	
	require_once APPPATH.'ThirdParty/googleapiclient/vendor/autoload.php';
	$analytics = initializeAnalytics($KEY_FILE_LOCATION);
	$profile = getFirstProfileId($analytics);
	
	if ($stattype==0) {
		$optParams = array(
			'dimensions' => 'ga:source,ga:keyword',
			'sort' => '-ga:sessions,ga:source',
			'max-results' => '300'
		);
		$results = getResults($analytics, $profile,$optParams,'ga:sessions', $date1, $date2);
	}
	if ($stattype==1) {
		$optParams = array(
			'dimensions' => 'ga:pagePath',
			'sort' => '-ga:pageviews',
			'max-results' => '300');
		$results = getResults($analytics, $profile,$optParams,'ga:pageviews', $date1, $date2);
	}
	if ($stattype==2) {
		$optParams = array(
			'dimensions' => 'ga:region,ga:country',
			'sort' => '-ga:sessions',
			'max-results' => '300');
		$results = getResults($analytics, $profile,$optParams,'ga:sessions', $date1, $date2);
	}
	if ($stattype==3) {
		$optParams = array(
			'dimensions' => 'ga:browser,ga:screenResolution',
			'sort' => '-ga:sessions',
			'max-results' => '300');
		$results = getResults($analytics, $profile,$optParams,'ga:sessions', $date1, $date2);
	}
	if ($stattype==4) {
		$optParams = array(
			'dimensions' => 'ga:deviceCategory',
			'sort' => '-ga:sessions',
			'max-results' => '300');
		$results = getResults($analytics, $profile,$optParams,'ga:sessions,ga:avgSessionDuration', $date1, $date2);
	}
		
	$string = '';
	if ($stattype==0) { 
		$string = $string.'<table class="all--width--list">
		<tr class="table--title">
			<td style="text-align:left; width:40%;">
				'.StatInfo1.'
			</td>
			<td style="text-align:left; width:40%;">
				'.StatInfo2.'
			</td>
			<td style="text-align:center; width:10%;">
				'.StatInfo3.'
			</td>
		</tr>';
		$rownum=0; 
		foreach ($results as $one): 
		$string = $string.'<tr class="table--row'.$rownum.'">
			<td style="text-align:left; width:40%;">
				'.$one[0].'
			</td>
			<td style="text-align:left; width:40%;">
				'.$one[1].'
			</td>
			<td style="text-align:center; width:10%;">
				'.$one[2].'
			</td>
		</tr>';
		$rownum++; if ($rownum==2) { $rownum=0; } 
		endforeach; 
	$string = $string.'</table>';
	} 
	if ($stattype==1) { 
	$string = $string.'<table class="all--width--list">
		<tr class="table--title">
			<td style="text-align:left; width:90%;">
				'.StatInfo4.'
			</td>
			<td style="text-align:center; width:10%;">
				'.StatInfo5.'
			</td>
		</tr>';
		$rownum=0; 
		foreach ($results as $one): 
		$string = $string.'<tr class="table--row'.$rownum.'">
			<td style="text-align:left; width:90%;">
				'.$one[0].'
			</td>
			<td style="text-align:center; width:10%;">
				'.$one[1].'
			</td>
		</tr>';
		$rownum++; if ($rownum==2) { $rownum=0; } 
		endforeach; 
	$string = $string.'</table>';
	} 
	if ($stattype==2) {
	$string = $string.'<table class="all--width--list"  style="margin-top:20px;">
		<tr class="table--title">
			<td style="text-align:left; width:45%;">
				'.StatInfo6.'
			</td>
			<td style="text-align:left; width:45%;">
				'.StatInfo7.'
			</td>
			<td style="text-align:center; width:10%;">
				'.StatInfo3.'
			</td>
		</tr>';
		$rownum=0; 
		foreach ($results as $one): 
		$string = $string.'<tr class="table--row'.$rownum.'">
			<td style="text-align:left; width:45%;">
				'.$one[0].'
			<td style="text-align:left; width:45%;">
				'.$one[1].'
			</td>
			<td style="text-align:center; width:10%;">
				'.$one[2].'
			</td>
		</tr>';
		$rownum++; if ($rownum==2) { $rownum=0; } 
		endforeach; 
	$string = $string.'</table>';
	}
	if ($stattype==3) {
	$string = $string.'<table class="all--width--list"  style="margin-top:20px;">
		<tr class="table--title">
			<td style="text-align:left; width:45%;">
				'.StatInfo8.'
			</td>
			<td style="text-align:left; width:45%;">
				'.StatInfo9.'
			</td>
			<td style="text-align:center; width:10%;">
				'.StatInfo3.'
			</td>
		</tr>';
		$rownum=0; 
		foreach ($results as $one): 
		$string = $string.'<tr class="table--row'.$rownum.'">
			<td style="text-align:left; width:45%;">
				'.$one[0].'
			<td style="text-align:left; width:45%;">
				'.$one[1].'
			</td>
			<td style="text-align:center; width:10%;">
				'.$one[2].'
			</td>
		</tr>';
		$rownum++; if ($rownum==2) { $rownum=0; } 
		endforeach; 
	$string = $string.'</table>';
	}
	if ($stattype==4) {
	$string = $string.'<table class="all--width--list"  style="margin-top:20px;">
		<tr class="table--title">
			<td style="text-align:left; width:45%;">
				'.StatInfo10.'
			</td>
			<td style="text-align:left; width:45%;">
				'.StatInfo3.'
			</td>
			<td style="text-align:center; width:10%;">
				'.StatInfo11.'
			</td>
		</tr>';
		$rownum=0; 
		foreach ($results as $one): 
		$string = $string.'<tr class="table--row'.$rownum.'">
			<td style="text-align:left; width:45%;">
				'.$one[0].'
			<td style="text-align:left; width:45%;">
				'.$one[1].'
			</td>
			<td style="text-align:center; width:10%;">
				'.number_format($one[2],2,'.','').'
			</td>
		</tr>';
		$rownum++; if ($rownum==2) { $rownum=0; } 
		endforeach; 
	$string = $string.'</table>';
	}
	
	return $string;
	
}
	

	
	