<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAnswerResource;
use App\Models\Test;
use App\Models\UserAnswer;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAnswerController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'testId' => 'required|exists:App\Models\Test,id',
        ]);

        $userId = $request->user()->id;
        $testId = $validated['testId'];

        $attempt = UserAnswer::where('user_id', $userId)->where('test_id', $testId)->max('attempt') + 1;


        $questions = Test::find($testId)->questions;

        foreach ($questions as $question) {
            $isCorrect = (strtolower($question->answer) == strtolower($request->input($question->id)));


            UserAnswer::create([
                'user_id' => $userId,
                'test_id' => $testId,
                'question_id' => $question->id,
                'text' => $request->input($question->id),
                'is_correct' => $isCorrect,
                'attempt' => $attempt
            ]);
        }
    }

    public function index($user = null)
    {
        if (!$user) {
            $user = auth()->id();
        }

        $tests = DB::table('test')
            ->select('id', 'title')
            ->whereIn('id', function (Builder $query) use ($user) {
                $query->select('test_id')
                    ->distinct()
                    ->from('user_answer')
                    ->where('user_id', $user);
            })->get();

        foreach ($tests as $test) {
           $attempts =  DB::table('user_answer')
                ->select('attempt', 'created_at', DB::raw('SUM(is_correct) as correct'), DB::raw('COUNT(question_id) as total'))
                ->where('test_id', $test->id)
                ->where('user_id', $user)
                ->groupBy('attempt', 'created_at')
                ->get();

            $test->attempts = $attempts;

            foreach ($attempts as $attempt) {
                $attempt->created_at = Carbon::parse($attempt->created_at)->format('d.m.Y H:i');
            }
        }

        return $tests;
    }

    public function show($test, $attempt, $user = null)
    {
        if (!$user) {
            $user = auth()->id();
        }

        $testId = DB::table('test')
            ->select('id')
            ->where('title', $test)
            ->first();

        return DB::table('user_answer')
            ->join('question', 'question.id', '=', 'user_answer.question_id')
            ->select('user_answer.is_correct', 'user_answer.text as user_answer', 'question.text as question', 'question.answer')
            ->where('user_id', $user)
            ->where('user_answer.test_id', $testId->id)
            ->where('attempt', $attempt)
            ->get();
    }
}
