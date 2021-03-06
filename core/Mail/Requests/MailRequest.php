<?php

namespace Core\Mail\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'sender' => 'string|required',
                    'recipient' => 'required',
                    'text' => 'nullable',
                    'html' => 'nullable',
                    'status' => 'required|in:posted,failed,sent',
                    'subject' => 'required',
                    'attachments' => 'array'
                ];
            }
            case 'PUT': {
                return [
                    'sender' => 'string|required',
                    'recipient' => 'required',
                    'text' => 'nullable',
                    'html' => 'nullable',
                    'status' => 'required',
                    'subject' => 'required'
                ];
            }
        }
    }
}
