<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\Classroom;
use App\Model\Member;
use App\Model\Content;
use App\Model\Submission;

use RealRashid\SweetAlert\Facades\Alert;

use \Auth;

class ClassroomController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        if ($id) {
            $class = Classroom::
            join('members','members.classroom_id','=','classrooms.id')
            ->where('classrooms.code', $id)
            ->select('classrooms.*', DB::raw('COUNT(members.id) as count'))
            ->groupBy(DB::raw('classrooms.id'))
            ->first();
            if ($class != null) {
                $content = Content::
                    join('users','users.id','=','contents.created_by')
                    ->where('contents.class_id', $class->id)
                    ->select(
                        'contents.*',
                        DB::raw('users.name as created_name')
                    )
                    ->orderBy('contents.created_at', 'DESC')->get();
                foreach($content as $value) {
                    $submission = Submission::where('assignment_id', $value->id)->where('user_id', Auth::user()->id)->first();
                    if($submission) {
                        $value->submission_id = $submission->id;
                        $value->submission_score = $submission->score;
                        $value->submission_status = $submission->status;
                    } else {
                        $value->submission_id = null;
                        $value->submission_score = null;
                        $value->submission_status = null;
                    }
                }
                return view('component.classroom.index', compact('class', 'content'));
            } else {
                Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
                return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Terjadi Kesalahan !');
            return redirect()->back();
        }

    }


    public function createAnnouncement($id)
    {
        if ($id) {
            $class = Classroom::where('code', $id)->first();
            if ($class != null) {
                if ($class->owner == Auth::user()->id) {
                    return view('component.classroom.form.create-announce', compact('class'));
                } else {
                    Alert::error('Gagal', 'Anda Bukan Pemilik Kelas !');
                    return redirect()->back();
                }
            } else {
                Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
                return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    public function save(Request $request)
    {
    	$class = new Classroom;
    	$class->name = $request->name;
    	$class->subject = $request->subject;
    	$class->description = $request->description;
    	$class->code = Str::random(rand(6,10));
    	$class->owner = Auth::user()->id;
    	$class->save();
        $member = new Member;
        $member->classroom_id = $class->id;
        $member->user_id = Auth::user()->id;
        $member->save();

    	Alert::success('Berhasil', 'Berhasil Menambah Kelas !');

    	return redirect()->back();
    }

    public function join(Request $request)
    {
    	if ($request->code) {
            $class = Classroom::where('code', $request->code)->first();
            if ($class != null ) {
                if ($class->owner != Auth::user()->id) {
                    if (Member::where('classroom_id', $class->id)->where('user_id', Auth::user()->id)->first() == null) {
                		$member = new Member;
                		$member->classroom_id = Classroom::where('code', $request->code)->value('id');
                		$member->user_id = Auth::user()->id;

                		$member->save();

                        Alert::success('Berhasil', 'Berhasil Bergabung !');

                		return redirect()->back();
                    } else {
                        Alert::error('Gagal', 'Anda Sudah Bergabung Ke Kelas Ini !');

                        return redirect()->back();
                    }
                } else {
                    Alert::error('Gagal', 'Pemilik Kelas Tidak Boleh Bergabung Ke Kelasnya Sendiri !');

                    return redirect()->back();
                }
            } else {
                Alert::error('Gagal', 'Kode Kelas Tidak Ditemukan !');

                return redirect()->back();
            }
    	} else {
            Alert::error('Gagal', 'Berhasil Bergabung !');

            return redirect()->back();
        }
    }

    public function leave(Request $request, $id)
    {
        $member = Member::where('classroom_id', $id)->where('user_id', Auth::user()->id)->first();
        if ($member) {
            $member->delete();
            Alert::success('Berhasil', 'Berhasil Meninggalkan Kelas !');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'kelas Tidak Ditemukan !');
            return redirect()->back();
        }
    }

    public function deleteMember($user, $class)
    {
        if (User::where('id', $user)->first() != null) {
            if (Classroom::where('id', $class)->value('owner') == Auth::user()->id) {
                if (Member::where('classroom_id', $class)->where('user_id', $user)->first() != null) {
                    Member::where('classroom_id', $class)->where('user_id', $user)->delete();
                    Alert::success('Berhasil', 'Berhasil Menghapus Anggota !');
                    return redirect()->back();
                } else {
                    Alert::error('Gagal', 'Anggota Bukan Bagian Dari Kelas Ini !');
                    return redirect()->back();
                }
            } else {
                Alert::error('Gagal', 'Anda Bukan Pemilik Kelas Ini !');
                return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Anggota Tidak Ditemukan !');
            return redirect()->back();
        }
    }
}
