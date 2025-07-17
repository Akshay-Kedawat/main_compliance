<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{LoginController, RegisterController, ForgotPasswordController, ResetPasswordController};
use App\Http\Controllers\Api\{CountryController, ProfileController, CategoryController, RegulationController, JurisdictionController, DocumentController, UserController, RoleController, PermissionController, QuizController, QuestionController};


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

Route::get('/list-country', [CountryController::class, 'getCountry']);

Route::middleware('api.auth')->group(function () {
    Route::get('/list-category', [CategoryController::class, 'index']);
    Route::post('/add-category', [CategoryController::class, 'store']);
    Route::post('/update-category', [CategoryController::class, 'update']);
    Route::post('/delete-category', [CategoryController::class, 'destroy']);

    Route::get('/list-regulation', [RegulationController::class, 'index']);
    Route::post('/add-regulation', [RegulationController::class, 'store']);
    Route::post('/update-regulation', [RegulationController::class, 'update']);
    Route::post('/delete-regulation', [RegulationController::class, 'destroy']);

    Route::get('/list-jurisdiction', [JurisdictionController::class, 'index']);
    Route::post('/add-jurisdiction', [JurisdictionController::class, 'store']);
    Route::post('/update-jurisdiction', [JurisdictionController::class, 'update']);
    Route::post('/delete-jurisdiction', [JurisdictionController::class, 'destroy']);

    Route::get('/list-user', [UserController::class, 'index']);
    Route::post('/add-user', [UserController::class, 'store']);
    Route::post('/update-user', [UserController::class, 'update']);
    Route::post('/delete-user', [UserController::class, 'destroy']);

    Route::get('/list-document', [DocumentController::class, 'index']);
    Route::post('/add-document', [DocumentController::class, 'store']);

    Route::get('/list-role', [RoleController::class, 'index']);
    Route::post('/assign-role-permission', [RoleController::class, 'assignRolePermission']);
    
    Route::get('/list-permission', [PermissionController::class, 'index']);

    Route::get('/list-quiz', [QuizController::class, 'index']);
    Route::post('/add-quiz', [QuizController::class, 'store']);
    Route::post('/update-quiz', [QuizController::class, 'update']);
    Route::post('/delete-quiz', [QuizController::class, 'destroy']);

    Route::get('/list-question', [QuestionController::class, 'index']);
    Route::post('/add-question', [QuestionController::class, 'store']);
    Route::post('/update-question', [QuestionController::class, 'update']);
    Route::post('/delete-question', [QuestionController::class, 'destroy']);

    Route::get('my-profile', [ProfileController::class,'getProfile']);
    Route::get('logout', [ProfileController::class,'logout']);
});