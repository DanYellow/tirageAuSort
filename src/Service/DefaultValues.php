<?php

namespace App\Service;


class DefaultValues
{
    public static function getEventName($data)
    {
        return array_key_exists('event_name', $data) ? $data["event_name"] : "Festival Les Talents de l'IUT";
    }
}
