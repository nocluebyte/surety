<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    Numbers,
};

class RatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd(request()->all());
        return [
            'countryRatings.*.name'=>['required',new AlphabetsV1],
            'countryRatings.*.financial'=>['required','max:99', new Numbers],
            'countryRatings.*.non_financial'=>['required','max:99', new Numbers],

            'countryRatings.-1.financial'=>['required','in:15',new Numbers],
            'countryRatings.-1.non_financial'=>['required','in:20', new Numbers],

            'sectorRatings.*.name'=>['required',new AlphabetsV1],
            'sectorRatings.*.financial'=>['required','max:99', new Numbers],
            'sectorRatings.*.non_financial'=>['required','max:99', new Numbers],

            'sectorRatings.-1.financial'=>['required','in:10',new Numbers],
            'sectorRatings.-1.non_financial'=>['required','in:20',new Numbers],

            'dateEst.*.from'=>['required','max:99',new Numbers],
            'dateEst.*.to'=>['required','max:99',new Numbers],
            'dateEst.*.financial'=>['required','max:99',new Numbers],
            'dateEst.*.non_financial'=>['required','max:99',new Numbers],

            'ociEmployeeDetail.*.from'=>['required',new Numbers],
            'ociEmployeeDetail.*.to'=>['required',new Numbers],
            'ociEmployeeDetail.*.financial'=>['required','max:99',new Numbers],
            'ociEmployeeDetail.*.non_financial'=>['required','max:99',new Numbers],

            'oci_weightage.financial'=>['required','in:20',new Numbers],
            'oci_weightage.non_financial'=>['required','in:20',new Numbers],

            'uwViewDetail.*.name'=>['required',new AlphabetsV1],
            'uwViewDetail.*.financial'=>['required','max:99',new Numbers],
            'uwViewDetail.*.non_financial'=>['required','max:99',new Numbers],

            'uwViewDetail.-1.financial'=>['required','in:30',new Numbers],
            'uwViewDetail.-1.non_financial'=>['required','in:40',new Numbers],

        ];
    }
}
