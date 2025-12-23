<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a single content page
     */
    public function show(string $slug)
    {
        $content = Content::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('content.show', compact('content'));
    }

    /**
     * List blog posts
     */
    public function blogIndex()
    {
        $posts = Content::published()
            ->type('blog')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('content.blog-index', compact('posts'));
    }
}
