<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyBuilder extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'survey_builders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'departamente_id',
        'schema',
        'generala',
        'categorie_de_control_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function departamente()
    {
        return $this->belongsTo(Departamente::class, 'departamente_id');
    }

    public function categorie_de_control()
    {
        return $this->belongsTo(CategorieDeControl::class, 'categorie_de_control_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
