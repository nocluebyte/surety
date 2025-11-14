<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Illuminate\Validation\Rule;
use App\Models\{
    Country,
    State,
    IssuingOfficeBranch,
};
use DB;
use Str;
use App\Rules\{
    AlphabetsAndNumbersV3,
    AlphabetsV1,
    GstNo,
    Numbers,
    AlphabetsAndNumbersV1,
    AlphabetsAndNumbersV6,
    AlphabetsV5,
    AlphabetsAndNumbersV2,
};

class IssuingOfficeBranchImport implements WithHeadingRow ,WithValidation,SkipsOnFailure  ,OnEachRow,WithChunkReading
{
    use SkipsFailures,Importable;
    private $country;
    private $state;
    public function __construct()
    {
        $this->country = Country::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->state = State::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->mode = Config('srtpl.filters.issuing_office_branch_filter.mode');
        // dd($this->mode);
    }

    public function onRow(Row $row)
    {
        $country = $this->country->where('name',Str::lower($row['country']))->first();
        $state = $this->state->where('name',Str::lower($row['state']))->first();
        $mode = in_array($row['mode'], $this->mode) ? $row['mode'] : NULL;

        $issuingOfficeBranch =  new IssuingOfficeBranch([
            'branch_name' => $row['branch_name'] ?? NULL,
            'branch_code' => $row['branch_code'] ?? NULL,
            'address' => $row['address'] ?? NULL,
            'state_id' => $state->id ?? NULL,
            'country_id' => $country->id ?? NULL,
            'city' => $row['city'] ?? NULL,
            'gst_no' => $row['gst_no'] ?? NULL,
            'oo_cbo_bo_kbo' => $row['oo_cbo_bo_kbo'] ?? NULL,
            'bank' => $row['bank'] ?? NULL,
            'bank_branch' => $row['bank_branch'] ?? NULL,
            'account_no' => $row['account_no'] ?? NULL,
            'ifsc'=>$row['ifsc'] ?? NULL,
            'micr'=>$row['micr'] ?? NULL,
            'mode'=>$mode ?? NULL,
        ]);
        $issuingOfficeBranch->save();
    }

    public function rules():array
    {
        return[
            "branch_name" => ["required", new AlphabetsAndNumbersV3],
            'branch_code' => ["required", "unique:issuing_office_branches,branch_code", new AlphabetsAndNumbersV2],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            'state' => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->state->pluck('name')->toArray())) {
                    $onFailure('State not found in system.');
               }
            }],
            'country' => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->country->pluck('name')->toArray())) {
                    $onFailure('Country not found in system.');
               }
            }],
            "oo_cbo_bo_kbo" => ["required", "unique:issuing_office_branches,oo_cbo_bo_kbo"],
            "gst_no" => ["nullable", "unique:issuing_office_branches,gst_no"],
            "micr" => ["required", "unique:issuing_office_branches,micr"],
            "bank" => ["required", new AlphabetsAndNumbersV3],
            "bank_branch" => ["required", new AlphabetsAndNumbersV3],
            "account_no" => ["required", new AlphabetsAndNumbersV6],
            "ifsc" => ["required", new AlphabetsAndNumbersV1],
            "mode" => ["required", function($attribute, $value, $onFailure) {
                if (!in_array($value, $this->mode)) {
                    $onFailure('Mode not found.');
               }
            }],
        ];
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
