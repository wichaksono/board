<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectLabelTask extends Model
{
    use HasUuids;

    protected $fillable = ['project_id', 'name'];

    /** Relasi ke proyek */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /** Relasi ke tugas yang memiliki label ini */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class, 'id', 'project_id');
    }
}
