<?php

namespace App\Http\Controllers;

use App\Enums\QuestionTypeEnum;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Test;
use App\Rules\ChoicesSize;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Test::withCount('questions')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'questions' => 'array|min:3'
        ]);

        DB::transaction(function () use ($validated, $request) {

            $test = Test::create([
                'title' => $validated['title'],
            ]);

            foreach ($request['questions'] as $question) {
                $question['test_id'] = $test->id;
                $this->createQuestion($question);
            }
        });

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Test::with('questions.choices')->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $test = Test::find($id);

        $validated = $request->validate([
            'title' => 'required',
            'questions' => 'array|min:3'
        ]);

        DB::transaction(function () use ($validated, $request, $test) {
            $test->title = $validated['title'];
            $test->save();

            $test->questions()->delete();

            foreach ($request['questions'] as $question) {
                $question['test_id'] = $test->id;

                $this->createQuestion($question);
            }

        });

        return response()->json(['message' => 'Test updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Test::destroy($id);
    }

    private function createQuestion($question)
    {
        $validator = \Validator::make($question, [
            'text' => 'required|string',
            'type' => ['required', new Enum(QuestionTypeEnum::class)],
            'test_id' => 'exists:App\Models\Test,id',
            'answer' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) use ($question) {
                    if ($question['type'] == QuestionTypeEnum::MULTIPLE_CHOICES->value) {
                        $choicesValues = array_column($question['choices'], 'text');
                        if (!in_array($value, $choicesValues)) {
                            $fail("The {$attribute} needs to be present in choices.");
                        }
                    }
                }],
            'choices' =>  function (string $attribute, mixed $value, Closure $fail) use ($question) {
                if ($question['type'] == QuestionTypeEnum::MULTIPLE_CHOICES->value) {
                    if (count($question['choices']) < 2) {
                        $fail("The {$attribute} needs at least 2 options.");
                    }
                }
            },
        ]);

        $questionInDB = Question::create($validator->validated());

        if ($questionInDB->type == QuestionTypeEnum::MULTIPLE_CHOICES->value) {
            foreach ($question['choices'] as $choice) {
                $choice['question_id'] = $questionInDB->id;
                $this->createChoice($choice);
            }
        }
    }

    private function createChoice($choice)
    {
        $validator = \Validator::make($choice, [
            'text' => 'required|string',
            'question_id' => 'exists:App\Models\Question,id',
        ]);

        return Choice::create($validator->validated());
    }
}
