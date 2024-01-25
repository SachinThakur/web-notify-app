<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class PhoneNumberValidateUsingApi implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Call the API URL
        $response = Http::withHeaders([
            'apikey' => 'JfJ4X4aQjgGrhKkeXZwOufOZWLYJCRMX'
        ])->get('https://api.apilayer.com/number_verification/validate',[
            'number' => $value,
        ]);

        $result = json_decode($response->getBody());

        // If the API retuned the correct response, validation is passed
        if ($response->ok() && $result->valid) {            
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Given a invalid phone number.';
    }
}
