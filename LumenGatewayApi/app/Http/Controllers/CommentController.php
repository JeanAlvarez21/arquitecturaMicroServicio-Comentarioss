<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the comment service
     * @var CommentService
     */
    public $commentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Retrieve and show all the comments
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->commentService->obtainComments());
    }

    /**
     * Creates an instance of comment
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->successResponse(
            $this->commentService->createComment($request->all()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Obtain and show an instance of comment
     * @return Illuminate\Http\Response
     */
    public function show($comment)
    {
        return $this->successResponse($this->commentService->obtainComment($comment));
    }

    /**
     * Updated an instance of comment
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $comment)
    {
        return $this->successResponse(
            $this->commentService->editComment($request->all(), $comment)
        );
    }

    /**
     * Removes an instance of comment
     * @return Illuminate\Http\Response
     */
    public function destroy($comment)
    {
        return $this->successResponse($this->commentService->deleteComment($comment));
    }
    
    /**
     * Obtain comments for a specific review
     * @return Illuminate\Http\Response
     */
    public function commentsByReview($review_id)
    {
        return $this->successResponse($this->commentService->commentsByReview($review_id));
    }
}
