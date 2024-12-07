<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAddReview;
use Illuminate\Http\Request;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    public function canReview(Request $request,$orderId,$productId)
    {
        return $this->reviewService->canReview($request,$orderId,$productId);
    }
    public function add(RequestAddReview $request)
    {
        return $this->reviewService->addReview($request);
    }
    public function update(RequestAddReview $request,$reviewId)
    {
        return $this->reviewService->updateReview($request,$reviewId);
    }
    public function delete(Request $request,$reviewId)
    {
        return $this->reviewService->deleteReview($request,$reviewId);
    }
    public function getByProduct(Request $request,$productId)
    {
        return $this->reviewService->getByProduct($request,$productId);
    }
    public function getByUser(Request $request)
    {
        return $this->reviewService->getByUser($request);
    }
    public function get(Request $request,$reviewId)
    {
        return $this->reviewService->get($request,$reviewId);
    }
    public function getAll(Request $request)
    {
        return $this->reviewService->getAll($request);
    }
    public function hiddenReview(Request $request,$reviewId)
    {
        return $this->reviewService->hiddenReview($request,$reviewId);
    }
}
