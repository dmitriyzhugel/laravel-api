<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Http\Request;

class UpdateCommentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|string',
            'post_id' => 'exists:posts,id',
        ];
    }
}
