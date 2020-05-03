<?php

namespace App\Helpers;

class Helper
{

    public static function getRequestMetaData($request)
    {
        return ['ip' => $request->ip(),
            'device' => '',
            'time' => date("Y-m-d H:i:s"),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
        ];
    }

    public static function getConstant($string)
    {
        return config('constants.'.$string);
    }

    public static function mergeAccessToken($stored_access_tokens, $user_access_token)
    {
        $stored_access_tokens = json_decode($stored_access_tokens, true);
        if (is_null($stored_access_tokens)) {
            $stored_access_tokens = [];
        }
        $stored_access_tokens[] = $user_access_token;
        return json_encode($stored_access_tokens);
    }

    public static function generateSessionEventURL($booking)
    {
        $url_params = [
            strtolower(str_replace(' ', '-', $booking['bookingUser']['employer_company'])),
            self::getSessionTypeString($booking['session_type']),
            $booking['duration'] . 'mins',
            self::getDeliveryTypeString($booking['delivery_type']),
            date('dmY', strtotime($booking['session_time'])),
            $booking['id'],
        ];
        return config('constants.FRONTEND_EVENT_URL_PREFIX'). '/'. implode('-', $url_params);
    }

    public static function getSessionEventInvitationUID($booking)
    {
        $params = [
            $booking['id'],
            self::getSessionTypeString($booking['session_type']),
            self::getDeliveryTypeString($booking['delivery_type']),
            strtolower(str_replace(' ', '-', $booking['bookingUser']['employer_company'])),
        ];
        return implode('_', $params);
    }

    public static function getSessionTypeString(int $session_type)
    {
        $session_types = array_flip(config('constants.SERVICES'));
        if (! empty($session_types[$session_type])) {
            $session_type = explode('_', $session_types[$session_type])[0];
            return strtolower($session_type);
        }
        return null;
    }

    public static function getDeliveryTypeString(int $delivery_type)
    {
        $delivery_types = array_flip(config('constants.DELIVERY_TYPE'));
        if ($delivery_type == config('constants.DELIVERY_TYPE.F2F')) {
            return $delivery_types[$delivery_type];
        }
        return strtolower($delivery_types[$delivery_type] ?? null);
    }

    public static function getSelfCancelLink($token, $id)
    {
        return env('FRONTEND_URL')."/".config('constants.ATTENDEE_CANCEL_BOOKING_URL').$token."-".$id;
    }

    public static function getSessionTypeByQuote(int $session_format)
    {
        $session_types = array_flip(config('constants.SESSION_FORMAT'));
        return str_replace("_", " ", $session_types[$session_format] ?? null);
    }
}
