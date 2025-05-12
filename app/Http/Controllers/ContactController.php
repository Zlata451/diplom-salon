<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // 🧾 Публічна сторінка з контактами
    public function show()
    {
        $contact = Contact::firstOrCreate([], [
            'phone' => '+38 (099) 123-45-67',
            'email' => 'info@beauty-salon.ua',
            'address' => 'вул. Гарна, 12, м. Львів, Україна',
            'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        ]);

        return view('contact', compact('contact'));
    }

    // ✏️ Форма редагування
    public function edit()
    {
        $contact = Contact::firstOrCreate([], [
            'phone' => '',
            'email' => '',
            'address' => '',
            'map' => '',
        ]);

        return view('admin.contact.edit', compact('contact'));
    }

    // 💾 Оновлення контактної інформації
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'map' => 'nullable|string',
        ]);

        $contact->update($request->only('phone', 'email', 'address', 'map'));

        return redirect()->route('contact')->with('success', 'Контактну інформацію оновлено!');
    }
}
