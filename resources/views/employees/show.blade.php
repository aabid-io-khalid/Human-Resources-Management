@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="this.parentElement.parentElement.remove()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" onclick="this.parentElement.parentElement.remove()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 1-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('employees.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Employees</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $employee->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Employee Profile Header -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Employee Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and information.</p>
            </div>
            <!-- Edit Mode Toggle -->
            <div>
                <button type="button" id="toggleEditMode" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg id="editIcon" class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span id="editButtonText">Edit Information</span>
                </button>
            </div>
        </div>
        
        <!-- Employee Profile and Cursus Header -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="h-24 w-24 bg-blue-100 rounded-full flex items-center justify-center text-blue-800 text-2xl font-bold mb-4">
                    {{ substr($employee->name, 0, 2) }}
                </div>
                <h2 class="text-xl font-bold view-mode">{{ $employee->name }}</h2>
                <p class="text-sm text-gray-500">@{{ $ employee->email }}</p>
                <p class="text-sm text-gray-700 mt-1 view-mode">{{ $employee->job_title }}</p>
                <div class="mt-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $employee->department ? $employee->department->name : 'No department assigned' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Career Path Timeline (Cursus) -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium text-gray-900 mb-5">Career Path</h3>
            
            <!-- Timeline Component -->
            <div class="relative">
                @if(count($careerSteps) > 0)
                    <!-- Timeline Line -->
                    <div class="absolute h-full w-0.5 bg-blue-500 left-6 top-0 transform -translate-x-1/2"></div>
                    
                    <!-- Timeline Items -->
                    <div class="relative z-10">
                        <div class="flex items-center space-x-8 mb-8">
                            @foreach($careerSteps as $index => $step)
                                <div class="flex-1 text-center">
                                    <div class="text-xs text-gray-500 mb-2">{{ $step->step_date->format('d/m/Y') }}</div>
                                    <div class="relative">
                                        <!-- Timeline Point -->
                                        <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 -top-4">
                                            <div class="w-4 h-4 bg-white border-2 {{ $step->is_current ? 'border-green-500' : 'border-blue-500' }} rounded-full"></div>
                                        </div>
                                        @if($index < count($careerSteps) - 1)
                                            <!-- Timeline Connector -->
                                            <div class="absolute left-1/2 w-full h-0.5 bg-blue-500 top-0 transform -translate-y-1/2"></div>
                                        @endif
                                    </div>
                                    <div class="mt-4 bg-gray-100 p-4 rounded-lg shadow hover:bg-gray-200 transition duration-200">
                                        <div class="font-medium">{{ $step->title }}</div>
                                        @if($step->type)
                                            <div class="text-sm text-gray-500">Type: {{ $step->type }}</div>
                                        @endif
                                        @if($step->status)
                                            <div class="text-xs mt-1">
                                                <span class="px-2 py-0.5 rounded-full 
                                                    {{ $step->status == 'Active' ? 'bg-green-100 text-green-800' : 
                                                       ($step->status == 'Certified' ? 'bg-blue-100 text-blue-800' : 
                                                        'bg-gray-100 text-gray-800') }}">
                                                    {{ $step->status }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Admin actions -->
                                        <div class="mt-2 flex space-x-2 justify-center">
                                            <button type="button" onclick="editStep({{ $step->id }})" class="text-xs text-blue-600 hover:underline">
                                                Edit
                                            </button>
                                            <form action="{{ route('career-steps.destroy', $step->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this step?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Current Contract Info Card -->
                @if($currentStep)
                <div class="mt-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-900">Current Position</h4>
                        <div class="flex items-center">
                            <span class="h-3 w-3 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-500">{{ $currentStep->status }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="font-medium">{{ $currentStep->type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class=" text-sm text-gray-500">Location</p>
                            <p class="font-medium">{{ $employee->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium">{{ $currentStep->step_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Department</p>
                            <p class="font-medium">{{ $employee->department ? $employee->department->name : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Manager</p>
                            <p class="font-medium">{{ $employee->manager ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Grade</p>
                            <p class="font-medium">{{ $employee->grade ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <!-- Absences & Delays Section -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Absences</p>
                            <p class="font-medium">{{ $employee->absences ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Retards</p>
                            <p class="font-medium">{{ $employee->delays ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <!-- Remarks Section -->
                    <div class="mt-6">
                        <p class="text-sm text-gray-500 mb-1">Remarques</p>
                        <p class="font-medium text-gray-700 italic">{{ $currentStep->details ?? 'No remarks available' }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Add New Career Step (Admin Only) -->
                <div class="mt-6 text-right view-mode">
                    <button type="button" onclick="showAddStepModal()" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Career Step
                    </button>
                </div>
            </div>
        </div>

        <!-- Employee Details Form -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form id="employeeForm" action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Profile Section -->
                            <div class="edit-mode hidden">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ $employee->name }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Department Information -->
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-3">Department Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="mb-4 edit-mode hidden">
                                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                        <select id="department_id" name="department_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                        <p class="text-gray-900 view-mode">{{ $employee->job_title }}</p>
                                        <div class="edit-mode hidden">
                                            <input type="text" id="job_title" name="job_title" value="{{ $employee->job_title }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                                        <p class="text-gray-900 view-mode">${{ number_format($employee->salary, 2) }}</p>
                                        <div class="edit-mode hidden">
                                            <input type="number" id="salary" name="salary" value="{{ $employee->salary }}" step="0.01" min="0" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Contact Information -->
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-3">Contact Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <p class="text-gray-900 view-mode">{{ $employee->email }}</p>
                                        <div class="edit-mode hidden">
                                            <input type="email" id="email" name="email" value="{{ $employee->email }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <p class="text-gray-900 view-mode">{{ $employee->phone ?? 'N/A' }}</p>
                                        <div class="edit-mode hidden">
                                            <input type="tel" id="phone" name="phone" value="{{ $employee->phone }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-3">Employment Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee since</label>
                                        <p class="text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last updated</label>
                                        <p class="text-gray-900">{{ $employee->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end space-x-4 mt-8 edit-mode hidden">
                                <button type="button" onclick="cancelEdit()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Save Changes
                                </button>
                            </div>
                            
                            <!-- Delete Employee Button (View Mode Only) -->
                            <div class="mt-6 view-mode">
                                <button type="button" onclick="showDeleteModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring- 2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Employee
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0l-3-3m3 3l-3 3" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Employee</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete this employee? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </form>                
                    <button type="button" onclick="hideDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Career Step Modal -->
    <div id="addStepModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class ="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Career Step</h3>
                            <div class="mt-4">
                                <form id="addStepForm" action="{{ route('employees.add-career-step', $employee->id) }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label for="step_date" class="block text-sm font-medium text-gray-700">Date</label>
                                            <input type="date" name="step_date" id="step_date" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="step_title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" name="step_title" id="step_title" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="step_type" class="block text-sm font-medium text-gray-700">Type</label>
                                            <select name="step_type" id="step_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">Select Type</option>
                                                <option value="CDI">CDI</option>
                                                <option value="CDD">CDD</option>
                                                <option value="Internship">Internship</option>
                                                <option value="Certification">Certification</option>
                                                <option value="Promotion">Promotion</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="step_status" class="block text-sm font-medium text-gray-700">Status</label>
                                            <select name="step_status" id="step_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="Active">Active</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Certified">Certified</option>
                                                <option value="Pass">Pass</option>
                                                <option value="Fail">Fail</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="step_details" class="block text-sm font-medium text-gray-700">Details</label>
                                            <textarea name="step_details" id="step_details" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="is_current" name="is_current" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="is_current" class="font-medium text-gray-700">Mark as current position</label>
                                                <p class="text-gray-500">If checked, this will be shown as the employee's current position.</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        ```html
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="addStepForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Step
                    </button>
                    <button type="button" onclick="hideAddStepModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle between view and edit modes
    document.getElementById('toggleEditMode').addEventListener('click', function() {
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');
        const editButtonText = document.getElementById('editButtonText');
        const editIcon = document.getElementById('editIcon');
        
        // Check current state
        const isEditMode = editElements[0].classList.contains('hidden');
        
        if (isEditMode) {
            // Switch to edit mode
            viewElements.forEach(el => el.classList.add('hidden'));
            editElements.forEach(el => el.classList.remove('hidden'));
            editButtonText.textContent = 'Cancel Editing';
            editIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
        } else {
            // Switch back to view mode
            cancelEdit();
        }
    });
    
    // Cancel edit function
    function cancelEdit() {
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');
        const editButtonText = document.getElementById('editButtonText');
        const editIcon = document.getElementById('editIcon');
        
        viewElements.forEach(el => el.classList.remove('hidden'));
        editElements.forEach(el => el.classList.add('hidden'));
        editButtonText.textContent = 'Edit Information';
        editIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />';
    }
    
    // Show delete modal
    function showDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    // Hide delete modal
    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Show add step modal
    function showAddStepModal() {
        document.getElementById('addStepModal').classList.remove('hidden');
    }
    
    // Hide add step modal
    function hideAddStepModal() {
        document.getElementById('addStepModal').classList.add('hidden');
    }
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const deleteModal = document.getElementById('deleteModal');
        const addStepModal = document.getElementById('addStepModal');
        
        if (event.target === deleteModal) {
            hideDeleteModal();
        }
        
        if (event.target === addStepModal) {
            hideAddStepModal();
        }
    });
    
    // Close modals with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideDeleteModal();
            hideAddStepModal();
        }
    });

    // Store career steps data in JavaScript
    const careerStepsData = @json($careerSteps);

    // Function to show edit modal with pre-filled data
    function editStep(stepId) {
        // Find the step data from our JavaScript object
        const step = careerStepsData.find(s => s.id === stepId);
        
        if ( step) {
            // Update form action URL
            document.getElementById('editStepForm').action = `/career-steps/${stepId}`;
            
            // Fill form fields
            document.getElementById('edit_step_date').value = step.step_date.substring(0, 10); // Format as YYYY-MM-DD
            document.getElementById('edit_step_title').value = step.title;
            document.getElementById('edit_step_type').value = step.type || '';
            document.getElementById('edit_step_status').value = step.status;
            document.getElementById('edit_step_details').value = step.details || '';
            document.getElementById('edit_is_current').checked = step.is_current;
            
            // Show modal
            document.getElementById('editStepModal').classList.remove('hidden');
        }
    }

    // Hide edit step modal
    function hideEditStepModal() {
        document.getElementById('editStepModal').classList.add('hidden');
    }

    // Close edit modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editStepModal');
        if (event.target === modal) {
            hideEditStepModal();
        }
    });
</script>
@endsection