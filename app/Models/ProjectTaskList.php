<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTaskList extends Model
{
    use HasUuids;

    protected $fillable = ['task_id', 'content', 'is_completed'];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /** Relasi ke tugas yang memiliki checklist ini */
    public function task(): BelongsTo
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }
}
