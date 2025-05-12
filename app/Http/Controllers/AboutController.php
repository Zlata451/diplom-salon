<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * 🧾 Показати публічну сторінку "Про нас"
     */
    public function show()
    {
        $note = About::where('section', 'note')->first();
        $info = About::where('section', 'info')->first();

        return view('about', compact('note', 'info'));
    }

    /**
     * ✏️ Показати форму редагування певної секції ("note" або "info")
     */
    public function edit($section)
    {
        if (!in_array($section, ['note', 'info'])) {
            abort(404);
        }

        $about = About::firstOrCreate(['section' => $section], ['content' => '']);
        return view('admin.about.edit', compact('about', 'section'));
    }

    /**
     * 💾 Оновити текст секції
     */
    public function update(Request $request, About $about)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $about->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('about')->with('success', 'Інформацію оновлено!');
    }
}
