<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LabelProject extends Model
{
    use HasUuids;

    protected $fillable = ['slug', 'name'];

    /** Relasi Many-to-Many dengan Project */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_labels', 'project_label_id', 'project_id');
    }
}
