<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function show(Submission $submission)
    {
        return view('submissions.show', compact('submission'));
    }

    public function score(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'comments' => 'nullable|string',
        ]);

        $submission->update($validated);

        return redirect()->back()->with('success', 'Score and comments updated successfully!');
    }
}
