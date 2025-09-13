@extends('layout')

@section('title', 'Create Interview - Hireflix')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Create New Interview</h1>
    
    <form method="POST" action="{{ route('interviews.store') }}" class="bg-white rounded-lg shadow-lg p-8">
        @csrf
        
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Interview Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="e.g., Frontend Developer Interview">
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea id="description" name="description" rows="4" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Describe the interview purpose and expectations...">{{ old('description') }}</textarea>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Interview Questions</label>
            <div id="questions-container">
                <div class="question-item mb-6 p-4 border border-gray-200 rounded-lg">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                        <select name="question_types[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="toggleQuestionOptions(this)">
                            <option value="text">Text Response</option>
                            <option value="video">Video Response</option>
                            <option value="mcq">Multiple Choice</option>
                            <option value="rating">Rating Scale (1-10)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                        <input type="text" name="questions[]" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your question...">
                    </div>
                    
                    <div class="mcq-options hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options (for MCQ)</label>
                        <div class="mcq-options-container space-y-2">
                            <input type="text" name="mcq_options[0][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Option 1">
                            <input type="text" name="mcq_options[0][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Option 2">
                        </div>
                        <button type="button" onclick="addMcqOption(this)" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-plus mr-1"></i>Add Option
                        </button>
                    </div>
                    
                    <div class="rating-options hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating Scale</label>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Min: 1</span>
                            <span class="text-sm text-gray-600">Max: 10</span>
                            <input type="text" name="rating_labels[0]" class="px-3 py-2 border border-gray-300 rounded-md" placeholder="Label (e.g., Communication Skills)">
                        </div>
                    </div>
                    
                    <button type="button" onclick="removeQuestion(this)" 
                            class="mt-3 text-red-600 hover:text-red-800 text-sm hidden">
                        <i class="fas fa-trash mr-1"></i>Remove Question
                    </button>
                </div>
            </div>
            
            <button type="button" onclick="addQuestion()" 
                    class="text-blue-600 hover:text-blue-800 text-sm">
                <i class="fas fa-plus mr-1"></i>Add Another Question
            </button>
        </div>
        
        <div class="flex justify-between">
            <a href="{{ route('interviews.index') }}" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Create Interview
            </button>
        </div>
    </form>
</div>

<script>
let questionCount = 0;

function toggleQuestionOptions(select) {
    const questionItem = select.closest('.question-item');
    const mcqOptions = questionItem.querySelector('.mcq-options');
    const ratingOptions = questionItem.querySelector('.rating-options');
    
    // Hide all options first
    mcqOptions.classList.add('hidden');
    ratingOptions.classList.add('hidden');
    
    // Show relevant options
    if (select.value === 'mcq') {
        mcqOptions.classList.remove('hidden');
    } else if (select.value === 'rating') {
        ratingOptions.classList.remove('hidden');
    }
}

function addMcqOption(button) {
    const container = button.previousElementSibling;
    const questionItem = button.closest('.question-item');
    const questionIndex = Array.from(questionItem.parentNode.children).indexOf(questionItem);
    const optionCount = container.children.length + 1;
    
    const input = document.createElement('input');
    input.type = 'text';
    input.name = `mcq_options[${questionIndex}][]`;
    input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md';
    input.placeholder = `Option ${optionCount}`;
    input.required = false;
    
    container.appendChild(input);
}

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questions-container');
    const questionItem = document.createElement('div');
    questionItem.className = 'question-item mb-6 p-4 border border-gray-200 rounded-lg';
    questionItem.innerHTML = `
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
            <select name="question_types[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="toggleQuestionOptions(this)">
                <option value="text">Text Response</option>
                <option value="video">Video Response</option>
                <option value="mcq">Multiple Choice</option>
                <option value="rating">Rating Scale (1-10)</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
            <input type="text" name="questions[]" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter your question...">
        </div>
        
        <div class="mcq-options hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options (for MCQ)</label>
            <div class="mcq-options-container space-y-2">
                <input type="text" name="mcq_options[${questionCount}][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Option 1">
                <input type="text" name="mcq_options[${questionCount}][]" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Option 2">
            </div>
            <button type="button" onclick="addMcqOption(this)" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                <i class="fas fa-plus mr-1"></i>Add Option
            </button>
        </div>
        
        <div class="rating-options hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Rating Scale</label>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Min: 1</span>
                <span class="text-sm text-gray-600">Max: 10</span>
                <input type="text" name="rating_labels[${questionCount}]" class="px-3 py-2 border border-gray-300 rounded-md" placeholder="Label (e.g., Communication Skills)">
            </div>
        </div>
        
        <button type="button" onclick="removeQuestion(this)" 
                class="mt-3 text-red-600 hover:text-red-800 text-sm">
            <i class="fas fa-trash mr-1"></i>Remove Question
        </button>
    `;
    container.appendChild(questionItem);
    updateRemoveButtons();
}

function removeQuestion(button) {
    button.closest('.question-item').remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((item, index) => {
        const removeBtn = item.querySelector('button[onclick*="removeQuestion"]');
        if (questions.length > 1) {
            removeBtn.classList.remove('hidden');
        } else {
            removeBtn.classList.add('hidden');
        }
    });
}
</script>
@endsection
