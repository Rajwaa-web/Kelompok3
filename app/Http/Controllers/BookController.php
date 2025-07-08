<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->get('category') != '') {
            $query->where('category_id', $request->get('category'));
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('books.index-simple', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        return view('books.show-simple', compact('book'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $books = Book::with('category')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->orWhere('isbn', 'like', "%{$query}%")
            ->paginate(12);

        return view('books.search', compact('books', 'query'));
    }
}
