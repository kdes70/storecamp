<?php

namespace App\Core\Validators\Role;

use Illuminate\Foundation\Http\FormRequest as Request;

class RolesUpdateFormRequest extends Request
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
        return [
            'name'         => 'required',
            'permissions'  => 'required',
            'display_name' => 'required|unique:roles,display_name,'.$this->id,
        ];
    }
}
