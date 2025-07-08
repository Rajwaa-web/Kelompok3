<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    private function userDashboard()
    {
        $user = Auth::user();

        $borrowedBooks = $user->borrowings()
            ->where('status', 'borrowed')
            ->count();

        $returnedBooks = $user->borrowings()
            ->where('status', 'returned')
            ->count();

        $totalBorrowings = $user->borrowings()->count();

        $totalFines = $user->borrowings()
            ->sum('fine_amount');

        $recentBorrowings = $user->borrowings()
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $popularBooks = Book::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard-simple', compact(
            'borrowedBooks',
            'returnedBooks',
            'totalBorrowings',
            'totalFines',
            'recentBorrowings',
            'popularBooks'
        ));
    }

    private function adminDashboard()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();
        $overdueBorrowings = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->count();

        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $popularBooks = Book::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.admin-simple', compact(
            'totalBooks',
            'totalUsers',
            'activeBorrowings',
            'overdueBorrowings',
            'recentBorrowings',
            'popularBooks'
        ));
    }
}
