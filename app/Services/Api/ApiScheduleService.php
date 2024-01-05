<?php

namespace App\Services\Api;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiScheduleService
{
    private Collection $schedule;
    private string $groupId;
    public function __construct(string $studyGroupId)
    {
        $this->groupId = $studyGroupId;
    }

    public function getByDate(Carbon $startDate, Carbon $endDate): Collection
    {
        $key = "api.schedule.$this->groupId".$startDate->format("d.m.Y").$endDate->format("d.m.Y");
        $data = [
            'aVuzID' => config('app.vuz_id'),
            'aStudyGroupID' => "'$this->groupId'",
            'aStartDate' =>"'".$startDate->format("d.m.Y")."'",
            'aEndDate' => "'".$endDate->format("d.m.Y")."'",
            'aStudyTypeID' => 'null'
        ];
        //dd($data);
        return Cache::remember($key, 600, function () use ($data) {
            $url = config('app.api_url').'GetScheduleDataX';
            $http = Http::get($url,$data);
            return collect($http->json()['d']);
        });
    }
    public function getToday(): Collection
    {
        return $this->getByDate(Carbon::today(),Carbon::today());
    }
    public function getTomorrow(): Collection
    {
        return $this->getByDate(Carbon::tomorrow(), Carbon::tomorrow());
    }

    public function getThisWeek(): Collection
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $this->getByDate($startOfWeek, $endOfWeek);
    }

    public function getNextWeek(): Collection
    {
        $startOfNextWeek = Carbon::now()->addWeek()->startOfWeek();
        $endOfNextWeek = Carbon::now()->addWeek()->endOfWeek();

        return $this->getByDate($startOfNextWeek, $endOfNextWeek);
    }
}
