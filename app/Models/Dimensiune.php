<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dimensiune extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'dimensiunes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dimensiune',
        'departament_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function departament()
    {
        return $this->belongsTo(Departamente::class, 'departament_id');
    }

    public function categoriiDeControl()
    {
        return $this->hasMany(CategorieDeControl::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
