<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyResult extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'survey_results';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'departament_id',
        'user_id',
        'schema_results',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function departament()
    {
        return $this->belongsTo(Departamente::class, 'departament_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
