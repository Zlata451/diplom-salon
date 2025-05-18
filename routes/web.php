<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\WorkingHourController;
use App\Http\Controllers\Admin\AppointmentToolsController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\ServicePublicController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PublicMasterController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Api\MasterApiController;
use App\Models\News;

// 🏠 Головна сторінка (з новинами)
Route::get('/', function () {
    $news = News::latest('published_at')->take(3)->get();
    return view('home', compact('news'));
})->name('home');

// 📖 Про нас
Route::get('/about', [AboutController::class, 'show'])->name('about');

// 📞 Контакти
Route::get('/contact', [ContactController::class, 'show'])->name('contact');

// 🧑‍💻 Дашборд
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Профіль користувача
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📆 Записи
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/services/{service}/book', [AppointmentController::class, 'book'])->name('appointments.book');
    Route::get('/masters/{master}/book', [AppointmentController::class, 'bookWithMaster'])->name('appointments.bookWithMaster');
    Route::get('/appointments/{appointment}/repeat', [AppointmentController::class, 'repeat'])->name('appointments.repeat');
    Route::get('/my-appointments', [AppointmentController::class, 'my'])->name('appointments.my');

    // 💬 Відгуки
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// 🛠️ Адмін-панель
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('masters', MasterController::class);
    Route::resource('news', NewsController::class);

    Route::get('masters/{master}/working-hours', [WorkingHourController::class, 'edit'])->name('working-hours.edit');
    Route::post('masters/{master}/working-hours', [WorkingHourController::class, 'update'])->name('working-hours.update');

    Route::get('/about/{section}/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::patch('/about/{about}', [AboutController::class, 'update'])->name('about.update');

    Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::patch('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');

    Route::post('/appointments/send-reminders', [AppointmentToolsController::class, 'sendReminders'])->name('appointments.sendReminders');
    Route::post('/appointments/update-statuses', [AppointmentToolsController::class, 'updateStatuses'])->name('appointments.updateStatuses');

    // 🗑️ Видалення відгуків (admin.reviews.destroy)
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});

// 🌐 Публічні сторінки
Route::get('/services', [ServicePublicController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServicePublicController::class, 'show'])->name('services.show');

Route::get('/masters', [PublicMasterController::class, 'index'])->name('masters.index');
Route::get('/masters/{master}', [PublicMasterController::class, 'show'])->name('masters.show');

// 📰 Новини
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [PublicNewsController::class, 'show'])->name('news.show');

// 📡 API
Route::get('/api/services/{service}/masters', [MasterApiController::class, 'getByService']);

require __DIR__.'/auth.php';
