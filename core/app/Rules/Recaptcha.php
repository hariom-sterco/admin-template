<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Recaptcha implements ValidationRule
{
    public function __construct(private string $expectedAction = 'contact_buy_property')
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Please confirm you are not a robot.');
            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();
        $score = $result['score'] ?? 0;
        $action = $result['action'] ?? null;

        if (!($result['success'] ?? false)) {
            $fail('reCAPTCHA verification failed. Please try again.');
            return;
        }

        if ($action !== $this->expectedAction) {
            $fail('reCAPTCHA verification failed. Please try again.');
            return;
        }

        if ($score < config('services.recaptcha.min_score', 0.5)) {
            $fail('We were unable to verify your submission. Please try again or contact us directly.');
        }
    }
}
