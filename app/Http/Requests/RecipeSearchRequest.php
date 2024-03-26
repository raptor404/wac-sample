<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class RecipeSearchRequest extends FormRequest
{
    /**
     * A fun little trick for GET input validation to help prevent XSS etc and move the logic for cleaning input here
     * @return array
     */
    public function validationData() : array
    {
        //TODO apply input cleaning as needed, if we change parameters,
        // issue a redirect here so unclean input never hits a query

        //This step is usually not needed in 2024, but it can be nice in-case these links are published so that no one can create a defacing link
        //Could just switch this to post if we want to hide the user input

        return [
            'email'=> $this->query('email', null),
            'keyword'=> $this->query('keyword', null),
            'ingredient'=> $this->query('ingredient', null),
            'password'=> $this->query('password', null),
            'page'=>$this->query('page'),
        ];
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        //basic honeypot for stupid autocompletes or fun phishing
        if($this->query('password', null)!==null){
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'email'=>'email|between:0,250|nullable',
            'keyword'=>'string|between:0,250|nullable',
            'ingredient'=>'string|between:0,250|nullable',
            'page' => 'integer|min:0|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) : array
    {
        //TODO add custom handler and use a universal error
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true
        ], 422));
    }

}
