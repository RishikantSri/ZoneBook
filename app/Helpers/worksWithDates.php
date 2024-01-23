<?php 

use App\Models\User;
use Carbon\Carbon;
 
if (!function_exists('toUserDate')) {
        // Check if the function toUserDate doesn't already exist
        // This is to avoid conflicts if the function is defined elsewhere
        // (e.g., in another part of the code or a package)
    function toUserDate(string|Carbon $date, ?User $user = null, string $timezone = 'UTC'): string
    {
        if ($user) {
            // If a User object is provided, use the user's timezone
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {
            // If $date is a string, parse it into a Carbon instance and set the timezone
            //for the localized date format,  in an English locale, it might be 'MM/DD/YYYY',in a French locale, it could be 'DD/MM/YYYY' 
            return Carbon::parse($date, 'UTC')->setTimezone($timezone)->isoFormat('L');
        }
        
        // If $date is already a Carbon instance, set the timezone and format it
        return $date->setTimezone($timezone)->isoFormat('L');
    }
}
 
if (!function_exists('toUserTime')) {
    function toUserTime(string|Carbon $date, ?User $user = null, string $timezone = 'UTC'): string
    {
        if ($user) {
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {
            // to format the date or time in a localized way,  '2022-01-20 14:30:00',
            return Carbon::parse($date, 'UTC')->setTimezone($timezone)->isoFormat('LT');
        }
 
        return $date->setTimezone($timezone)->isoFormat('LT');
    }
}
 
if (!function_exists('toUserDateTime')) {
    function toUserDateTime(string|Carbon $date, ?User $user = null, string $timezone = 'UTC'): string
    {
        if ($user) {
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {
            return Carbon::parse($date, 'UTC')->setTimezone($timezone)->isoFormat('L LT');
        }
 
        return $date->setTimezone($timezone)->isoFormat('L LT');
    }
}
 
if (!function_exists('fromUserDate')) {

    // Check if the function fromUserDate doesn't already exist
    // This is to avoid conflicts if the function is defined elsewhere
    // (e.g., in another part of the code or a package)

    function fromUserDate(string|Carbon $date, ?User $user = null, string $timezone = null): string
    {
        if ($user) {
            // If a User object is provided, use the user's timezone
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {

            // If $date is a string, parse it into a Carbon instance with the specified timezone,
            // then set the timezone to 'UTC' and convert it to a date string
            return Carbon::parse($date, $timezone)->setTimezone('UTC')->toDateString();
        }
    
        // If $date is already a Carbon instance, set the timezone to 'UTC' and convert it to a date-time string
        return $date->setTimezone('UTC')->toDateTimeString();
    }
}
 
if (!function_exists('fromUserTime')) {
    function fromUserTime(string|Carbon $date, ?User $user = null, string $timezone = null): string
    {
        if ($user) {
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {
            return Carbon::parse($date, $timezone)->setTimezone('UTC')->toTimeString();
        }
 
        return $date->setTimezone('UTC')->toDateTimeString();
    }
}
 
if (!function_exists('fromUserDateTime')) {
    function fromUserDateTime(string|Carbon $date, ?User $user = null, string $timezone = null): string
    {
        if ($user) {
            $timezone = $user->timezone;
        }
 
        if (is_string($date)) {
            return Carbon::parse($date, $timezone)->setTimezone('UTC')->toDateTimeString();
        }
 
        return $date->setTimezone('UTC')->toDateTimeString();
    }
}


?>