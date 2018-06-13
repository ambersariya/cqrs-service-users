<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    /**
     * @var ApiProblem
     */
    private $apiProblem;

    public function __construct(ApiProblem $apiProblem)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($this->apiProblem->statusCode(), $this->apiProblem->reason());
    }

    public function apiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }

    public static function with(ApiProblem $apiProblem): self
    {
        return new self($apiProblem);
    }
}