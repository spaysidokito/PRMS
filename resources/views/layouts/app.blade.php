<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> {{-- For icons --}}
    </head>
    <body class="dashboard-body">
        <x-banner />

        <div class="dashboard-layout">
            <!-- Sidebar -->
            <aside class="dashboard-sidebar slide-in">
                <div class="sidebar-header">
                    <img src="{{ asset('images/logo.png') }}" alt="PRIMOSA Logo" class="logo-image" />
                    <div class="app-name">PRIMOSA</div>
                </div>
                <nav class="sidebar-nav">
                    <ul>
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-home"></i></span> <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        @if(auth()->user()->canEdit())
                        <li>
                            <a href="{{ route('student-profiles.index') }}" class="{{ request()->routeIs('student-profiles.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-users-cog"></i></span> <span class="nav-text">Student Management</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-calendar-check"></i></span> <span class="nav-text">Event Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources.index') }}" class="{{ request()->routeIs('resources.*') && !request()->routeIs('analytics.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-cubes"></i></span> <span class="nav-text">Resource Management</span>
                            </a>
                        </li>
                        @if(auth()->user()->canEdit())
                        <li>
                            <a href="{{ route('form-submissions.index') }}" class="{{ request()->routeIs('form-submissions.index') || request()->routeIs('form-submissions.show') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-file-upload"></i></span> <span class="nav-text">Form Submissions</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isStudent())
                        <li>
                            <a href="{{ route('form-submissions.my-submissions') }}" class="{{ request()->routeIs('form-submissions.my-submissions') || request()->routeIs('form-submissions.create') || request()->routeIs('form-submissions.show') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-file-upload"></i></span> <span class="nav-text">My Submissions</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('my-documents.index') }}" class="{{ request()->routeIs('my-documents.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-folder-open"></i></span> <span class="nav-text">My Documents</span>
                            </a>
                        </li>
                        @if(auth()->user()->canEdit())
                        <li>
                            <a href="{{ route('analytics.index') }}" class="{{ request()->routeIs('analytics.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-chart-line"></i></span> <span class="nav-text">Analytics</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->canManageUsers())
                        <li>
                            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }} nav-link-hover">
                                <span class="nav-icon"><i class="fas fa-user-shield"></i></span> <span class="nav-text">User Management</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('profile.show') }}" class="nav-link-hover"> {{-- Assuming settings are part of profile --}}
                                <span class="nav-icon"><i class="fas fa-cog"></i></span> <span class="nav-text">Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="sidebar-footer">
                    <button class="collapse-btn btn-click" onclick="toggleSidebar()">
                        <span class="nav-icon"><i class="fas fa-chevron-left"></i></span> <span class="nav-text">Collapse</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="dashboard-main-content">
                <!-- Page Heading / Header -->
                <header class="dashboard-header fade-in">
                    <div class="header-title">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            Dashboard
                        @endif
                    </div>
                    <div class="user-profile-dropdown">
                        @livewire('navigation-menu') {{-- Repurposing for user dropdown, might need custom component later --}}
                    </div>
                </header>

                <!-- Page Content -->
                <main class="dashboard-content-area page-transition">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
        <script>
            function toggleSidebar() {
                const sidebar = document.querySelector('.dashboard-sidebar');
                const mainContent = document.querySelector('.dashboard-main-content');
                const collapseBtnIcon = document.querySelector('.collapse-btn .fas');
                const navTexts = document.querySelectorAll('.sidebar-nav .nav-text, .sidebar-footer .nav-text');
                const appName = document.querySelector('.sidebar-header .app-name');

                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');

                if (sidebar.classList.contains('collapsed')) {
                    sidebar.style.width = '80px';
                    mainContent.style.marginLeft = '80px';
                    if(collapseBtnIcon) {
                        collapseBtnIcon.classList.remove('fa-chevron-left');
                        collapseBtnIcon.classList.add('fa-chevron-right');
                    }
                    navTexts.forEach(el => el.style.display = 'none');
                    if(appName) appName.style.display = 'none';

                } else {
                    sidebar.style.width = '280px';
                    mainContent.style.marginLeft = '280px';
                    if(collapseBtnIcon) {
                        collapseBtnIcon.classList.remove('fa-chevron-right');
                        collapseBtnIcon.classList.add('fa-chevron-left');
                    }
                    navTexts.forEach(el => el.style.display = 'inline');
                    if(appName) appName.style.display = 'inline-block'; // or 'inline'
                }
            }

            // Enhanced page transition handling
            document.addEventListener('DOMContentLoaded', function() {
                // Add loading state to navigation links
                const navLinks = document.querySelectorAll('.sidebar-nav a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        // Add subtle animation to the clicked link
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                });

                // Add animation to page content on load
                const contentArea = document.querySelector('.dashboard-content-area');
                if (contentArea) {
                    contentArea.style.opacity = '0';
                    contentArea.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        contentArea.style.transition = 'all 0.4s ease-out';
                        contentArea.style.opacity = '1';
                        contentArea.style.transform = 'translateY(0)';
                    }, 100);
                }
            });
        </script>
    </body>
</html>
