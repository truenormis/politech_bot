<?php

namespace App\Services\Api;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiFilterService
{
    private Collection $apiData;

    public function __construct()
    {
        $this->apiData = Cache::remember('api.filters', 600, function () {
            $url = config('app.api_url').'GetStudentScheduleFiltersData';
            $http = Http::get($url,[
                'aVuzID' => 11761
            ]);
            return collect($http->json()['d']);
        });
    }

    public function getFilters() : Collection
    {
        return $this->apiData;
    }
}
