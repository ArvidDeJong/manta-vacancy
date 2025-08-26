<?php

namespace Darvis\MantaVacancy\Services;

use Darvis\MantaVacancy\Models\Vacancyreaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Manta\FluxCMS\Models\Option;
use Manta\FluxCMS\Mail\MailDefault;

class VacancyreactionMailService
{
    /**
     * Send vacancy application email to configured recipients
     *
     * @param Vacancyreaction $vacancyreaction
     * @return bool
     */
    public function sendVacancyreactionEmail(Vacancyreaction $vacancyreaction): bool
    {
        try {
            $receivers = $this->getEmailReceivers();
            $subject = $this->getEmailSubject();
            $content = $this->processEmailTemplate($vacancyreaction);

            Log::info('Vacancyreaction mail sending to receivers: ' . implode(', ', $receivers));
            foreach ($receivers as $receiver) {
                if ($this->shouldSendToSender($receiver, $vacancyreaction)) {
                    Log::info('Vacancyreaction mail sending to sender: ' . $vacancyreaction->email);
                    Mail::to($vacancyreaction->email)->send(new MailDefault([
                        'subject' => $subject,
                        'html' => $content,
                        'from' => [
                            'address' => config('manta-vacancy.email.from.address', env('MAIL_FROM_ADDRESS')),
                            'name' => config('manta-vacancy.email.from.name', env('MAIL_FROM_NAME')),
                        ],
                        'replyTo' => [
                            'address' => $vacancyreaction->email,
                            'name' => $vacancyreaction->name,
                        ],
                    ]));
                } elseif ($this->isValidEmail($receiver)) {
                    Log::info('Vacancyreaction mail sending to receiver: ' . $receiver);
                    Mail::to($receiver)->send(new MailDefault([
                        'subject' => $subject,
                        'html' => $content,
                        'from' => [
                            'address' => config('manta-vacancy.email.from.address', env('MAIL_FROM_ADDRESS')),
                            'name' => config('manta-vacancy.email.from.name', env('MAIL_FROM_NAME')),
                        ],
                        'replyTo' => [
                            'address' => $vacancyreaction->email,
                            'name' => $vacancyreaction->name,
                        ],
                    ]));
                } else {
                    Log::info('Invalid email receiver: ' . $receiver);
                }
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Vacancyreaction mail sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get configured email receivers
     *
     * @return array
     */
    private function getEmailReceivers(): array
    {
        $receiversString = Option::get('VACANCYREACTION_EMAIL_RECEIVERS', Vacancyreaction::class, app()->getLocale());
        $receivers = explode(PHP_EOL, $receiversString);

        // Fallback to environment variable if no receivers configured
        if (empty($receivers) || (count($receivers) === 1 && empty($receivers[0]))) {
            $receivers = [env('MAIL_TO_ADDRESS')];
        }

        return array_filter($receivers); // Remove empty entries
    }

    /**
     * Get configured email subject
     *
     * @return string
     */
    private function getEmailSubject(): string
    {
        return Option::get('VACANCYREACTION_EMAIL_SUBJECT', Vacancyreaction::class, app()->getLocale())
            ?? 'Nieuwe sollicitatie ontvangen';
    }

    /**
     * Process email template with vacancyreaction data
     *
     * @param Vacancyreaction $vacancyreaction
     * @return string
     */
    private function processEmailTemplate(Vacancyreaction $vacancyreaction): string
    {
        $template = Option::get('VACANCYREACTION_EMAIL', Vacancyreaction::class, app()->getLocale());

        if (empty($template)) {
            return $this->getDefaultEmailTemplate($vacancyreaction);
        }

        // Replace template variables like {{ $vacancyreaction->name }}
        $pattern = '/\{\{\s*\$(\w+)-&gt;(\w+)\s*\}\}/';

        return preg_replace_callback($pattern, function ($matches) use ($vacancyreaction) {
            $modelName = $matches[1];   // bijvoorbeeld "vacancyreaction"
            $attribute = $matches[2];   // bijvoorbeeld "name"

            // Check if the property exists on the vacancyreaction model
            if ($modelName === 'vacancyreaction' && isset($vacancyreaction->{$attribute})) {
                return e($vacancyreaction->{$attribute});
            }

            return ''; // Fallback for invalid placeholders
        }, $template);
    }

    /**
     * Generate default email template if none configured
     *
     * @param Vacancyreaction $vacancyreaction
     * @return string
     */
    private function getDefaultEmailTemplate(Vacancyreaction $vacancyreaction): string
    {
        $vacancy = $vacancyreaction->vacancy;
        
        return "
            <h2>Nieuwe sollicitatie ontvangen</h2>
            <p><strong>Vacature:</strong> " . ($vacancy ? e($vacancy->title) : 'Onbekend') . "</p>
            <p><strong>Naam:</strong> " . e($vacancyreaction->name) . "</p>
            <p><strong>Email:</strong> " . e($vacancyreaction->email) . "</p>
            <p><strong>Telefoon:</strong> " . e($vacancyreaction->phone) . "</p>
            <p><strong>Motivatie:</strong></p>
            <p>" . nl2br(e($vacancyreaction->comment_client)) . "</p>
        ";
    }

    /**
     * Check if email should be sent to the sender
     *
     * @param string $receiver
     * @param Vacancyreaction $vacancyreaction
     * @return bool
     */
    private function shouldSendToSender(string $receiver, Vacancyreaction $vacancyreaction): bool
    {
        return preg_match('/##ZENDER##/', $receiver) && $this->isValidEmail($vacancyreaction->email);
    }

    /**
     * Validate email address
     *
     * @param string|null $email
     * @return bool
     */
    private function isValidEmail(?string $email): bool
    {
        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
