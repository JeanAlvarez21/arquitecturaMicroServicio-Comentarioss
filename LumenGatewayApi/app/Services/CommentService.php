<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class CommentService
{
    use ConsumesExternalService;

    /**
     * The base uri to be used to consume the comments service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to be used to consume the comments service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.comments.base_uri');
        $this->secret = config('services.comments.secret');
        
        // Validate configuration
        if (empty($this->baseUri)) {
            // throw new \RuntimeException('COMMENTS_SERVICE_BASE_URL is not configured in .env file');
        }
    }

    /**
     * Get the full list of comments from the comments service
     * @return string
     */
    public function obtainComments()
    {
        return $this->performRequest('GET', '/comments');
    }

    /**
     * Create an instance of comment using the comments service
     * @return string
     */
    public function createComment($data)
    {
        return $this->performRequest('POST', '/comments', $data);
    }

    /**
     * Get a single comment from the comments service
     * @return string
     */
    public function obtainComment($comment)
    {
        return $this->performRequest('GET', "/comments/{$comment}");
    }

    /**
     * Edit a single comment from the comments service
     * @return string
     */
    public function editComment($data, $comment)
    {
        return $this->performRequest('PUT', "/comments/{$comment}", $data);
    }

    /**
     * Remove a single comment from the comments service
     * @return string
     */
    public function deleteComment($comment)
    {
        return $this->performRequest('DELETE', "/comments/{$comment}");
    }

    /**
     * Get comments for a specific review
     * @return string
     */
    public function commentsByReview($review_id)
    {
        return $this->performRequest('GET', "/comments/review/{$review_id}");
    }
}
