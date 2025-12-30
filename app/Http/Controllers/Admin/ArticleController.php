<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 1. ADMIN: List all articles
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
        }

        $articles = $query->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    // 2. ADMIN: Create Form
    public function create()
    {
        return view('admin.articles.create');
    }

    // 3. ADMIN: Store Article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        Article::create($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'مقاله آموزشی ثبت شد.');
    }

    // 4. ADMIN: Edit Form
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    // 5. ADMIN: Update Article
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $article->update($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'مقاله ویرایش شد.');
    }

    // 6. ADMIN: Delete Article
    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'مقاله حذف شد.');
    }

    // 7. PUBLIC USER: Knowledge Base Index (Searchable)
    public function kbIndex(Request $request)
    {
        $query = Article::where('is_published', true);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        $articles = $query->latest()->get(); // Get all for the user page (or paginate if many)
        
        return view('knowledge-base.index', compact('articles'));
    }
}