<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'candidate_id',
        'answers',
        'video_answers',
        'score',
        'comments',
    ];

    protected $casts = [
        'answers' => 'array',
        'video_answers' => 'array',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }
}
