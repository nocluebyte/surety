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
    Tender,
    ProjectType,
    Beneficiary,
    BondTypes,
    ProjectDetail,
};
use DB;
use Str;
use App\Rules\{
    AlphabetsAndNumbersV3,
    AlphabetsV1,
    Numbers,
    AlphabetsAndNumbersV5,
};
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Controllers\CommonController;

class TenderImport implements WithHeadingRow ,WithValidation,SkipsOnFailure  ,OnEachRow,WithChunkReading
{
    use SkipsFailures,Importable;
    private $country;
    private $state;
    public function __construct()
    {
        $this->country = Country::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->state = State::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->project_type = ProjectType::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->beneficiary = Beneficiary::select(DB::raw('LOWER(company_name) as company_name'),'id')->get();
        $this->bond_type = BondTypes::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->project_details = ProjectDetail::get();
        $this->type_of_contracting = Config('srtpl.type_of_contracting');
        // dd($this->mode);
    }

    public function onRow(Row $row)
    {
        $project_type = $this->project_type->where('name',Str::lower($row['project_type']))->first();
        $beneficiary = $this->beneficiary->where('company_name',Str::lower($row['beneficiary']))->first();
        $bond_type = $this->bond_type->where('name',Str::lower($row['bond_type']))->first();
        $project_details = $this->project_details->where('code', Str::upper($row['project_details_id']))->first();
        $type_of_contracting = in_array($row['type_of_contracting'], $this->type_of_contracting) ? $row['type_of_contracting'] : NULL;
        // dd($project_details);

        $tender =  new Tender([
            'code' => codeGenerator('tenders', 5, 'TIN'),
            'tender_id' => $row['tender_id'] ?? NULL,
            'tender_header' => $row['tender_header'] ?? NULL,
            'tender_description' => $row['tender_description'] ?? NULL,
            'location' => $row['location'] ?? NULL,
            'project_type' => $project_type->id ?? NULL,
            'beneficiary_id' => $beneficiary->id ?? NULL,
            'contract_value' => $row['contract_value'] ?? NULL,
            'period_of_contract' => $row['period_of_contract'] ?? NULL,
            'bond_value' => $row['bond_value'] ?? NULL,
            'bond_type_id' => $bond_type->id ?? NULL,
            'type_of_contracting' => $type_of_contracting ?? NULL,
            'rfp_date' => isset($row['rfp_date']) ? Date::excelToDateTimeObject($row['rfp_date'])->format('Y-m-d') : NULL,
            'project_description' => $row['project_description'] ?? NULL,
            'project_details' => $project_details->id ?? NULL,
            'pd_beneficiary' => $project_details->beneficiary_id ?? NULL,
            'pd_project_name' => $project_details->project_name ?? NULL,
            'pd_project_description' => $project_details->project_description ?? NULL,
            'pd_project_value' => $project_details->project_value ?? NULL,
            'pd_type_of_project' => $project_details->type_of_project ?? NULL,
            'pd_project_start_date' => $project_details->project_start_date ?? NULL,
            'pd_project_end_date' => $project_details->project_end_date ?? NULL,
            'pd_period_of_project' => $project_details->period_of_project ?? NULL,
        ]);
        $tender->save();
    }

    public function rules():array
    {
        return[
            "tender_id" => ["required", new AlphabetsAndNumbersV5],
            "beneficiary" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->beneficiary->pluck('company_name')->toArray())) {
                    $onFailure('Beneficiary not found in system.');
               }
            }],
            "tender_header" => ["required", new AlphabetsV1],
            "location" => ["required", new AlphabetsV1],
            "project_type" => "nullable",
            "contract_value" => ["required", new Numbers],
            "period_of_contract" => ["required", new Numbers],
            "bond_value" => ["required", new Numbers],
            "bond_type" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->bond_type->pluck('name')->toArray())) {
                    $onFailure('Bond Type not found in system.');
               }
            }],
            "tender_description" => "required",
            "rfp_date" => "required",
            "project_description" => "required",
            "type_of_contracting" => ["required", function($attribute, $value, $onFailure) {
                if (!in_array($value, $this->type_of_contracting)) {
                    $onFailure('Type of Contracting not found.');
               }
            }],

            "project_details_id" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array($value,$this->project_details->pluck('code')->toArray())) {
                    $onFailure('Project Details ID not found in system.');
               }
            }],
        ];
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
