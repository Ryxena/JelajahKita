<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ImageDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $sort = $request->query('sort', 'asc');
        $categoryId = $request->query('categories');

        $query = Destination::with(['images:destination_id,path', 'reviews', 'categories']);

        if ($search) {
            $query->whereAny(['name', 'description', 'province', 'city'], 'like', $search)
                ->orWhereHas('categories', function ($categoryQuery) use ($search) {
                    $categoryQuery->where('name', 'like', "%{$search}%");
                });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($categoryQuery) use ($categoryId) {
                $categoryQuery->where('id', $categoryId);
            });
        }

        $query->orderBy('name', $sort);

        $destinations = $query->get()
            ->each(function ($destination) {
                $destination->reviews->each(function ($review) {
                    $review->user_name = $review->user->name;
                    $review->destination_name = $review->destination->name;
                    unset($review->user, $review->destination);
                })->makeHidden(['updated_at']);
                $destination->categories->each(function ($category) {
                    unset($category->pivot);
                })->makeHidden(['created_at', 'updated_at']);
            });

        return ApiResponse::success($destinations, 'Success get all destinations');
    }


    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'description' => 'required|string|min:10',
            'province' => 'required|string',
            'city' => 'required|string',
            'budget' => 'required|integer',
            'facility' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', $validator->errors());
        }
        $destination = Destination::create($request->only('name', 'description', 'province', 'city', 'budget', 'facility'));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('destinations', 'public');
                ImageDestination::create([
                    'destination_id' => $destination->id,
                    'path' => $path,
                ]);
            }
        }

        return ApiResponse::success($destination, 'Destination created');
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::where('id', $id)->first();
        if (! $destination) {
            return ApiResponse::error('Destination not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|min:5',
            'description' => 'nullable|string|min:10',
        ]);
        if ($validator->fails()) {
            return ApiResponse::error('Validation error', $validator->errors());
        }
        $destination->update($request->only('name', 'description', 'province', 'city'));
        if ($request->has('category_ids')) {
            $destination->categories()->sync($request->category_ids);
        }

        return ApiResponse::success($destination, 'Destination updated');
    }

    public function delete(Request $request, $id)
    {
        $destination = Destination::where('id', $id)->first();
        if (! $destination) {
            return ApiResponse::error('Destination not found');
        }
        $destination->delete();

        return ApiResponse::success(null, 'Destination deleted');
    }

    public function show($id)
    {
        $destination = Destination::with(['reviews', 'categories', 'images:destination_id,path'])->where('id', $id)->get()->each(function ($destination) {
            $destination->reviews->each(function ($review) {
                $review->user_name = $review->user->name;
                $review->destination_name = $review->destination->name;
                unset($review->user, $review->destination);
            })->makeHidden(['updated_at']);
            $destination->categories->each(function ($category) {
                unset($category->pivot);
            })->makeHidden(['created_at', 'updated_at']);

        });

        return ApiResponse::success($destination, 'Destination found');
    }
}
