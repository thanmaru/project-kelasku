<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Classroom;
use App\Model\Content;
use App\Model\Submission;
use App\User;

use \Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $class = Classroom::
            join('members','members.classroom_id','=','classrooms.id')
            ->join('members as m2','m2.classroom_id','=','classrooms.id')
            ->where('members.user_id', Auth::user()->id)
            ->select('classrooms.*', DB::raw('COUNT(m2.id) as count'))
            ->groupBy(DB::raw('classrooms.id'))
            ->get();
        return view('welcome', compact('class'));
    }

    public function tasklist()
    {
        $submissions = Submission::where('user_id', Auth::user()->id)->select('assignment_id')->get()->toArray();
        $content = Content::
            join('classrooms','classrooms.id','=','contents.class_id')
            ->join('users','users.id','=','contents.created_by')
            ->join('members','classrooms.id','=','members.classroom_id')
            ->where('members.user_id',Auth::user()->id)
            ->whereNotIn('contents.id',$submissions)
            ->where('contents.type','ASSIGNMENT')
            ->select(
                DB::raw('classrooms.owner as classroom_owner'),
                DB::raw('classrooms.name as classroom_name'),
                DB::raw('classrooms.subject as classroom_subject'),
                DB::raw('classrooms.code as classroom_code'),
                'contents.*',
                DB::raw('users.name as created_name')
            )
            ->get();
        return view('component.task.index', compact('content'));
    }
}
