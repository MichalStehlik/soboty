<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use PDF;

class CertificatesController extends Controller
{
    public function create()
    {
        $groups = \App\Group::get();
        return view("certificates.create",["groups" => $groups]);
    }

    public function build(Request $request)
    {
        $this->validate($request,[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "gender" => "required",
            "group" => "required|exists:groups,id",
            "printdate" => "required",
        ]);

        $group = \App\Group::find($request->group);
        $filename = $request->printdate . "_" . $group->name . "_certificates.pdf";
        $pdf = PDF::loadView('pdf.singlecertificate', ["group" => $group,"firstname" => $request->firstname,"lastname" => $request->lastname,"gender" => $request->gender, "printdate" => $request->printdate],[],[
            'title' => 'Osvědčení o účasti',
            'format' => "A4-L",
            "dpi" => 300,
            "image_dpi" => 300
        ]);
        return $pdf->stream($filename);

        flash("Osvědčení bylo vytvořeno.")->success();
        return \Redirect::back();
        //return view('pdf.singlecertificate', ["group" => $group,"firstname" => $request->firstname,"lastname" => $request->lastname,"gender" => $request->gender, "printdate" => $request->printdate]);
    }

    public function certificates(Group $group)
    {
        $mytime = Carbon::now();
        $filename = $mytime->toDateTimeString() . "_" . $group->name . "_certificates.pdf";
        $applications = \App\Application::where(["groups_id" => $group->id, "cancelled_by" => null])->get();
        $pdf = PDF::loadView('pdf.certificate', ["group" => $group,"applications" => $applications, "today" => $mytime],[],[
            'title' => 'Osvědčení o účasti',
            'format' => "A4-L",
            "dpi" => 300,
            "image_dpi" => 300
        ]);
        return $pdf->stream($filename);
    }
}
