<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Event extends Model {
    use HasFactory;
    protected $fillable = ['company_id', 'title', 'description', 'scheduled_at', 'link'];
    public function company() { return $this->belongsTo(Company::class); }
}
