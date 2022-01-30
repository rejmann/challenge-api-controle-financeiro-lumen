<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moviment extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'description',
        'value',
        'date',
        'types_id',
        'categories_id'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'types_id',
        'categories_id'
    ];

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    public function type()
    {
        return $this->belongsTo(Type::class)->first();
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->first();
    }
}
