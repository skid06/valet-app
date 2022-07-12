<?php

namespace App\Http\Services;

use App\Models\Department;

class DepartmentService
{
    public function checkCompanyDepartment(Department $department)
    {
        // get the departments by the company
        $company_departments = auth()->user()->company->departments->pluck('id')->toArray();
        
        // validate if department belongs to company
        if(!in_array($department->id, $company_departments)) {
            return false;
        }
        
        return true;
    }
}