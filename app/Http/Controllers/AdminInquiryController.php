<?php 

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminInquiryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->query(), [
            'tab' => 'nullable|in:all,' . implode(',', array_keys(Inquiry::TABS)),
            'priority' => 'nullable|in:normal,urgent',
            'search' => 'nullable|string|max:100',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()){
            return $this->validationError($validator);
        }

        $query = Inquiry::query();

        $tab = $request->query('tab', 'all');
        if ($tab !== 'all') {
            $query->whereIn('status', Inquiry::TABS[$tab]);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->query('priority'));
        }

        if ($request-> filled('search')){
            $term = '%' . $request->query('search') . '%';

            $query->where(function ($q) use ($term) {
                $q->where('client_name', 'like', $term)
                  ->orWhere('client_email', 'like', $term)
                  ->orWhere('inquiry_tye', 'like', $term)
                  ->orWhere('location', 'like', $term);
            });
        }

        $inquiries = $query
             ->orderBy('created_at' , 'desc')
             ->paginate((int) $request->query('per_page', 10));

        return response()->json([
            'status' => 'success',
            'data' => $inquiries,
        ]);
    }

    public function summary(): JsonResponse
    {
        $counts = ['all' => Inquiry::count()];
 
        foreach (Inquiry::TABS as $tab => $statuses) {
            $counts[$tab] = Inquiry::whereIn('status', $statuses)->count();
        }
 
        $replied = Inquiry::whereNotNull('replied_at')->get(['created_at', 'replied_at']);
        $avgResponseHours = $replied->count()
            ? round($replied->avg(fn ($i) => $i->created_at->diffInMinutes($i->replied_at)) / 60, 1)
            : null;
 
        $conversionRate = $counts['all'] > 0
            ? round($counts['converted'] / $counts['all'] * 100, 1)
            : 0;
 
        return response()->json([
            'status' => 'success',
            'data'   => [
                'counts'             => $counts,
                'avg_response_hours' => $avgResponseHours,
                'conversion_rate'    => $conversionRate,
                'weekly_inflow'      => Inquiry::where('created_at', '>=', now()->subDays(7))->count(),
            ],
        ]);
    }
 
    public function show(string $id): JsonResponse
    {
        $inquiry = Inquiry::find($id);
 
        if (!$inquiry) {
            return $this->notFound();
        }
 
        return response()->json([
            'status' => 'success',
            'data'   => $inquiry,
        ]);
    }
 
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', Inquiry::STATUSES),
        ]);
 
        if ($validator->fails()) {
            return $this->validationError($validator);
        }
 
        $inquiry = Inquiry::find($id);
 
        if (!$inquiry) {
            return $this->notFound();
        }
 
        $old = $inquiry->status;
        $new = $request->input('status');
 
        $inquiry->status = $new;
 
        if ($new === 'replied' && !$inquiry->replied_at) {
            $inquiry->replied_at = now();
        }
 
        if ($old !== $new) {
            $inquiry->addHistory('status', "Status changed from {$old} to {$new}.");
        }
 
        $inquiry->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Inquiry status updated.',
            'data'    => $inquiry,
        ]);
    }
 
    public function updatePriority(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'priority' => 'required|in:normal,urgent',
        ]);
 
        if ($validator->fails()) {
            return $this->validationError($validator);
        }
 
        $inquiry = Inquiry::find($id);
 
        if (!$inquiry) {
            return $this->notFound();
        }
 
        $inquiry->priority = $request->input('priority');
        $inquiry->addHistory('status', 'Priority set to ' . $inquiry->priority . '.');
        $inquiry->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Inquiry priority updated.',
            'data'    => $inquiry,
        ]);
    }
 
    public function addNote(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:2|max:1000',
        ]);
 
        if ($validator->fails()) {
            return $this->validationError($validator);
        }
 
        $inquiry = Inquiry::find($id);
 
        if (!$inquiry) {
            return $this->notFound();
        }
 
        $inquiry->addHistory('note', $request->input('text'));
        $inquiry->save();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Note added.',
            'data'    => $inquiry,
        ], 201);
    }
 
    public function destroy(string $id): JsonResponse
    {
        $inquiry = Inquiry::find($id);
 
        if (!$inquiry) {
            return $this->notFound();
        }
 
        $inquiry->delete();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Inquiry deleted.',
        ]);
    }
 
    private function validationError($validator): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors(),
        ], 422);
    }
 
    private function notFound(): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => 'Inquiry not found.',
        ], 404);
    }
}
 