<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Ensures a URL points to a page on the configured Endurain instance
 * (config('endurain.url'), set through ENDURAIN_URL).
 *
 * Used in resources/fieldsets/endurain_activity.yaml as:
 *   validate:
 *     - 'new \App\Rules\EndurainUrl'
 *
 * Laravel skips this rule for empty values, so pair it with "required"
 * where a URL is mandatory.
 */
class EndurainUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $base = (string) config('endurain.url');

        if ($base === '') {
            $fail('ENDURAIN_URL is not configured, so Endurain links cannot be checked. Add it to the .env file.');

            return;
        }

        $value = is_string($value) ? trim($value) : '';

        // Must be a valid URL on the Endurain host, with a path after the base URL.
        if (
            filter_var($value, FILTER_VALIDATE_URL) === false
            || ! str_starts_with($value, $base.'/')
            || strlen($value) <= strlen($base) + 1
        ) {
            $fail("The link must be a public activity URL that starts with {$base}/");
        }
    }
}
