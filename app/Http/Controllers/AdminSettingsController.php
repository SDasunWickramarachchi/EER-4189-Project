<?php
 
namespace App\Http\Controllers;
 
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminSettingsController extends Controller{
    public function show(): JsonResponse{
        return response()->json([
            'status' => 'success',
            'data'   => Setting::current(),
        ]);
    }

    public function update(Request $request): JsonResponse{
        $validator = Validator::make($request->all(), [

            'studio_name'    => 'sometimes|required|string|min:2|max:100',
            'bio'            => 'sometimes|nullable|string|max:1000',
            'dispatch_email' => 'sometimes|required|email|max:150',
            'phone'          => ['sometimes', 'nullable', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'tax_id'         => 'sometimes|nullable|string|max:100',
            'address'        => 'sometimes|nullable|string|max:255',
            'artist_note'    => 'sometimes|nullable|string|max:1000',
 
            'shooting_days'   => 'sometimes|required|array|min:1',
            'shooting_days.*' => 'integer|between:0,6|distinct',
            'daily_start'     => 'sometimes|required|date_format:H:i',
            'daily_end'       => 'sometimes|required|date_format:H:i',
            'turnaround_hours' => 'sometimes|required|integer|between:0,168',

            'notify_high_value'      => 'sometimes|boolean',
            'notify_contract_signed' => 'sometimes|boolean',
            'notify_deposit'         => 'sometimes|boolean',
            'high_value_threshold'   => 'sometimes|required|integer|between:0,1000000',
 
            'retainer_percent' => 'sometimes|required|integer|between:0,100',
            'grace_hours'      => 'sometimes|required|integer|between:0,720',
        ], 
        [
            'studio_name.required'      => 'Please enter the studio name.',
            'dispatch_email.required'   => 'Please enter the dispatch email.',
            'dispatch_email.email'      => 'Please enter a valid email address.',
            'phone.regex'               => 'Please enter a valid phone number.',
            'shooting_days.required'    => 'Choose at least one shooting day.',
            'shooting_days.min'         => 'Choose at least one shooting day.',
            'daily_start.required'      => 'Please enter the opening time.',
            'daily_start.date_format'   => 'Use the format HH:MM, for example 06:00.',
            'daily_end.required'        => 'Please enter the closing time.',
            'daily_end.date_format'     => 'Use the format HH:MM, for example 19:30.',
            'turnaround_hours.required' => 'Please enter the turnaround buffer in hours.',
            'turnaround_hours.between'  => 'The buffer must be between 0 and 168 hours.',
            'retainer_percent.required' => 'Please enter the retainer percentage.',
            'retainer_percent.between'  => 'The retainer must be between 0 and 100 percent.',
            'grace_hours.required'      => 'Please enter the grace period in hours.',
            'grace_hours.between'       => 'The grace period must be between 0 and 720 hours.',
        ]);
 
        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }
 
        $data = $validator->validated();
        $setting = Setting::current();

        $start = $data['daily_start'] ?? $setting->daily_start;
        $end   = $data['daily_end'] ?? $setting->daily_end;
        if ($start >= $end) {
            return $this->validationError(['daily_end' => ['The closing time must be later than the opening time.']]);
        }
 
        if (isset($data['shooting_days'])) {
            $days = array_values(array_unique(array_map('intval', $data['shooting_days'])));
            sort($days);
            $data['shooting_days'] = $days;
        }
 
        $setting->fill($data);
        $setting->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Settings saved.',
            'data'    => $setting,
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'avatar.required' => 'Please choose a picture.',
            'avatar.image'    => 'The file must be a picture.',
            'avatar.mimes'    => 'Use a JPG, PNG or WEBP picture.',
            'avatar.max'      => 'The picture must be smaller than 2 MB.',
        ]);
 
        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }
 
        $setting = Setting::current();
        $path = $request->file('avatar')->store('avatars', 'public');
 
        if ($setting->avatar_path) {
            Storage::disk('public')->delete($setting->avatar_path);
        }
 
        $setting->avatar_path = $path;
        $setting->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Avatar updated.',
            'data'    => $setting,
        ]);
    }

    public function removeAvatar(): JsonResponse
    {
        $setting = Setting::current();
 
        if ($setting->avatar_path) {
            Storage::disk('public')->delete($setting->avatar_path);
        }
 
        $setting->avatar_path = null;
        $setting->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Avatar removed.',
            'data'    => $setting,
        ]);
    }
 
    private function validationError($errors): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'errors' => $errors,
        ], 422);
    }
}
 