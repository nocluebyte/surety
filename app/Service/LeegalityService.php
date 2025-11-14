<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;
use App\Models\LeegalityDocument;

class LeegalityService
{
    private $baseUrl;
    private $token;

    private $fields = [];

    public function __construct()
    {
        $this->baseUrl = config('leegality.base_url');
        $this->token = config('leegality.auth_token');
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    public function getToken()
    {
        return $this->token;
    }

    public function getDocumentFieldJson(){ 

        return array_values($this->fields);
       
    }

    public function setDocumentFieldJson($fieldValues){
        
             $fields = [
                    [
                        "name"=>"bond_policy_no",
                        "required"=>true,
                        "id"=>"1757919278808",
                        "value"=>$fieldValues['bond_policy_no'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_type",
                        "required"=>true,
                        "id"=>"1757921806280",
                        "value"=>$fieldValues['bond_type'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_start_date",
                        "required"=>true,
                        "id"=>"1757922683548",
                        "value"=>$fieldValues['bond_start_date'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_end_date",
                        "required"=>true,
                        "id"=>"1757922736619",
                        "value"=>$fieldValues['bond_end_date'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_period",
                        "required"=>true,
                        "id"=>"1757922801217",
                        "value"=>$fieldValues['bond_period'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"project_value",
                        "required"=>true,
                        "id"=>"1757922821915",
                        "value"=>$fieldValues['project_value'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"contract_value",
                        "required"=>true,
                        "id"=>"1757922848193",
                        "value"=>$fieldValues['contract_value'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_value",
                        "required"=>true,
                        "id"=>"1757922880480",
                        "value"=>$fieldValues['bond_value'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"project_description",
                        "required"=>true,
                        "id"=>"1757922922850",
                        "value"=>$fieldValues['project_description'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_issue_date",
                        "required"=>true,
                        "id"=>"1757941314391",
                        "value"=>$fieldValues['bond_issue_date'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"bond_issue_date",
                        "required"=>false,
                        "id"=>"1757941130891",
                        "value"=>$fieldValues['bond_issue_date'] ?? '',
                        "type"=>"text"
                    ],
                    [
                        "name"=>"insurer",
                        "required"=>true,
                        "id"=>"1757941364957",
                        "value"=>$fieldValues['insurer'] ?? '',
                        "type"=>"text"
                    ]
                    ];

                    $this->fields = $fields;
    
    }

    public function sendDocumentForeSigning($signer_name,$indemnity_signing_through,$signer_email,$signer_phone)
    {
        $fields = $this->getDocumentFieldJson();
        $invitees = [
            'name'=>$signer_name
        ];
        
        switch ($indemnity_signing_through) {
            case 'Phone':
                $invitees['phone'] = '7506670571';
                break;
            case 'Email':
                 $invitees['email'] = 'rudrakshansure@outlook.com';
                break;
            case 'Aadhar':
                $invitees['email'] = 'rudrakshansure@outlook.com';
                break;
        }

        return Http::withHeader('X-AUTH-TOKEN', $this->token)->post(
            "{$this->baseUrl}/sign/request",
            [
                "profileId" => "mmYkMqv",
                "file" => [
                            "templateId"=>" V1HBZVF",
                            "fields"=>$fields
                        ],
                "invitees" =>[$invitees]
                        //  "signers"=>[
                        //     [
                        //         "name"=>"Test Signer",
                        //         "email"=>$signer_email,
                        //         "phone"=>$signer_phone,
                        //     ]
                        // ]

            ]
        );

    }

    public function sendEmailToSigner($signUrl){
        return Http::withHeaders([
            'x-auth-token' => $this->token,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/sign/request/resend", [
            'signUrls' => [
                $signUrl
            ]
        ]);
    }

    public function setLeegalityDocumentRecord($proposal_id,$contractor_id,$input){
   
        $record = LeegalityDocument::updateOrCreate([
            'proposal_id'=>$proposal_id
        ],[
            'name'=>$input['invitees'][0]['name'],		
            'email'=>$input['invitees'][0]['email'],	
            'proposal_id'=>$proposal_id,
            'contractor_id'=>$contractor_id,	
            'document_id'=>$input['documentId'],	
            'phone'=>$input['invitees'][0]['phone'],	
            'sign_url'=>$input['invitees'][0]['signUrl'],	
            'active'=>$input['invitees'][0]['active'],	
            'expiry_date'=>$input['invitees'][0]['expiryDate']
        ]);

        return $record?->id;
        
    }




}