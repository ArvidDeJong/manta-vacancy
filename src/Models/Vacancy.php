<?php

namespace Darvis\MantaVacancy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Manta\FluxCMS\Traits\HasTranslationsTrait;
use Manta\FluxCMS\Traits\HasUploadsTrait;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes, HasUploadsTrait, HasTranslationsTrait;

    const MODEL_NAME = __CLASS__;

    protected $fillable = [
        'company_id',
        'content',
        'created_by',
        'updated_by',
        'deleted_by',
        'excerpt',
        'locale',
        'pid',
        'seo_description',
        'seo_title',
        'show_from',
        'show_till',
        'slug',
        'sort',
        'summary_requirements',
        'tags',
        'title',
        'title_2',
        'title_3',
        'employment_type',
        'location',
        'email_receivers',
        'text_1',
        'text_2',
        'text_3',
        'text_4',
        'email_client',
        'email_webmaster',
        'data',
    ];

    /**
     * Optioneel: Als je JSON kolommen wilt casten, kun je hieronder casts toevoegen.
     */
    protected $casts = [
        'show_from' => 'datetime',
        'show_till' => 'datetime',
        'data' => 'array',
        'email_receivers' => 'array',
    ];

    /**
     * @param mixed $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getShowFromAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getShowTillAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    /**
     * One-to-many relationship with Vacancyreaction.
     *
     * @return HasMany
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(Vacancyreaction::class);
    }

    /**
     * Scope to filter records by model name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $modelName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForModel($query, $modelName)
    {
        return $query->where('model', $modelName);
    }
}
