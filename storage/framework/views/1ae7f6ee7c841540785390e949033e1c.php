<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">

        
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <h5 class="mb-4">Navigation</h5>

            <nav class="nav flex-column">
                <a href="<?php echo e(route('dashboard')); ?>"
                   class="nav-link active">🏠 Dashboard</a>

                <a href="#profileSettings"
                   class="nav-link">👤 Profile</a>

                <a href="#dashboardSettings"
                   class="nav-link">⚙️ Settings</a>

                <a href="<?php echo e(route('inventory.index')); ?>"
                   class="nav-link">📦 Inventory</a>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="nav-link text-start w-100 border-0 bg-transparent">
                        🚪 Log Out
                    </button>
                </form>
            </nav>
        </aside>

        
        <main class="col-md-9 col-lg-10 p-4">

            
            <section id="profileSettings" class="mb-5">
                <h2 class="mb-4">Profile</h2>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">Student Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Student Name</label>
                                <input class="form-control"
                                       value="<?php echo e(auth()->user()->name ?? 'Admin'); ?>"
                                       readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Student ID</label>
                                <input class="form-control"
                                       value="2026-001" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Academic Year</label>
                                <input class="form-control"
                                       value="2026-2027" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Year Level</label>
                                <input class="form-control"
                                       value="3rd Year" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Program</label>
                                <input class="form-control"
                                       value="Bachelor of Science in Information Technology"
                                       readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            
            <section id="dashboardSettings">
                <h2 class="mb-4">
                    Good <?php echo e(now()->hour >= 5 && now()->hour < 12 ? 'Morning' : (now()->hour < 17 && now()->hour >= 12 ? 'Afternoon' : (now()->hour < 21 && now()->hour >= 17 ? 'Evening' : 'Night'))); ?>,
                    <?php echo e(auth()->user()->name ?? 'Admin'); ?>!
                </h2>

                
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>🎓 GPA</h6>
                                <p class="card-text"><?php echo e($gpa); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>📚 Courses</h6>
                                <p class="card-text"><?php echo e($totalCourses); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>📝 Assignments</h6>
                                <p class="card-text"><?php echo e($totalAssignments); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6>📅 Attendance</h6>
                                <p class="card-text"><?php echo e($attendance); ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if($lowPerformanceCount > 0): ?>
                    <div class="alert alert-warning mb-4">
                        <strong>Performance Alert:</strong>
                        <?php echo e($lowPerformanceCount); ?> scored activity item(s)
                        are below 90. Review the highlighted rows.
                    </div>
                <?php endif; ?>

                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="searchInput" class="form-label">
                                    Search
                                </label>
                                <input id="searchInput"
                                       class="form-control"
                                       placeholder="Search activities...">
                            </div>

                            <div class="col-md-3">
                                <label for="categoryFilter" class="form-label">
                                    Category
                                </label>
                                <select id="categoryFilter"
                                        class="form-select">
                                    <option value="all">All Categories</option>
                                    <?php $__currentLoopData = $products->pluck('category')->filter()->unique()->sort(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category); ?>">
                                            <?php echo e($category); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="statusFilter" class="form-label">
                                    Status
                                </label>
                                <select id="statusFilter" class="form-select">
                                    <option value="all">All Status</option>
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="overdue">Overdue</option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button id="resetFilters"
                                        class="btn btn-secondary w-100">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row g-4 mb-4">
                    <div class="col-lg-6">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5>Course Performance</h5>
                                <div class="chart-container">
                                    <canvas id="performanceChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5>Assignment Status</h5>
                                <div class="chart-container">
                                    <canvas id="assignmentChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5>Attendance</h5>
                                <div class="chart-wide">
                                    <canvas id="attendanceChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between
                                    align-items-center mb-3">
                            <h5 class="mb-0">Student Activities</h5>

                            <div>
                                <span class="me-3">
                                    Results:
                                    <strong id="resultCount">
                                        <?php echo e($products->count()); ?>

                                    </strong>
                                </span>
                                <button id="exportCsvBtn"
                                        class="btn btn-sm btn-primary">
                                    Export CSV
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Activity</th>
                                        <th>Status</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>

                                <tbody id="activityTableBody">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="<?php echo e($product->score !== null && $product->score < 90 ? 'low-performance-row' : ''); ?>"
                                            data-category="<?php echo e($product->category); ?>"
                                            data-status="<?php echo e($product->status); ?>"
                                            data-search="<?php echo e(strtolower(($product->name ?? '') . ' ' . ($product->subject ?? '') . ' ' . ($product->category ?? '') . ' ' . ($product->status ?? ''))); ?>">

                                            <td>
                                                <?php echo e($product->created_at?->format('Y-m-d') ?? 'N/A'); ?>

                                            </td>

                                            <td><?php echo e($product->category); ?></td>

                                            <td>
                                                <?php echo e($product->name ?? $product->subject ?? 'Student activity'); ?>

                                            </td>

                                            <td>
                                                <span class="badge
                                                    <?php echo e($product->status === 'completed' ? 'bg-success' : ($product->status === 'overdue' ? 'bg-danger' : 'bg-warning text-dark')); ?>">
                                                    <?php echo e($product->status); ?>

                                                </span>
                                            </td>

                                            <td><?php echo e($product->score ?? '—'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div id="emptyState"
                             class="text-center text-muted d-none">
                            No activities found.
                        </div>

                        <div class="text-end text-muted small mt-2">
                            Last Updated:
                            <span id="lastUpdated"><?php echo e(now()->format('h:i:s A')); ?></span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categories = <?php echo json_encode($categoryScores->keys()->values(), 15, 512) ?>;
    const scores = <?php echo json_encode($categoryScores->values(), 15, 512) ?>;

    const completed = <?php echo e($completedCount); ?>;
    const pending = <?php echo e($pendingCount); ?>;
    const overdue = <?php echo e($overdueCount); ?>;

    const attendanceLabels = <?php echo json_encode($attendanceLabels->values(), 15, 512) ?>;
    const attendanceValues = <?php echo json_encode($attendanceValues, 15, 512) ?>;

    new Chart(document.getElementById('performanceChart'), {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Average Score',
                data: scores,
                backgroundColor: 'rgba(54, 162, 235, 0.55)',
                borderColor: '#36A2EB',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    new Chart(document.getElementById('assignmentChart'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Overdue'],
            datasets: [{
                data: [completed, pending, overdue],
                backgroundColor: ['#36A2EB', '#FF6384', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    new Chart(document.getElementById('attendanceChart'), {
        type: 'line',
        data: {
            labels: attendanceLabels,
            datasets: [{
                label: 'Attendance %',
                data: attendanceValues,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 162, 235, 0.15)',
                tension: 0.25,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Search and filter activities.
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const rows = Array.from(
        document.querySelectorAll('#activityTableBody tr')
    );

    function filterRows() {
        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;
        const status = statusFilter.value;
        let visible = 0;

        rows.forEach(row => {
            const matchesSearch =
                row.dataset.search.includes(query);

            const matchesCategory =
                category === 'all' ||
                row.dataset.category === category;

            const matchesStatus =
                status === 'all' ||
                row.dataset.status === status;

            const show =
                matchesSearch &&
                matchesCategory &&
                matchesStatus;

            row.classList.toggle('d-none', !show);

            if (show) visible++;
        });

        document.getElementById('resultCount').textContent = visible;

        document.getElementById('emptyState')
            .classList.toggle('d-none', visible !== 0);
    }

    searchInput.addEventListener('input', filterRows);
    categoryFilter.addEventListener('change', filterRows);
    statusFilter.addEventListener('change', filterRows);

    document.getElementById('resetFilters')
        .addEventListener('click', function () {
            searchInput.value = '';
            categoryFilter.value = 'all';
            statusFilter.value = 'all';
            filterRows();
        });

    // Export currently visible rows to CSV.
    document.getElementById('exportCsvBtn')
        .addEventListener('click', function () {
            const visibleRows = rows.filter(
                row => !row.classList.contains('d-none')
            );

            const csvRows = [
                ['Date', 'Category', 'Activity', 'Status', 'Score']
            ];

            visibleRows.forEach(row => {
                csvRows.push(
                    Array.from(row.querySelectorAll('td'))
                        .map(cell => cell.innerText.trim())
                );
            });

            const csv = csvRows.map(row =>
                row.map(value =>
                    '"' + value.replaceAll('"', '""') + '"'
                ).join(',')
            ).join('\n');

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = 'student-activities.csv';
            link.click();

            URL.revokeObjectURL(url);
        });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LAB05\lab05_2411600350\resources\views/dashboard.blade.php ENDPATH**/ ?>