<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Software Development', 'Marketing', 'Design', 'Sales', 'Customer Support'];
        foreach ($categories as $name) {
            Category::create(['name' => $name, 'slug' => Str::slug($name)]);
        }
    }
}
