<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Group;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Request as RequestFacade;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey, Group $group, Question $question)
    {
        $answers = $question->answers;

        if(RequestFacade::ajax()) {
            return response()->json([
                'data' => $answers
            ], 200);
        }

        return view('admin.answers.index')
            ->with('survey', $survey)
            ->with('group', $group)
            ->with('question', $question)
            ->with('answers', $answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Survey $survey, Group $group, Question $question, Request $request)
    {
        $question->answers()->create([
            'value'  => $request->value,
            'code'  => $request->code,
            'answer_text' => $request->answer_text,
            'order'  => $request->order,
            'visable' => $request->visable == 'true' ? true : false,
        ]);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, Group $group, Question $question, Answer $answer)
    {
        $answer->delete();

        return response(200);
    }
}
