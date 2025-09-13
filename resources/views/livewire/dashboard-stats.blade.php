<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon total-students">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-card-info">
            <h4>{{ $stats['total_students'] }}</h4>
            <p>Total Students</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon active-students">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-card-info">
            <h4>{{ $stats['active_students'] }}</h4>
            <p>Active Students</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon events">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-card-info">
            <h4>{{ $stats['events'] }}</h4>
            <p>Events</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon dropped-students">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-card-info">
            <h4>{{ $stats['dropped_students'] }}</h4>
            <p>Dropped Students</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon graduated-students">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="stat-card-info">
            <h4>{{ $stats['graduated_students'] }}</h4>
            <p>Graduated Students</p>
        </div>
    </div>
</div>
