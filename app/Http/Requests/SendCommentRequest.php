<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'c-name' => 'bail|required|max:50',
            'c-email' => 'bail|required|email',
            'c-body' => 'required|min:2|max:3000',
            'c-subscription' => 'boolean',
            'comment_parent' => 'required|integer',
        ];
    }

    public function messages() {
        return [
            'c-name.required'=>'Inserisci il tuo nome.',
            'c-name.max'=>'Il nome deve contenere al massimo :max caratteri.',
            'c-email.required'=>'Inserisci il tuo indirizzo e-mail.',
            'c-email.email'=>'Inserisci un indirizzo email corretto.',
            'c-body.required'=>'Il testo del commento è obbligatorio.',
            'c-body.min'=>'Il testo del commento deve avere almeno :min caratteri.',
            'c-body.max'=>'Il testo del tuo commento è troppo lungo. Consentiti massimo :max caratteri.',
        ];
    }
}
