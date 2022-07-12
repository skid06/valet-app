<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Company;
use App\Events\NewCompanyHasSubscribedEvent;
use App\Events\NewUserAssignedToCompanyEvent;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use App\Http\Services\CompanyService;


class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $data = $request->validated();
        
        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role'  => $data['role']
        ]);

        $ability = [
            1 => ['system:admin'], 
            2 => ['system:owner'], 
            3 => ['system:user']
        ];

        $token = $user->createToken('main', $ability[$data['role']])->plainTextToken;

        if($data['role'] == 2){
            // Create company for the user
            $company = Company::create([
                'name' => $data['company_name'],
                'slug' => Str::slug($data['company_name']),
                'description' => $data['description'],
                'user_id' => $user->id
            ]);
            
            event(new NewCompanyHasSubscribedEvent($user));

        } elseif($data['role'] == 3) {
            $department = Department::where('id', (int)$request->department_id)->first();

            if($department) {
                $department->users()->attach($user->id, [
                    'from_date' => now()->toDateString(), 
                    'to_date' => now()->addYear(1)->toDateString()
                ]);
                // send welcome email to users stating he get assigned to a company
                // event(new NewUserAssignedToCompanyEvent($user));                
            }
        }
        

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();
        $token = $user->createToken('main', ['system:admin'])->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
