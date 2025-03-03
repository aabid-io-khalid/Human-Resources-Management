@extends('layouts.app')

@section('styles')
<style>
    .org-tree {
        --connector-color: #ddd;
        --hover-color: #f0f9ff;
    }
    
    .org-tree .node {
        transition: all 0.2s ease;
        padding: 10px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .org-tree .node:hover {
        background-color: var(--hover-color);
        transform: translateY(-2px);
    }
    
    /* Lines for the org chart */
    .org-tree ul {
        position: relative;
        padding-top: 20px;
    }
    
    .org-tree li {
        position: relative;
        padding: 0 0 0 20px;
    }
    
    .org-tree li::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        border-left: 1px solid var(--connector-color);
        height: 100%;
    }
    
    .org-tree li:last-child::before {
        height: 20px;
    }
    
    .org-tree li::after {
        content: "";
        position: absolute;
        top: 20px;
        left: 0;
        border-top: 1px solid var(--connector-color);
        width: 20px;
    }
    
    .org-tree > ul > li::before,
    .org-tree > ul > li::after {
        display: none;
    }
    
    .org-tree ul ul {
        margin-left: 10px;
    }
    
    /* Department colors */
    .dept-hr { --dept-color: #4f46e5; }
    .dept-finance { --dept-color: #0891b2; }
    .dept-it { --dept-color: #059669; }
    .dept-marketing { --dept-color: #d97706; }
    .dept-operations { --dept-color: #dc2626; }
    .dept-sales { --dept-color: #7c3aed; }
    .dept-default { --dept-color: #6b7280; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Enterprise Organizational Structure</h1>
    
    <div class="mb-8 bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Organizational Chart
            </h2>
            
            <div class="flex space-x-2">
                <button id="expand-all" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md text-sm hover:bg-indigo-200 transition">
                    Expand All
                </button>
                <button id="collapse-all" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200 transition">
                    Collapse All
                </button>
                
                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {{-- Assuming 1 is HR and 2 is Admin --}}
                <a href="{{ route('organigramme.edit') }}" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 transition">
                    Edit Structure
                </a>
                @endif
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex flex-wrap -mx-2">
                <div class="px-2 mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 mr-1"></span>
                        Executive
                    </span>
                </div>
                <div class="px-2 mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-1"></span>
                        Manager
                    </span>
                </div>
                <div class="px-2 mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span>
                        Team Lead
                    </span>
                </div>
                <div class="px-2 mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <span class="w-2 h-2 rounded-full bg-gray-500 mr-1"></span>
                        Employee
                    </span>
                </div>
            </div>
        </div>
        
        <div class="org-tree overflow-x-auto">
            <ul class="min-w-max">
                <li>
                    <div class="node w-64 border border-gray-300 rounded-lg p-4 mb-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center text-white text-lg font-bold">
                                    CEO
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $ceo->name ?? 'CEO Name' }}</h3>
                                <p class="text-sm text-gray-500">Chief Executive Officer</p>
                                
                                @if(auth()->user()->role_id == 1) {{-- Assuming 1 is HR --}}
                                <button class="mt-1 text-xs text-indigo-600 hover:text-indigo-800" onclick="showEmployeeDetails({{ $ceo->id ?? 1 }})">
                                    View Details
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <ul>
                        <li class="dept-hr">
                            <div class="node w-64 border border-gray-300 rounded-lg p-4 mb-4 relative" style="border-left: 4px solid var(--dept-color);">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                            HR
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-base font-medium text-gray-900">{{ $hr_director->name ?? 'HR Director' }}</h3>
                                        <p class="text-xs text-gray-500">Human Resources</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Manager
                                        </span>
                                        
                                        @if(auth()->user()->role_id == 1) {{-- Assuming 1 is HR --}}
                                        <button class="mt-1 text-xs text-indigo-600 hover:text-indigo-800" onclick="showEmployeeDetails({{ $hr_director->id ?? 2 }})">
                                            View Details
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <button class="absolute top-2 right-2 toggle-children">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg> </button>
                            </div>
                            
                            <ul class="dept-children">
                                @foreach($hr_employees ?? [] as $employee)
                                <li>
                                    <div class="node w-64 border border-gray-300 rounded-lg p-3 mb-3">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 text-sm">
                                                    {{ strtoupper(substr($employee->name ?? 'HR', 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $employee->name ?? 'HR Employee' }}</h3>
                                                <p class="text-xs text-gray-500">{{ $employee->job_title ?? 'HR Specialist' }}</p>
                                                
                                                @if(auth()->user()->role_id == 1 || (auth()->user()->role_id == 2 && auth()->user()->department_id == $employee->department_id)) 
                                                <button class="mt-1 text-xs text-indigo-600 hover:text-indigo-800" onclick="showEmployeeDetails({{ $employee->id ?? 1 }})">
                                                    View Details
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        
                        <li class="dept-it">
                            <div class="node w-64 border border-gray-300 rounded-lg p-4 mb-4 relative" style="border-left: 4px solid var(--dept-color);">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                            IT
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-base font-medium text-gray-900">{{ $it_director->name ?? 'IT Director' }}</h3>
                                        <p class="text-xs text-gray-500">Information Technology</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Manager
                                        </span>
                                        
                                        @if(auth()->user()->role_id == 1 || (auth()->user()->role_id == 2 && auth()->user()->department_id == 'IT')) 
                                        <button class="mt-1 text-xs text-indigo-600 hover:text-indigo-800" onclick="showEmployeeDetails({{ $it_director->id ?? 3 }})">
                                            View Details
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <button class="absolute top-2 right-2 toggle-children">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            
                            <ul class="dept-children">
                                @foreach($it_employees ?? [] as $employee)
                                <li>
                                    <div class="node w-64 border border-gray-300 rounded-lg p-3 mb-3">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 text-sm">
                                                    {{ strtoupper(substr($employee->name ?? 'IT', 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $employee->name ?? 'IT Employee' }}</h3>
                                                <p class="text-xs text-gray-500">{{ $employee->job_title ?? 'IT Specialist' }}</p>
                                                
                                                @if(auth()->user()->role_id == 1 || (auth()->user()->role_id == 2 && auth()->user()->department_id == $employee->department_id)) 
                                                <button class="mt-1 text-xs text-indigo-600 hover:text-indigo-800" onclick="showEmployeeDetails({{ $employee->id ?? 1 }})">
                                                    View Details
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
 </li>
                        
                        <li class="dept-marketing">
                            <div class="node w-64 border border-gray-300 rounded-lg p-4 mb-4 relative" style="border-left: 4px solid var(--dept-color);">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold">
                                            MK
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-base font-medium text-gray-900">{{ $marketing_director->name ?? 'Marketing Director' }}</h3>
                                        <p class="text-xs text-gray-500">Marketing Department</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Manager
                                        </span>
                                    </div>
                                </div>
                                
                                <button class="absolute top-2 right-2 toggle-children">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            
                            <ul class="dept-children">
                                @foreach($marketing_employees ?? [] as $employee)
                                <li>
                                    <div class="node w-64 border border-gray-300 rounded-lg p-3 mb-2">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs">
                                                    {{ strtoupper(substr($employee->name ?? 'MK', 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-2">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $employee->name ?? 'Marketing Specialist ' . $loop->iteration }}</h3>
                                                <p class="text-xs text-gray-500">{{ $employee->job_title ?? 'Marketing' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Employee Details Modal -->
    <div id="employee-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-employee-name">Employee Details</h3>
                    <button type="button" id="close-modal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="mb-4 flex items-center">
                    <div class="bg-indigo-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-medium" id="modal-full-name">John Doe</p>
                    </div >
                </div>
                
                <div class="mb-4 flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Position</p>
                        <p class="font-medium" id="modal-position">Manager</p>
                    </div>
                </div>
                
                <div class="mb-4 flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="font-medium" id="modal-department">IT Department</p>
                    </div>
                </div>
                
                <div class="mb-4 flex items-center">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Join Date</p>
                        <p class="font-medium" id="modal-join-date">January 15, 2022</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-1">Career Progress</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 65%" id="modal-career-progress"></div>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-xs text-gray-500">Current Level</span>
                        <span class="text-xs text-gray-500" id="modal-career-level">Level 3</span>
                    </div>
                </div>
                
                @if(auth()->user()->role_id == 1)
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="#" id="modal-view-formations" class="px ```html
                    <a href="#" id="modal-view-formations" class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded text-sm hover:bg-indigo-200 transition">
                        View Formations
                    </a>
                    <a href="#" id="modal-view-leaves" class="px-3 py-2 bg-amber-100 text-amber-700 rounded text-sm hover:bg-amber-200 transition">
                        View Leave Requests
                    </a>
                    <a href="#" id="modal-edit" class="px-3 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition">
                        Edit Employee
                    </a>
                </div>
                @endif
                
                @if(auth()->user()->role_id == 2)
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="#" id="modal-view-career" class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded text-sm hover:bg-indigo-200 transition">
                        Career Steps
                    </a>
                    <a href="#" id="modal-view-requests" class="px-3 py-2 bg-amber-100 text-amber-700 rounded text-sm hover:bg-amber-200 transition">
                        View Requests
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle department children visibility
        document.querySelectorAll('.toggle-children').forEach(button => {
            button.addEventListener('click', function() {
                const children = this.closest('.node').nextElementSibling;
                if (children) {
                    children.classList.toggle('hidden');
                }
            });
        });

        // Expand all button
        document.getElementById('expand-all').addEventListener('click', function() {
            document.querySelectorAll('.dept-children').forEach(child => {
                child.classList.remove('hidden');
            });
        });

        // Collapse all button
        document.getElementById('collapse-all').addEventListener('click', function() {
            document.querySelectorAll('.dept-children').forEach(child => {
                child.classList.add('hidden');
            });
        });
    });

    function showEmployeeDetails(employeeId) {
        // Fetch employee details via AJAX or set them directly for demo purposes
        // Example: Fetching data and populating modal
        document.getElementById('modal-full-name').innerText = 'Employee Name'; // Replace with actual data
        document.getElementById('modal-position').innerText = 'Employee Position'; // Replace with actual data
        document.getElementById('modal-department').innerText = 'Employee Department'; // Replace with actual data
        document.getElementById('modal-join-date').innerText = 'Join Date'; // Replace with actual data
        document.getElementById('modal-career-progress').style.width = '70%'; // Replace with actual data
        document.getElementById('modal-career-level').innerText = 'Level 2'; // Replace with actual data

        // Show modal
        document.getElementById('employee-modal').classList.remove('hidden');
    }

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('employee-modal').classList.add('hidden');
    });
</script>
@endsection