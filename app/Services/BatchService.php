<?php

namespace App\Services;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BatchService
{
    public function renderBatches()
    {
        $teacherId = Auth::guard('teacher')->id();
        $batches = Batch::with('teacher')
            ->where('teacher_id', $teacherId)
            ->latest()
            ->get();

        return view('teacher.pages.batch_list', compact('batches'));
    }

    public function renderBatchForm($id = null)
    {
        $batch = $id ? Batch::findOrFail($id) : null;
        return view('teacher.pages.batch_form', compact('batch'));
    }

    public function handleBatchSave(Request $request, $id = null)
    {
        try {
            $validated = $request->validate([
                'name'          => 'required|string|max:255',
                'max_students'  => 'required|integer|min:1',
                'start_date'    => 'required|date',
                'end_date'      => 'nullable|date|after_or_equal:start_date',
                'status'        => 'required|in:active,inactive',
            ]);

            $batch = $id ? Batch::findOrFail($id) : new Batch();
            $batch->name = $validated['name'];
            $batch->teacher_id = Auth::guard('teacher')->user()->id;
            $batch->max_students = $validated['max_students'];
            $batch->start_date = $validated['start_date'];
            $batch->end_date = $validated['end_date'] ?? null;
            $batch->status = $validated['status'];
            $batch->save();

            return redirect()->route('batchList')->with('success', 'Batch saved successfully.');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'Failed ! ' . $th->getMessage())->withInput();
        }
    }

    public function handleBatchDelete($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();
        return redirect()->route('batchList')->with('success', 'Batch deleted successfully.');
    }
}
