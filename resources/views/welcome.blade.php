@extends('layout')

@section('title', 'Welcome to Hireflix')

@section('content')
<div class="text-center">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">
            Welcome to <span class="text-blue-600">Hireflix</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            The modern video interview platform for seamless hiring
        </p>
        
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <i class="fas fa-user-tie text-4xl text-purple-600 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-4">For Recruiters</h3>
                <p class="text-gray-600 mb-6">Create interviews, review submissions, and score candidates efficiently.</p>
                <a href="{{ route('register.admin') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 inline-block">
                    Sign Up as Admin
                </a>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <i class="fas fa-user text-4xl text-green-600 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-4">For Candidates</h3>
                <p class="text-gray-600 mb-6">Record video responses to interview questions at your convenience.</p>
                <a href="{{ route('register.candidate') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 inline-block">
                    Sign Up as Candidate
                </a>
            </div>
        </div>
        
        <div class="text-center">
            <p class="text-gray-600 mb-4">Already have an account?</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 text-lg">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </a>
        </div>
    </div>
</div>
@endsection
