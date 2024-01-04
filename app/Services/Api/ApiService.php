<?php

namespace App\Services\Api;

use Illuminate\Support\Collection;


class ApiService
{
    private Collection $filters;

    public function __construct(ApiFilterService $filters)
    {
        $this->filters = $filters->getFilters();
    }

    public function getFaculties() : Collection
    {
        return collect($this->filters->get('faculties'));
    }

    public function getEducationForms() : Collection
    {
        return collect($this->filters->get('educForms'));
    }
    public function getCourses() : Collection
    {
        return collect($this->filters->get('courses'));
    }
    public function getGroups(string $facultyId,string $educationForm,string $course) : Collection
    {
        $groupsApi = new ApiGroupsService($facultyId,$educationForm,$course);
        return $groupsApi->getGroups();
    }

    public function schedule(string $studyGroupId): ApiScheduleService
    {
        return new ApiScheduleService($studyGroupId);
    }
}
