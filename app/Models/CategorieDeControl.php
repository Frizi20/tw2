<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategorieDeControl extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'categorie_de_controls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nume',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // public function surveyBuilder()
    // {
    //     return $this->hasOne(SurveyBuilder::class, 'categorie_de_control_id');
    // }

    public function dimensions()
    {
        return $this->belongsToMany(Dimensiune::class, 'survey_builders', 'categorie_de_control_id', 'dimensiune_id');
    }

    public function departamente()
    {
        return $this->belongsToMany(Departamente::class, 'survey_builders', 'categorie_de_control_id');
    }

    public function surveyBuilder()
    {
        return $this->hasMany(SurveyBuilder::class, 'categorie_de_control_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
