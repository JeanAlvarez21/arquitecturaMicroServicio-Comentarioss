<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Services\ReviewService;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    use ApiResponser;

    public $reviewService;
    public $userService;

    public function __construct(ReviewService $reviewService, UserService $userService)
    {
        $this->reviewService = $reviewService;
        $this->userService = $userService;
    }

    /**
     * Return the list of comments
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return $this->successResponse($comments);
    }

    /**
     * Create one new comment
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'content' => 'required|max:1000',
            'review_id' => 'required|integer|min:1',
            'user_id' => 'required|integer|min:1',
            'parent_id' => 'nullable|integer|min:1',
        ];

        $this->validate($request, $rules);

        // Validate Review exists
        // try {
        //     $this->reviewService->obtainReview($request->review_id);
        // } catch (\Exception $e) {
        //     return $this->errorResponse('The review does not exist', Response::HTTP_NOT_FOUND);
        // }

        // Validate User exists
        // try {
        //     $this->userService->obtainUser($request->user_id);
        // } catch (\Exception $e) {
        //     return $this->errorResponse('The user does not exist', Response::HTTP_NOT_FOUND);
        // }

        // Validate Parent Comment exists if provided
        if ($request->has('parent_id') && $request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if (!$parent) {
                return $this->errorResponse('The parent comment does not exist', Response::HTTP_NOT_FOUND);
            }
        }

        $comment = Comment::create($request->all());

        return $this->successResponse($comment, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one comment
     * @return Illuminate\Http\Response
     */
    public function show($comment)
    {
        $comment = Comment::findOrFail($comment);
        return $this->successResponse($comment);
    }

    /**
     * Obtains comments for a specific review
     * @return Illuminate\Http\Response
     */
    public function commentsByReview($review_id)
    {
        $comments = Comment::where('review_id', $review_id)->get();
        return $this->successResponse($comments);
    }

    /**
     * Update an existing comment
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $comment)
    {
        $comment = Comment::findOrFail($comment);

        $rules = [
            'content' => 'max:1000',
            'review_id' => 'integer|min:1',
            'user_id' => 'integer|min:1',
            'parent_id' => 'nullable|integer|min:1',
        ];

        $this->validate($request, $rules);

        // Validate Review if changed
        // if ($request->has('review_id')) {
        //     try {
        //         $this->reviewService->obtainReview($request->review_id);
        //     } catch (\Exception $e) {
        //         return $this->errorResponse('The review does not exist', Response::HTTP_NOT_FOUND);
        //     }
        // }

        // Validate User if changed
        // if ($request->has('user_id')) {
        //     try {
        //         $this->userService->obtainUser($request->user_id);
        //     } catch (\Exception $e) {
        //         return $this->errorResponse('The user does not exist', Response::HTTP_NOT_FOUND);
        //     }
        // }
        
         // Validate Parent Comment if changed
        if ($request->has('parent_id') && $request->parent_id) {
             // Prevent self-referencing
            if ($request->parent_id == $comment->id) {
                return $this->errorResponse('A comment cannot be its own parent', Response::HTTP_CONFLICT);
            }
            $parent = Comment::find($request->parent_id);
            if (!$parent) {
                return $this->errorResponse('The parent comment does not exist', Response::HTTP_NOT_FOUND);
            }
        }

        $comment->fill($request->all());

        if ($comment->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $comment->save();

        return $this->successResponse($comment);
    }

    /**
     * Remove an existing comment
     * @return Illuminate\Http\Response
     */
    public function destroy($comment)
    {
        $comment = Comment::findOrFail($comment);
        $comment->delete();

        return $this->successResponse($comment);
    }
}
