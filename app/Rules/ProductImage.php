<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ProductImage implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value instanceof UploadedFile) {
            // If it's a single file, validate the file
            return $value->isValid();
        }

        if (is_array($value)) {
            // If it's an array, validate each file in the array
            foreach ($value as $file) {
                if (!$file instanceof UploadedFile || !$file->isValid()) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    protected function isValidImage($value)
    {
        return $value instanceof UploadedFile && $value->isValid();
    }

    public function message()
    {
        return 'The :attribute must be a valid image or an array of valid images.';
    }
}
