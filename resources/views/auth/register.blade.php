@extends('layout')

@section('title', 'Register - Hireflix')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold text-center mb-8">
        Sign Up as {{ ucfirst($role) }}
    </h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4 p-3 bg-{{ $role === 'admin' ? 'purple' : 'green' }}-50 rounded-md">
            <p class="text-sm text-{{ $role === 'admin' ? 'purple' : 'green' }}-700">
                <i class="fas fa-{{ $role === 'admin' ? 'user-tie' : 'user' }} mr-2"></i>
                You are registering as: <strong>{{ $role === 'admin' ? 'Admin/Reviewer' : 'Candidate' }}</strong>
            </p>
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <button type="submit" class="w-full bg-{{ $role === 'admin' ? 'purple' : 'green' }}-600 text-white py-2 px-4 rounded-md hover:bg-{{ $role === 'admin' ? 'purple' : 'green' }}-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Create {{ ucfirst($role) }} Account
        </button>
    </form>
    
    <div class="text-center mt-6">
        <p class="text-gray-600">Already have an account?</p>
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in here</a>
    </div>
</div>
@endsection
