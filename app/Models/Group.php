<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'groups';
    public $fillable = ['educational_experience_id', 'teacher_id', 'name', 'shift', 'period', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];

    public function educationalExperience()
    {
        return $this->belongsTo(EducationalExperience::class, 'educational_experience_id', 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'id', 'group_id');
    }

    public function students() {
        return $this->hasManyThrough(
            User::class,           // Target model (User)
            Enrollment::class,     // Intermediate model (Enrollment)
            'group_id',            // Foreign key on the Enrollment table referencing Group
            'id',                  // Foreign key on the User table
            'id',                  // Local key on the Group table
            'student_id'           // Local key on the Enrollment table referencing User
        );
    }


}
