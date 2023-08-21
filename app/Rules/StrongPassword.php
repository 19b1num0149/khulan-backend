<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Password must be at least 8 characters long and at most 100 characters long
        if (strlen($value) < 8 || strlen($value) > 100) {
            $fail('At least 8 characters long');
        }

        // Password must contain at least one uppercase letter
        if (! preg_match('/[A-Z]/', $value)) {
            $fail(trans('validation.password.mixed'));
        }

        // Password must contain at least one lowercase letter
        if (! preg_match('/[a-z]/', $value)) {
            $fail(trans('validation.password.mixed'));
        }

        // Password must contain at least one number
        if (! preg_match('/[0-9]/', $value)) {
            $fail(trans('validation.password.numbers'));
        }

        // Password must contain at least one special character
        if (! preg_match('/[!@#$%^&*()\-_=+{}[\]:;<>.,?~]/', $value)) {
            $fail(trans('validation.password.symbols'));
        }

        // Avoid common words or patterns (you can add more common passwords to the array)
        $commonPasswords = ['password', '123456', 'qwerty', 'admin'];
        if (in_array(strtolower($value), $commonPasswords)) {
            $fail(' Do not use common passwords');
        }

        // // Avoid password similarity to username or email (replace 'username' and 'email' with actual input fields)
        // $username = 'username';
        // $email = 'email';
        // if (similar_text(strtolower($value), strtolower($username)) > 4 || similar_text(strtolower($value), strtolower($email)) > 4) {
        //     return false;
        // }
    }
}
