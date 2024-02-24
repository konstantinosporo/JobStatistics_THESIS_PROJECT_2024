<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

// Public Routes (Out of auth)
Route::get('/', function () {
  return view('index');
});
// Language handling
Route::get('/switch-language/{locale?}', [LanguageController::class, 'switchLanguage'])
  ->name('switch.language');

//Sign up/in/out
Route::post('/signUp', [UserController::class, "createUser"])->name('createUser');
Route::post('/signIn', [UserController::class, "signInUser"]);
Route::get('/signOutUser', [UserController::class, 'signOutUser'])->name('signOut');

// Index Routes
Route::get('/index', [RedirectionsController::class, "indexRedirect"])->name("index");
Route::get('/signIn', [RedirectionsController::class, "signInRedirect"])->name("signIn");
Route::get('/signUp', [RedirectionsController::class, "signUpRedirect"])->name("signUp");

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {

  //(USER)
  Route::middleware(['user'])->group(function () {
    // Index route
    Route::get('/indexStudent', [RedirectionsController::class, 'signedInRedirect'])->name('indexStudent');

    // Job Search and Statistics Routes
    Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
    Route::get('/statistics', [JobController::class, 'statistics'])->name('statistics');
    Route::get('/showGraphType1', [JobController::class, 'showGraphType1'])->name('graphType1');

    // (AJAX) Routes user/recruiter/admin
    Route::get('/suggest-job-categories', [JobController::class, 'suggestJobCategories']);
    Route::get('/suggest-job-categories/pie', [JobController::class, 'suggestJobCategoriesPie']);
    Route::get('/get-job-description', [JobDescriptionController::class, 'getJobDescription']);

    // CV Routes
    Route::get('/createCv', [CvController::class, 'create'])->name('createCv');
    Route::post('/storeCv', [CvController::class, 'store'])->name('storeCv');
    Route::get('/editCv', [CvController::class, 'edit'])->name('editCv');
    Route::post('/editCv', [CVController::class, 'update'])->name('updateCv');
    Route::delete('/deleteCV', [CVController::class, 'delete'])->name('deleteCv');

    // Applicant(User) Routes
    Route::get('/job_listings/applicant', [JobListingController::class, 'showJobListingsForApplicants'])
      ->name('job_listings.applicant_index');
    Route::post('/job_listings/applicant/{jobListing}', [JobListingController::class, 'apply'])
      ->name('job_listings.applicant');
  });

  //(ADMIN)
  Route::middleware(['admin'])->group(function () {
    //Admin Index
    Route::get('/signedInAdmin', [RedirectionsController::class, 'signedInAdminRedirect'])->name('signedInAdmin');
    //Edit jobs descriptions
    Route::get('/admin/index-jobs', [AdminController::class, 'viewJobs'])->name('admin.jobs.indexDescriptions');
    Route::get('/admin/edit-jobs/{id}', [AdminController::class, 'editJobs'])->name('admin.jobs.editDescriptions');
    Route::patch('admin/jobs/edit/{id}', [AdminController::class, 'updateJobDescription'])->name('admin.jobs.update');
    //AJAX
    Route::get('/suggest-job-categories/admin', [AdminController::class, 'suggestJobCategoriesAdmin']);
    // Delete job description
    Route::delete('admin/jobs/delete/{id}', [AdminController::class, 'deleteJobDescription'])->name('admin.jobs.delete');
    //View/Edit Users
    Route::get('/admin/index-users', [AdminController::class, 'viewUsers'])->name('admin.viewUsers.indexViewUsers');
    // Edit user rights
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.viewUsers.editUser');
    Route::patch('admin/user/edit/{id}', [AdminController::class, 'updateUser'])->name('admin.viewUsers.updateUser');
    // Delete user
    Route::delete('admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.viewUsers.delete');
  });


  // (RECRUITER)
  Route::middleware(['recruiter'])->group(function () {
    Route::get('/signedInRecruiter', [RedirectionsController::class, 'signedInRecruiterRedirect'])->name('signedInRecruiter');
    Route::get('/job_listings', [JobListingController::class, 'index'])->name('job_listings.index');
    Route::post('/job_listings', [JobListingController::class, 'store'])->name('job_listings.store');
    Route::get('/job_listings/create', [JobListingController::class, 'create'])->name('job_listings.create');
    Route::get('/job_listings/view', [JobListingController::class, 'showJobListingsForRecruiters'])->name('recruiter.job_listings.view');
    Route::get('/job_listings/edit/{id}', [JobListingController::class, 'edit'])->name('job_listings.edit');
    Route::patch('/job_listings/{id}', [JobListingController::class, 'update'])->name('job_listings.update');
    Route::delete('/job_listings/{jobListing}', [JobListingController::class, 'destroy'])->name('job_listings.destroy');
    Route::get('/job_listings/applicants', [JobListingController::class, 'showApplicants'])->name('job_listings.showApplicants');
    Route::get('/suggest-job-categories-recruiter', [JobListingController::class, 'getJobCategorySuggestions']);

    // View CV of the Applicant
    Route::get('/viewCv/{cv}', [CvController::class, 'view'])->name('viewCv');
    //View and send messages
    Route::get('/recruiter/messages', [MessageController::class, 'recruiterIndex'])->name('recruiter.messages.index');
  });

  // Messaging Routes
  Route::get('/messagesIndex', [MessageController::class, 'index'])->name('messages.index');
  Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
  // Messagin notification
  Route::get('/mark-messages-as-read', [MessageController::class, 'markAsRead'])->name('markMessagesAsRead');
  Route::get('/get-new-messages-count', [MessageController::class, 'getNewMessagesCount'])
    ->name('getNewMessagesCount');
  //Messagin Soft deleting
  Route::delete('/messages/{id}', [MessageController::class, 'softDestroy'])->name('messages.destroy');
});


// Resource Routes (Out of auth)
Route::resource('job-categories', JobCategoryController::class);
Route::resource('jobs', JobController::class);
