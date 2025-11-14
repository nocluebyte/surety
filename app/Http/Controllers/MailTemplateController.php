<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\MailTemplateDatatable;
use App\Models\{MailTemplate, SmtpConfiguration};
use Illuminate\Http\Request;
use App\Http\Requests\MailTemplateRequest;
use Carbon\Carbon;
use Sentinel;
use Session;
use Flash;
use Mail;
use Centaur\Mail\CentaurWelcomeEmail;
use Nsure\Helper\Facades\AppHelper;
use Illuminate\Support\Facades\File;

class MailTemplateController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:mail_template.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:mail_template.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:mail_template.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:mail_template.delete', ['only' => ['destroy']]);
        $this->title = trans("mail_template.mail_template");
        view()->share('title', $this->title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(MailTemplateDatatable $dataTable)
    {
        return $dataTable->render('mail-template.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['smtp_data'] = $this->get_smtp_detail();
        $this->data['module_names'] = config('srtpl.mail_template');
        return response()->json(['html' => view('mail-template.create',$this->data)->render()]);
    }

    public function get_smtp_detail(){
        $get_smtp = SmtpConfiguration::select('id','username')->get()->toArray();
        $smtp_data = [];
        if(!empty($get_smtp)){
            foreach ($get_smtp as $key => $row) {
                $smtp_data[$row['id']] = $row['username'];
            }
        }
        return $smtp_data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(MailTemplateRequest $request)
    {
        $check_entry = MailTemplate::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->module_name == $request['module_name'])) {
            return redirect()->route('mail-template.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $attachment = $this->uploadImage($request);
        $mail_template = new MailTemplate();
        $mail_template->module_name = $request->module_name;
        $mail_template->smtp_id = $request->smtp_id;
        $mail_template->subject = $request->subject;
        $mail_template->message_body = $request->message_body;
        // $mail_template->send_time = $request->send_time ?? '';
        if($attachment !=''){
            $mail_template->attachment = $attachment;
        }
        $mail_template->save();
        return redirect()->route('mail-template.index')->with('success' , __('mail_template.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->data['mail_template'] = MailTemplate::find($id);
        $this->data['smtp_data'] = $this->get_smtp_detail();
        return response()->json(['html' => view('mail-template.edit',$this->data)->render()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mail_template = MailTemplate::find($id);
        $this->data['mail_template'] = $mail_template;
        $this->data['smtp_data'] = $this->get_smtp_detail();
        $this->data['module_names'] = config('srtpl.mail_template');
        return response()->json(['html' => view('mail-template.edit',$this->data)->render()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, MailTemplateRequest $request)
    {
        $mail_template = MailTemplate::findOrFail($id);
        $input = $request->all();
        $attachment = $this->uploadImage($request,$mail_template->attachment);
        if($attachment !=''){
            $mail_template->attachment = $attachment;
        }
        // $mail_template->send_time = $request->send_time;
        $mail_template->update($input);
        return redirect()->route('mail-template.index')->with('success' , __('mail_template.update_success'));

    }

    public function uploadImage($request,$unlink = '')
    {
        $attachment = '';
        if ($request->hasFile('attachment')) {

            $storepath = '/uploads/attachment/';

            $file['attachment'] = AppHelper::getUniqueFilename($request->file('attachment'), AppHelper::getImagePath($storepath));

            $request->file('attachment')->move(AppHelper::getImagePath($storepath), $file['attachment']);
            $attachment = $storepath.$file['attachment'];
            if (File::exists($unlink)) {
                unlink(base_path('public'.$unlink));
            }
        }
        return $attachment;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mail_template = MailTemplate::findOrFail($id);
        if ($mail_template) {
            $mail_template->delete();
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
