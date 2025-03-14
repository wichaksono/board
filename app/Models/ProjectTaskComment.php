<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTaskComment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['task_id', 'user_id', 'content', 'parent_id'];

    /** Relasi ke tugas yang dikomentari */
    public function task(): BelongsTo
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }

    /** Relasi ke pengguna yang menulis komentar */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Relasi ke komentar induk (jika ini adalah balasan) */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProjectTaskComment::class, 'parent_id');
    }

    /** Relasi ke komentar balasan (jika komentar ini memiliki balasan) */
    public function replies(): HasMany
    {
        return $this->hasMany(ProjectTaskComment::class, 'parent_id');
    }
}
