<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;

// Homepage
Route::get('/', function () {
    return view('welcome-simple');
})->name('welcome');

// Login Selection Page
Route::get('/login-selection', function () {
    return view('auth.login-selection');
})->name('login.selection')->middleware('guest');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login-simple');
})->name('login')->middleware('guest');

Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, request()->boolean('remember'))) {
        request()->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.post')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register-simple');
})->name('register')->middleware('guest');

Route::post('/register', function () {
    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user',
    ]);

    Auth::login($user);

    return redirect()->route('dashboard');
})->name('register.post')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

// Admin Login Routes
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login')->middleware('guest');

Route::post('/admin/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, request()->boolean('remember'))) {
        $user = Auth::user();

        // Check if user is admin
        if (!$user->isAdmin()) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akses ditolak. Hanya admin yang dapat login melalui halaman ini.',
            ])->onlyInput('email');
        }

        request()->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('admin.login.post')->middleware('guest');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    // Borrowings
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings'])->name('borrowings.my');
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow'])->name('books.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    // Admin Book Management
    Route::get('/admin/books', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        $books = \App\Models\Book::with('category')->paginate(15);
        $categories = \App\Models\Category::all();

        return view('admin.books.index-simple', compact('books', 'categories'));
    })->name('admin.books.index');

    Route::get('/admin/books/create', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('admin.books.create-simple', compact('categories'));
    })->name('admin.books.create');

    Route::post('/admin/books', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $validated['available_stock'] = $validated['stock'];

        \App\Models\Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    })->name('admin.books.store');

    Route::get('/admin/books/{book}/edit', function (\App\Models\Book $book) {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('admin.books.edit-simple', compact('book', 'categories'));
    })->name('admin.books.edit');

    Route::put('/admin/books/{book}', function (\App\Models\Book $book) {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        // Update available stock based on the difference
        $stockDifference = $validated['stock'] - $book->stock;
        $validated['available_stock'] = $book->available_stock + $stockDifference;

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    })->name('admin.books.update');

    Route::delete('/admin/books/{book}', function (\App\Models\Book $book) {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Check if book has active borrowings
        $activeBorrowings = $book->borrowings()->where('status', 'borrowed')->count();
        if ($activeBorrowings > 0) {
            return redirect()->route('admin.books.index')->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam!');
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    })->name('admin.books.destroy');

    // Admin User Management
    Route::get('/admin/users', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $users = \App\Models\User::paginate(15);

        return view('admin.users.index-simple', compact('users'));
    })->name('admin.users.index');

    // Admin Borrowing Management
    Route::get('/admin/borrowings', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $borrowings = \App\Models\Borrowing::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.borrowings.index-simple', compact('borrowings'));
    })->name('admin.borrowings.index');

    // Admin Categories Management
    Route::get('/admin/categories', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = \App\Models\Category::withCount('books')->paginate(10);

        return view('admin.categories.index-simple', compact('categories'));
    })->name('admin.categories.index');

    Route::post('/admin/categories', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        \App\Models\Category::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    })->name('admin.categories.store');

    Route::put('/admin/categories/{category}', function (\App\Models\Category $category) {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    })->name('admin.categories.update');

    Route::delete('/admin/categories/{category}', function (\App\Models\Category $category) {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Check if category has books
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki buku!');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    })->name('admin.categories.destroy');
});
