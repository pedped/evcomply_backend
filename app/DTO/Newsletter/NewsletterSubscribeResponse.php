<?php

namespace App\DTO\Newsletter;

class NewsletterSubscribeResponse
{
    public bool $result;

    public ?string $errorMessage;

    /**
     * @param bool $result true when the subscription is successful and false when that is failed
     * @param string|null $errorMessage
     */
    public function __construct(bool $result, string $errorMessage = null)
    {
        $this->result = $result;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     */
    public function setResult(bool $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string|null $errorMessage
     */
    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function __toString()
    {
        return json_encode(array_filter((array)$this, function ($var) {
            return !is_null($var);
        }));
    }
}
