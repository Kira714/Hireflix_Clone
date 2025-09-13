@extends('layout')

@section('title', $interview->title . ' - Hireflix')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button - Always Show -->
    <div class="mb-6">
        <a href="{{ route('interviews.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to All Interviews
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $interview->title }}</h1>
        <p class="text-gray-600 mb-8">{{ $interview->description }}</p>
        
        @if($submission)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Interview Completed</h3>
                        <p class="text-green-600">You have already submitted your responses for this interview.</p>
                        @if($submission->score)
                            <p class="text-green-600 mt-2">
                                <strong>Score:</strong> {{ $submission->score }}/100
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        @if(Auth::user()->isAdmin())
            <!-- Admin View: Questions with Options and Responses -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Interview Questions</h2>
                
                @foreach($interview->questions as $index => $question)
                    @php
                        $questionType = $interview->question_types[$index] ?? 'text';
                    @endphp
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Question {{ $index + 1 }}
                            </h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $questionType === 'video' ? 'bg-red-100 text-red-800' : 
                                           ($questionType === 'mcq' ? 'bg-blue-100 text-blue-800' : 
                                           ($questionType === 'rating' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($questionType) }}
                            </span>
                        </div>
                        
                        <p class="text-gray-700 mb-4">{{ $question }}</p>
                        
                        @if($questionType === 'mcq' && isset($interview->mcq_options[$index]))
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Available Options:</h4>
                                <div class="space-y-2">
                                    @foreach($interview->mcq_options[$index] as $key => $option)
                                        @if(!empty($option))
                                            <div class="flex items-center p-3 bg-white rounded border">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold mr-3">
                                                    {{ chr(65 + $key) }}
                                                </span>
                                                <span>{{ $option }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($questionType === 'rating')
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Rating Scale: 1-10</h4>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-sm">
                                            {{ $i }}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endif
                        
                        <!-- Show user responses if any -->
                        @if($submission && isset($submission->answers[$index]))
                            <div class="border-t pt-4">
                                <h4 class="font-medium text-green-700 mb-2">
                                    <i class="fas fa-user-check mr-2"></i>User Response:
                                </h4>
                                <div class="bg-green-50 p-3 rounded border border-green-200">
                                    <p class="text-green-800 font-medium">{{ $submission->answers[$index] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        
        @if(!Auth::user()->isAdmin())
            <!-- Candidate Form -->
        <form method="POST" action="{{ route('interviews.submit', $interview) }}" id="interview-form" onsubmit="debugFormSubmission(event)">
            @csrf
            
            @foreach($interview->questions as $index => $question)
                @php
                    $questionType = $interview->question_types[$index] ?? 'text';
                @endphp
                
                <div class="mb-8 p-6 border border-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        Question {{ $index + 1 }}
                        <span class="text-sm font-normal text-blue-600 ml-2">
                            ({{ ucfirst($questionType) }} Response)
                        </span>
                    </h3>
                    <p class="text-gray-700 mb-6">{{ $question }}</p>
                    
                    @if($questionType === 'video')
                        @php
                            $hasVideo = $submission && isset($submission->video_answers[$index]) && !empty($submission->video_answers[$index]);
                            // Debug: Show what we have
                            if($submission) {
                                \Log::info("Question $index video data:", [
                                    'has_video_answers' => isset($submission->video_answers),
                                    'video_answers_data' => $submission->video_answers,
                                    'specific_index' => $submission->video_answers[$index] ?? 'not set'
                                ]);
                            }
                        @endphp
                        
                        @if($hasVideo)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Submitted Video:</label>
                                <video controls class="w-full max-w-md bg-black rounded">
                                    <source src="{{ $submission->video_answers[$index] }}" type="video/webm">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="text-green-600 text-sm mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>Video submitted successfully
                                </p>
                            </div>
                        @elseif($submission)
                            <div class="bg-gray-100 p-4 rounded-lg text-center">
                                <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-600">No video was recorded for this question</p>
                                <p class="text-xs text-gray-500 mt-1">Debug: {{ json_encode($submission->video_answers ?? 'null') }}</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Record Your Video Response
                                    </label>
                                    <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                        <video id="video_{{ $index }}" width="400" height="300" class="mx-auto mb-4 hidden bg-black rounded"></video>
                                        <div id="controls_{{ $index }}">
                                            <button type="button" onclick="startRecording({{ $index }})" 
                                                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 mr-2">
                                                <i class="fas fa-record-vinyl mr-2"></i>Start Recording
                                            </button>
                                            <button type="button" onclick="stopRecording({{ $index }})" 
                                                    class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 hidden">
                                                <i class="fas fa-stop mr-2"></i>Stop Recording
                                            </button>
                                            <button type="button" onclick="playRecording({{ $index }})" 
                                                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 hidden ml-2">
                                                <i class="fas fa-play mr-2"></i>Play
                                            </button>
                                        </div>
                                        <p id="status_{{ $index }}" class="text-gray-600 mt-2">Click to start recording your video response</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    
                    @elseif($questionType === 'mcq')
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Select your answer:</label>
                            <div class="space-y-3">
                                @php
                                    $mcqOptions = $interview->mcq_options[$index] ?? ['Option A', 'Option B'];
                                    $selectedAnswer = $submission->answers[$index] ?? null;
                                @endphp
                                @foreach($mcqOptions as $key => $option)
                                    @if(!empty($option))
                                        @php
                                            $optionLetter = chr(65 + $key);
                                            $isSelected = $selectedAnswer === $optionLetter;
                                        @endphp
                                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:bg-blue-50 hover:border-blue-300 {{ $isSelected ? 'bg-blue-100 border-blue-500' : 'border-gray-200' }} {{ $submission ? 'cursor-not-allowed opacity-75' : '' }}">
                                            <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}" 
                                                   class="w-5 h-5 text-blue-600 mr-4" 
                                                   {{ $submission ? 'disabled' : 'required' }}
                                                   {{ $selectedAnswer === $option ? 'checked' : '' }}>
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold mr-3">
                                                        {{ $optionLetter }}
                                                    </span>
                                                    <span class="text-gray-900 font-medium">{{ $option }}</span>
                                                </div>
                                            </div>
                                            @if($selectedAnswer === $option)
                                                <div class="ml-3">
                                                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                                                </div>
                                            @endif
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    
                    @elseif($questionType === 'rating')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Rate from 1 to 10:</label>
                            @php
                                $selectedRating = $submission->answers[$index] ?? null;
                            @endphp
                            <div class="flex items-center justify-center space-x-2 p-4 bg-gray-50 rounded-lg">
                                @for($i = 1; $i <= 10; $i++)
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="answers[{{ $index }}]" value="{{ $i }}" 
                                               class="sr-only" {{ $submission ? 'disabled' : 'required' }}
                                               {{ $selectedRating == $i ? 'checked' : '' }}
                                               onchange="highlightRating(this, {{ $index }}, {{ $i }})">
                                        <div id="rating_{{ $index }}_{{ $i }}" class="w-12 h-12 rounded-full border-2 flex items-center justify-center text-lg font-bold transition-all duration-200 
                                                    {{ $selectedRating == $i ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-blue-400 hover:bg-blue-50' }}">
                                            {{ $i }}
                                        </div>
                                        <span class="text-xs text-gray-500 mt-1">
                                            @if($i == 1) Poor
                                            @elseif($i <= 3) Below
                                            @elseif($i <= 5) Average
                                            @elseif($i <= 7) Good
                                            @elseif($i <= 9) Great
                                            @else Perfect
                                            @endif
                                        </span>
                                    </label>
                                @endfor
                            </div>
                            <div id="rating_selected_{{ $index }}" class="mt-3 text-center {{ $selectedRating ? '' : 'hidden' }}">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                    <i class="fas fa-star mr-2"></i>Selected: <span id="rating_value_{{ $index }}">{{ $selectedRating }}</span>/10
                                </span>
                            </div>
                        </div>
                    
                    @elseif($questionType === 'file')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload your file:</label>
                            <input type="file" name="answers[{{ $index }}]" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   {{ $submission ? 'disabled' : 'required' }}>
                        </div>
                    
                    @else
                        <div>
                            <label for="answer_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Text Response
                            </label>
                            <textarea id="answer_{{ $index }}" name="answers[{{ $index }}]" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Type your answer here..."
                                      {{ $submission ? 'readonly' : 'required' }}>{{ $submission ? $submission->answers[$index] ?? '' : '' }}</textarea>
                        </div>
                    @endif
                </div>
            @endforeach
            
            @if(!$submission)
                <div class="flex justify-between">
                    <a href="{{ route('interviews.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400">
                        Back to Interviews
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                        Submit Responses
                    </button>
                </div>
            @else
                <div class="text-center">
                    <a href="{{ route('interviews.index') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                        Back to Interviews
                    </a>
                </div>
            @endif
        </form>
        @endif
    </div>
</div>

<script>
function debugFormSubmission(event) {
    event.preventDefault(); // Prevent normal form submission
    
    console.log('Form submission started');
    const form = event.target;
    const formData = new FormData(form);
    
    // Add video data manually
    const videoInputs = document.querySelectorAll('input[name^="video_answers"]');
    videoInputs.forEach(input => {
        if (input.value) {
            formData.set(input.name, input.value);
            console.log(`Added video data for ${input.name}: ${input.value.length} characters`);
        }
    });
    
    // Submit via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '/interviews';
        } else {
            console.error('Submission failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function highlightRating(input, questionIndex, selectedValue) {
    // Reset all ratings for this question
    for (let i = 1; i <= 10; i++) {
        const circle = document.getElementById(`rating_${questionIndex}_${i}`);
        if (circle) {
            circle.className = 'w-12 h-12 rounded-full border-2 flex items-center justify-center text-lg font-bold transition-all duration-200 bg-white border-gray-300 text-gray-600 hover:border-blue-400 hover:bg-blue-50';
        }
    }
    
    // Highlight selected rating
    const selectedCircle = document.getElementById(`rating_${questionIndex}_${selectedValue}`);
    if (selectedCircle) {
        selectedCircle.className = 'w-12 h-12 rounded-full border-2 flex items-center justify-center text-lg font-bold transition-all duration-200 bg-blue-600 border-blue-600 text-white';
    }
    
    // Show selected indicator
    const indicator = document.getElementById(`rating_selected_${questionIndex}`);
    const valueSpan = document.getElementById(`rating_value_${questionIndex}`);
    if (indicator && valueSpan) {
        indicator.classList.remove('hidden');
        valueSpan.textContent = selectedValue;
    }
}

// Simpler video approach - save as base64 in database
let mediaRecorder = {};
let recordedChunks = {};
let stream = {};

async function startRecording(questionIndex) {
    const video = document.getElementById(`video_${questionIndex}`);
    const status = document.getElementById(`status_${questionIndex}`);
    const startBtn = document.querySelector(`button[onclick="startRecording(${questionIndex})"]`);
    const stopBtn = document.querySelector(`button[onclick="stopRecording(${questionIndex})"]`);
    
    status.textContent = 'Requesting camera access...';
    
    try {
        // Force browser to ask for permission
        const constraints = {
            video: {
                width: { ideal: 640 },
                height: { ideal: 480 }
            },
            audio: true
        };
        
        stream[questionIndex] = await navigator.mediaDevices.getUserMedia(constraints);
        
        video.srcObject = stream[questionIndex];
        video.classList.remove('hidden');
        video.muted = true; // Prevent feedback
        await video.play();
        
        // Setup MediaRecorder
        recordedChunks[questionIndex] = [];
        mediaRecorder[questionIndex] = new MediaRecorder(stream[questionIndex]);
        
        mediaRecorder[questionIndex].ondataavailable = function(event) {
            if (event.data.size > 0) {
                recordedChunks[questionIndex].push(event.data);
            }
        };
        
        mediaRecorder[questionIndex].onstop = function() {
            const blob = new Blob(recordedChunks[questionIndex], { type: 'video/webm' });
            
            video.srcObject = null;
            video.src = URL.createObjectURL(blob);
            video.controls = true;
            video.muted = false;
            
            // Convert to base64 and save
            const reader = new FileReader();
            reader.onloadend = function() {
                const base64data = reader.result;
                let hiddenInput = document.getElementById(`video_data_${questionIndex}`);
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.id = `video_data_${questionIndex}`;
                    hiddenInput.name = `video_answers[${questionIndex}]`;
                    document.querySelector('form').appendChild(hiddenInput);
                }
                hiddenInput.value = base64data;
                
                // Debug: Log what we're setting
                console.log('Video data set for question', questionIndex, 'Length:', base64data.length);
                console.log('Hidden input created:', hiddenInput);
                
                status.textContent = 'Video recorded! Will be saved when you submit.';
            };
            reader.readAsDataURL(blob);
            
            document.querySelector(`button[onclick="playRecording(${questionIndex})"]`).classList.remove('hidden');
        };
        
        // Start recording
        mediaRecorder[questionIndex].start();
        status.textContent = 'Recording... Click stop when finished.';
        startBtn.classList.add('hidden');
        stopBtn.classList.remove('hidden');
        
    } catch (error) {
        console.error('Camera error:', error);
        
        if (error.name === 'NotAllowedError') {
            status.innerHTML = 'Camera access denied. <br><strong>Please click the camera icon in your browser address bar and allow access, then try again.</strong><br>Or use text response below.';
        } else if (error.name === 'NotFoundError') {
            status.textContent = 'No camera found. Please use text response below.';
        } else {
            status.textContent = 'Camera not available. Please use text response below.';
        }
    }
}

function stopRecording(questionIndex) {
    if (mediaRecorder[questionIndex] && mediaRecorder[questionIndex].state === 'recording') {
        mediaRecorder[questionIndex].stop();
        
        // Stop all tracks
        if (stream[questionIndex]) {
            stream[questionIndex].getTracks().forEach(track => track.stop());
        }
        
        const startBtn = document.querySelector(`button[onclick="startRecording(${questionIndex})"]`);
        const stopBtn = document.querySelector(`button[onclick="stopRecording(${questionIndex})"]`);
        
        startBtn.classList.remove('hidden');
        stopBtn.classList.add('hidden');
    }
}

function playRecording(questionIndex) {
    const video = document.getElementById(`video_${questionIndex}`);
    video.play();
}
</script>
@endsection
