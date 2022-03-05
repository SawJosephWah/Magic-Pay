<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('admin_user');

        // dd($id);
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:admins,email,'.$id,
            'phone' => 'required|max:20|unique:admins,phone,'.$id,
        ];
    }
}
