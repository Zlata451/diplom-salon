<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Відображення всіх новин.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->get();
        return view('news.index', compact('news'));
    }

    /**
     * Відображення однієї новини.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }
}
