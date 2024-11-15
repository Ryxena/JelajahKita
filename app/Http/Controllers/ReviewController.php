<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(): JsonResponse
    {
        $reviews = Review::with(['destination', 'user'])->get();

        return ApiResponse::success($reviews, 'Success get all reviews');
    }

    public function create(Request $request): JsonResponse
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required|exists:destinations,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', $validator->errors());
        }

        $review = Review::create([
            'user_id' => $user->id,
            'destination_id' => $request->get('destination_id'),
            'rating' => $request->get('rating'),
            'review' => $request->get('review'),
        ]);

        return ApiResponse::success($review, 'Review created');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $review = Review::find($id);

        if (! $review) {
            return ApiResponse::error('Review not found');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'review' => 'sometimes|required|string|min:10',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation error', $validator->errors());
        }

        $review->update($request->only('rating', 'review'));

        return ApiResponse::success($review, 'Review updated');
    }

    public function delete($id): JsonResponse
    {
        $review = Review::find($id);
        if (! $review) {
            return ApiResponse::error('Review not found');
        }

        $review->delete();

        return ApiResponse::success(null, 'Review deleted');
    }
}
