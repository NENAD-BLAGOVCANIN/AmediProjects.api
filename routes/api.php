<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfileImageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\SummaryDayController;
use App\Http\Controllers\SummaryInstallationController;
use App\Http\Controllers\SummaryPlannerController;
use App\Http\Controllers\MonthlyCollectionController;
use App\Http\Controllers\PdfController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
});
    // make pdf
    Route::post('/makePdf', [PdfController::class, 'generatePdf']);
    Route::post('/makeAccountDetailsPdf', [PdfController::class, 'generateAccountDetailsPdf']);
    Route::post('/generate-pdf-and-send-email', [PdfController::class, 'generatePdfAndSendEmail']);
    Route::post('/generate-pdf-and-send-email-daily', [PdfController::class, 'generateDailyPdfAndSendEmail']);
    Route::post('/generate-pdf-and-send-email-weekly', [PdfController::class, 'generateWeeklyPdfAndSendEmail']);
    Route::post('/generate-pdf-and-send-collection-daily', [PdfController::class, 'generateDailyCollectionPdfAndSendEmail']);


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::get('/user/info', [UserController::class, 'info']);


    Route::post('/profile/image', [ProfileImageController::class, 'updateProfileImage']);

    // collections
    Route::get('/collections/sum-debt', [CollectionController::class, 'getSumOfDebt']);
    Route::get('collections', [CollectionController::class, 'index']);
    Route::post('collections', [CollectionController::class, 'store']);
    Route::get('collections/{collection}', [CollectionController::class, 'show']);
    Route::put('collections/{collection}', [CollectionController::class, 'update']);
    Route::delete('collections/{collection}', [CollectionController::class, 'destroy']);
    Route::put('/collections/{id}/archive', [CollectionController::class, 'updateArchiveStatus']);
    Route::put('/collections/{id}', [CollectionController::class, 'update']);

    // productions
    Route::get('productions', [ProductionController::class, 'index']);
    Route::post('productions', [ProductionController::class, 'store']);
    Route::get('productions/{production}', [ProductionController::class, 'show']);
    Route::put('productions/{production}', [ProductionController::class, 'update']);
    Route::delete('productions/{production}', [ProductionController::class, 'destroy']);
    Route::get('/productions-active-planning', [ProductionController::class, 'getActivePlanningProductions']);


    Route::get('/contacts', [ContactsController::class, 'index']);
    Route::post('/contacts', [ContactsController::class, 'store']);
    Route::get('/contacts/{id}', [ContactsController::class, 'show']);
    Route::put('/contacts/{id}', [ContactsController::class, 'update']);
    Route::delete('/contacts/{id}', [ContactsController::class, 'destroy']);
    // summary_installations
    Route::apiResource('summary_installations', SummaryInstallationController::class);
    // summary_planners
    Route::apiResource('summary_planners', SummaryPlannerController::class);

    Route::get('/projects-started', [ProjectController::class, 'getProjectsStartedPerMonth']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/my-projects', [ProjectController::class, 'myProjects']);
    Route::get('/project-info', [ProjectController::class, 'projectInfo']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::post('/switch-project', [ProjectController::class, 'switchProject']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/project', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    Route::get('/project/members', [ProjectController::class, 'projectMembers']);
    Route::get('/project-details/{id}', [ProjectController::class, 'getProjectDetails']);
    Route::post('/projects/image', [ProfileImageController::class, 'updateProjectImage']);
    Route::get('/project-collections-summary', [ProjectController::class, 'getProjectCollectionsSummary']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


    // summaryDay
    
    Route::get('/summary-days', [SummaryDayController::class, 'index']);
    Route::post('/summary-days', [SummaryDayController::class, 'store']);
    Route::get('/summary-days/{summaryDay}', [SummaryDayController::class, 'show']);
    Route::put('/summary-days/{summaryDay}', [SummaryDayController::class, 'update']);
    Route::delete('/summary-days/{summaryDay}', [SummaryDayController::class, 'destroy']);
    Route::get('/summary-days-id', [SummaryDayController::class, 'getCollectionSummary']);

    Route::get('/tasks', [TasksController::class, 'index']);
    Route::post('/tasks', [TasksController::class, 'store']);
    Route::post('/tasks/assign', [TasksController::class, 'assign']);
    Route::get('/tasks/{id}', [TasksController::class, 'show']);
    Route::put('/tasks/{id}', [TasksController::class, 'update']);
    Route::delete('/tasks/{id}', [TasksController::class, 'destroy']);
    Route::get('taskable-items', [TasksController::class, 'getTaskableItems']);
    Route::get('/tasks-with-users', [TasksController::class, 'allTasksWithUsers']);
    Route::put('/tasks/{id}/archive', [TasksController::class, 'updateArchiveStatus']);

    // MonthlyCollectionController
    Route::post('/monthly-collections', [MonthlyCollectionController::class, 'store']);
    Route::get('/monthly-collections', [MonthlyCollectionController::class, 'index']);
    Route::get('/monthly-collections/{id}', [MonthlyCollectionController::class, 'show']);
    Route::put('/monthly-collections/{id}', [MonthlyCollectionController::class, 'update']);
    Route::get('/monthly-collections-collected-this-month', [MonthlyCollectionController::class, 'getAmountCollectedThisMonth']);

    Route::get('/notifications', [NotificationsController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationsController::class, 'show']);
    Route::post('/notifications', [NotificationsController::class, 'store']);
    Route::put('/notifications/{id}', [NotificationsController::class, 'update']);
    Route::delete('/notifications/{id}', [NotificationsController::class, 'destroy']);
    // stations
    // Route::apiResource('stations', StationController::class);
    Route::get('/stations', [StationController::class, 'index']);
    Route::put('/stations/update/{project_id}', [StationController::class, 'updateStation']);


    Route::get('/leads', [LeadsController::class, 'index']);
    Route::post('/leads', [LeadsController::class, 'store']);
    Route::get('/leads/{id}', [LeadsController::class, 'show']);
    Route::put('/leads/{id}', [LeadsController::class, 'update']);
    Route::delete('/leads/{id}', [LeadsController::class, 'destroy']);

    Route::get('/clients', [ClientsController::class, 'index']);
    Route::post('/clients', [ClientsController::class, 'store']);
    Route::get('/clients/{id}', [ClientsController::class, 'show']);
    Route::put('/clients/{id}', [ClientsController::class, 'update']);
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);
    
    
    
    Route::get('/bonuses', [BonusController::class, 'index']);
    Route::get('/bonuses/{id}', [BonusController::class, 'getBonusById']); // New route for retrieving bonus by ID

    // Route::resource('bonuses', BonusController::class);
    
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
});

Route::post('/handle-invite-link', [ProjectController::class, 'inviteLink']);
