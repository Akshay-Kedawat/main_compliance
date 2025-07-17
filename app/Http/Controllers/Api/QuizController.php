<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Quiz\{CreateQuizRequest, UpdateQuizRequest, DeleteQuizRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Quiz;
use JWTAuth;

class QuizController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $quiz = Quiz::orderByDesc('id')->get();

            if (count($quiz) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-quiz');
                $this->data    = $quiz;
            } else {
                DB::rollback();
                $this->status  = false;
                $this->message = trans('message.data_not_found');
                $this->data    = (object) [];
            }
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function store(CreateQuizRequest $request)
    {
        DB::beginTransaction();
        try {
            $quiz              = new Quiz;
            $quiz->title	   = $request->title;
            $quiz->duration    = $request->duration;
            $quiz->description = $request->description;
            $quiz->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-quiz');
            $this->data    = $quiz;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function update(UpdateQuizRequest $request)
    {
        DB::beginTransaction();
        try {
            $quiz = Quiz::find($request->quiz_id);
            $quiz->title	   = $request->title;
            $quiz->duration    = $request->duration;
            $quiz->description = $request->description;
            $quiz->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.update-quiz');
            $this->data    = $quiz;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function destroy(DeleteQuizRequest $request)
    {
        DB::beginTransaction();
        try {
            Quiz::find($request->quiz_id)->delete();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.delete-quiz');
            $this->data    = (object) [];
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
