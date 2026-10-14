
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Inventory Tracking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --theme-primary: #800776;
            --theme-secondary: #5E3023;
            --theme-accent: #C08552;
            --theme-background: #DAB49D;
            --theme-light-accent: #F3E3D7;
            --theme-text: #5E3023;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--theme-background);
            color: var(--theme-text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
        }

        .topbar {
            background: linear-gradient(135deg, #5E3023, #895737);
            color: white;
            min-height: 56px;
            padding: 12px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            color: white;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
        }

        .layout {
            display: flex;
            min-height: calc(100vh - 56px);
        }

        .sidebar {
            background: white;
            border-right: 1px solid rgba(94, 48, 35, .15);
            width: 240px;
            flex-shrink: 0;
            padding: 22px 14px;
        }

        .sidebar h6 {
            margin: 0 0 18px 8px;
            color: var(--theme-text);
        }

        .sidebar a {
            display: block;
            color: var(--theme-text);
            padding: 11px 14px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: var(--theme-light-accent);
            color: var(--theme-primary);
        }

        .sidebar a.active {
            background: var(--theme-primary);
            color: white;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding: 26px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .stat-card, .content-card {
            background: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(94, 48, 35, .12);
        }

        .stat-card {
            padding: 20px;
            height: 100%;
            transition: transform .2s ease;
        }

        .stat-card:hover { transform: translateY(-3px); }

        .stat-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .stat-value {
            color: var(--theme-primary);
            font-size: 30px;
            font-weight: 700;
            margin-top: 5px;
        }

        .content-card {
            padding: 22px;
            margin-bottom: 22px;
        }

        .section-title {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
        }

        .form-control, .form-select {
            border: 1px solid rgba(94, 48, 35, .25);
            border-radius: 6px;
            font-size: 13px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 .2rem rgba(128, 7, 118, .15);
        }

        .btn-primary-custom {
            background: var(--theme-primary);
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            background: var(--theme-secondary);
            color: white;
        }

        .btn-accent {
            background: var(--theme-accent);
            color: white;
            border: none;
        }

        .btn-accent:hover {
            background: var(--theme-primary);
            color: white;
        }

        .table {
            color: var(--theme-text);
            vertical-align: middle;
            margin-bottom: 0;
        }

        .table thead th {
            color: var(--theme-primary);
            background: var(--theme-light-accent);
            white-space: nowrap;
            font-size: 12px;
        }

        .table td { font-size: 13px; }

        .badge-low {
            background: #dc3545;
            color: white;
        }

        .badge-stock {
            background: #198754;
            color: white;
        }

        .empty-row {
            background: #f4f4f4;
            text-align: center;
            padding: 14px !important;
            color: #777;
        }

        .alert-warning {
            background: #fff3cd;
            color: #664d03;
            border-color: #ffecb5;
        }

        .alert-success {
            background: var(--theme-light-accent);
            color: var(--theme-text);
            border-color: var(--theme-accent);
        }

        .pagination { margin-bottom: 0; }

        .page-link { color: var(--theme-primary); }

        .page-item.active .page-link {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
        }

        @media (max-width: 767px) {
            .layout { display: block; }
            .sidebar {
                width: 100%;
                min-height: auto;
                padding: 12px;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
            .sidebar h6 { margin-bottom: 8px; }
            .sidebar a {
                display: inline-block;
                padding: 8px 10px;
            }
            .main-content { padding: 16px 12px; }
            .page-title { font-size: 22px; }
            .content-card { padding: 15px; }
            .topbar { padding: 12px; }
            .brand { font-size: 17px; }
        }
    </style>
</head>

<body>
    <!-- Top Navigation -->
    <header class="topbar">
        <a href="<?php echo e(route('dashboard')); ?>" class="brand">Student Portal</a>

        <div>
            <span class="me-2">Welcome, <strong><?php echo e(auth()->user()->name ?? 'Admin'); ?></strong></span>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light btn-sm">Dashboard</a>
        </div>
    </header>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h6>Navigation</h6>
            <nav>
                <a href="<?php echo e(route('dashboard')); ?>">🏠 Dashboard</a>
                <a href="<?php echo e(route('inventory.index')); ?>" class="active">📦 Inventory Tracking</a>
                <a href="<?php echo e(route('products.index')); ?>">📋 Products</a>

                <form action="<?php echo e(route('logout')); ?>" method="POST" class="mt-3">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-link text-decoration-none w-100 text-start"
                            style="color: var(--theme-text); padding: 10px 14px;">
                        🚪 Log Out
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="page-title">Inventory Tracking System</h1>

            <!-- Success and Error Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <strong>Please check the following:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">📦 Total Products</div>
                        <div class="stat-value"><?php echo e($products->total()); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">⚠️ Low-Stock Products</div>
                        <div class="stat-value"><?php echo e($lowStockProducts->count()); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">📊 Total Units in Stock</div>
                        <div class="stat-value"><?php echo e(number_format(\App\Models\InventoryProduct::sum('quantity'))); ?></div>
                    </div>
                </div>
            </div>

            <!-- Add Product -->
            <section class="content-card">
                <h2 class="section-title">Add Inventory Product</h2>

                <form action="<?php echo e(route('inventory.products.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="<?php echo e(old('name')); ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" id="sku" name="sku" class="form-control"
                                   value="<?php echo e(old('sku')); ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" id="category" name="category" class="form-control"
                                   value="<?php echo e(old('category')); ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Starting Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control"
                                   value="<?php echo e(old('quantity', 0)); ?>" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="reorder_level" class="form-label">Reorder Level</label>
                            <input type="number" id="reorder_level" name="reorder_level"
                                   class="form-control" value="<?php echo e(old('reorder_level', 10)); ?>"
                                   min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" id="unit_price" name="unit_price"
                                   class="form-control" value="<?php echo e(old('unit_price', 0)); ?>"
                                   min="0" step="0.01" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom btn-sm mt-3">
                        + Add Product
                    </button>
                </form>
            </section>

            <!-- Record Transaction -->
            <section class="content-card">
                <h2 class="section-title">Record Stock Transaction</h2>

                <form action="<?php echo e(route('inventory.transactions.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="inventory_product_id" class="form-label">Product</label>
                            <select id="inventory_product_id" name="inventory_product_id"
                                    class="form-select" required>
                                <option value="">Select product</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>"
                                        <?php if(old('inventory_product_id') == $product->id): echo 'selected'; endif; ?>>
                                        <?php echo e($product->name); ?> (Stock: <?php echo e($product->quantity); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="type" class="form-label">Transaction Type</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value="stock_in"
                                    <?php if(old('type', 'stock_in') === 'stock_in'): echo 'selected'; endif; ?>>Stock In</option>
                                <option value="stock_out"
                                    <?php if(old('type') === 'stock_out'): echo 'selected'; endif; ?>>Stock Out</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="transaction_quantity" class="form-label">Quantity</label>
                            <input type="number" id="transaction_quantity" name="quantity"
                                   class="form-control" value="<?php echo e(old('quantity')); ?>"
                                   min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   class="form-control" value="<?php echo e(old('reference_number')); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="notes" class="form-label">Notes</label>
                            <input type="text" id="notes" name="notes"
                                   class="form-control" value="<?php echo e(old('notes')); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm mt-3">
                        Save Transaction
                    </button>
                </form>
            </section>

         ```blade
<!-- Inventory Products Table -->
<section class="content-card">
    <h2 class="section-title">Inventory Products</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Reorder Level</th>
                    <th>Unit Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->sku); ?></td>
                        <td><?php echo e($product->category ?? 'N/A'); ?></td>
                        <td><?php echo e($product->quantity); ?></td>
                        <td><?php echo e($product->reorder_level); ?></td>
                        <td><?php echo e(number_format((float) $product->unit_price, 2)); ?></td>

                        <td>
                            <?php if($product->quantity <= $product->reorder_level): ?>
                                <span class="badge badge-low">Low Stock</span>
                            <?php else: ?>
                                <span class="badge badge-stock">In Stock</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-nowrap">
                            <a href="<?php echo e(route('inventory.products.edit', $product->id)); ?>"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            <form action="<?php echo e(route('inventory.products.destroy', $product->id)); ?>"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this inventory product?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="empty-row">
                            No inventory products yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <?php echo e($products->links()); ?>

    </div>
</section>
            <!-- Low Stock Alerts -->
            <section class="content-card">
                <h2 class="section-title">Low-Stock Alerts</h2>

                <?php $__empty_1 = true; $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="alert alert-warning py-2 mb-2">
                        <strong><?php echo e($product->name); ?></strong> —
                        <?php echo e($product->quantity); ?> units remaining.
                        Reorder level: <?php echo e($product->reorder_level); ?>.
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-success mb-0">No low-stock products.</p>
                <?php endif; ?>
            </section>

            <!-- Recent Transactions -->
            <section class="content-card">
                <h2 class="section-title">Recent Transactions</h2>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reference</th>
                                <th>Notes</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($transaction->created_at?->format('Y-m-d H:i')); ?></td>
                                    <td><?php echo e($transaction->inventoryProduct?->name ?? 'Product unavailable'); ?></td>
                                    <td>
                                        <?php if($transaction->type === 'stock_in'): ?>
                                            <span class="badge bg-success">STOCK IN</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">STOCK OUT</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($transaction->quantity); ?></td>
                                    <td><?php echo e($transaction->reference_number ?? '—'); ?></td>
                                    <td><?php echo e($transaction->notes ?? '—'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="empty-row">No transactions recorded yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <p class="text-end small mt-3">
                Laboratory 6 — Real-Time Inventory Tracking System
            </p>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\laboratory05_2411600350\resources\views/inventory/index.blade.php ENDPATH**/ ?>