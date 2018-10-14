<?php

function dateForHumans( $date )
{
	Carbon\Carbon::setLocale('ar');
	$date  = Carbon\Carbon::parse( $date );
	return $date->diffForHumans() ;
}

function diffInDays( $start_date , $end_date )
{

	$start  = Carbon\Carbon::parse( $start_date );
	$end  = Carbon\Carbon::parse($end_date);
	return $start->diff($end)->days ;
}

function formatCourseDate( $date)
{
	return Carbon\Carbon::parse(str_replace("-", " ", $date))->format('d/m/Y');
}

function getTimeFromDateTime( $datetime )
{
	return Carbon\Carbon::parse(str_replace("-", " ", $datetime))->format('H:m');
}

function isActiveTap( $route )
{
	if (request()->is('admin-panel/'.$route.'/*') or request()->is('admin-panel/'.$route)) {
		return "m-menu__item--active";
	}else{
		return "" ;
	}
}


function isActiveLi( $route )
{
	if (request()->is($route.'/*') or request()->is($route)) {
		return "activeLi";
	}else{
		return "" ;
	}
}


function adminType( $admin )
{
	if ($admin->isAdmin()) {
		return "ادمن";
	}elseif ($admin->isModerator()) {
		return "مشرف";
	}else{
		return "سوبر ادمن";
	}
}


function dayName ($date )
{
	Carbon\Carbon::setlocale(LC_TIME, 'en');
	return Carbon\Carbon::parse( $date )->formatLocalized('%A');
}

function translateTimePeriod( $time )
{
	return strtr(strtolower($time), array('am' => 'صباحاً' , 'pm' => 'مساءاً') );
}

function getTimePeriod( $time )
{
	return Carbon\Carbon::parse( $time )->format('A');
}

function viewerType( $type )
{
	return strtr(strtolower($type), array('mobile' => 'الهاتف   فقط' , 'web' => ' الكومبيوتر  فقط' , 'both' => ' الهاتف او الكومبيوتر') );
}


function translateAttendanceType( $type )
{
	return strtr($type, array('all' => 'الكل' , 'men' => 'رجال فقط' ,'women' => 'نساء فقط', 'children' => 'اطفال فقط' ) );
}
function translateWeekDays( $day )
{
	return strtr(strtolower($day),
		array('saturday' => 'السبت' , 'sunday' => 'الأحد' ,'monday' => 'الأثنين', 'tuesday' => 'الثلاثاء' , 'wednesday'=> 'الاربعاء' ,
			'thursday' => 'الخميس' ,'friday' => 'الجمعة' ) );
}

function decodeEmoticons($src) {
	$replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
	$result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
	$result = mb_convert_encoding($result, 'utf-8', 'utf-16');
	return $result;
}



function arTOen($string) {
	return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
}

function getIP() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
					return $ip;
				}
			}
		}
	}
}





function property_types()
{
	return ['land' 			=> __('admin.land'),
			'apartment' 	=> __('admin.apartment'),
			'villa' 		=> __('admin.villa'),
			'big_flat' 		=> __('admin.big_flat'),
			'building' 		=> __('admin.building'),
			'small_house' 	=> __('admin.small_house'),
			'rest' 			=> __('admin.rest'),
			'store' 		=> __('admin.store'),
			'farm' 			=> __('admin.farm'),
			'room' 			=> __('admin.room'),
			'office' 		=> __('admin.office'),
			'warehouse' 	=> __('admin.warehouse'),
			'tent' 			=> __('admin.tent'),
			'other' 		=> __('admin.other'),
		];
}


function villa_properties()
{
	return [
		'front_yard' 	=> __('admin.front_yard'),
		'room_numbers' 	=> __('admin.room_numbers'),
		'hall_numbers' 	=> __('admin.hall_numbers'),
		'street_width' 	=> __('admin.street_width'),
		'property_age' 	=> __('admin.property_age'),
		'have_stairs' 	=> __('admin.have_stairs'),
	];

}

function cities()
{
	return ['ryad' => 'ryad' , 'mecca' => 'mecca', 'gedah'=> 'gedah' ];
}

function areas()
{
	return ['mnfoha' => 'mnfoha' , 'yasmin' => 'yasmin', 'wrd'=> 'wrd' ];
}
