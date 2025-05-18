<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Видалити відгук.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Відгук успішно видалено!');
    }
}
