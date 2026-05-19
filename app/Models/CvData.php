<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CvData extends Model {
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'phone',
        'location',
        'linkedin_url',
        'github_username',
        'summary',
        'skills',
        'experience',
        'projects',
        'education',
        'languages'
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'projects' => 'array',
        'education' => 'array',
        'languages' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
