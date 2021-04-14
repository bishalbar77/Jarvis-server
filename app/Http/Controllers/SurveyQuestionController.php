<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SurveyQuestion;
use Log;
use AWS;
use Auth;

class SurveyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->perpage)){
            $perpage = $request->perpage;
        } else {
            $perpage = 10;
        }

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Survey Questions"
            ]
        ];

        $filter = [];       

        if($request->status){
            $filter['status'] = $request->status;
        }

        $surveyquestions = SurveyQuestion::where($filter)->orderBy('id', 'desc')->paginate($perpage);

        return view('surveyquestions.list', [
            'breadcrumbs' => $breadcrumbs,
            'surveyquestions' => $surveyquestions,
            'filter'      => $filter,
            'perpage'     => $perpage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/surveyquestions",
                'name'=>"Survey Questions"
            ],
            [
                'name'=>"Create Survey Questions"
            ]
        ];

        return view('surveyquestions.create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'possible_answers' => 'required',
            'status' => 'required'
        ]);

        $surveyquestions = new SurveyQuestion;
        $surveyquestions->text = $request->text;
        $surveyquestions->possible_answers = $request->possible_answers;
        $surveyquestions->status = $request->status;
        $surveyquestions->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SurveyQuestionController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('surveyquestions')->with('success', 'Survey Questions created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surveyquestions = SurveyQuestion::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/surveyquestions",
                'name'=>"Survey Questions"
            ],
            [
                'name'=>"Edit Survey Questions"
            ]
        ];


        return view('surveyquestions.edit', [
            'breadcrumbs' => $breadcrumbs,
            'surveyquestions' => $surveyquestions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required',
            'possible_answers' => 'required',
            'status' => 'required'
        ]);

        $surveyquestions = $old = SurveyQuestion::find($id);
        $surveyquestions->text = $request->text;
        $surveyquestions->possible_answers = $request->possible_answers;
        $surveyquestions->status = $request->status;
        $surveyquestions->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SurveyQuestionController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/surveyquestions')->with('success', 'Survey Questions details Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $surveyquestions = SurveyQuestion::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SurveyQuestionController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $surveyquestions,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        SurveyQuestion::destroy($id);

        return redirect('/surveyquestions')->with('success', 'Survey Questions deleted successfully!');
    }
}
