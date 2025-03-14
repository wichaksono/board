<?php
namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** Relasi dengan Customer (1 User bisa memiliki banyak Customer) */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /** Relasi dengan Project sebagai pemilik proyek */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    /** Relasi dengan Project sebagai project manager */
    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'pm_id');
    }

    /** Relasi dengan ProjectTask sebagai tugas yang dimiliki oleh user */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    /** Relasi many-to-many dengan ProjectTask untuk tugas yang diberikan */
    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(ProjectTask::class, 'project_task_assigns', 'user_id', 'task_id');
    }

    /** Relasi dengan ProjectTaskComment untuk komentar yang dibuat user */
    public function taskComments(): HasMany
    {
        return $this->hasMany(ProjectTaskComment::class);
    }
}
