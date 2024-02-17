<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\Backend\SocialServiceController;
use App\Http\Controllers\Backend\PortfolioImageController;
use App\Http\Controllers\Backend\PortfolioVideoController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\HeadingController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AppointmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/',function(){
//return view('construction');
//});
Auth::routes(['login'=>false,'home'=>false,'register'=>false]);
Route::get('/',[FrontendController::class,'frontendPage'])->name('frontend.home');
Route::get('/jamana_login',[\App\Http\Controllers\Auth\LoginController::class,'loginPage'])->name('backend.login');
Route::post('/jamana_login',[\App\Http\Controllers\Auth\LoginController::class,'adminLogin'])->name('backend.jamana_login');
Route::get('/jamana_register',[\App\Http\Controllers\Auth\RegisterController::class,'registerPage'])->name('backend.register');
Route::post('/jamana_register',[\App\Http\Controllers\Auth\RegisterController::class,'adminRegister'])->name('backend.jamana_register');
Route::get('/login', function () {
    abort(404);
});
Route::get('/register', function () {
    abort(404);
});
Route::get('/logout', function () {
    abort(404);
});
Route::get('/gallery',[FrontendController::class,'frontendGallery'])->name('frontend.gallery');
Route::get('/services',[FrontendController::class,'frontendServices'])->name('frontend.services');
Route::get('/service_post/{id}',[FrontendController::class,'servicePost'])->name('frontend.service_post');
Route::get('/blogs',[FrontendController::class,'frontendBlogs'])->name('frontend.blogs');
Route::get('/blog_post/{id}',[FrontendController::class,'blogPost'])->name('frontend.blog_post');
Route::get('/about',[FrontendController::class,'aboutUs'])->name('frontend.about');
Route::get('/contact',[FrontendController::class,'contact'])->name('frontend.contact');
Route::post('/contactForm',[FrontendController::class,'contactStore'])->name('frontend.contact.store');
Route::post('/contactServiceId',[FrontendController::class,'serviceId'])->name('frontend.service_id');
Route::middleware(['auth'])->group(function () {
    Route::get('/jamana_home',function(){
    return view('home');
    })->name('backend.home');
    //setting route
    Route::get('backend/setting/trash', [SettingController::class, 'trash'])->name('backend.setting.trash');
    Route::delete('backend/setting/permanentDelete/{id}', [SettingController::class, 'permanentDelete'])->name('backend.setting.permanentDelete');
    Route::get('backend/setting/restore/{id}', [SettingController::class, 'restore'])->name('backend.setting.restore');
    Route::resource('backend/setting', SettingController::class)->names('backend.setting');
    //social_services route
    Route::get('backend/social_medias/trash', [SocialServiceController::class, 'trash'])->name('backend.social_medias.trash');
    Route::delete('backend/social_medias/permanentDelete/{id}', [SocialServiceController::class, 'permanentDelete'])->name('backend.social_medias.permanentDelete');
    Route::get('backend/social_medias/restore/{id}', [SocialServiceController::class, 'restore'])->name('backend.social_medias.restore');
    Route::resource('backend/social_medias', SocialServiceController::class)->names('backend.social_medias');
    //portfolio images route
    Route::get('backend/portfolio_images/trash', [PortfolioImageController::class, 'trash'])->name('backend.portfolio_images.trash');
    Route::delete('backend/portfolio_images/permanentDelete/{id}', [PortfolioImageController::class, 'permanentDelete'])->name('backend.portfolio_images.permanentDelete');
    Route::get('backend/portfolio_images/restore/{id}', [PortfolioImageController::class, 'restore'])->name('backend.portfolio_images.restore');
    Route::resource('backend/portfolio_images', PortfolioImageController::class)->names('backend.portfolio_images');
    //portfolio videos route
    Route::get('backend/portfolio_videos/trash', [PortfolioVideoController::class, 'trash'])->name('backend.portfolio_videos.trash');
    Route::delete('backend/portfolio_videos/permanentDelete/{id}', [PortfolioVideoController::class, 'permanentDelete'])->name('backend.portfolio_videos.permanentDelete');
    Route::get('backend/portfolio_videos/restore/{id}', [PortfolioVideoController::class, 'restore'])->name('backend.portfolio_videos.restore');
    Route::resource('backend/portfolio_videos', PortfolioVideoController::class)->names('backend.portfolio_videos');
    //services route
    Route::get('backend/services/trash', [ServiceController::class, 'trash'])->name('backend.services.trash');
    Route::delete('backend/services/permanentDelete/{id}', [ServiceController::class, 'permanentDelete'])->name('backend.services.permanentDelete');
    Route::get('backend/services/restore/{id}', [ServiceController::class, 'restore'])->name('backend.services.restore');
    Route::resource('backend/services', ServiceController::class)->names('backend.services');
    //heading route
    Route::get('backend/headings/trash', [HeadingController::class, 'trash'])->name('backend.headings.trash');
    Route::delete('backend/headings/permanentDelete/{id}', [HeadingController::class, 'permanentDelete'])->name('backend.headings.permanentDelete');
    Route::get('backend/headings/restore/{id}', [HeadingController::class, 'restore'])->name('backend.headings.restore');
    Route::resource('backend/headings', HeadingController::class)->names('backend.headings');
    //faq route
    Route::get('backend/faq/trash', [FaqController::class, 'trash'])->name('backend.faq.trash');
    Route::delete('backend/faq/permanentDelete/{id}', [FaqController::class, 'permanentDelete'])->name('backend.faq.permanentDelete');
    Route::get('backend/faq/restore/{id}', [FaqController::class, 'restore'])->name('backend.faq.restore');
    Route::resource('backend/faq', FaqController::class)->names('backend.faq');
    //teams route
    Route::get('backend/teams/trash', [TeamController::class, 'trash'])->name('backend.teams.trash');
    Route::delete('backend/teams/permanentDelete/{id}', [TeamController::class, 'permanentDelete'])->name('backend.teams.permanentDelete');
    Route::get('backend/teams/restore/{id}', [TeamController::class, 'restore'])->name('backend.teams.restore');
    Route::resource('backend/teams', TeamController::class)->names('backend.teams');
    //permission route
    Route::get('backend/permissions/trash', [PermissionController::class, 'trash'])->name('backend.permissions.trash');
    Route::delete('backend/permissions/permanentDelete/{id}', [PermissionController::class, 'permanentDelete'])->name('backend.permissions.permanentDelete');
    Route::get('backend/permissions/restore/{id}', [PermissionController::class, 'restore'])->name('backend.permissions.restore');
    Route::resource('backend/permissions', PermissionController::class)->names('backend.permissions');
    //blogs route
    Route::get('backend/blogs/trash', [BlogController::class, 'trash'])->name('backend.blogs.trash');
    Route::delete('backend/blogs/permanentDelete/{id}', [BlogController::class, 'permanentDelete'])->name('backend.blogs.permanentDelete');
    Route::get('backend/blogs/restore/{id}', [BlogController::class, 'restore'])->name('backend.blogs.restore');
    Route::resource('backend/blogs', BlogController::class)->names('backend.blogs');
    //about route
    Route::get('backend/about/trash',[AboutController::class, 'trash'])->name('backend.about.trash');
    Route::get('backend/about/permanentDelete/{id}',[AboutController::class,'permanentDelete'])->name('backend.about.permanentDelete');
    Route::get('backend/about/restore/{id}',[AboutController::class,'restore'])->name('backend.about.restore');
    Route::resource('backend/about',AboutController::class)->names('backend.about');
    //appointment route
    Route::get('backend/appointment/trash', [AppointmentController::class, 'trash'])->name('backend.appointment.trash');
    Route::delete('backend/appointment/permanentDelete/{id}', [AppointmentController::class, 'permanentDelete'])->name('backend.appointment.permanentDelete');
    Route::get('backend/appointment/restore/{id}', [AppointmentController::class, 'restore'])->name('backend.appointment.restore');
    Route::resource('backend/appointment', AppointmentController::class)->names('backend.appointment');
});
