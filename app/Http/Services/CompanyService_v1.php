<?php

namespace App\Http\Services;

use App\Models\Company;
use App\Models\Department;
use Carbon\Carbon;
use App\Models\User;

class CompanyService
{
    public $error_message = null;

    public function belongToCompany(int $id)
    {
        $company = auth()->user()->company;
      
        // validate if department belongs to company
        if($company->id !== $id) {
            return false;
        }
        
        return true;
    }

    // public function validateCompanyData($companyID, $departmentID)
    // {
    //     $department = Department::where('id', $departmentID)->first();

    //     if(!$department) {
    //         return false;          
    //     }
 
    //     $company_department = $this->checkDepartment($department->id, $companyID);
    //     if(!$company_department) {
    //         return false;
    //     }
    //     return true;  
    // }

    public function validateCompanyData($department_id, $company_id = null, $user_id = null)
    {
        $department = Department::where('id', $department_id)->first();

        if(!$department) {
            info("department is not found");
            return false;          
        }

        $company_departments = [];
        info(gettype($company_id).": ".$company_id);
        if($company_id != null) {
            $company = Company::where('id', $company_id)->first();
            if(!$company){
                info("company is not found");
                return false;                  
            }
            if(!$company->departments()->exists()){
                info("company has no department");
                return false;
            }
            $company_departments = $company->departments->pluck('id')->toArray();
            info("it has company", $company_departments);    
        } else {
            if(!auth()->check()){
              info("Not logged in");
              return false;               
            } 
            if(!auth()->user()->company->departments()->exists()) {
                info("logged in user's company has no department");
                return false;          
            }
            $company_departments = auth()->user()->company->departments->pluck('id')->toArray();
        }
        // validate if department belongs to company's departments
        if(!in_array($department_id, $company_departments)) {
            info("department doesn't belong to company", $company_departments);
            return false;
        }
        return true;
    }    

    public function checkProject(int $id)
    {
        $company = auth()->user()->company;
      
        if($company->id !== $id) {
            return false;
        }
        
        return true;
    }
}