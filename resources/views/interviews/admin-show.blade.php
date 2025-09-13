@extends('layout')

@section('title', $interview->title . ' - Admin View')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('interviews.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to All Interviews
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $interview->title }}</h1>
        <p class="text-gray-600 mb-6">{{ $interview->description }}</p>
        
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-question-circle text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-600">Questions</p>
                        <p class="text-2xl font-bold text-blue-800">{{ count($interview->questions) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-users text-green-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm text-green-600">Submissions</p>
                        <p class="text-2xl font-bold text-green-800">{{ $submissions->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-star text-purple-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm text-purple-600">Avg Score</p>
                        <p class="text-2xl font-bold text-purple-800">
                            {{ $submissions->whereNotNull('score')->avg('score') ? number_format($submissions->whereNotNull('score')->avg('score'), 1) : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Interview Questions</h3>
            <ol class="list-decimal list-inside space-y-2">
                @foreach($interview->questions as $question)
                    <li class="text-gray-700">{{ $question }}</li>
                @endforeach
            </ol>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Candidate Submissions</h2>
        
        @if($submissions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Candidate
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Submitted
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Score
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $submission->candidate->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $submission->candidate->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $submission->created_at->format('M j, Y g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->score)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                     {{ $submission->score >= 80 ? 'bg-green-100 text-green-800' : 
                                                        ($submission->score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $submission->score }}/100
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Not scored
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('submissions.show', $submission) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No submissions yet</h3>
                <p class="text-gray-500">Candidates haven't submitted their responses yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
