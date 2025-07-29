<?php

namespace Darvis\MantaVacancy\Models;

use App\Mail\MailHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
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

    public function sendmail()
    {
        $vacancyreaction = $this;

        // E-mail versturen
        $VACANCYREACTION_RECEIVERS = Option::get('VACANCYREACTION_EMAIL_RECEIVERS', Vacancyreaction::class, app()->getLocale());
        $VACANCYREACTION_EMAIL_SUBJECT = Option::get('VACANCYREACTION_EMAIL_SUBJECT', Vacancyreaction::class, app()->getLocale());
        $VACANCYREACTION_EMAIL = Option::get('VACANCYREACTION_EMAIL', Vacancyreaction::class, app()->getLocale());
        // Decode the JSON string to an array
        $receiversArray = json_decode($VACANCYREACTION_RECEIVERS, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $receiversArray[] = env('MAIL_TO_ADDRESS');
            // Handle JSON decode error
            // throw new \Exception('Error decoding VACANCYREACTION_RECEIVERS JSON: ' . json_last_error_msg());
        }

        // Ensure $receiversArray is an array
        if (!is_array($receiversArray)) {
            $receiversArray[] = env('MAIL_TO_ADDRESS');
            // throw new \Exception('VACANCYREACTION_RECEIVERS must be a JSON array.');
        }

        $templateContent = $VACANCYREACTION_EMAIL;
        $pattern = '/\{\{\s*\$(\w+)-&gt;(\w+)\s*\}\}/';

        // Geef $vacancyreaction door in de callback
        $content = preg_replace_callback($pattern, function ($matches) use ($vacancyreaction) {
            $modelName = $matches[1];   // bijvoorbeeld "vacancyreaction"
            $attribute = $matches[2];   // bijvoorbeeld "name"

            // Check of de property op het model bestaat en een waarde heeft
            if ($modelName === 'vacancyreaction' && isset($vacancyreaction->{$attribute})) {
                return e($vacancyreaction->{$attribute});
            }

            return ''; // Fallback bij een ongeldige placeholder
        }, $templateContent);


        // Process each receiver
        foreach ($receiversArray as $receiver) {
            if ($receiver == "##ZENDER##" && filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($this->email)->send(new MailHtml($VACANCYREACTION_EMAIL_SUBJECT, $content));
            } else if (filter_var($receiver, FILTER_VALIDATE_EMAIL)) {
                Mail::to($receiver)->send(new MailHtml($VACANCYREACTION_EMAIL_SUBJECT, $content));
            }
        }

        $this->send = true;
    }
}
