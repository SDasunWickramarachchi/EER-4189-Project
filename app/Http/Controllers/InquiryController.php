<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
  public function store(Request $request): JsonResponse
  {
    if ($request->filled('website')) {
        return response()->json([
            'status' => 'success',
            'message' => 'Inquiry received.',
        ], 201);
    }
        $validator = Validator::make($request->all(), [
            'client_name'  => 'required|string|min:2|max:100',
            'client_email' => 'required|email|max:150',
            'client_phone' => ['nullable', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'inquiry_type' => 'nullable|string|max:100',
            'message'      => 'required|string|min:10|max:2000',
            'location'     => 'nullable|string|max:255',
            'session_date' => 'nullable|date|after_or_equal:today',
        ], [
            'client_name.required'  => 'Please enter your full name.',
            'client_email.required' => 'Please enter your email address.',
            'client_email.email'    => 'Please enter a valid email address.',
            'client_phone.regex'    => 'Please enter a valid phone number.',
            'message.required'      => 'Please write your message.',
            'message.min'           => 'Please write at least 10 characters.',
            'session_date.after_or_equal' => 'Please choose today or a later date.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $inquiry = new Inquiry($validator->validated());
        $inquiry->status = 'new';
        $inquiry->priority = 'normal';
        $inquiry->addHistory('status', 'Inquiry received.');
        $inquiry->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Inquiry received.',
            'data'    => [
                'reference_number' => $inquiry->reference_number,
                'status'           => $inquiry->status,
            ],
        ], 201);
  }  
}