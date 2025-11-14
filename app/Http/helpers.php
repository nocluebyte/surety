<?php

use Carbon\Carbon;
use App\Models\{Country, Setting, Store};
use App\Models\{Employee, Year, Payment, Journal, Receipt, Quotation,Floor,Planning};
use App\Models\{State, InsuranceCompanies, Agent, Broker, UnderWriter, Principle, Beneficiary, TypeOfEntity, EstablishmentType, Proposal, RelationshipManager};
use Carbon\CarbonPeriod;

/**
 *
 * @param type $change_dropdown
 * @param type $replace_dropdown
 * @param type $url
 * @param type $empty
 * @return string
 */
if (!function_exists('ajax_fill_dropdown')) {
    function ajax_fill_dropdown($change_dropdown, $replace_dropdown, $url, $empty = [], $first_remove = null)
    {
        $html = '<script type="text/javascript">';

        $html .= 'jQuery(document).ready(function($) {';
        $html .= 'jQuery("select[name=\'' . $change_dropdown . '\']").change(function(e){';
        $html .= 'addLoadSpiner(jQuery("select[name=\'' . $replace_dropdown . '\']"));';
        $html .= 'jQuery.ajax({';
        $html .= 'type: "POST",';
        $html .= 'url: "' . $url . '",';
        $html .= 'dataType:"json",';
        $html .= 'data: jQuery(this).parents("form").find("input,select[name=\'' . $change_dropdown . '\']").serialize(),';
        $html .= 'success:function(data){';
        if (empty($first_remove)) {
            $html .= '    jQuery("select[name=\'' . $replace_dropdown . '\']").find("option:not(:first)").remove();';
        } else {
            $html .= '    jQuery("select[name=\'' . $replace_dropdown . '\']").find("option").remove();';
        }
        if (!empty($empty)) {
            foreach ($empty as $key => $emt) {
                $html .= '    jQuery("select[name=\'' . $emt . '\']").find("option:not(:first)").remove();';
            }
        }
        $html .= '    jQuery.each(data, function(key,value){';
        $html .= '        jQuery("select[name=\'' . $replace_dropdown . '\']").append(\'<option value="\'+key+\'">\'+value+\'</option>\');';
        $html .= '});';
        $html .= 'hideLoadSpinner(jQuery("select[name=\'' . $replace_dropdown . '\']"));';
        $html .= '}';
        $html .= '});';
        $html .= '});';
        $html .= '});';
        $html .= '</script>';
        return $html;
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

/**
 *
 * @param type $type
 * @param type $base64
 * @param type $alt
 * @param array $attributes
 * @return type
 */
if (!function_exists('imgBase64')) {
    function imgBase64($type, $base64, $alt = null, $attributes = [])
    {
        $attributes['alt'] = $alt;
        $attrib = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $attrib .= ' ' . $key . '="' . $value . '"';
            }
        }
        return '<img src="' . $type . ';base64,' . $base64 . '"' . $attrib . '>';
    }
}

/**
 *
 * @param type $code
 * @param type $density
 * @param type $top_txt
 * @param type $is_bottom_code
 * @return type
 */

/*
 * @author  Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author  Simon Franz
 * @author  Deadfish
 * @author  SK83RJOSH
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link      http://kevin.vanzonneveld.net/
 *
 * @param mixed   $in     String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
    $out = '';
    //$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $index = 'm7t5xmkoa6yjr5phn2i29xb47a60vp8lk4xd';
    $base = strlen($index);

    if ($pass_key !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID

        for ($n = 0; $n < strlen($index); $n++) {
            $i[] = substr($index, $n, 1);
        }

        $pass_hash = hash('sha256', $pass_key);
        $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

        for ($n = 0; $n < strlen($index); $n++) {
            $p[] = substr($pass_hash, $n, 1);
        }

        array_multisort($p, SORT_DESC, $i);
        $index = implode($i);
    }

    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $len = strlen($in) - 1;

        for ($t = $len; $t >= 0; $t--) {
            $bcp = pow($base, $len - $t);
            $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
        }

        if (is_numeric($pad_up)) {
            $pad_up--;

            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
    } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;

            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }

        for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
            $bcp = pow($base, $t);
            $a = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in = $in - ($a * $bcp);
        }
    }

    return $out;
}
if (!function_exists('timetoseconds')) {
    function timetoseconds($str_time)
    {
        $time = Carbon::createFromFormat('H:i', $str_time);
        $time_seconds = $time->secondsSinceMidnight();
        return $time_seconds;
        //$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hour;
    }
}
// function format_amount($value, $precision = null)
// {
//     setlocale(LC_MONETARY, 'en_IN');
//     if (is_null($precision)) {
//         $precision = 0;
//     }
//     if (!empty($value)) {
//         return money_format('%!i', round(trim($value), $precision));
//     }
//     return number_format(0, $precision);
// }
function format_amount($value, $precision = null)
{
    setlocale(LC_MONETARY, 'en_IN');
    if (is_null($precision)) {
        $precision = '0';
    } else if ($precision == 1) {
        $precision = '0.0';
    } else if ($precision == 2) {
        $precision = '0.00';
    } else if ($precision == 3) {
        $precision = '0.000';
    } else {
        $precision = '0';
    }
    if (!empty($value)) {
        $fmt = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);
        $fmt->setPattern("#,##,##".$precision);
        return $fmt->format($value);
    }
    return number_format(0, $precision);
}

if (!function_exists('money_format')) {
    function money_format($str,$value, $precision = 2)
    {
        return number_format($value,$precision);
    }
}

if (!function_exists('CheckHoursDiff')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function CheckHoursDiff($created_at, $status = null)
    {
        $user = Sentinel::getUser();
        if (Carbon::now()->diffInHours($created_at) < Config::get('srtpl.settings.edit_past_entry_time', 12) || $user->hasAnyAccess(['settings.allow_past_entry_edit', 'users.superadmin'])) {
            return true;
        }
        if ($status == "Pending") {
            return true;
        }
        return false;
    }
}
function compareFloatNumbers($float1, $float2, $operator = '=')
{
    // Check numbers to 5 digits of precision
    $epsilon = 0.00001;
    $float1 = (float) $float1;
    $float2 = (float) $float2;
    $operator = trim($operator);
    switch ($operator) {
            // equal
        case '=':
        case 'eq': {
                if (abs($float1 - $float2) < $epsilon) {
                    return true;
                }
                break;
            }
            // less than
        case '<':
        case 'lt': {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                } else {
                    if ($float1 < $float2) {
                        return true;
                    }
                }
                break;
            }
            // less than or equal
        case '<=':
        case 'lte': {
                if (compareFloatNumbers($float1, $float2, '<') || compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
            // greater than
        case '>':
        case 'gt': {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                } else {
                    if ($float1 > $float2) {
                        return true;
                    }
                }
                break;
            }
            // greater than or equal
        case '>=':
        case 'gte': {
                if (compareFloatNumbers($float1, $float2, '>') || compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
        case '<>':
        case '!=':
        case 'ne': {
                if (abs($float1 - $float2) > $epsilon) {
                    return true;
                }
                break;
            }
        default: {
                die("Unknown operator '" . $operator . "' in compareFloatNumbers()");
            }
    }
    return false;
}
if (!function_exists('emptyMethod')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function emptyMethod($created_at)
    {
        return true;
    }
}
if (!function_exists('calculateDays')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function calculateDays($data)
    {
        $attendance_types = config('srtpl.attendance_types');
        $days = ['H' => 0, 'P' => 0, 'A' => 0, 'L' => 0, 'HP' => 0];
        $dataArr = json_decode($data, true);
        if ($dataArr && is_array($dataArr) && count($dataArr)) {
            foreach ($dataArr as $key => $value) {
                if (!isset($attendance_types[$value])) continue;
                $days['H'] += $attendance_types[$value]['H'];
                $days['P'] += $attendance_types[$value]['P'];
                $days['A'] += $attendance_types[$value]['A'];
                $days['L'] += $attendance_types[$value]['L'];
                if ($value == "HP") {
                    $days['HP'] += 1;
                }
            }
        }
        return $days;;
    }
}
if (!function_exists('calculateWeekOff')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function calculateWeekOff($month,$year,$day = 'Wednesday')
    {
        $months = $month;  
        $years=$year;                                      
        $monthName = date("F", mktime(0, 0, 0, $months));
        $fromdt = date('Y-m-01 ',strtotime("First Day Of  $monthName $years"));
        $todt = date('Y-m-d ',strtotime("Last Day of $monthName $years"));

        $num_weekoff= 0;                
        for ($i = 0; $i < ((strtotime($todt) - strtotime($fromdt)) / 86400); $i++)
        {
            if(date('l',strtotime($fromdt) + ($i * 86400)) == $day)
            {
                    $num_weekoff++;
            }    
        }
        return $num_weekoff;;
    }
}
function convertToIndianCurrency($number = 0)
{
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore','Arab', 'Kharab', 'Nil', 'Padma', 'shankh');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str[] = null;
        }
    }
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And " . ($words[$decimal - $decimal % 10]) . " " . ($words[$decimal % 10]) . " Paise"  : '';
    if($paise == "And Hundred  Paise") {
        $paise = "";
    }
    return ($Rupees ? $Rupees . " Rupees " : '') . $paise . " Only";
}
if (!function_exists('timeToFloat')) {
    function timeToFloat($str_time = '', $working_hours = 8)
    {
        $time = Carbon::createFromFormat('H:i', $str_time);
        $timeToFloat = $time->hour + round($time->minute / 60, 2);
        $work_hours = round(($timeToFloat / $working_hours), 2);
        if ($work_hours && $work_hours <= 0.25) {
            $work_hours = 0.25;
        } else {
            $work_hours = round($work_hours * 2) / 2;
        }
        return $work_hours;
    }
    function statusHelper($status = 'default')
    {
        switch ($status) {
            case 'success':
                $result = '<i class="color-success fa fa-check-circle" aria-hidden="true"></i>';
                return $result;
                break;
            case 'default':
                $result = '<i class="color-default fa fa-meh-o" aria-hidden="true"></i>';
                return $result;
                break;
            case 'notice':
                $result = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                return $result;
                break;
            case 'error':
                $result = '<i class="color-error fa fa-exclamation-circle" aria-hidden="true"></i>';
                return $result;
                break;
            case 'info':
                $result = '<i class="color-info fa fa-info-circle" aria-hidden="true"></i>';
                return $result;
                break;
            default:
                $result = '<i class="color-success fa fa-smile-o" aria-hidden="true"></i>';
                return $result;
                break;
        }
    }
}
/*
https://www.php.net/manual/en/function.money-format.php
This is an implementation of the function money_format for the platforms that do not it bear.
This function accepts to same string of format accepts for the original function of the PHP.
*/
/*
if (!function_exists('money_format')) {
    function money_format($format, $number)
    {
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
                  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                               $match[1] : ' ',
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                               $match[0] : '+',
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value  *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                            ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                            $csuffix;
            } else {
                $currency = '';
            }
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                     $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                         STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }
}
*/

/*
* Country Array to HTML Select List
* Developed By: Jose Philip Raja - www.josephilipraja.com
* About Author: Creative Director of CreaveLabs IT Solutions - www.creavelabs.com
*
* Usage:
*   echo countrySelector(); // Basic
*   echo countrySelector("IN"); // Set default Country with its code
*   echo countrySelector("IN", "my-country", "my-country", "form-control"); // With full Options
*
*/
function countrySelector($defaultCountry = "", $id = "", $name = "", $classes = "")
{
    // $countryArray = config('project.country_codes');
    $countries = Country::select('id','country','code','phone_code')->get();
    $output = "<select id='".$id."' name='".$name."' class='".$classes."'>";
    $output .= "<option value=''>Select Country</option>";
    foreach($countries as $country){
        $countryName = ucwords(strtolower($country->country)); // Making it look good
        // $country->code." - ".
        $output .= "<option value='".$country->id."' ".(($country->id == $defaultCountry) ? "selected" : "").">".$countryName." (+".$country->phone_code.")</option>";
    }
    $output .= "</select>";
    return $output; // or echo $output; to print directly
}

if (!function_exists('getStatusHtml')) {
    function getStatusHtml($row, $is_disabled = "", $permission = null, $field = "is_active", $value = "Yes")
    {
        $user = Sentinel::getUser();
        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->$field == $value ? "Active" : "Inactive";
        }

        $statusHtml = "";
        $url = route('common.change-status', [$row->id]);
        $table =  $row->getTable();
        $checked = ''; 
        if (strtoupper($row->$field) == strtoupper($value) && $row->$field !== NULL) {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" '.$checked.' '.$is_disabled.'>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

if(!function_exists('getInactiveStatus')) {
    function getInactiveStatus($row = null, $value = null, $id = null, $table_name = null, $is_disabled = "", $permission = null, $field = "is_active")
    {
        $user = Sentinel::getUser();
        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $value == 'Yes' ? "Active" : "Inactive";
        }

        $row_id = isset($row) ? $row->id : $id;

        $statusHtml = "";
        $url = route('common.change-inactive-status', [$row_id]);
        $table = isset($row) ? $row->getTable() : $table_name;
        $checked = ''; 
        // dd(isset($row) , strtoupper($row->$field) == 'YES' , $row->$field !== NULL, $row->$field);
        if (isset($row) && strtoupper($row->$field) == 'YES' && $row->$field !== NULL) {
            $checked = "checked";
        }
        if($value == 'Yes') {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-inactive-status" id="status_' . $row_id . '" name="status_' . $row_id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row_id . '" '.$checked.' '.$is_disabled.'>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

if (!function_exists('getDisplayHtml')) {
    function getDisplayHtml($row, $permission = null)
    {
        $user = Sentinel::getUser();

        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->is_displayed == "Yes" ? "Active" : "Inactive";
        }

        $statusHtml = "";
        $url = route('common.change-displayed', [$row->id]);
        $table =  $row->getTable();
        $checked = '';
        if (strtoupper($row->is_displayed) == 'YES' && $row->is_displayed !== NULL) {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center" style="padding-left:20%">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" ' . $checked . '>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

if (!function_exists('getEmployeeStatusHtml')) {
    function getEmployeeStatusHtml($row, $permission = null)
    {
        $user = Sentinel::getUser();
        
        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->is_active == "Yes" ? "Active" : "Inactive";
        }

        $statusHtml = "";
        $url = route('common.change-status', [$row->id]);
        $table =  $row->getTable();
        $checked = ''; $disabled = '';
        if (strtoupper($row->is_active) == 'YES' && $row->is_active !== NULL) {
            $checked = "checked";
        }
        if((isset($row->left_date) && $row->left_date != '00-00-0000')){
            $disabled = "disabled";
        }
        $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-employee-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" '.$checked.' '.$disabled.'>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}


if (!function_exists('getDefaultHtml')) {
    function getDefaultHtml($row, $permission = null)
    {
        $user = Sentinel::getUser();
        
        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->is_default == "Yes" ? "Yes" : "No";
        }

        $defaultHtml = "";
        $url = route('common.change-default', [$row->id]);
        $display_url = route('common.change-displayed', [$row->id]);
        $table =  $row->getTable();
        $checked = '';
        if (strtoupper($row->is_default) == 'YES' && $row->is_default !== NULL && strtoupper($row->is_displayed) == 'YES') {
            $checked = "checked";
        }
        else if(strtoupper($row->is_displayed) == 'NO') {
            $checked = "disabled";
        }
        $defaultHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-default" id="is_default_' . $row->id . '" name="is_default_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" '.$checked.'>
                    <span></span>
                </label>
            </span>
            </div>';
        return $defaultHtml;
    }
}

if (!function_exists('getInfoHtml')) {
    function getInfoHtml($row)
    {
        $table_name =  $row->getTable();
        return '<li class="navi-item">
            <a href="#" class="navi-link show-info" data-toggle="modal" data-target="#AddModelInfo"
                data-table="'.$table_name.'" data-id="'.$row->id.'" data-url="'.route('get-info').'">
                <span class="navi-icon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <span class="navi-text">info</span>
            </a></li>';
    }
}

if (!function_exists('getInfo')) {
    function getInfo($row, $table)
    {
        return '<a href="#" class="btn btn-text-dark-50 font-weight-bold btn-hover-bg-light show-info" data-toggle="modal" data-target="#AddModelInfo"
                data-table="'.$table.'" data-id="'.$row->id.'" data-url="'.route('get-info').'">
                <span class="navi-icon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <span class="navi-text">info</span>
            </a>';
    }
}

if (!function_exists('IDGenerator')) {
    function IDGenerator($model, $trow, $length = 4, $prefix, $colname = null, $colid = null)
    {
        $data = $model::orderBy('id','desc')->when($colname, function ($query) use ($colname, $colid) {
            $query->where($colname, $colid);
        })->first();
        if(!$data){
            $og_length = $length-1;
            $last_number = '1';
        }else{
            $code = substr($data->$trow, strlen($prefix)+1);
            $actial_last_number = ($code/1)*1;
            $increment_last_number = ((int)$actial_last_number)+1;
            $last_number_length = strlen($increment_last_number);
            $og_length = $length - $last_number_length;
            $last_number = $increment_last_number;
        }
        $zeros = "";
        for($i=0;$i<$og_length;$i++){
            $zeros.="0";
        }
        return $prefix.'-'.$zeros.$last_number;
    }
}

if (!function_exists('codeGenerator')) {
    function codeGenerator($table, $length = 4, $prefix) {
        $tableDesc = DB::table($table)->orderBy('id','desc')->first() ?? null;
        $id = (!empty($tableDesc)) ? $tableDesc->id + 1 : 1;

        $idNumber = $prefix . "-" . str_pad($id, $length, '0', STR_PAD_LEFT);
        return $idNumber;
    }
}

if (!function_exists('versionGenerator')) {
    function versionGenerator($table, $length = 4, $proposalId) {
        $allproposalId = DB::table($table)->orderBy('proposal_id','desc')->orderBy('id', 'desc');

        $tableDesc = $allproposalId->first() ?? null;
        $id = 1;
        if(in_array($proposalId, $allproposalId->pluck('proposal_id')->toArray())){
            $id = $tableDesc->version + 1;
        } else {
            $id = 1;
        }
        // $id = (!empty($tableDesc)) ? $tableDesc->proposal_id + 1 : 1;

        $idNumber = str_pad($id, $length, '0', STR_PAD_LEFT);
        return $idNumber;
    }
}

function generateSeriesNumber($type)
{
    $tranType = Series::where('type', $type)->first();

    $no = getNextNumber($type);
    $yearPrefix = $monthYearPrefix = $mYPrefix ="";
    $year = getDefaultYear();
    if ($year) {
        $yearPrefix = date('y', strtotime($year->from_date)) . date('y', strtotime($year->to_date));
        $y = "";
        if (in_array(date('m'), ['04', '05', '06', '07', '08', '09', '10', '11', '12'])) {
            $y = date('y', strtotime($year->from_date));
        } else {
            $y = date('y', strtotime($year->to_date));
        }
        $monthYearPrefix = date('m') . $y;
        $mYPrefix = Carbon::now()->format('my');
    } 
    switch ($tranType->type) {
        case 'PO':
            $seriesNumber = $tranType->prefix . $yearPrefix . "/" . str_pad($no, 4, '0', STR_PAD_LEFT) . $tranType->suffix;
            break;
        default:
            # code...
            break;
    }

    $data = [
        'number' => $seriesNumber ?? null,
        'next_number' => (!empty($seriesNumber)) ?  $no + 1 : null
    ];

    return $data;
}

function getDefaultYear() {
    if (Session::has('default_year')) {
        $year = Session::get('default_year');
    } else {
        $year = Year::where(['is_default' => 'Yes'])->first();
    }
    
    return $year;
}

function checkNumberSign($number) {
    return ( $number > 0 ) ? 1 : ( ( $number < 0 ) ? -1 : 0 );
}

if (!function_exists('isActive')) {

    function isActive($routePattern = null, $class = 'active', $prfix = 'web.')
    {
        $name = Route::currentRouteName();

        if (!is_array($routePattern) && $routePattern != null) {
            $routePattern = explode(' ', $routePattern);
        }

        foreach ((array)$routePattern as $i) {
            if (Str::is($prfix . $i, $name)) {
                return $class;
            }
        }

        foreach ((array)$routePattern as $i) {
            if (Str::is($i, $name)) {
                return $class;
            }
        }
    }
}

if(!function_exists('update_smtp')){
    function update_smtp($mail_data)
    {
        Config::set('mail.mailers.smtp.transport', $mail_data['driver']);
        Config::set('mail.mailers.smtp.host', $mail_data['host']);
        Config::set('mail.mailers.smtp.port', $mail_data['port']);
        Config::set('mail.from.address', $mail_data['username']);
        Config::set('mail.mailers.smtp.encryption', $mail_data['encryption']);
        Config::set('mail.mailers.smtp.username', $mail_data['username']);
        Config::set('mail.mailers.smtp.password', $mail_data['password']);
    }
}

if(!function_exists('get_smtp_details')){

    function get_smtp_details($module_name){
        $fields = [ 
            'SC.from_name',         
            'SC.host_name',         
            'SC.username',         
            'SC.port',         
            'SC.password',         
            'SC.driver',         
            'SC.encryption',         
            'MT.module_name',         
            'MT.subject',         
            'MT.message_body',         
            'MT.is_active',         
            'MT.attachment',         
            // 'MT.lead_source_id',         
            // 'MT.send_time',         
        ];

        $result = DB::table('mail_templates as MT')->select($fields)->join('smtp_configurations as SC', function($join){
            $join->on('SC.id', '=', 'MT.smtp_id');
        })->where([
            ['MT.module_name', $module_name],
            ['MT.is_active', 'YES'],
            ['SC.is_active', 'YES'],
        ])->whereNull('MT.deleted_at')->whereNull('SC.deleted_at')->first();

        return (!empty($result)) ? $result : [];

    }

}

if (!function_exists('uploadFile')) {

    function uploadFile($request, $folder_name, $input_name, $unlink = null)
    {
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name); 
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->{$input_name}->move(public_path('uploads/'.$folder_name), $fileName);
            $image_path = 'uploads/'.$folder_name.'/'.$fileName;

            /*if ($unlink) {
                Storage::delete($unlink);
            }*/
            return $image_path;
        }
        return  $unlink ? $unlink : NULL;
    }
}

if (!function_exists('cutNum')) {
    function cutNum($num, $precision = 2) {
        return floor($num) . substr(str_replace(floor($num), '', $num), 0, $precision + 1);
    }
}

if (!function_exists('uploadAttachment')) {

    function uploadAttachment($request, $field, $folder_name,$unlink = '')
    {
        $attachment = '';
        if ($request->hasFile($field)) {  

            $current = Carbon::now();            
            $storepath = '/uploads/'.$current->format('Y').'/'.$current->format('m').'/'.$folder_name.'/';
            $file[$field] = AppHelper::getUniqueFilename($request->file($field), AppHelper::getImagePath($storepath));
            $request->file($field)->move(AppHelper::getImagePath($storepath), $file[$field]);
            $attachment = $storepath.$file[$field];            
            if (File::exists($unlink)) {
                unlink(base_path('public'.$unlink));
            }      
        }
        return $attachment;
        
    }

}

if(!function_exists('get_size')){
    function get_size($file_path)
    {
        $fileSize = File::size(public_path($file_path));        
        return number_format($fileSize / 1048576,2);
    }
}

if (!function_exists('image_compress')) {

    function image_compress($image_path = ''){

        if($image_path !=''){
            $img = Image::make($image_path);
            $img->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($image_path);
        }
    }
    
}

if (!function_exists('monthsByYears')) {

    function monthsByYears($format = null){
        $selectedYear = Year::where('is_default', 'Yes')->first();
        if (isset($selectedYear)) {
            $from_date = Carbon::parse($selectedYear->from_date)->format('Y-m-d');
            //$to_date = Carbon::parse($selectedYear->to_date)->format('Y-m-d');
            $to_date = Carbon::now()->format('Y-m-d');
            $period = CarbonPeriod::create($from_date, $to_date)->month();
            $now = Carbon::now();
            $currentMonth = $now->format('m');
            
            //dd($from_date,$to_date);
            $monthsArr = [];
            foreach ($period as $dt) {
                $month = $dt->format('m');
                //if($month<=$currentMonth){
                    $monthsArr[$dt->format('m')] = $dt->format($format);               
                //}
            }

            return $monthsArr;            
        }
    }
    
}

if (!function_exists('amountFormat')) {

    function amountFormat($amount = 0){
        return number_format((float)$amount, 2, '.', ',');
    }
}

if (!function_exists('custom_date_format')) {
    function custom_date_format($date = '', $format = 'Y-m-d') 
    {
        return ($date != '') ? Carbon::parse($date)->format($format) : '';
    }
}

if (!function_exists('numberFormatPrecision')) {
    function numberFormatPrecision($number, $precision = 2)
    {
        $response = format_amount((float)$number, $precision);
        return $response;
    }
}

if (!function_exists('numberWithoutRoundOff')) {
    function numberWithoutRoundOff($number, $precision = 2)
    {
        $precisions = pow(10, $precision);
        $response = floor($number * $precisions ) / $precisions;
        return number_format((float)$response, $precision);
    }
}

if (!function_exists('stringToReplace')) {
    function stringToReplace($string, $text = ',', $replace = '.')
    {
        return str_replace($text, $replace, $string);
    }
}

if (!function_exists('multiUploadFile')) {

    function multiUploadFile($file, $folder_name)
    {
        $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
        $fileName = str_replace(' ', '_', $fileName);
        $folder_name = Carbon::now()->format('Y/m/').'/'.$folder_name.'/';
        $file->move(public_path('uploads/'.$folder_name), $fileName);
        return 'uploads/'.$folder_name.$fileName;
    }
}

if (!function_exists('getIsAudited')) {
    function getIsAudited($is_audit = '')
    {
        $html = '';
        if ($is_audit == 'Yes') {
            $html = '<span class="label h6 p-4 label-outline-primary label-pill label-inline btn btn-light-primary btn-sm font-weight-bold">' . __('common.audited') . '</span>';
        }
        return $html;
    }
}

if (!function_exists('linear_loop')) {
    function linear_loop($array)
    {
        /*foreach ($array as $val) {

            $product_name = $val->product->product_name ?? '';
            $rm_name = $val->rawMaterial->name ?? '';

            if (strlen($product_name) > 120 || $rm_name > 120) {
                return 9;
            } else if (strlen($product_name) > 75 || $rm_name > 75) {
                return 11;
            } else if (strlen($product_name) > 50 || $rm_name > 50) {
                return 16;
            } else {
                return 25;
            }
        }*/
        $product_name = max(array_map('strlen', $array->pluck('product')->pluck('product_name')->toArray())) + max(array_map('strlen', $array->pluck('product')->pluck('product_version')->pluck('version_name')->toArray()));
        
        $rm_name = max(array_map('strlen', $array->pluck('rawMaterial')->pluck('name')->toArray()));

        if ($product_name > 120 || $rm_name > 120) {
            return 9;
        } else if ($product_name > 75 || $rm_name > 75) {
            return 11;
        } else if ($product_name > 50 || $rm_name > 50) {
            return 20;
        } else if ($product_name > 40 || $rm_name > 40) {
            return 15;
        } else if ($product_name > 30 || $rm_name > 30) {
            return 22;
        } else {
            return 25;
        }
    }
}

if (!function_exists('getSetting')) {
    function getSetting($name)
    {
        $settingData = Setting::where(['name' => $name])->first();
        if ($settingData) {
            return $settingData->value;
        }

        return "";
    }
}

if (!function_exists('getSettingState')) {
    function getSettingState()
    {
        $stateId = getSetting('state');
        $state = State::find($stateId);
        if ($state) {
            return $state->name;
        }
        return "";
    }
}

if (!function_exists('getSettingCountry')) {
    function getSettingCountry()
    {
        $countryId = getSetting('country');
        $country = Country::find($countryId);
        if ($country) {
            return $country->name;
        }
        return "";
    }
}

function qtyFormat($val, $f="0")
{
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}
if (!function_exists('cleanSpecialCharacters')) {
    function cleanSpecialCharacters($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}

function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}

if (!function_exists('getDisableStatusHtml')) {
    function getDisableStatusHtml($row, $permission = null)
    {
        $checked = '';
        if (strtoupper($row->is_active) == 'YES' && $row->is_active !== NULL) {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center" style="padding-left:20%">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-status"' . $checked . ' disabled>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

function convertAmountToWords($amount = 0, $currValueArr = [])
{
    $numberToWords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    $dollars = intval($amount);
    $cents = intval(($amount - $dollars) * 100);
    
    $dollarsInWords = $numberToWords->format($dollars);
    $centsInWords = $numberToWords->format($cents);
    
    if (count($currValueArr) > 0) {
        $amountInWords = ucwords($dollarsInWords . " " . $currValueArr[0] . " and " . $centsInWords . " " . $currValueArr[1] . " only");
    } else {
        $amountInWords = ucwords($dollarsInWords . " rupees and " . $centsInWords . " paise only");
    }
    
    return $amountInWords;
}

if (!function_exists('numberExcelFormatPrecision')) {
    function numberExcelFormatPrecision($number, $precision = 2)
    {
        $response = format_excel_amount((float)$number, $precision);
        return $response;
    }
}

function format_excel_amount($value, $precision = null)
{
    setlocale(LC_MONETARY, 'en_IN');
    if (is_null($precision)) {
        $precision = '0';
    } else if ($precision == 1) {
        $precision = '0.0';
    } else if ($precision == 2) {
        $precision = '0.00';
    } else if ($precision == 3) {
        $precision = '0.000';
    } else {
        $precision = '0';
    }
    if (!empty($value)) {
        $fmt = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);
        $fmt->setPattern("#####" . $precision);
        return $fmt->format($value);
    }
    return number_format(0, $precision);
}

if (!function_exists('valid_date')) {

    function valid_date($date)
    {
        try {
            return Carbon::parse($date);
        } catch (\Exception $e) {
            return false;
        }
    }
}
if (!function_exists('fg_barcode')) {

    function fg_barcode($transactionId)
    {
        $barcode = "FG/" . Carbon::now()->format('my').'/'.str_pad($transactionId, 4, "0", STR_PAD_LEFT);
        return $barcode;
    }
}

if (!function_exists('getStatusHtmlTeam')) {
    function getStatusHtmlTeam($row, $permission = null)
    {
        $user = Sentinel::getUser();

        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->is_active == "Yes" ? "Active" : "Inactive";
        }

        $statusHtml = "";
        $url = route('common.change-status-team', [$row->id]);
        $table =  $row->getTable();
        $checked = '';
        if (strtoupper($row->is_active) == 'YES' && $row->is_active !== NULL) {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" ' . $checked . '>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

if (!function_exists('getdmsFileIcon')) {

    function getdmsFileIcon($attachment){

        $fileext =  File::extension($attachment);

        if ($fileext == 'xlsx' || $fileext == 'xls') {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/exl.png')."'
            class='theme-light-show' alt=''>";
        }
        elseif ($fileext == 'docx' || $fileext == 'doc') {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/doc.svg')."'
            class='theme-light-show' alt=''>";
        }
        elseif ($fileext == 'pdf') {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/pdf.svg')."'
            class='theme-light-show' alt=''>";
        }
        elseif ($fileext == 'pptx') {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/ppt.png')."'
            class='theme-light-show' alt=''>";
        }
        elseif ($fileext == 'png' || $fileext == 'jpg' || $fileext == 'jpeg' || $fileext == 'svg' || $fileext == 'webp' || $fileext == 'HEIC') {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/png.png')."'
            class='theme-light-show' alt=''>";
        }
        else {
            $icon ="<img height='35' weight='20' src='".asset('/media/files/document.png')."'
            class='theme-light-show' alt=''>";
        }

        return $icon;
    }
}

if (!function_exists('unlink_file')) {
    function unlink_file($paths , $multiple=false){
        if ($multiple) {

            foreach ($paths as $key => $path) {
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }
        else
        {
            if (File::exists($paths)) {
                File::delete($paths);
            }
        }
    }
}

if (!function_exists('getStatusBlacklist')) {
    function getStatusBlacklist($row, $is_disabled = "", $permission = null, $field = "is_active", $value = "Yes")
    {
        $user = Sentinel::getUser();
        if (isset($permission) && !$user->hasAnyAccess([$permission, 'users.superadmin'])) {
            return $row->$field == $value ? "Active" : "Inactive";
        }

        $statusHtml = "";
        $url = route('common.change-status-blacklist', [$row->id]);
        $table =  $row->getTable();
        $checked = '';
        if (strtoupper($row->$field) == strtoupper($value) && $row->$field !== NULL) {
            $checked = "checked";
        }
        $statusHtml = '<div class="text-center">
            <span class="switch switch-icon switch-md">
                <label>
                    <input type="checkbox" class="change-status" id="status_' . $row->id . '" name="status_' . $row->id . '" data-url="' . $url . '" data-table="' . $table . '" value="' . $row->id . '" '.$checked.' '.$is_disabled.'>
                    <span></span>
                </label>
            </span>
            </div>';
        return $statusHtml;
    }
}

if (!function_exists('encryptId')) {
    function encryptId($id){
        $encrypt_id = Crypt::encryptString($id);

        return $encrypt_id;
    }
}

if (!function_exists('decryptId')) {
    function decryptId($id){
        $decrypt_id = Crypt::decryptString($id);

        return $decrypt_id;
    }
}

if (!function_exists('secureFile')) {
    function secureFile($path){
        $dirName = dirname($path);
        $encryptDir = Crypt::encryptString($dirName);
        // $fileName = basename($path);
        $encryptedPath = $encryptDir;
        // dd($encryptedPath);
        return $encryptedPath;
    }
}

if (!function_exists('parseGroupedOptionValue')) {
    function parseGroupedOptionValue($value)
    {
        $parts = explode('|', $value, 2);
    
         return [
            $parts[0] ?? null,
            $parts[1] ?? null
        ];
    }
}

if (!function_exists('deParseGroupedOptionValue')) {
    function deParseGroupedOptionValue($value)
    {
        $parts = implode('|', $value);
    
        return $parts;
    }
}

if (!function_exists('safe_divide')) {
    function safe_divide($numerator, $denominator, $default = 0)
    {
        return $denominator != 0 ? $numerator / $denominator : $default;
    }
}