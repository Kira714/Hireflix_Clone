<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $interviews = Interview::where('created_by', Auth::id())->get();
            return view('interviews.index', compact('interviews'));
        } else {
            $interviews = Interview::all();
            return view('interviews.candidate-index', compact('interviews'));
        }
    }

    public function create()
    {
        return view('interviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string',
            'question_types' => 'required|array|min:1',
            'question_types.*' => 'required|string|in:text,video,mcq,rating',
        ]);

        // Handle MCQ options
        $mcqOptions = $request->input('mcq_options', []);
        $ratingLabels = $request->input('rating_labels', []);
        
        // Debug: Log what we're receiving
        \Log::info('MCQ Options received:', $mcqOptions);
        \Log::info('Rating Labels received:', $ratingLabels);

        Interview::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'questions' => $validated['questions'],
            'question_types' => $validated['question_types'],
            'mcq_options' => $mcqOptions,
            'rating_labels' => $ratingLabels,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('interviews.index')->with('success', 'Interview created successfully!');
    }

    public function show(Interview $interview)
    {
        if (Auth::user()->isCandidate()) {
            $submission = Submission::where('interview_id', $interview->id)
                ->where('candidate_id', Auth::id())
                ->first();
            
            return view('interviews.show', compact('interview', 'submission'));
        }

        $submissions = $interview->submissions()->with('candidate')->get();
        return view('interviews.admin-show', compact('interview', 'submissions'));
    }

    public function edit(Interview $interview)
    {
        // Check if user is admin (remove the ownership check for now)
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('interviews.edit', compact('interview'));
    }

    public function update(Request $request, Interview $interview)
    {
        // Check if user is admin (remove the ownership check for now)
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string',
            'question_types' => 'required|array|min:1',
            'question_types.*' => 'required|string|in:text,video,mcq,rating',
        ]);

        // Handle MCQ options and rating labels
        $mcqOptions = $request->input('mcq_options', []);
        $ratingLabels = $request->input('rating_labels', []);

        $interview->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'questions' => $validated['questions'],
            'question_types' => $validated['question_types'],
            'mcq_options' => $mcqOptions,
            'rating_labels' => $ratingLabels,
        ]);

        return redirect()->route('interviews.index')->with('success', 'Interview updated successfully!');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return redirect()->route('interviews.index')->with('success', 'Interview deleted successfully!');
    }

    public function uploadVideo(Request $request)
    {
        try {
            $video = $request->file('video');
            $questionIndex = $request->input('question_index');
            
            if ($video) {
                $filename = 'video_' . Auth::id() . '_' . $questionIndex . '_' . time() . '.webm';
                $video->move(public_path('videos'), $filename);
                
                return response()->json([
                    'success' => true,
                    'video_path' => '/videos/' . $filename
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'No video uploaded']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function submit(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|string',
        ]);

        // Handle video answers
        $videoAnswers = $request->input('video_answers', []);
        
        // Debug: Log what we're receiving
        \Log::info('Video answers received:', $videoAnswers);
        \Log::info('All request data:', $request->all());

        Submission::updateOrCreate(
            [
                'interview_id' => $interview->id,
                'candidate_id' => Auth::id(),
            ],
            [
                'answers' => $validated['answers'],
                'video_answers' => $videoAnswers,
            ]
        );

        return redirect()->route('interviews.index')->with('success', 'Answers submitted successfully!');
    }
}
