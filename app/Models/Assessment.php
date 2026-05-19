<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model {
    protected $fillable = ['job_posting_id', 'title'];
    public function questions() { return $this->hasMany(Question::class); }
}
