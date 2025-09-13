<div class="fade-in">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Resource Management</h2>
        <p class="text-gray-600">Select a resource category to manage</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <!-- SOA Button -->
        <div class="resource-card card-hover">
            <div class="resource-card-content">
                <div class="resource-icon">
                    <i class="fas fa-handshake text-4xl text-blue-600"></i>
                </div>
                <h3 class="resource-title">SOA</h3>
                <p class="resource-description">Student Organization & Activities</p>
                <button class="resource-btn btn-click" onclick="window.location.href='{{ route('resources.soa') }}'">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Manage SOA
                </button>
            </div>
        </div>

        <!-- GTC Button -->
        <div class="resource-card card-hover">
            <div class="resource-card-content">
                <div class="resource-icon">
                    <i class="fas fa-clipboard-check text-4xl text-green-600"></i>
                </div>
                <h3 class="resource-title">GTC</h3>
                <p class="resource-description">Guidance Testing Center</p>
                <button class="resource-btn btn-click" onclick="window.location.href='{{ route('resources.gtc') }}'">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Manage GTC
                </button>
            </div>
        </div>

        <!-- POD Button -->
        <div class="resource-card card-hover">
            <div class="resource-card-content">
                <div class="resource-icon">
                    <i class="fas fa-gavel text-4xl text-purple-600"></i>
                </div>
                <h3 class="resource-title">POD</h3>
                <p class="resource-description">Prefect of Discipline</p>
                <button class="resource-btn btn-click" onclick="window.location.href='{{ route('resources.pod') }}'">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Manage POD
                </button>
            </div>
        </div>
    </div>
</div>
