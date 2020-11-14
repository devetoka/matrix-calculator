<?php

namespace App\Http\Requests;

use App\Utils\Validation\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatrixRequest extends FormRequest
{
    use FailedValidation;
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
        $second_matrix_row = is_array(request('first_matrix'))  ?
            count(request('first_matrix')[0]) : null;
        return [
            'first_matrix' => 'bail|required|array',
            'first_matrix.*' => 'bail|array',
            'second_matrix' => [
                'bail',
                'required',
                'array',
                'size:'. $second_matrix_row
            ],
            'second_matrix.*' => 'array',
        ];
    }


    public function messages()
    {
        return [
            'second_matrix.size'
            => 'The number of columns on the first matrix must equal the number of rows on the second matrix'
        ];
    }
}
