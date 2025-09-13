@extends('layout')

@section('title', 'Review Submission - Hireflix')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('interviews.show', $submission->interview) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Interview
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $submission->interview->title }}</h1>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ $submission->candidate->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>{{ $submission->created_at->format('M j, Y g:i A') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>{{ $submission->candidate->email }}</span>
                    </div>
                </div>
            </div>
            
            <div class="text-right">
                @if($submission->score)
                    <div class="text-3xl font-bold mb-2 {{ $submission->score >= 80 ? 'text-green-600' : ($submission->score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $submission->score }}/100
                    </div>
                    <div class="text-sm text-gray-500">Current Score</div>
                @else
                    <div class="text-2xl text-gray-400 mb-2">Not Scored</div>
                    <div class="text-sm text-gray-500">Awaiting Review</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Questions and Answers -->
    <div class="space-y-6 mb-8">
        @foreach($submission->interview->questions as $index => $question)
            @php
                $questionType = $submission->interview->question_types[$index] ?? 'text';
            @endphp
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Question {{ $index + 1 }}
                        </h3>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-3
                                    {{ $questionType === 'video' ? 'bg-red-100 text-red-800' : 
                                       ($questionType === 'mcq' ? 'bg-blue-100 text-blue-800' : 
                                       ($questionType === 'rating' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                            <i class="fas fa-{{ $questionType === 'video' ? 'video' : ($questionType === 'mcq' ? 'list' : ($questionType === 'rating' ? 'star' : 'edit')) }} mr-2"></i>
                            {{ ucfirst($questionType) }} Response
                        </div>
                        <p class="text-gray-700 text-lg">{{ $question }}</p>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                        Candidate's Response:
                    </h4>
                    
                    @if($questionType === 'mcq' && isset($submission->interview->mcq_options[$index]))
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700 mb-2">Available Options:</h5>
                            <div class="space-y-2 mb-4">
                                @foreach($submission->interview->mcq_options[$index] as $key => $option)
                                    @if(!empty($option))
                                        @php
                                            $optionLetter = chr(65 + $key);
                                            $isSelected = isset($submission->answers[$index]) && $submission->answers[$index] === $option;
                                        @endphp
                                        <div class="flex items-center p-3 rounded-lg border {{ $isSelected ? 'bg-blue-50 border-blue-300' : 'bg-gray-50 border-gray-200' }}">
                                            <span class="inline-flex items-center justify-center w-6 h-6 {{ $isSelected ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-full text-sm font-semibold mr-3">
                                                {{ $optionLetter }}
                                            </span>
                                            <span class="{{ $isSelected ? 'text-blue-900 font-medium' : 'text-gray-700' }}">{{ $option }}</span>
                                            @if($isSelected)
                                                <i class="fas fa-check-circle text-blue-600 ml-auto"></i>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if(isset($submission->answers[$index]))
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                    <p class="text-green-800 font-medium">
                                        <i class="fas fa-arrow-right mr-2"></i>Selected: {{ $submission->answers[$index] }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    @if($questionType === 'video' && isset($submission->video_answers[$index]))
                        <div class="mb-4">
                            <video controls class="w-full max-w-2xl bg-black rounded-lg shadow-md">
                                <source src="{{ $submission->video_answers[$index] }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif
                    
                    @if($questionType !== 'mcq' && isset($submission->answers[$index]) && !empty($submission->answers[$index]))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 text-lg">{{ $submission->answers[$index] }}</p>
                        </div>
                    @elseif($questionType !== 'mcq')
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-500 italic">No text response provided</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Scoring Section -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-clipboard-check mr-3 text-blue-600"></i>
                Score & Comments
            </h2>
            <a href="{{ route('interviews.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                <i class="fas fa-list mr-2"></i>All Interviews
            </a>
        </div>
        
        <form method="POST" action="{{ route('submissions.score', $submission) }}">
            @csrf
            
            <div class="mb-6">
                <label for="score" class="block text-sm font-medium text-gray-700 mb-2">
                    Score (0-100)
                </label>
                <input type="number" id="score" name="score" min="0" max="100" 
                       value="{{ $submission->score }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-6">
                <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                    Comments & Feedback
                </label>
                <textarea id="comments" name="comments" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Provide detailed feedback for the candidate...">{{ $submission->comments }}</textarea>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('interviews.show', $submission->interview) }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400">
                    Back to Interview
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                    Save Score & Comments
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
