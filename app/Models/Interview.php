<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'questions',
        'question_types',
        'mcq_options',
        'rating_labels',
        'created_by',
    ];

    protected $casts = [
        'questions' => 'array',
        'question_types' => 'array',
        'mcq_options' => 'array',
        'rating_labels' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
