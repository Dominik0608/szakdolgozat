<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // false alapból, tutorial írja át truera
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
        ];

        $rules = $this->addArrayToRules($rules, 'test_input', 'required');
        $rules = $this->addArrayToRules($rules, 'test_output', 'required');
        $rules = $this->addArrayToRules($rules, 'validator_input', 'required');
        $rules = $this->addArrayToRules($rules, 'validator_output', 'required');

        //dd($rules);
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'title.required' => 'A cím megadása kötelező!',
            'title.min' => 'A címnek legalább :min karakternek kell lennie.',
            'title.max' => 'A cím legfeljebb :max karakter lehet.',
            'description.required' => 'A leírás megadás kötelező!',
        ];

        $messages = $this->addArrayToMessages($messages, 'test_input', 'Test input megadása kötelező!');
        $messages = $this->addArrayToMessages($messages, 'test_output', 'Test output megadása kötelező!');
        $messages = $this->addArrayToMessages($messages, 'validator_input', 'Validator input megadása kötelező!');
        $messages = $this->addArrayToMessages($messages, 'validator_output', 'Validator output megadása kötelező!');

        //dd($messages);

        return $messages;
    }

    private function addArrayToRules($rules, $array, $text)
    {
        foreach($this->request->get($array) as $key => $val)
        {
            $rules[$array.'.'.$key] = $text;
        }
        return $rules;
    }

    private function addArrayToMessages($messages, $array, $text)
    {
        foreach($this->request->get($array) as $key => $val)
        {
            $messages[$array.'.'.$key.'.required'] = $text;
        }
        return $messages;
    }
}
