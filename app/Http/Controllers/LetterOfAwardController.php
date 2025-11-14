<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Principle;
use App\Models\LetterOfAward;
use App\Http\Requests\LetterOfAwardRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Carbon\Carbon;

class LetterOfAwardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:principle.add_letter_of_award', ['only' => ['create', 'store']]);
        $this->middleware('permission:principle.edit_letter_of_award', ['only' => ['edit', 'update']]);
        $this->common = new CommonController();
    }

    public function store(LetterOfAwardRequest $request)
    {
        $check_entry = LetterOfAward::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->ref_no_loa == $request['ref_no_loa'])) {
            return redirect()->route('principle.index')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->except(['_token', 'loa_attachment', 'loa_attachment_count']);

        $letterOfAward = LetterOfAward::create($input);

        $this->common->storeMultipleFiles($request, $request['loa_attachment'], 'loa_attachment', $letterOfAward, $letterOfAward->id, 'letter_of_award');

        return redirect()->route('principle.show', encryptId($request->contractor_id))->with('success', __('letter_of_award.create_success'));
    }

    public function update($id, LetterOfAwardRequest $request)
    {
        $letterOfAward = LetterOfAward::findOrFail($id);
        $updateInput = $request->except(['_token', 'loa_attachment', 'loa_attachment_count']);
        $letterOfAward->update($updateInput);

        // dd($request->all());
        if($request['loa_attachment']){
            // dd('444');
            $this->common->updateMultipleFiles($request, $request['loa_attachment'], 'loa_attachment', $letterOfAward, $letterOfAward->id, 'letter_of_award');
        }

        return redirect()->route('principle.show', encryptId($letterOfAward->contractor_id))->with('success', __('letter_of_award.update_success'));
    }
}
