<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Exception;

class ApiProblem
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $reason;


    public function __construct(int $statusCode, string $reason)
    {

        $this->statusCode = $statusCode;
        $this->reason = $reason;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function toArray(): array
    {
        return [
            'statusCode' => $this->statusCode(),
            'reason' => $this->reason(),
        ];
    }
}