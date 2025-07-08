<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Auth::user()->borrowings()
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    public function myBorrowings()
    {
        $activeBorrowings = Auth::user()->borrowings()
            ->with('book')
            ->where('status', 'borrowed')
            ->orderBy('due_date', 'asc')
            ->get();

        $history = Auth::user()->borrowings()
            ->with('book')
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc')
            ->paginate(10);

        return view('borrowings.my-borrowings-simple', compact('activeBorrowings', 'history'));
    }

    public function borrow(Request $request, Book $book)
    {
        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Check if user already borrowed this book
        $existingBorrowing = Auth::user()->borrowings()
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        // Create borrowing record
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // 2 weeks borrowing period
            'status' => 'borrowed',
        ]);

        // Update book availability
        $book->decrement('available_stock');

        return back()->with('success', 'Buku berhasil dipinjam. Batas pengembalian: ' . $borrowing->due_date->format('d M Y'));
    }

    public function return(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowing->status !== 'borrowed') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $borrowing->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        // Update book availability
        $borrowing->book->increment('available_stock');

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function history()
    {
        $borrowings = Auth::user()->borrowings()
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('borrowings.history', compact('borrowings'));
    }
}
