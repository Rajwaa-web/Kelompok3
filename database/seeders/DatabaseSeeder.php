<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user (update existing test user)
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->update(['role' => 'user']);
        } else {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create categories
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Buku-buku tentang teknologi dan komputer'],
            ['name' => 'Sastra', 'description' => 'Novel, puisi, dan karya sastra lainnya'],
            ['name' => 'Sains', 'description' => 'Buku-buku ilmu pengetahuan alam'],
            ['name' => 'Sejarah', 'description' => 'Buku-buku sejarah dan biografi'],
            ['name' => 'Ekonomi', 'description' => 'Buku-buku ekonomi dan bisnis'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample books
        $books = [
            [
                'title' => 'Laravel: Up & Running',
                'author' => 'Matt Stauffer',
                'isbn' => '9781492041207',
                'description' => 'A comprehensive guide to Laravel framework',
                'category_id' => 1,
                'stock' => 5,
                'available_stock' => 5,
                'publisher' => "O'Reilly Media",
                'publication_year' => 2019,
                'cover' => 'laravel-up-and-running.jpg',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'description' => 'A handbook of agile software craftsmanship',
                'category_id' => 1,
                'stock' => 3,
                'available_stock' => 3,
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'cover' => 'clean-code.jpg',
            ],
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789792248074',
                'description' => 'Novel tentang perjuangan anak-anak Belitung',
                'category_id' => 2,
                'stock' => 4,
                'available_stock' => 4,
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'cover' => 'laskar-pelangi.jpg',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'description' => 'The story of how we humans went from insignificant apes to rulers of the world',
                'category_id' => 4,
                'stock' => 2,
                'available_stock' => 2,
                'publisher' => 'Harper',
                'publication_year' => 2015,
                'cover' => 'sapiens.jpg',
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'isbn' => '9780307887894',
                'description' => 'How todays entrepreneurs use continuous innovation to create radically successful businesses',
                'category_id' => 5,
                'stock' => 3,
                'available_stock' => 3,
                'publisher' => 'Crown Business',
                'publication_year' => 2011,
                'cover' => 'lean-startup.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Copy sample cover images to storage/app/public/covers (manual step: place images in this folder)
    }
}
