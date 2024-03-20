<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Board\BoardController;
use App\Http\Controllers\Board\ProfileController;
use App\Http\Controllers\Board\AdminController;
use App\Http\Controllers\Board\CategoryController;
use App\Http\Controllers\Board\SettingController;
use App\Http\Controllers\Board\CountryController;
use App\Http\Controllers\Board\UniversityController;
use App\Http\Controllers\Board\UserController;
use App\Http\Controllers\Board\CourseController;
use App\Http\Controllers\Board\TrainerController;
use App\Http\Controllers\Board\CourseInstallmentController;
use App\Http\Controllers\Board\PackageController;
use App\Http\Controllers\Board\CourseUnitController;
use App\Http\Controllers\Board\LessonController;
use App\Http\Controllers\Board\PurchaseController;
use App\Http\Controllers\Board\UploadLessonVideoController;
use App\Http\Controllers\Board\UserInstallmentController;
use App\Http\Controllers\Board\TransactionController;
use App\Http\Controllers\Board\PackageInstallmentController;
use App\Http\Controllers\Board\PageController;
use App\Http\Controllers\Board\CourseReviewController;
use App\Http\Controllers\Board\AjaxController;
use App\Http\Controllers\Board\ReportConttroller;



use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\PayInstallmentController;

Route::get('error' , function(Request $request){
   $status = 'error';
   $message = 'تم الدفع بنجاح';
   return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status));
});

Route::get('/test' ,[TestController::class , 'index'] );
Route::get('/test2' ,[TestController::class , 'index2'] );
// Route::get('/test' ,[MyFatoorahController::class , 'index'] );

Route::get('/' , function(){
    if (Auth::check()) {
        return redirect(route('board.index'));
    }
    return redirect(route('login'));
});


Route::group(['prefix' => 'Board' , 'as' => 'board.'  ], function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/' , [BoardController::class , 'index'] )->name('index');
        Route::get('/profile' , [ProfileController::class , 'index'] )->name('profile');
        Route::patch('/profile' , [ProfileController::class , 'update'] )->name('profile.update');
        Route::get('/logout' , [ProfileController::class , 'logout'] )->name('profile.logout');
        Route::resource('admins', AdminController::class); // done
        Route::resource('users', UserController::class); // done
        Route::resource('categories', CategoryController::class); // done
        Route::resource('countries', CountryController::class);  // done
        Route::resource('universities', UniversityController::class);  // done
        Route::resource('courses', CourseController::class);  // done
        Route::resource('packages', PackageController::class);  // done
        Route::resource('trainers', TrainerController::class);  // done
        Route::resource('courses.units', CourseUnitController::class);  // done
        Route::resource('courses.units.lessons', LessonController::class);  // done
        Route::resource('pages', PageController::class);  // done
        Route::resource('reviews', CourseReviewController::class);

        Route::get('purchases' , [PurchaseController::class ,'index'] )->name('purchases.index');
        Route::get('purchases/{purchase}' , [PurchaseController::class ,'show'] )->name('purchases.show');
        Route::get('purchases/{purchase}/installments' , [PurchaseController::class ,'installments'] )->name('purchases.installments');
        Route::get('purchases/{purchase}/transaction' , [PurchaseController::class ,'transaction'] )->name('purchases.transaction');
        Route::get('purchases/{purchase}/transactions' , [PurchaseController::class ,'transactions'] )->name('purchases.transactions');

        Route::get('transactions' , [TransactionController::class , 'index'] )->name('transactions.index');
        Route::get('transactions/{transaction}'  , [TransactionController::class , 'show'] )->name('transactions.show');

        Route::get('installments' , [UserInstallmentController::class , 'index'] )->name('installments.index');
        Route::get('installments/{installment}' , [UserInstallmentController::class , 'show'] )->name('installments.show');

        Route::get('courses/{course}/students' , [CourseController::class , 'students'] )->name('courses.students');
        Route::get('courses/{course}/reviews' , [CourseController::class , 'reviews'] )->name('courses.reviews');

        Route::get('courses/{course}/installments' , [CourseInstallmentController::class , 'index'] )->name('courses.installments.index');
        Route::get('/courses/{course}/installments/create' , [CourseInstallmentController::class , 'create'] )->name('courses.installments.create');
        Route::post('/courses/{course}/installments' , [CourseInstallmentController::class , 'store'] )->name('courses.installments.store');
        Route::get('/courses/{course}/installments/{installment}/edit' , [CourseInstallmentController::class , 'edit'] )->name('courses.installments.edit');
        Route::patch('/courses/{course}/installments/{installment}' , [CourseInstallmentController::class , 'update'] )->name('courses.installments.update');
        Route::get('/courses/{course}/installments/{installment}', [CourseInstallmentController::class , 'show'] )->name('courses.installments.show');
        
        Route::get('/packages/{package}/courses/create' , [PackageController::class , 'add_course_to_package'] )->name('packages.courses.create');
        Route::get('/packages/{package}/courses' , [PackageController::class , 'show_packge_courses'] )->name('packages.courses.index');
        Route::post('/packages/{package}/courses' , [PackageController::class , 'store_course_to_package'] )->name('packages.courses.store');
        Route::post('proccess_video_uploads' , [UploadLessonVideoController::class , 'store'] )->name('proccess_video_uploads');
        Route::patch('proccess_video_uploads' , [UploadLessonVideoController::class , 'store'] )->name('proccess_video_uploads');
        Route::get('users/{user}/courses' , [UserController::class , 'courses'] )->name('users.courses');
        Route::get('users/{user}/purchases' , [UserController::class , 'purchases'] )->name('users.purchases');
        Route::get('users/{user}/transactions' , [UserController::class , 'transactions'] )->name('users.transactions');
        Route::get('users/{user}/installments' , [UserController::class , 'installments'] )->name('users.installments');
        Route::resource('packages.installments', PackageInstallmentController::class);
        Route::get('packages/{package}/students' , [PackageController::class , 'students'] )->name('packages.students');
        Route::get('packages/{package}/reviews' , [PackageController::class , 'reviews'] )->name('packages.reviews');
        Route::get('get_courses_depend_on_university_id' , [AjaxController::class , 'get_courses_depend_on_university_id'] )->name('get_courses_depend_on_university_id');
        Route::get('settings/social' , [SettingController::class , 'edit'] )->name('settings.social.edit');
        Route::patch('settings/social' , [SettingController::class , 'update'] )->name('settings.social.update');
        Route::get('settings/payments' , [SettingController::class , 'edit_payments'] )->name('settings.payments.edit');
        Route::patch('settings/payments' , [SettingController::class , 'update_payments'] )->name('settings.payments.update');
        Route::get('settings/reviews' , [SettingController::class , 'edit_reviews'] )->name('settings.reviews.edit');
        Route::patch('settings/reviews' , [SettingController::class , 'update_reviews'] )->name('settings.reviews.update');

        Route::get('/reports/courses/subscriptions' , [ReportConttroller::class , 'courses_subscriptions'] )->name('courses.subscriptions.report');
        Route::get('/reports/total_courses/subscriptions' , [ReportConttroller::class , 'total_courses_subscriptions'] )->name('courses.total.subscriptions.report');
    });
});



Route::get('orders/{order:order_number}/pay' , [CheckoutController::class , 'pay' ]  )->name('orders.pay');
Route::get('orders/{order:order_number}/myfatoorah/callback' , [CheckoutController::class , 'myfatoorah_callback'])->name('myfatoorah.callback');
Route::get('orders/{order:order_number}/bank_misr/callback' , [CheckoutController::class , 'bank_misr_callback' ])->name('bank_misr_callback.callback');
    
Route::get('installments/{installment:installment_number}/myfatoorah/pay' , [PayInstallmentController::class , 'pay_with_myfatoorah'] )->name('installments.myfatoorah.pay');
Route::get('installments/{installment:installment_number}/myfatoorah/callback',[PayInstallmentController::class , 'myfatoorah_callback'] )->name('myfatoorah.installments.callback');
Route::get('installments/{installment:installment_number}/myfatoorah/error/callback',[PayInstallmentController::class , 'myfatoorah_errorcallback'] )->name('myfatoorah.installments.errorCallback');

Route::get('installments/{installment:installment_number}/bank-misr/pay' , [PayInstallmentController::class , 'pay_with_bank_misr'] )->name('installments.bank_misr.pay');
Route::get('installments/{installment:installment_number}/bank-misr/callback' , [PayInstallmentController::class , 'bank_misr_callback'] )->name('bank_misr_callback.installments.callback');

require __DIR__.'/auth.php';



