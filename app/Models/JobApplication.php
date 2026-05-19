<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class JobApplication extends Model {
    use HasFactory;
    protected $fillable = ['job_posting_id', 'user_id', 'resume_path', 'status', 'interview_at', 'meeting_link', 'quiz_score'];
    public function jobPosting() { return $this->belongsTo(JobPosting::class); }
    public function user() { return $this->belongsTo(User::class); }
}
