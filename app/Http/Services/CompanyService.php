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
        if(!auth()->check()){
            return false;               
        } 

        $company = auth()->user()->company;
        if(!$company->exists()) {
            info("logged in user has no company");
            return false;          
        }        
      
        if($company->id !== $id) {
            return false;
        }

        return true;
    }

    public function validateCompanyData($department_id, $company_id = null)
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
            info(gettype($company_departments));  
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
            info($company_departments);
        }
        // validate if department belongs to company's departments
        if(!in_array($department_id, $company_departments)) {
            info("department doesn't belong to company", $company_departments);
            return false;
        }
        return true;
    }
    
    public function assignProject($department, $project, bool $remove_project)
    {
        // $project = Project::where('id', $projectID)->first();
        if(!$project) {
            return response()->json([
                'message' => 'Project is not found.'
            ], 404);            
        }

        $company_project = $this->belongToCompany($project->company_id);
        if(!$company_project) {
            return response()->json([
                'message' => 'Project doesn\'t belong to your company.'
            ], 403);
        }

        // $department = Department::where('id', $departmentID)->first();
        if(!$department) {
            return response()->json([
                'message' => 'Department is not found.'
            ], 404);            
        }

        $company_department = $this->belongToCompany($department->company_id);
        if(!$company_department) {
            return response()->json([
                'message' => 'Department doesn\'t belong to your company.'
            ], 403);
        }

        $project_ids = $department->projects->pluck('id')->toArray();
        if($remove_project){
            if(!in_array($project->id, $project_ids)){
                return response()->json([
                    'message' => "$project->name is not found from $department->name."
                ], 404);
            }
            $department->projects()->detach($project->id);      
            return response()->json([
                'message' => "You have unassigned $project->name from $department->name."
            ], 200);  
        } else {
            if(in_array($project->id, $project_ids)){
                return response()->json([
                    'message' => "$project->name is already assigned to $department->name."
                ], 200);
            }
            $department->projects()->attach($project->id, [
                'from_date' => now()->toDateString(), 
                'to_date' => now()->addYear(1)->toDateString()
            ]);

            return response()->json([
                'message' => "You have assigned $project->name to $department->name. ".request()->remove_project
            ], 201);
        }
    }   
    
    public function assignUser($department, $user, bool $remove_user)
    {
        // $userID = (int) $request->userID;
        // $user = User::where('id', $userID)->first();
        if(!$user) {
            info("user is not found: ".$user);
            return response()->json([
                'message' => 'User is not found.ww'
            ], 404);             
        }  
        info("user is found: ".$user);
        // $company_service = new CompanyService;
        $result = $this->validateCompanyData($department->id); 

        if(!$result){
            // return false;
            return response()->json([
                'message' => 'Department doesn\'t belong to your companynnn.'
            ], 404);    
        }

        // $department = Department::where('id', $departmentID)->first();

        $user_ids = $department->users->pluck('id')->toArray();
        if($remove_user){
            if(!in_array($user->id, $user_ids)){
                return response()->json([
                    'message' => "$user->name is not found from $department->name."
                ], 404);
            }
            $department->users()->detach($user->id);      
            return response()->json([
                'message' => "You have unassigned $user->name from $department->name."
            ], 200);  
        } else {
            if(in_array($user->id, $user_ids)){
                return response()->json([
                    'message' => "$user->name is already assigned to $department->name."
                ], 200);
            }
            $department->users()->attach($user->id, [
              'from_date' => now()->toDateString(), 
              'to_date' => now()->addYear(1)->toDateString()
          ]);

            return response()->json([
              'message' => "$user->name have been assigned  to $department->name."
          ], 201);
        }

        // $department->users()->attach($user->id, [
        //     'from_date' => now()->toDateString(), 
        //     'to_date' => now()->addYear(1)->toDateString()
        // ]);
        // send welcome email to users stating he get assigned to a company
        // event(new NewUserAssignedToCompanyEvent($user));   
        // return response()->json([
        //     'message' => "$user->name have been assigned  to $department->name."
        // ], 201);
    }    
}