@extends('layout')

@section('title', 'Login - Hireflix')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold text-center mb-8">Sign In</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Sign In
        </button>
    </form>
    
    <div class="text-center mt-6">
        <p class="text-gray-600">Don't have an account?</p>
        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Sign up here</a>
    </div>
</div>
@endsection
