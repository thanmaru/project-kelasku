<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Classroom;
use App\Model\Content;
use RealRashid\SweetAlert\Facades\Alert;
use \Auth;

class AnnouncementController extends Controller
{
    public function index($code, $id)
    {
        if ($code) {
            $class = Classroom::
            join('members','members.classroom_id','=','classrooms.id')
            ->where('classrooms.code', $code)
            ->select('classrooms.*', DB::raw('COUNT(members.id) as count'))
            ->groupBy(DB::raw('classrooms.id'))
            ->first();
            if ($class) {
                $content = Content::join('users','users.id','=','contents.created_by')->where('contents.id', $id)->select('contents.*', DB::raw('users.name as created_name'))->first();
                if($content) {
                    return view('component.announcement.index', compact('class', 'content'));
                } else {
                    Alert::error('Gagal', 'Pengumuman Tidak Ditemukan !');
                    return redirect()->back();
                }
                
            } else {
                Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
                return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
            return redirect()->back();
        }
    }

    public function save(Request $request, $id)
    {
    	if ($id) {
            $class = Classroom::find($id);
            if ($class) {
    	    	$test = new Content;
    	    	$test->name = $request->name;
    	    	$test->description = $request->description;
                $test->type = "ANNOUNCEMENT";
    	    	$test->class_id = $id;
    	    	$test->created_by = Auth::user()->id;
    	    	$test->save();
    	    	Alert::success('Success', 'Pengumuman Berhasil Dibuat !');
    		    return redirect()->route('classroom', [$class->code]);
            } else {
                Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
            return redirect()->back();
            }
    	} else {
    		Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
    		return redirect()->back();
    	}
    }


}
