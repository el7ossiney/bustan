<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class Category extends Model
{

    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory , SoftDeletes    ;
    protected $fillable  = [
        'name',
        'status',
        'parent_id',
        'slug',
        'description',
        'image'
    ];

    public function parents()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
        ;
    }
    public function child()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault();
    }
    public static function Rules($id =0){
        return [
            'name' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('categories','Name')->ignore($id)
            ],
            'parent_id' => [
                'nullable',
                Rule::exists('categories','id')
            ],
            'status' => [
                Rule::in(['active','archived'])
            ],
            'description' =>[
                'nullable',
            ],
            'image'=>[
                'nullable',
                Rule::imageFile(),

            ]

        ];
    }
    public function scopeFilter(EloquentBuilder $builder , $filter){
        $builder->when($filter['name'] ?? False , function($builder , $value){
            $builder->where('name','LIKE',"%{$value}%");
        });
        $builder->when($filter['status'] ?? False , function($builder , $value){
            $builder->where('status','=',$value);
        });
    }
    
}
