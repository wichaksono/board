<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTask extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'order_column',
        'priority',
        'start_date',
        'due_date',
        'milestone_id',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date'   => 'date',
    ];

    /** Relasi ke proyek */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /** Relasi ke milestone (opsional) */
    public function milestone(): BelongsTo
    {
        return $this->belongsTo(ProjectMilestone::class, 'milestone_id');
    }

    /** Relasi ke pengguna yang membuat tugas */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi many-to-many ke pengguna yang ditugaskan */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_task_assigns', 'task_id', 'user_id');
    }

    /** Relasi ke daftar checklist dalam tugas */
    public function taskLists(): HasMany
    {
        return $this->hasMany(ProjectTaskList::class, 'task_id');
    }

    /** Relasi ke komentar dalam tugas */
    public function comments(): HasMany
    {
        return $this->hasMany(ProjectTaskComment::class, 'task_id');
    }
}

