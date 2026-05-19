<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class JobPosting extends Model {
    use HasFactory;
    protected $fillable = ['company_id', 'category_id', 'title', 'description', 'location', 'type', 'salary', 'status'];
    public function company() { return $this->belongsTo(Company::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function applications() { return $this->hasMany(JobApplication::class); }
}
