<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AdminDesaController;
use App\Http\Controllers\Web\AdminEducationController;
use App\Http\Controllers\Web\AdminPatientController;
use App\Http\Controllers\Web\AdminInstrumentController;
use App\Http\Controllers\Web\AdminLogController;
use App\Http\Controllers\Web\AdminPharmacologyController;
use App\Http\Controllers\Web\AssessmentAdminController;
use App\Http\Controllers\Web\AssessmentController;
use App\Http\Controllers\Web\InstrumentController;
use App\Http\Controllers\Web\MedicationController;
use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::redirect('/', '/login')->name('landing');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [PageController::class, 'doLogin'])->name('login.post');
    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/register', [PageController::class, 'doRegister'])->name('register.post');
    Route::post('/resend-verification', [PageController::class, 'resendVerificationWeb'])->name('verification.resend');
    Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/new-password', [PageController::class, 'newPassword'])->name('new-password');
});

// Email verification
Route::get('/success-verification', fn () => view('success-verification', ['user' => auth()->user()]))
    ->middleware('auth')->name('success-verification');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::redirect('/home', '/admin')->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Education
    Route::get('/education', [PageController::class, 'education'])->name('education');
    Route::get('/education/{slug}', [PageController::class, 'educationDetail'])->name('education.detail');
    Route::get('/education/{categorySlug}/{articleSlug}', [PageController::class, 'educationShow'])->name('education.article');

    // Blood Sugar
    Route::get('/blood-sugar', [PageController::class, 'bloodSugar'])->name('blood-sugar');
    Route::get('/blood-sugar/gdp', [PageController::class, 'bloodSugarGdp'])->name('blood-sugar.gdp');
    Route::get('/blood-sugar/gds', [PageController::class, 'bloodSugarGds'])->name('blood-sugar.gds');
    Route::get('/blood-sugar/tutorial', [PageController::class, 'bloodSugarTutorial'])->name('blood-sugar.tutorial');
    Route::post('/blood-sugar/save', [PageController::class, 'saveBloodSugar'])->name('blood-sugar.save');
    Route::get('/blood-sugar/history', [PageController::class, 'bloodSugarHistory'])->name('blood-sugar.history');

    // Weight Tracking
    Route::get('/health/weight', [PageController::class, 'weightLog'])->name('weight.log');
    Route::post('/health/weight', [PageController::class, 'saveWeight'])->name('weight.save');

    // Foot Screening
    Route::get('/foot-screening', [PageController::class, 'footScreening'])->name('foot-screening');
    Route::get('/foot-screening/survey', [PageController::class, 'footScreeningSurvey'])->name('foot-screening.survey');
    Route::post('/foot-screening/result', [PageController::class, 'footScreeningResult'])->name('foot-screening.result');
    Route::get('/foot-screening/history', [PageController::class, 'footScreeningHistory'])->name('foot-screening.history');
    Route::get('/foot-screening/history/{id}', [PageController::class, 'footScreeningDetail'])->name('foot-screening.detail');

    // Nutrition Therapy
    Route::get('/tnt', [PageController::class, 'tnt'])->name('tnt');
    Route::post('/tnt/calculate', [PageController::class, 'tntCalculate'])->name('tnt.calculate');
    Route::get('/tnt/history', [PageController::class, 'tntHistory'])->name('tnt.history');
    Route::get('/tnt/history/{id}', [PageController::class, 'tntDetail'])->name('tnt.detail');
    Route::post('/tnt/save', [PageController::class, 'tntSave'])->name('tnt.save');

    // Assessment Diabetes Foot
    Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
    Route::get('/assessment/start', [AssessmentController::class, 'start'])->name('assessment.start');
    Route::get('/assessment/riwayat', [AssessmentController::class, 'history'])->name('assessment.history');
    Route::get('/assessment/riwayat/{id}', [AssessmentController::class, 'detail'])->name('assessment.detail');
    Route::get('/assessment/{groupSlug}', [AssessmentController::class, 'step'])->name('assessment.step');
    Route::post('/assessment/{groupSlug}', [AssessmentController::class, 'saveStep'])->name('assessment.save');
    Route::get('/assessment-review', [AssessmentController::class, 'review'])->name('assessment.review');

    // Pharmacology
    Route::get('/pharmacology', [PageController::class, 'pharmacology'])->name('pharmacology');

    // Medications
    Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
    Route::get('/medications/create', [MedicationController::class, 'create'])->name('medications.create');
    Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
    Route::get('/medications/{id}/edit', [MedicationController::class, 'edit'])->name('medications.edit');
    Route::put('/medications/{id}', [MedicationController::class, 'update'])->name('medications.update');
    Route::delete('/medications/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');

    // Profile
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [PageController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile/update', [PageController::class, 'profileUpdate'])->name('profile.update');

    // Change Password
    Route::get('/change-password', [PageController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [PageController::class, 'doChangePassword'])->name('change.password.update');

    // Instrument Keyakinan
    Route::get('/instrument', [InstrumentController::class, 'index'])->name('instruments.index');
    Route::post('/instrument', [InstrumentController::class, 'store'])->name('instruments.store');
    Route::get('/instrument/result/{id}', [InstrumentController::class, 'result'])->name('instruments.result');
    Route::get('/instrument/history', [InstrumentController::class, 'history'])->name('instruments.history');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('admin.users.detail');
    Route::get('/users/{id}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::get('/users/{userId}/assessments/{resultId}', [AdminController::class, 'userAssessmentDetail'])->name('admin.assessments.result.detail');

    // Data Entry (select patient & redirect to form)
    Route::get('/data-entry/select-patient', [AdminController::class, 'showSelectPatient'])->name('admin.data-entry.select-patient');
    Route::post('/data-entry/select', [AdminController::class, 'selectDataEntryUser'])->name('admin.data-entry.select');
    Route::get('/data-entry/clear', [AdminController::class, 'clearDataEntrySession'])->name('admin.data-entry.clear');

    // Desa (Superadmin only)
    Route::middleware('superadmin')->group(function () {
        Route::get('/desa', [AdminDesaController::class, 'index'])->name('admin.desa.index');
        Route::get('/desa/create', [AdminDesaController::class, 'create'])->name('admin.desa.create');
        Route::post('/desa', [AdminDesaController::class, 'store'])->name('admin.desa.store');
        Route::get('/desa/{id}/edit', [AdminDesaController::class, 'edit'])->name('admin.desa.edit');
        Route::put('/desa/{id}', [AdminDesaController::class, 'update'])->name('admin.desa.update');
        Route::delete('/desa/{id}', [AdminDesaController::class, 'destroy'])->name('admin.desa.destroy');
    });

    // Patients
    Route::get('/patients', [AdminPatientController::class, 'index'])->name('admin.patients.index');
    Route::get('/patients/create', [AdminPatientController::class, 'create'])->name('admin.patients.create');
    Route::post('/patients', [AdminPatientController::class, 'store'])->name('admin.patients.store');
    Route::get('/patients/{id}/edit', [AdminPatientController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/patients/{id}', [AdminPatientController::class, 'update'])->name('admin.patients.update');
    Route::delete('/patients/{id}', [AdminPatientController::class, 'destroy'])->name('admin.patients.destroy');
    Route::get('/kader-by-desa/{desaId}', [AdminPatientController::class, 'kaderByDesa'])->name('admin.kader.by.desa');

    // Assessment management
    Route::get('/assessments', [AssessmentAdminController::class, 'index'])->name('admin.assessments.index');
    Route::get('/assessments/create', [AssessmentAdminController::class, 'create'])->name('admin.assessments.create');
    Route::post('/assessments', [AssessmentAdminController::class, 'store'])->name('admin.assessments.store');
    Route::get('/assessments/{id}/edit', [AssessmentAdminController::class, 'edit'])->name('admin.assessments.edit');
    Route::put('/assessments/{id}', [AssessmentAdminController::class, 'update'])->name('admin.assessments.update');
    Route::delete('/assessments/{id}', [AssessmentAdminController::class, 'destroy'])->name('admin.assessments.destroy');

    // Sub-groups
    Route::get('/assessments/{groupId}/sub-groups/create', [AssessmentAdminController::class, 'createSubGroup'])->name('admin.assessments.sub-groups.create');
    Route::post('/assessments/{groupId}/sub-groups', [AssessmentAdminController::class, 'storeSubGroup'])->name('admin.assessments.sub-groups.store');
    Route::get('/assessments/{groupId}/sub-groups/{subGroupId}/edit', [AssessmentAdminController::class, 'editSubGroup'])->name('admin.assessments.sub-groups.edit');
    Route::put('/assessments/{groupId}/sub-groups/{subGroupId}', [AssessmentAdminController::class, 'updateSubGroup'])->name('admin.assessments.sub-groups.update');
    Route::delete('/assessments/{groupId}/sub-groups/{subGroupId}', [AssessmentAdminController::class, 'destroySubGroup'])->name('admin.assessments.sub-groups.destroy');

    // Options
    Route::get('/assessments/{groupId}/sub-groups/{subGroupId}/options', [AssessmentAdminController::class, 'indexOptions'])->name('admin.assessments.options.index');
    Route::get('/assessments/{groupId}/sub-groups/{subGroupId}/options/create', [AssessmentAdminController::class, 'createOption'])->name('admin.assessments.options.create');
    Route::post('/assessments/{groupId}/sub-groups/{subGroupId}/options', [AssessmentAdminController::class, 'storeOption'])->name('admin.assessments.options.store');
    Route::get('/assessments/{groupId}/sub-groups/{subGroupId}/options/{optionId}/edit', [AssessmentAdminController::class, 'editOption'])->name('admin.assessments.options.edit');
    Route::put('/assessments/{groupId}/sub-groups/{subGroupId}/options/{optionId}', [AssessmentAdminController::class, 'updateOption'])->name('admin.assessments.options.update');
    Route::delete('/assessments/{groupId}/sub-groups/{subGroupId}/options/{optionId}', [AssessmentAdminController::class, 'destroyOption'])->name('admin.assessments.options.destroy');

    // Rules
    Route::get('/assessments/rules', [AssessmentAdminController::class, 'indexRules'])->name('admin.assessments.rules.index');
    Route::get('/assessments/rules/create', [AssessmentAdminController::class, 'createRule'])->name('admin.assessments.rules.create');
    Route::post('/assessments/rules', [AssessmentAdminController::class, 'storeRule'])->name('admin.assessments.rules.store');
    Route::get('/assessments/rules/{id}/edit', [AssessmentAdminController::class, 'editRule'])->name('admin.assessments.rules.edit');
    Route::put('/assessments/rules/{id}', [AssessmentAdminController::class, 'updateRule'])->name('admin.assessments.rules.update');
    Route::delete('/assessments/rules/{id}', [AssessmentAdminController::class, 'destroyRule'])->name('admin.assessments.rules.destroy');

    // Rule Categories
    Route::get('/assessments/categories/create', [AssessmentAdminController::class, 'createRuleCategory'])->name('admin.assessments.categories.create');
    Route::post('/assessments/categories', [AssessmentAdminController::class, 'storeRuleCategory'])->name('admin.assessments.categories.store');
    Route::get('/assessments/categories/{id}/edit', [AssessmentAdminController::class, 'editRuleCategory'])->name('admin.assessments.categories.edit');
    Route::put('/assessments/categories/{id}', [AssessmentAdminController::class, 'updateRuleCategory'])->name('admin.assessments.categories.update');
    Route::delete('/assessments/categories/{id}', [AssessmentAdminController::class, 'destroyRuleCategory'])->name('admin.assessments.categories.destroy');

    // Conclusions
    Route::get('/assessments/conclusions', [AssessmentAdminController::class, 'indexConclusions'])->name('admin.assessments.conclusions.index');
    Route::get('/assessments/conclusions/create', [AssessmentAdminController::class, 'createConclusion'])->name('admin.assessments.conclusions.create');
    Route::post('/assessments/conclusions', [AssessmentAdminController::class, 'storeConclusion'])->name('admin.assessments.conclusions.store');
    Route::get('/assessments/conclusions/{id}/edit', [AssessmentAdminController::class, 'editConclusion'])->name('admin.assessments.conclusions.edit');
    Route::put('/assessments/conclusions/{id}', [AssessmentAdminController::class, 'updateConclusion'])->name('admin.assessments.conclusions.update');
    Route::delete('/assessments/conclusions/{id}', [AssessmentAdminController::class, 'destroyConclusion'])->name('admin.assessments.conclusions.destroy');

    // Monitoring
    Route::get('/monitoring/foot-screening', [AdminController::class, 'monitoringFootScreening'])->name('admin.monitoring.foot-screening');
    Route::get('/monitoring/foot-screening/{id}', [AdminController::class, 'monitoringFootScreeningDetail'])->name('admin.monitoring.foot-screening.detail');
    Route::get('/monitoring/assessments', [AdminController::class, 'monitoringAssessments'])->name('admin.monitoring.assessments');
    Route::get('/monitoring/assessments/export', [AdminController::class, 'exportAssessments'])->name('admin.monitoring.assessments.export');
    Route::get('/monitoring/blood-sugar', [AdminController::class, 'monitoringBloodSugar'])->name('admin.monitoring.blood-sugar');
    Route::get('/monitoring/blood-sugar/export', [AdminController::class, 'exportBloodSugar'])->name('admin.monitoring.blood-sugar.export');

    Route::get('/monitoring/education', [AdminController::class, 'monitoringEducation'])->name('admin.monitoring.education');
    Route::get('/monitoring/education/{categorySlug}', [AdminController::class, 'monitoringEducationArticles'])->name('admin.monitoring.education.articles');
    Route::get('/monitoring/education/{categorySlug}/{articleSlug}', [AdminController::class, 'monitoringEducationDetail'])->name('admin.monitoring.education.detail');

    // Monitoring delete (non-puskesmas only)
    Route::middleware('non_puskesmas')->group(function () {
        Route::delete('/monitoring/foot-screening/{id}', [AdminController::class, 'monitoringFootScreeningDestroy'])->name('admin.monitoring.foot-screening.destroy');
        Route::delete('/monitoring/assessments/{id}', [AdminController::class, 'monitoringAssessmentDestroy'])->name('admin.monitoring.assessments.destroy');
        Route::delete('/monitoring/blood-sugar/{id}', [AdminController::class, 'monitoringBloodSugarDestroy'])->name('admin.monitoring.blood-sugar.destroy');
    });

    // Instrument Keyakinan
    Route::get('/instruments', [AdminInstrumentController::class, 'index'])->name('admin.instruments.index');
    Route::post('/instruments/groups', [AdminInstrumentController::class, 'storeGroup'])->name('admin.instruments.groups.store');
    Route::put('/instruments/groups/{id}', [AdminInstrumentController::class, 'updateGroup'])->name('admin.instruments.groups.update');
    Route::delete('/instruments/groups/{id}', [AdminInstrumentController::class, 'destroyGroup'])->name('admin.instruments.groups.destroy');
    Route::get('/instruments/{groupId}/questions/create', [AdminInstrumentController::class, 'createQuestion'])->name('admin.instruments.questions.create');
    Route::post('/instruments/{groupId}/questions', [AdminInstrumentController::class, 'storeQuestion'])->name('admin.instruments.questions.store');
    Route::get('/instruments/questions/{id}/edit', [AdminInstrumentController::class, 'editQuestion'])->name('admin.instruments.questions.edit');
    Route::put('/instruments/questions/{id}', [AdminInstrumentController::class, 'updateQuestion'])->name('admin.instruments.questions.update');
    Route::delete('/instruments/questions/{id}', [AdminInstrumentController::class, 'destroyQuestion'])->name('admin.instruments.questions.destroy');
    Route::get('/instruments/results', [AdminInstrumentController::class, 'results'])->name('admin.instruments.results');
    Route::get('/instruments/results/export', [AdminInstrumentController::class, 'exportResults'])->name('admin.instruments.results.export');
    Route::get('/instruments/results/{id}', [AdminInstrumentController::class, 'resultDetail'])->name('admin.instruments.results.detail');
    Route::middleware('non_puskesmas')->delete('/instruments/results/{id}', [AdminInstrumentController::class, 'destroyResult'])->name('admin.instruments.results.destroy');

    // Education
    Route::get('/education', [AdminEducationController::class, 'index'])->name('admin.education.index');
    Route::post('/education/categories', [AdminEducationController::class, 'storeCategory'])->name('admin.education.categories.store');
    Route::put('/education/categories/{id}', [AdminEducationController::class, 'updateCategory'])->name('admin.education.categories.update');
    Route::delete('/education/categories/{id}', [AdminEducationController::class, 'destroyCategory'])->name('admin.education.categories.destroy');
    Route::get('/education/{categoryId}/articles', [AdminEducationController::class, 'articles'])->name('admin.education.articles');
    Route::get('/education/{categoryId}/articles/create', [AdminEducationController::class, 'createArticle'])->name('admin.education.articles.create');
    Route::post('/education/{categoryId}/articles', [AdminEducationController::class, 'storeArticle'])->name('admin.education.articles.store');
    Route::get('/education/articles/{id}/edit', [AdminEducationController::class, 'editArticle'])->name('admin.education.articles.edit');
    Route::put('/education/articles/{id}', [AdminEducationController::class, 'updateArticle'])->name('admin.education.articles.update');
    Route::delete('/education/articles/{id}', [AdminEducationController::class, 'destroyArticle'])->name('admin.education.articles.destroy');

    // Log System
    Route::get('/logs', [AdminLogController::class, 'index'])->name('admin.logs');
    Route::get('/logs/data', [AdminLogController::class, 'data'])->name('admin.logs.data');
    Route::get('/logs/export', [AdminLogController::class, 'export'])->name('admin.logs.export');

    // Farmakologi
    Route::get('/pharmacology', [AdminPharmacologyController::class, 'index'])->name('admin.pharmacology.index');
    Route::get('/pharmacology/create', [AdminPharmacologyController::class, 'create'])->name('admin.pharmacology.create');
    Route::post('/pharmacology', [AdminPharmacologyController::class, 'store'])->name('admin.pharmacology.store');
    Route::get('/pharmacology/{id}/edit', [AdminPharmacologyController::class, 'edit'])->name('admin.pharmacology.edit');
    Route::put('/pharmacology/{id}', [AdminPharmacologyController::class, 'update'])->name('admin.pharmacology.update');
    Route::delete('/pharmacology/{id}', [AdminPharmacologyController::class, 'destroy'])->name('admin.pharmacology.destroy');
    Route::get('/pharmacology/export', [AdminPharmacologyController::class, 'export'])->name('admin.pharmacology.export');
});

// Static pages (public)
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/privasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/syarat-ketentuan', [PageController::class, 'terms'])->name('terms');

// Webview pages
Route::get('/tutorial-check-gula-darah', fn () => view('webview.gula-darah'))->name('tutorial.gula-darah');
Route::get('/tutorial-cara-perawatan-hipoglekimia', fn () => view('webview.hipoglekimia'))->name('tutorial.hipoglekimia');
Route::get('/tutorial-cara-perawatan-hiperglikemia', fn () => view('webview.hiperglikemia'))->name('tutorial.hiperglikemia');
Route::get('/recomendasi-foot', [PageController::class, 'recommendationFoot'])->name('recommendation.foot');
