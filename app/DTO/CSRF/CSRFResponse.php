<?php

namespace App\DTO\CSRF;

class CSRFResponse
{

    public string $key;

    /**
     * this will handle the CSRF key
     * @param bool $key generated key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __toString()
    {
        return json_encode(array_filter((array)$this, function ($var) {
            return !is_null($var);
        }));
    }
}
