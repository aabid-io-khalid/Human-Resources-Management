@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
            <h1 class="text-white text-xl font-bold">Your Notifications</h1>
        </div>
        
        <div class="p-4">
            @if ($notifications && $notifications->isNotEmpty())
                <div class="space-y-3">
                    @foreach ($notifications as $notification)
                        <div class="flex items-start p-3 border-l-4 border-blue-500 bg-gray-50 rounded hover:bg-blue-50 transition duration-150">
                            <div class="flex-1">
                                <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <button class="text-gray-400 hover:text-gray-600" title="Mark as read">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="mt-4 text-gray-500 text-lg">No notifications found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection