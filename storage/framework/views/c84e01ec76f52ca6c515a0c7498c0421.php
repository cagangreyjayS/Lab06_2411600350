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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        Good <?php echo e(now()->hour >= 5 && now()->hour < 12 ? 'Morning' : (now()->hour < 17 && now()->hour >= 12 ? 'Afternoon' : (now()->hour < 21 && now()->hour >= 17 ? 'Evening' : 'Night'))); ?>,
                        <?php echo e(auth()->user()->name ?? 'Admin'); ?>!
                    </h2>
                    <!-- Real-time Last Updated Timestamp -->
                    <div class="text-sm text-muted">
                        Last Updated: <span id="last-updated">Loading...</span>
                    </div>
                </div>

                
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">📦 Total Products</h6>
                                <p id="stat-total-products" class="card-text display-6 fw-bold text-gray-900">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">⚠️ Low Stock Items</h6>
                                <p id="stat-low-stock" class="card-text display-6 fw-bold text-warning">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">❌ Out of Stock</h6>
                                <p id="stat-out-of-stock" class="card-text display-6 fw-bold text-danger">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">🔄 Total Transactions</h6>
                                <p id="stat-total-transactions" class="card-text display-6 fw-bold text-primary">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if(isset($lowPerformanceCount) && $lowPerformanceCount > 0): ?>
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
                                       placeholder="Search inventory or activities...">
                            </div>

                            <div class="col-md-3">
                                <label for="categoryFilter" class="form-label">
                                    Category
                                </label>
                                <select id="categoryFilter"
                                        class="form-select">
                                    <option value="all">All Categories</option>
                                    <?php if(isset($products)): ?>
                                        <?php $__currentLoopData = $products->pluck('category')->filter()->unique()->sort(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>">
                                                <?php echo e($category); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
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

                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Recent Stock Movements</h5>
                            <span class="badge bg-secondary">Live Polling Active</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>User</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-transactions-body">
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Loading recent movements...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Student Activities</h5>

                            <div>
                                <span class="me-3">
                                    Results:
                                    <strong id="resultCount">
                                        <?php echo e(isset($products) ? $products->count() : 0); ?>

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
                                <tbody id="activity-table-body">
                                    <?php if(isset($products)): ?>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($product->created_at ? $product->created_at->format('Y-m-d') : 'N/A'); ?></td>
                                                <td><?php echo e($product->category ?? 'General'); ?></td>
                                                <td><?php echo e($product->name); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo e($product->status === 'completed' ? 'success' : ($product->status === 'pending' ? 'warning' : 'danger')); ?>">
                                                        <?php echo e(ucfirst($product->status ?? 'pending')); ?>

                                                    </span>
                                                </td>
                                                <td><?php echo e($product->score ?? 'N/A'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\laboratory05_2411600350\resources\views/dashboard.blade.php ENDPATH**/ ?>