<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'priorities',
        'boards',
        'user_id',
        'pm_id'
    ];

    protected $casts = [
        'priorities' => 'array',
        'boards'     => 'array',
    ];

    /** Relasi ke pemilik proyek */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Relasi ke project manager */
    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pm_id');
    }

    /** Relasi ke milestone dalam proyek */
    public function milestones(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    /** Relasi ke tugas dalam proyek */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    /** Relasi many-to-many dengan label proyek */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(LabelProject::class, 'project_labels', 'project_id', 'project_label_id');
    }
}
