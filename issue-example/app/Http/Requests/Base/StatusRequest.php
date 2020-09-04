<?php



namespace App\Http\Requests\Base;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Response;

use Illuminate\Contracts\Validation\Validator;


class StatusRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Request $request
     * @return bool
     */
    public function authorize(Request $request)
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
			'status' => 'required|integer',
		];
    }

}
