<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Services\CompanyService;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $company_service = new CompanyService;
        $validated = $company_service->validateCompanyData((int)$this->department_id, (int)$this->company_id);

        if(!$validated){
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role'  => 'required',
            'company_id'  =>'required_if:role,3',
            'department_id'  =>'required_if:role,3',
            'name'  => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed'
            ],
            'company_name' => 'required_if:role,2|unique:companies,name',
            'description'  => 'required',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('This action is unauthorized. Contact your employer if the right department and company are given.');
    }
}
