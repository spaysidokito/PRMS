<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResourceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('student-profiles', StudentProfileController::class);

    // Student's own profile routes
    Route::get('/my-profile', [StudentProfileController::class, 'myProfile'])->name('my-profile');
    Route::get('/my-profile/edit', [StudentProfileController::class, 'editMyProfile'])->name('my-profile.edit');
    Route::put('/my-profile/update', [StudentProfileController::class, 'updateMyProfile'])->name('my-profile.update');

    // Form Submissions
    Route::prefix('form-submissions')->name('form-submissions.')->group(function () {
        // Student routes
        Route::get('/my-submissions', [App\Http\Controllers\FormSubmissionController::class, 'mySubmissions'])->name('my-submissions');
        Route::get('/create', [App\Http\Controllers\FormSubmissionController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\FormSubmissionController::class, 'store'])->name('store');

        // Admin/Staff routes
        Route::get('/', [App\Http\Controllers\FormSubmissionController::class, 'index'])->name('index');
        Route::get('/{formSubmission}', [App\Http\Controllers\FormSubmissionController::class, 'show'])->name('show');
        Route::get('/{formSubmission}/print', [App\Http\Controllers\FormSubmissionController::class, 'print'])->name('print');
        Route::put('/{formSubmission}/status', [App\Http\Controllers\FormSubmissionController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{formSubmission}', [App\Http\Controllers\FormSubmissionController::class, 'destroy'])->name('destroy');
    });

    Route::resource('events', EventController::class);

    Route::get('/resources', function () {
        return view('resources.index');
    })->name('resources.index');

    // Resource Management Routes
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/soa', [App\Http\Controllers\ResourceController::class, 'soa'])->name('soa');
        Route::get('/gtc', [App\Http\Controllers\ResourceController::class, 'gtc'])->name('gtc');
        Route::get('/pod', [App\Http\Controllers\ResourceController::class, 'pod'])->name('pod');

        // Admin management routes
        Route::get('/manage-soa', [App\Http\Controllers\ResourceController::class, 'manageSoa'])->name('manage-soa');
        Route::get('/manage-gtc', [App\Http\Controllers\ResourceController::class, 'manageGtc'])->name('manage-gtc');
        Route::get('/manage-pod', [App\Http\Controllers\ResourceController::class, 'managePod'])->name('manage-pod');

        // Form CRUD routes
        Route::post('/forms', [App\Http\Controllers\ResourceController::class, 'storeForm'])->name('forms.store');
        Route::put('/forms/{id}', [App\Http\Controllers\ResourceController::class, 'updateForm'])->name('forms.update');
        Route::delete('/forms/{id}', [App\Http\Controllers\ResourceController::class, 'destroyForm'])->name('forms.destroy');
        Route::post('/forms/{id}/upload', [App\Http\Controllers\ResourceController::class, 'uploadFormFile'])->name('forms.upload');

        Route::post('/soa/store', [App\Http\Controllers\ResourceController::class, 'soaStore'])->name('soa.store');
        Route::post('/gtc/store', [App\Http\Controllers\ResourceController::class, 'gtcStore'])->name('gtc.store');
        Route::post('/pod/store', [App\Http\Controllers\ResourceController::class, 'podStore'])->name('pod.store');

        // SOA Form Upload and Download Routes
        Route::post('/soa/upload', [App\Http\Controllers\ResourceController::class, 'soaUpload'])->name('soa.upload');
        Route::get('/soa/download', [App\Http\Controllers\ResourceController::class, 'soaDownloadFile'])->name('soa.download');
        Route::get('/soa/preview', [App\Http\Controllers\ResourceController::class, 'soaPreview'])->name('soa.preview');

        // GTC Form Upload and Download Routes
        Route::post('/gtc/upload', [App\Http\Controllers\ResourceController::class, 'gtcUpload'])->name('gtc.upload');
        Route::get('/gtc/download', [App\Http\Controllers\ResourceController::class, 'gtcDownloadFile'])->name('gtc.download');
        Route::get('/gtc/preview', [App\Http\Controllers\ResourceController::class, 'gtcPreview'])->name('gtc.preview');

        // SOA Template Routes
        Route::get('/soa/template/preview', [App\Http\Controllers\ResourceController::class, 'soaTemplatePreview'])->name('soa.template.preview');
        Route::get('/soa/template/download', [App\Http\Controllers\ResourceController::class, 'soaTemplateDownload'])->name('soa.template.download');

        // GTC Template Routes
        Route::get('/gtc/template/preview', [App\Http\Controllers\ResourceController::class, 'gtcTemplatePreview'])->name('gtc.template.preview');
        Route::get('/gtc/template/download', [App\Http\Controllers\ResourceController::class, 'gtcTemplateDownload'])->name('gtc.template.download');

        Route::get('/gtc/download', [App\Http\Controllers\ResourceController::class, 'gtcDownload'])->name('gtc.download');
        Route::get('/pod/download', [App\Http\Controllers\ResourceController::class, 'podDownload'])->name('pod.download');

        Route::get('/soa/print', [App\Http\Controllers\ResourceController::class, 'soaPrint'])->name('soa.print');
        Route::get('/gtc/print', [App\Http\Controllers\ResourceController::class, 'gtcPrint'])->name('gtc.print');
        Route::get('/pod/print', [App\Http\Controllers\ResourceController::class, 'podPrint'])->name('pod.print');
    });

    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');

    // My Documents Routes (Students)
    Route::prefix('my-documents')->name('my-documents.')->group(function () {
        Route::get('/', [App\Http\Controllers\StudentDocumentController::class, 'index'])->name('index');
        Route::post('/store', [App\Http\Controllers\StudentDocumentController::class, 'store'])->name('store');
        Route::get('/{id}/download', [App\Http\Controllers\StudentDocumentController::class, 'download'])->name('download');
        Route::delete('/{id}', [App\Http\Controllers\StudentDocumentController::class, 'destroy'])->name('destroy');
    });

    // Analytics Routes (Faculty/Staff and Admin only)
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('index');
        Route::get('/export', [App\Http\Controllers\AnalyticsController::class, 'export'])->name('export');
    });
});
