<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\PaymentController;
use App\Models\Like;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user_id = Auth::id();
    $profile_data = null;
    $profile_data = Profile::getDetailByCondition($user_id);
    $my_info = User::find($user_id);

    $search_flg = isset($_GET['search_flg']) ? $_GET['search_flg'] : null;
    $name = isset($_GET['name']) ? $_GET['name'] : null;

    if($search_flg == 1){
        //検索であれば以下の処理
        $condition = [
            'name' => $name
        ];

        $user_list = User::getListByCondition($condition);

    }else {

        if($my_info['gender'] == 1){
            //女性のユーザーリスト

            $condition = [
                'gender' => 2,
            ];

            $user_list = User::getListByCondition($condition);

        }else{
            //男のユーザーリスト
            $condition = [
                'gender' => 1,
            ];

            $user_list = User::getListByCondition($condition);
        }

    }

    $like_count = Like::Where('target_user_id', $user_id)->count();

    return Inertia::render('Dashboard', [
        'profile_data' => $profile_data,
        'user_list' => $user_list,
        'like_count' => $like_count,
        'user_id' => $user_id,
    ]);


})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile_setting_page', [ProfileController::class, 'profile_setting_page']);
    Route::post('/set_profile', [ProfileController::class, 'set_profile']);

});

Route::get('/user_detail_page', [UserController::class, 'user_detail_page']);
Route::get('/send_good', [UserController::class, 'send_good']);
Route::get('/my_good_like_page', [UserController::class, 'my_good_like_page']);
Route::get('/thank_you_like_other_user', [UserController::class, 'thank_you_like_other_user']);
Route::get('/thank_you_like_other_user', [UserController::class, 'thank_you_like_other_user']);
Route::post('/search_user', [UserController::class, 'search_user']);
Route::get('/my_page', [UserController::class, 'my_page']);
Route::get('/plan_edit_page', [UserController::class, 'plan_edit_page']);
Route::get('/upgrade_plan_page', [UserController::class, 'upgrade_plan_page']);


Route::get('/matching_list_page', [MatchingController::class, 'matching_list_page']);
Route::get('/matching_talk_page', [MatchingController::class, 'matching_talk_page']);
Route::post('/send_message', [MatchingController::class, 'send_message']);
Route::post('/delete_message', [MatchingController::class, 'delete_message']);


Route::post('/register_credit_card', [PaymentController::class, 'register_credit_card']);



require __DIR__.'/auth.php';
