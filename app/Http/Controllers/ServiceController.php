<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Get active services for Customer View.
     * GET /api/services
     */
    public function publicIndex(): JsonResponse
    {
        try {
            $services = Service::active()
                ->orderBy('display_order', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $services,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch public services: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all services for Admin Management.
     * GET /api/admin/services
     */
    public function adminIndex(): JsonResponse
    {
        try {
            $services = Service::orderBy('display_order', 'asc')->get();

            return response()->json([
                'status' => 'success',
                'data' => $services,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch admin services: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new service.
     * POST /api/admin/services
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,draft',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $imageUrl = $request->input('image_url', '/images/hero.jpg');

            // Handle file upload if present
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/services'), $filename);
                $imageUrl = '/uploads/services/' . $filename;
            }

            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'image_url' => $imageUrl,
                'status' => $request->status,
                'button_text' => $request->input('button_text', 'Inquire For Full Detail Package'),
                'button_link' => $request->input('button_link', '/booking'),
                'display_order' => Service::count() + 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Service created successfully',
                'data' => $service,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create service: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific service for editing.
     * GET /api/admin/services/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $service,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch service: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing service.
     * POST/PUT /api/admin/services/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'status' => 'sometimes|required|in:active,draft',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'image_url' => 'nullable|string',
                'button_text' => 'nullable|string',
                'button_link' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $updateData = [];

            if ($request->has('name')) $updateData['name'] = $request->name;
            if ($request->has('description')) $updateData['description'] = $request->description;
            if ($request->has('status')) $updateData['status'] = $request->status;
            if ($request->has('button_text')) $updateData['button_text'] = $request->button_text;
            if ($request->has('button_link')) $updateData['button_link'] = $request->button_link;

            // Handle new image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/services'), $filename);
                $updateData['image_url'] = '/uploads/services/' . $filename;
            } elseif ($request->has('image_url')) {
                $updateData['image_url'] = $request->image_url;
            }

            $service->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Service updated successfully',
                'data' => $service->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update service: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a service.
     * DELETE /api/admin/services/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found',
                ], 404);
            }

            $service->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete service: ' . $e->getMessage(),
            ], 500);
        }
    }
}
