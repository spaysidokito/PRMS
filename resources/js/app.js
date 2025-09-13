import './bootstrap';

// Page Transition Animations
document.addEventListener('DOMContentLoaded', function() {
    // Add animation classes to page content
    const pageContent = document.querySelector('.dashboard-content-area');
    if (pageContent) {
        pageContent.classList.add('fade-in');
    }

    // Add hover effects to navigation links
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    navLinks.forEach(link => {
        link.classList.add('nav-link-hover');
    });

    // Add card hover effects
    const cards = document.querySelectorAll('.bg-white.shadow-xl');
    cards.forEach(card => {
        card.classList.add('card-hover');
    });

    // Add button click animations
    const buttons = document.querySelectorAll('button, .btn, [type="submit"]');
    buttons.forEach(button => {
        button.classList.add('btn-click');
    });

    // Add table row hover effects
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.classList.add('table-row-hover');
    });

    // Calendar functionality
    initializeCalendar();

    // Page transition on navigation
    const links = document.querySelectorAll('a[href]:not([href^="#"]):not([href^="javascript:"]):not([target="_blank"])');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Skip if it's a form submission or special link
            if (link.closest('form') || link.hasAttribute('download') || link.getAttribute('href').includes('#')) {
                return;
            }

            // Add loading state
            const originalText = link.innerHTML;
            link.innerHTML = '<span class="loading-spinner"></span> Loading...';
            link.style.pointerEvents = 'none';

            // Add page exit animation
            const contentArea = document.querySelector('.dashboard-content-area');
            if (contentArea) {
                contentArea.style.transition = 'all 0.2s ease-out';
                contentArea.style.opacity = '0.7';
                contentArea.style.transform = 'translateX(-10px)';
            }

            // Reset after a short delay (simulating page load)
            setTimeout(() => {
                link.innerHTML = originalText;
                link.style.pointerEvents = 'auto';

                if (contentArea) {
                    contentArea.style.opacity = '1';
                    contentArea.style.transform = 'translateX(0)';
                }
            }, 300);
        });
    });

    // Livewire page transitions
    document.addEventListener('livewire:navigated', function() {
        const contentArea = document.querySelector('.dashboard-content-area');
        if (contentArea) {
            contentArea.classList.remove('fade-in');
            void contentArea.offsetWidth; // Trigger reflow
            contentArea.classList.add('fade-in');
        }

        // Reinitialize calendar after Livewire updates
        setTimeout(() => {
            initializeCalendar();
        }, 100);
    });

    // Form submission animations
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                submitBtn.disabled = true;

                // Reset after form submission
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            }
        });
    });

    // Modal animations
    const modals = document.querySelectorAll('.modal, [x-data*="modal"]');
    modals.forEach(modal => {
        modal.classList.add('scale-in');
    });

    // Search input animations
    const searchInputs = document.querySelectorAll('input[type="text"][placeholder*="Search"]');
    searchInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-in');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-in');
        });
    });

    // Add smooth scrolling
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Calendar functionality
function initializeCalendar() {
    const calendarDays = document.querySelectorAll('.calendar-day');

    calendarDays.forEach(day => {
        // Add hover effects for calendar days
        day.addEventListener('mouseenter', function() {
            if (this.classList.contains('has-events')) {
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            }
        });

        day.addEventListener('mouseleave', function() {
            if (this.classList.contains('has-events')) {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            }
        });

        // Add tooltip for days with events
        if (day.classList.contains('has-events')) {
            const events = day.querySelectorAll('.event-indicator');
            if (events.length > 0) {
                const eventTitles = Array.from(events).map(event => {
                    const eventTitle = event.getAttribute('data-event-title') || 'Event';
                    return eventTitle;
                }).join(', ');

                day.setAttribute('title', `Events: ${eventTitles}`);
            }
        }

        // Add hover animation for event indicators
        const eventIndicators = day.querySelectorAll('.event-indicator');
        eventIndicators.forEach(indicator => {
            indicator.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.2)';
            });

            indicator.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });

    // Add animation for calendar navigation
    const calendarNavButtons = document.querySelectorAll('[wire\\:click*="Month"]');
    calendarNavButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add loading animation
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
                setTimeout(() => {
                    icon.style.transform = 'rotate(0deg)';
                }, 300);
            }
        });
    });
}

// Performance optimization: Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add intersection observer for scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
        }
    });
}, observerOptions);

// Observe elements for scroll animations
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.bg-white, .stat-card, .table-row, .calendar-day');
    animatedElements.forEach(el => {
        observer.observe(el);
    });
});

// Calendar month change animation
document.addEventListener('livewire:updated', function() {
    const calendarGrid = document.querySelector('.calendar-grid');
    if (calendarGrid) {
        calendarGrid.style.opacity = '0.7';
        calendarGrid.style.transform = 'scale(0.98)';

        setTimeout(() => {
            calendarGrid.style.transition = 'all 0.3s ease-out';
            calendarGrid.style.opacity = '1';
            calendarGrid.style.transform = 'scale(1)';
        }, 100);
    }
});

// Events Modal Functions
function showEventsModal(date, events) {
    const modal = document.getElementById('eventsModal');
    const modalDate = document.getElementById('modalDate');
    const modalEvents = document.getElementById('modalEvents');

    // Format the date
    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    modalDate.textContent = `Events on ${formattedDate}`;

    // Clear previous events
    modalEvents.innerHTML = '';

    // Add events to modal
    events.forEach(event => {
        const eventElement = document.createElement('div');
        eventElement.className = 'border-l-4 border-blue-500 pl-4 py-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer';
        eventElement.onclick = () => {
            window.location.href = `/events/${event.id}`;
        };

        const startTime = new Date(event.start_date).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });

        const endTime = new Date(event.end_date).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });

        eventElement.innerHTML = `
            <div class="font-medium text-gray-900">${event.title}</div>
            <div class="text-sm text-gray-500">${startTime} - ${endTime}</div>
            <div class="text-sm text-gray-500">${event.venue}</div>
            <div class="text-xs text-blue-600 mt-1">Click to view details</div>
        `;

        modalEvents.appendChild(eventElement);
    });

    // Show modal with animation
    modal.classList.remove('hidden');
    modal.style.opacity = '0';
    modal.style.transform = 'scale(0.9)';

    setTimeout(() => {
        modal.style.transition = 'all 0.3s ease-out';
        modal.style.opacity = '1';
        modal.style.transform = 'scale(1)';
    }, 10);
}

function closeEventsModal() {
    const modal = document.getElementById('eventsModal');

    modal.style.transition = 'all 0.3s ease-out';
    modal.style.opacity = '0';
    modal.style.transform = 'scale(0.9)';

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('eventsModal');
    const modalContent = modal.querySelector('.relative');

    if (event.target === modal) {
        closeEventsModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('eventsModal');
        if (!modal.classList.contains('hidden')) {
            closeEventsModal();
        }
    }
});
