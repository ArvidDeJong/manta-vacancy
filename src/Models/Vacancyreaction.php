<?php

namespace Darvis\MantaVacancy\Models;

use App\Mail\MailHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Manta\FluxCMS\Models\Option;
use Manta\FluxCMS\Traits\HasUploadsTrait;

class Vacancyreaction extends Model
{
    use HasFactory, SoftDeletes, HasUploadsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vacancy_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'host',
        'pid',
        'locale',
        'active',
        'sort',
        'company',
        'title',
        'sex',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'phone',
        'address',
        'address_nr',
        'zipcode',
        'city',
        'country',
        'birthdate',
        'subject',
        'comment',
        'internal_vacancyreaction',
        'ip',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @param mixed $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    /**
     * Scope to filter by vacancy ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $vacancyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByVacancy($query, int $vacancyId)
    {
        return $query->where('vacancy_id', $vacancyId);
    }

    public function sendmail(): bool
    {
        $mailService = app(\Darvis\MantaVacancy\Services\VacancyreactionMailService::class);
        return $mailService->sendVacancyreactionEmail($this);
    }
}
