<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\InjurieController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SpecilizationController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Requests\EmailVerificationRequest as RequestsEmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Middleware\VerifyUser;

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




Route::prefix('user')->controller(UserController::class)->group(function () {

    Route::post('/register', [UserController::class,'register']);
    Route::get('/verfiy/{id}/{hash}',[UserController::class,'verfiyEmail'])->name("verfiy");
    Route::post('/login', [UserController::class,'login']);//->middleware(UserAuth::class);
    Route::post('/forgot', [UserController::class,'forgot']);//->middleware(UserAuth::class)->name('forgot');
    Route::post('/verfiy-reset-password/{token}',[UserController::class,'verfiyResetPassword'] )->name('password.reset');
    Route::post('/resetpassword', [UserController::class,'restPassword'])
    //->middleware([UserAuth::class])
    ->name('password.update');
    Route::post('/logout', [UserController::class,'logout'])->middleware(VerifyUser::class);

});


Route::post('admin/login', [AdminController::class,'login']);
Route::prefix('admin')->middleware(VerifyAdmin::class)->controller(UserController::class)->group(function () {

    //users
    Route::post('/add-user', [UserController::class,'register']);
    Route::post('/update-user/{id}', [UserController::class,'update']);
    Route::post('/delete-user/{id}', [UserController::class,'destroy']);
    Route::post('/users/{id?}', [UserController::class,'userList']);

    //sports
    Route::post('/add-sport', [SportController::class,'add']);
    Route::post('/update-sport/{id}', [SportController::class,'update']);
    Route::post('/delete-sport/{id}', [SportController::class,'delete']);
    Route::post('/sports/{id?}', [SportController::class,'list']);

    //positions
    Route::post('/add-position', [PositionController::class,'add']);
    Route::post('/update-position/{id}', [PositionController::class,'update']);
    Route::post('/delete-position/{id}', [PositionController::class,'delete']);
    Route::post('/positions/{id?}', [PositionController::class,'list']);

    //players
    Route::post('/add-player', [PlayerController::class,'add']);
    Route::post('/update-player/{id}', [PlayerController::class,'update']);
    Route::post('/delete-player/{id}', [PlayerController::class,'delete']);
    Route::post('/players/{id?}', [PlayerController::class,'list']);
    // achievement
    Route::post('/add-achievement', [AchievementController::class,'add']);
    Route::post('/update-achievement/{id}', [AchievementController::class,'update']);
    Route::post('/delete-achievement/{id}', [AchievementController::class,'delete']);
    Route::post('/achievements/{id?}', [AchievementController::class,'list']);
    // skill
    Route::post('/add-skill', [SkillController::class,'add']);
    Route::post('/update-skill/{id}', [SkillController::class,'update']);
    Route::post('/delete-skill/{id}', [SkillController::class,'delete']);
    Route::post('/skills/{id?}', [SkillController::class,'list']);
    // injurie
    Route::post('/add-injurie', [InjurieController::class,'add']);
    Route::post('/update-injurie/{id}', [InjurieController::class,'update']);
    Route::post('/delete-injurie/{id}', [InjurieController::class,'delete']);
    Route::post('/injuries/{id?}', [InjurieController::class,'list']);




    //specilization
    Route::post('/add-specilization', [SpecilizationController::class,'add']);
    Route::post('/update-specilization/{id}', [SpecilizationController::class,'update']);
    Route::post('/delete-specilization/{id}', [SpecilizationController::class,'delete']);
    Route::post('/specilizations/{id?}', [SpecilizationController::class,'list']);

    //coach
    Route::post('/add-coach', [CoachController::class,'add']);
    Route::post('/update-coach/{id}', [CoachController::class,'update']);
    Route::post('/delete-coach/{id}', [CoachController::class,'delete']);
    Route::post('/coachs/{id?}', [CoachController::class,'list']);

     // experience
     Route::post('/add-experience', [ExperienceController::class,'add']);
     Route::post('/update-experience/{id}', [ExperienceController::class,'update']);
     Route::post('/delete-experience/{id}', [ExperienceController::class,'delete']);
     Route::post('/experiences/{id?}', [ExperienceController::class,'list']);
     // licence
     Route::post('/add-licence', [LicenceController::class,'add']);
     Route::post('/update-licence/{id}', [LicenceController::class,'update']);
     Route::post('/delete-licence/{id}', [LicenceController::class,'delete']);
     Route::post('/licences/{id?}', [LicenceController::class,'list']);
     // award
     Route::post('/add-award', [AwardController::class,'add']);
     Route::post('/update-award/{id}', [AwardController::class,'update']);
     Route::post('/delete-award/{id}', [AwardController::class,'delete']);
     Route::post('/awards/{id?}', [AwardController::class,'list']);
    
     //club
     Route::post('/add-club', [ClubController::class,'add']);
     Route::post('/update-club/{id}', [ClubController::class,'update']);
     Route::post('/delete-club/{id}', [ClubController::class,'delete']);
     Route::post('/clubs/{id?}', [ClubController::class,'list']);

    // certificate
    Route::post('/add-certificate', [CertificateController::class,'add']);
    Route::post('/update-certificate/{id}', [CertificateController::class,'update']);
    Route::post('/delete-certificate/{id}', [CertificateController::class,'delete']);
    Route::post('/certificates/{id?}', [CertificateController::class,'list']);

    
});


















