@extends('layout')

@section('title', 'Available Interviews - Hireflix')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Available Interviews</h1>
</div>

@if($interviews->count() > 0)
    <div class="grid gap-6">
        @foreach($interviews as $interview)
            @php
                $submission = $interview->submissions->where('candidate_id', auth()->id())->first();
            @endphp
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $interview->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $interview->description }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-question-circle mr-2"></i>
                            {{ count($interview->questions) }} questions
                        </div>
                        
                        @if($submission)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                <i class="fas fa-check mr-2"></i>Submitted
                                @if($submission->score)
                                    - Score: {{ $submission->score }}/100
                                @endif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>Pending
                            </span>
                        @endif
                    </div>
                    
                    <div class="ml-6">
                        <a href="{{ route('interviews.show', $interview) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            @if($submission)
                                <i class="fas fa-eye mr-2"></i>View Submission
                            @else
                                <i class="fas fa-video mr-2"></i>Start Interview
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <i class="fas fa-video text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">No interviews available</h3>
        <p class="text-gray-500">Check back later for new interview opportunities.</p>
    </div>
@endif
@endsection
