<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-50">
            <!-- Sidebar -->
            <div class="hidden md:flex md:w-64 md:flex-col">
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-blue-800 border-r border-gray-200">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <span class="text-xl font-semibold tracking-wider text-white">HR Management</span>
                    </div>
                    <div class="flex flex-col flex-grow mt-5">
                        <nav class="flex-1 px-2 space-y-1">
                            <a href="/employees" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Employees
                            </a>

                            <a href="/contracts" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Contracts
                            </a>

                            <a href="/departments" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Departments
                            </a>

                            <a href="/roles" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                Roles
                            </a>

                            <a href="/formations/" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Formation
                            </a>

                            <a href="/notifications/" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notification
                            </a>

                            <a href="/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Leave Requests
                            </a>

                            <a href="/hr/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                HR Leave Approvals
                            </a>

                            <a href="/manager/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Manager Leave Approvals
                            </a>

                            <a href="/organigramme" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md group">
                                <svg class="flex-shrink-0 w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                Organigramme
                            </a>
                        </nav>
                    </div>
                    <div class="p-4 border-t border-blue-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white"><?php echo e(Auth::check() ? Auth::user()->name : 'Guest'); ?></p>
                                <a href="<?php echo e(route('profile.edit')); ?>" class="text-xs font-medium text-blue-200 hover:text-white">View profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div x-data="{ open: false }" class="sticky top-0 z-10 flex items-center pt-1 pl-1 md:hidden">
                <button @click="open = !open" type="button" class="p-2 text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Mobile menu dropdown -->
                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-16 bg-blue-800 rounded-md shadow-lg w-64">
                    <nav class="p-2 space-y-1">
                        <a href="/employees" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Employees</a>
                        <a href="/contracts" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Contracts</a>
                        <a href="/departments" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Departments</a>
                        <a href="/roles" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Roles</a>
                        <a href="/formations/" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Formation</a>
                        <a href="/notifications/" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Notification</a>
                        <a href="/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Leave Requests</a>
                        <a href="/hr/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">HR Leave Approvals</a>
                        <a href="/manager/leave/requests" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Manager Leave Approvals</a>
                        <a href="/organigramme" class="flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 rounded-md">Organigramme</a>
                    </nav>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Top Navigation Bar -->
                <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow">
                    <div class="flex flex-1 justify-end px-4">
                        <div class="flex items-center ml-4 md:ml-6">
                            <!-- Notification dropdown -->
                            <div class="relative ml-3">
                                <button type="button" class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- User dropdown -->
                            <div x-data="{ open: false }" class="relative ml-3">
                                <div>
                                    <button @click= "open = !open" type="button" class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </button>
                                </div>
                                
                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                                    <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Dashboard</a>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Log out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Heading -->
                <?php if(isset($header)): ?>
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <?php echo e($header); ?>

                        </div>
                    </header>
                <?php endif; ?>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            </div>
        </div>
        
        <!-- Alpine.js for dropdown functionality -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html><?php /**PATH C:\Users\Youcode\Herd\hrsm\resources\views/layouts/app.blade.php ENDPATH**/ ?>