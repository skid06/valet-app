<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Project;
use Carbon\Carbon;
use App\Http\Services\CompanyService;

class ManageDepartmentController extends Controller
{
    public function assignUser(Department $department, User $user)
    {
        $company_service = new CompanyService;
        return $company_service->assignUser($department, $user, request()->remove_user);
        // $user = User::where('id', $userID)->first();
        // if(!$user) {
        //     info("user is not found: ".$user);
        //     return response()->json([
        //         'message' => 'User is not found.ww'
        //     ], 404);             
        // }  
        // info("user is found:$userID ".$user);
        // $company_service = new CompanyService;
        // $result = $company_service->validateCompanyData($departmentID); 

        // if(!$result){
        //     // return false;
        //     return response()->json([
        //         'message' => 'Department doesn\'t belong to your companynnn.'
        //     ], 404);    
        // }

        // $department = Department::where('id', $departmentID)->first();

        // $department->users()->attach($user->id, [
        //     'from_date' => now()->toDateString(), 
        //     'to_date' => now()->addYear(1)->toDateString()
        // ]);
        // // send welcome email to users stating he get assigned to a company
        // // event(new NewUserAssignedToCompanyEvent($user));   
        // return response()->json([
        //     'message' => "$user->name have been assigned  to $department->name."
        // ], 201);
    }

    public function assignProject(Department $department, Project $project)
    {
        $company_service = new CompanyService;
        return $company_service->assignProject($department, $project, request()->remove_project);
        // $project = Project::where('id', $projectID)->first();
        // if(!$project) {
        //     return response()->json([
        //         'message' => 'Project is not found.'
        //     ], 404);            
        // }

        // $company_service = new CompanyService;
        // $company_project = $company_service->belongToCompany($project->company_id);
        // if(!$company_project) {
        //     return response()->json([
        //         'message' => 'Project doesn\'t belong to your company.'
        //     ], 403);
        // }

        // $department = Department::where('id', $departmentID)->first();
        // if(!$department) {
        //     return response()->json([
        //         'message' => 'Department is not found.'
        //     ], 404);            
        // }

        // $company_department = $company_service->belongToCompany($department->company_id);
        // if(!$company_department) {
        //     return response()->json([
        //         'message' => 'Department doesn\'t belong to your company.'
        //     ], 403);
        // }

        // $project_ids = $department->projects->pluck('id')->toArray();
        // if(request()->remove_project){
        //     if(!in_array($project->id, $project_ids)){
        //         return response()->json([
        //             'message' => "$project->name is not found from $department->name."
        //         ], 404);
        //     }
        //     $department->projects()->detach($project->id);      
        //     return response()->json([
        //         'message' => "You have unassigned $project->name from $department->name."
        //     ], 200);  
        // } else {
        //     if(in_array($project->id, $project_ids)){
        //         return response()->json([
        //             'message' => "$project->name is already assigned to $department->name."
        //         ], 200);
        //     }
        //     $department->projects()->attach($project->id, [
        //         'from_date' => now()->toDateString(), 
        //         'to_date' => now()->addYear(1)->toDateString()
        //     ]);

        //     return response()->json([
        //         'message' => "You have assigned $project->name to $department->name. ".request()->remove_project
        //     ], 201);
        // }

    }

    public function inviteUser(Request $request)
    {

    }
}
