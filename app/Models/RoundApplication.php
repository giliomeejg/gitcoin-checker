<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'round_id',
        'project_addr',
        'status',
        'last_updated_on',
        'version',
        'metadata',
    ];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_addr', 'id_addr');
    }

    public function results()
    {
        return $this->hasMany(RoundApplicationPromptResult::class, 'application_id', 'id');
    }
}
