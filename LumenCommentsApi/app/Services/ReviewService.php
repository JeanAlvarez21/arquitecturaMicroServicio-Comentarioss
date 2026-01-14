<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class ReviewService
{
    use ConsumesExternalService;

    /**
     * The base uri to be used to consume the reviews service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = env('REVIEWS_SERVICE_BASE_URL');
        
        if (empty($this->baseUri)) {
            // throw new \RuntimeException('REVIEWS_SERVICE_BASE_URL is not configured in .env file');
        }
    }

    /**
     * Get a single review from the reviews service
     * @return array
     */
    public function obtainReview($review)
    {
        return $this->performRequest('GET', "/reviews/{$review}");
    }
}
