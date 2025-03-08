<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProductRequest
 * @package App\Http\Requests
 *
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $vendor
 * @property string $product_type
 * @property string $status
 * @property integer $quantity
 * @property string $image
 */
class UpdateProductRequest extends FormRequest
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
            'name' => ['required','min:3'],
            'description' => ['nullable'],
            'price' => ['numeric', 'nullable'],
            'vendor' => ['nullable'],
            'product_type' => ['nullable'],
            'status' => ['required', 'in:active,archived,draft'],
            'quantity' => ['integer', 'nullable'],
            'image' => ['url', 'nullable'],
        ];
    }
}
