<?php

namespace App\Models\ModelBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Database\Factories\ProductFactory;

/**
 * Class ProductBase
 * @package App\Models\ModelBase
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $vendor
 * @property string $product_type
 * @property string $status
 * @property integer $quantity
 * @property string $image
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ProductBase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'vendor',
        'product_type',
        'status',
        'quantity',
        'image',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * @return string[]
     */
    public static function keys(): array
    {
        return [
            'id',
            'name',
            'description',
            'price',
            'vendor',
            'product_type',
            'status',
            'quantity',
            'image',
            'created_at',
            'updated_at',
        ];
    }
}
