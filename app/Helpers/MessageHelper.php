<?php

namespace App\Helpers;



use Illuminate\Support\Collection;

class MessageHelper
{
    public static function fromApiToTelegram(Collection $data): string
    {
        $groupedData = $data->groupBy(['week_day', function (array $item) {
            return $item['study_time'];
        }], preserveKeys: true);
        $view = (string)view('schedule')->with(['data' => $groupedData]);
        return $view;
    }
}
