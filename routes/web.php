<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\WorkingHourController;
use App\Http\Controllers\ServicePublicController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PublicMasterController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\MasterApiController;
use App\Models\News;

// 🏠 Головна сторінка (з новинами)
Route::get('/', function () {
    $news = News::latest('published_at')->take(3)->get();
    return view('home', compact('news'));
})->name('home');

// 📖 Про нас (публічна сторінка)
Route::get('/about', [AboutController::class, 'show'])->name('about');

// 📞 Контакти (публічна сторінка)
Route::get('/contact', [ContactController::class, 'show'])->name('contact');

// 🧑‍💻 Дашборд (залишено для сумісності)
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

    // 🔄 Окреме оновлення тільки статусу
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // ✏️ Редагування запису
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    // 🔥 Запис на конкретну послугу
    Route::get('/services/{service}/book', [AppointmentController::class, 'book'])->name('appointments.book');

    // 🔥 Запис до обраного майстра
    Route::get('/masters/{master}/book', [AppointmentController::class, 'bookWithMaster'])->name('appointments.bookWithMaster');

    // 🔁 Повторити запис
    Route::get('/appointments/{appointment}/repeat', [AppointmentController::class, 'repeat'])->name('appointments.repeat');

    // 🧾 Мої записи
    Route::get('/my-appointments', [AppointmentController::class, 'my'])->name('appointments.my');
});

// 🛠️ Адмін-панель
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('masters', MasterController::class);
    Route::resource('news', NewsController::class);

    // ✏️ Редагування графіку роботи
    Route::get('masters/{master}/working-hours', [WorkingHourController::class, 'edit'])->name('working-hours.edit');
    Route::post('masters/{master}/working-hours', [WorkingHourController::class, 'update'])->name('working-hours.update');

    // ✏️ Редагування секцій "Про нас"
    Route::get('/about/{section}/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::patch('/about/{about}', [AboutController::class, 'update'])->name('about.update');

    // ✏️ Редагування "Контактів"
    Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::patch('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');
});

// 🌐 Публічні сторінки
Route::get('/services', [ServicePublicController::class, 'index'])->name('services.index');
Route::get('/masters', [PublicMasterController::class, 'index'])->name('masters.index');

// 📰 Публічні новини
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [PublicNewsController::class, 'show'])->name('news.show');

// 📡 API: Отримання майстрів по послузі (для JavaScript)
Route::get('/api/services/{service}/masters', [MasterApiController::class, 'getByService']);

require __DIR__.'/auth.php';
