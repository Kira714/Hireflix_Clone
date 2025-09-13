@extends('layout')

@section('title', 'Interviews - Hireflix')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900">
        @if(auth()->user()->isAdmin())
            My Interviews
        @else
            Available Interviews
        @endif
    </h1>
    
    @if(auth()->user()->isAdmin())
        <a href="{{ route('interviews.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Create Interview
        </a>
    @endif
</div>

@if($interviews->count() > 0)
    <div class="grid gap-6">
        @foreach($interviews as $interview)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $interview->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $interview->description }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-question-circle mr-2"></i>
                            {{ count($interview->questions) }} questions
                            
                            @if(auth()->user()->isAdmin())
                                <span class="mx-2">•</span>
                                <i class="fas fa-users mr-2"></i>
                                {{ $interview->submissions->count() }} submissions
                            @endif
                        </div>
                        
                        @if(auth()->user()->isCandidate())
                            @php
                                $submission = $interview->submissions->where('candidate_id', auth()->id())->first();
                            @endphp
                            
                            @if($submission)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-2"></i>Submitted
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>Pending
                                </span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="ml-6 flex space-x-2">
                        <a href="{{ route('interviews.show', $interview) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </a>
                        <a href="{{ route('interviews.edit', $interview) }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <form method="POST" action="{{ route('interviews.destroy', $interview) }}" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this interview?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <i class="fas fa-video text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">
            @if(auth()->user()->isAdmin())
                No interviews created yet
            @else
                No interviews available
            @endif
        </h3>
        <p class="text-gray-500">
            @if(auth()->user()->isAdmin())
                Create your first interview to get started.
            @else
                Check back later for new interview opportunities.
            @endif
        </p>
    </div>
@endif
@endsection
