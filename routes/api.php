<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CaseStudyController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\JobApplicationController;
use App\Http\Controllers\Api\JobBoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
// Blog Category
    // create Blog Category
    Route::post('/blog-category/create', [BlogCategoryController::class, 'create']);
    // Blog Category list
    Route::get('/blog-category/list', [BlogCategoryController::class, 'list']);
    // update Blog Category
    Route::post('/blog-category/update/{id}', [BlogCategoryController::class, 'update']);
    // retrieve Blog Category
    Route::get('/blog-category/{id}', [BlogCategoryController::class, 'view']);
    // delete Blog Category
    Route::post('/blog-category/delete/{id}', [BlogCategoryController::class, 'drop']);

// Blog
    // create Blog
    Route::post('/blog/create', [BlogController::class, 'create']);
    // Blog list
    Route::get('/blog/list', [BlogController::class, 'list']);
    // update Blog
    Route::post('/blog/update/{id}', [BlogController::class, 'update']);
    // retrieve Blog
    Route::get('/blog/{id}', [BlogController::class, 'view']);
    // delete Blog
    Route::post('/blog/delete/{id}', [BlogController::class, 'drop']);
    // Post Images for Blog
    Route::post('/blog/image/', [BlogController::class, 'uploadImage']);

// Case Study
    // create case study
    Route::post('/case-study/create', [CaseStudyController::class, 'create']);
    // case study list
    Route::get('/case-study/list', [CaseStudyController::class, 'list']);
    // update case study
    Route::post('/case-study/update/{id}', [CaseStudyController::class, 'update']);
    // retrieve case study
    Route::get('/case-study/{id}', [CaseStudyController::class, 'view']);
    // delete case study
    Route::post('/case-study/delete/{id}', [CaseStudyController::class, 'drop']);

// Contact Us Queries
    // contact us queries list
    Route::get('/contact-us/list', [ContactUsController::class, 'list']);

// Job Board
    // create job
    Route::post('/job/create', [JobBoardController::class, 'create']);
    // job list
    Route::get('/job/list', [JobBoardController::class, 'list']);
    // update job
    Route::post('/job/update/{id}', [JobBoardController::class, 'update']);
    // retrieve job
    Route::get('/job/{id}', [JobBoardController::class, 'view']);
    // delete job
    Route::post('/job/delete/{id}', [JobBoardController::class, 'drop']);

// Job Application 
    // apply job
    Route::post('/job/apply', [JobApplicationController::class, 'create']);
    // job application list
    Route::get('/job-application/list', [JobApplicationController::class, 'list']);
    // update job application
    Route::post('/job-application/update/{id}', [JobApplicationController::class, 'update']);
    // retrieve job application
    Route::get('/job-application/{id}', [JobApplicationController::class, 'view']);
    // Retrieve job application by user ID
    Route::get('/user/job-applications/', [JobApplicationController::class, 'listByApplicant']);
    // Update job application status
    Route::post('/job-application/{job_id}/status', [JobApplicationController::class, 'updateJobStatus']);
    
    
// Users

    // Logout authenticated user 
    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);


});

// create contact query
Route::post('/contact-us/create', [ContactUsController::class, 'create']);

// case studies list
    Route::get('/public/case-study/list', [CaseStudyController::class, 'frontList']);
    Route::get('/public/case-study/{id}', [CaseStudyController::class, 'view']);

// Blog list
    Route::get('/public/blog/list', [BlogController::class, 'frontList']);
    Route::get('/public/blog/{slug}', [BlogController::class, 'view']);

// job list
    Route::get('/public/job/list', [JobBoardController::class, 'displayList']);

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);