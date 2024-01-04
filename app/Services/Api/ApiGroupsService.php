<?php

namespace App\Services\Api;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class ApiGroupsService
{
    private Collection $groups;
    public function __construct(string $facultyId,string $educationForm,string $course)
    {
        $key = "api.groups.$facultyId.$educationForm.$course";
        $data = [
            'aVuzID' => config('app.vuz_id'),
            'aFacultyID' => "'$facultyId'",
            'aEducationForm' => $educationForm,
            'aCourse' => $course,
            'aGiveStudyTimes' => 'false'
        ];
        $this->groups = Cache::remember($key, 600, function () use ($data) {
            $url = config('app.api_url').'GetStudyGroups';
            $http = Http::get($url,$data);
            return collect($http->json()['d']['studyGroups']);
        });
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

}
