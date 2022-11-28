<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Classroom;
use App\Model\Content;
use App\Model\Quest;
use App\Model\Option;
use App\Model\Submission;
use App\Model\Answer;
use RealRashid\SweetAlert\Facades\Alert;
use \Auth;
use \Carbon\Carbon;

class TestController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

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
                    $submission = Submission::where('assignment_id', $content->id)->where('user_id', Auth::user()->id)->first();
                    if($submission) {
                        $answer = Answer::where('submission_id', $submission->id)->get();
                        $submission->answer = $answer;
                    }
                    $content->submission = $submission;
                    return view('component.test.index', compact('class', 'content'));
                } else {
                    Alert::error('Gagal', 'Tugas Tidak Ditemukan !');
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
    
    public function submission($code, $id)
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
                    $submissions = Submission::
                        join('users','users.id','=','submissions.user_id')
                        ->where('assignment_id', $content->id)
                        ->select('submissions.*',DB::raw('users.name as user_name'))
                        ->get();
                    $content->submissions = $submissions;
                    return view('component.test.submissions', compact('class', 'content'));
                } else {
                    Alert::error('Gagal', 'Tugas Tidak Ditemukan !');
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

    public function start($code, $id)
    {
        $class = Classroom::where('code', $code)->first();
        if ($class) {
            if ($id) {
                $test = Content::where('id', $id)->first();
                if ($test) {
                    $submission = Submission::where('user_id', Auth::user()->id)->where('assignment_id', $test->id)->first();
                    if ($submission) {
                        Alert::error('Gagal', 'Anda Sudah Mengerjakan Tugas !');
                        return redirect()->back();
                    } else {
                        $quest = Quest::where('test_id', $test->id)->get();
                        return view('component.test.start', compact('class', 'test', 'quest'));
                    }
                } else {
                    Alert::error('Gagal', 'Tes Tidak Ditemukan !');
                    return redirect()->back();        
                }
            } else {
                Alert::error('Gagal', 'Tes Tidak Ditemukan !');
                return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Tes Tidak Ditemukan !');
            return redirect()->back();
        }
    }

    public function submit(Request $request, $code, $id)
    {
        if ($code) {
            $class = Classroom::where('code', $code)->first();
            if($class) {
            	if ($id) {
                    $content = Content::find($id);
                    if ($content->due_date) {
                        if (date('Y-m-d H:i:s') > $content->due_date) {
                            $time = 'LATE';
                        } else {
                            $time = 'ONTIME';
                        }
                    } else {
                        $time = 'ONTIME';
                    }
                    if ($content) {
                        $option = $request->option;
                        if (count($option) > 0) {
                            $submission = new Submission;
                            $submission->user_id = Auth::user()->id;
                            $submission->assignment_id = $content->id;
                            $submission->status = $time;
                            $submission->save();
                            $quest_count = 0;
                            $correct_count = 0;
                            for ($i=0; $i < count($option); $i++) { 
                                $quest = Quest::where('id', $option[$i]['quest_id'])->first();
                                if ($quest->answer == $option[$i]['answer']) {
                                    $status = 'CORRECT';
                                    $quest_count += 1;
                                    $correct_count += 1;
                                } else {
                                    $quest_count += 1;
                                    $status = 'INCORRECT';
                                }
                                $answer = new Answer;
                                $answer->submission_id = $submission->id;
                                $answer->quest_id = $quest->id;
                                $answer->answer = $option[$i]['answer'];
                                $answer->status = $status;
                                $answer->save();
                            }
                            $score = ($correct_count / $quest_count) * 100;
                            $submission->score = $score;
                            $submission->save();

                            Alert::success('Success', 'Berhasil Menyelesaikan Tugas !');
                            return redirect()->route('test', [$code, $id]);
                        } else {
                            Alert::error('Gagal', 'Tes Tidak Ditemukan !');
                            return redirect()->back();
                        }

                    } else {
                        Alert::error('Gagal', 'Tes Tidak Ditemukan !');
                        return redirect()->back();
                    }
            	} else {
            		Alert::error('Gagal', 'Tes Tidak Ditemukan !');
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

    public function create(Request $request, $code)
    {
        if ($code) {
            $quest = $request->quest;
            $option = $request->option;
            if ($quest != 0 && $option != 0) {
	            $class = Classroom::where('code', $code)->first();
	            if ($class != null) {
                    return view('component.test.form.create', compact('class', 'quest', 'option'));
	            } else {
	                Alert::error('Gagal', 'Kelas Tidak Ditemukan !');
	                return redirect()->back();
	            }
            } else {
            	Alert::error('Gagal', 'Jumlah Soal dan Pilihan Ganda Tidak Boleh Kosong !');
            	return redirect()->back();
            }
        } else {
            Alert::error('Gagal', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    public function save(Request $request, $code)
    {
        // dd($request->all());
    	if ($code) {
            $class = Classroom::where('code', $code)->first();
            if ($class) {
                if ($request->due_date) {
                    $date = Carbon::parse($request->due_date)->isoFormat('YYYY-MM-DD HH:mm:ss');
                } else {
                    $date = null;
                }
    	    	$test = new Content;
    	    	$test->name = $request->name;
    	    	$test->description = $request->description;
                $test->due_date = $date;
                $test->type = "ASSIGNMENT";
    	    	$test->class_id = $class->id;
    	    	$test->created_by = Auth::user()->id;
    	    	$test->save();
    	    	if ($test->id) {
    	    		for ($i=0; $i < count($request->quest); $i++) { 
    		    		$quest = new Quest;
    		    		$quest->test_id = $test->id;
    		    		$quest->quest = $request->quest[$i];
    		    		$quest->answer = $request->answer[$i];
    		    		$quest->save();
    		    		if ($quest->id) {
    		    			for ($j=0; $j < count($request->option[$i]); $j++) { 
    		    				$option = new Option;
    		    				$option->quest_id = $quest->id;
    		    				$option->option = $j+1;
    		    				$option->name = $request->option[$i][$j];
    		    				$option->save();
                                if ($request->answer[$i] == $j) {
                                    $quest->answer = $option->id;
                                    $quest->save();
                                }
    		    			}
    		    		} else {
    		    			Alert::error('Gagal', 'Pertanyaan Tidak Ditemukan !');
                			return redirect()->back();
    		    		}
    	    		}
        	    	Alert::success('Success', 'Tes Berhasil Dibuat !');
        		    return redirect()->route('classroom', [$code]);
    	    	} else {
    	    		Alert::error('Gagal', 'Tes Tidak Ditemukan !');
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

    public function delete($code, $id)
    {
    	if ($id) {
    		$quest = Quest::where('test_id', $id)->get();
    		foreach ($quest as $key => $value) {
    			$option = Option::where('quest_id', $value->id)->get()->count();	
	    		for ($i=0; $i < $option; $i++) { 
	    			Option::where('quest_id', $value->id)->delete();
	    		}
                $submission = Submission::where('assignment_id', $value->id)->get();
                foreach($submission as $value) {
                    Answer::where('submission_id', $value->id)->delete();
                }
                Submission::where('assignment_id', $value->id)->delete();
    		}
    		Quest::where('test_id', $id)->delete();
    		Content::where('id', $id)->delete();
    		Alert::success('Berhasil', 'Tes Berhasil Dihapus !');
    		return redirect()->back();

    	} else {
    		Alert::error('Gagal', 'Tes Tidak Ditemukan !');
    		return redirect()->back();
    	}
    }
}
