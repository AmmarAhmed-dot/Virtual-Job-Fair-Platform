<?php
namespace Database\Seeders;
use App\Models\JobPosting;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
class JobSeeder extends Seeder
{
    public function run()
    {
        $institute = User::where('role', 'institute')->first();
        if (!$institute) {
            $institute = User::create([
                'name' => 'Sample Institute',
                'email' => 'institute@sample.com',
                'password' => \Hash::make('password'),
                'role' => 'institute'
            ]);
            $institute->company()->create(['name' => 'Sample Tech Co']);
        }
        
        $category = Category::first();
        $company = $institute->company;

        JobPosting::create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'Software Engineer',
            'description' => 'We are looking for a Laravel developer.',
            'location' => 'Remote',
            'type' => 'Full-time',
            'salary' => '80k - 100k',
            'status' => 'approved'
        ]);

        JobPosting::create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'UI/UX Designer',
            'description' => 'Help us design beautiful interfaces.',
            'location' => 'Lahore',
            'type' => 'Contract',
            'salary' => '50k - 70k',
            'status' => 'approved'
        ]);
    }
}
