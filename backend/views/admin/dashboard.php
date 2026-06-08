<?php
declare(strict_types=1);

use RentEase\Support\Csrf;
use RentEase\Support\Request;

$activeTab = Request::get('tab', 'overview');

?>
<!doctype html>
<html lang="en" class="h-full bg-[#f8f9ff] text-slate-900 antialiased selection:bg-teal-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations Console — RentEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        teal: { 50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a', 950: '#042f2e' },
                        slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
        .bento-item { transform: translateY(20px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-link.active {
            color: #14b8a6;
            background: #f0fdfa;
            border-color: #ccfbf1;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen custom-scrollbar">

    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <main class="flex-1 w-full mx-auto max-w-7xl px-4 py-8 md:px-8">

        <!-- Header Section -->
        <div class="bento-item mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight font-outfit">Operations <span class="text-teal-600">Console</span></h1>
                <p class="text-slate-500 font-medium max-w-2xl">Centralized management for marketplace logistics, inventory, and user relations.</p>
            </div>
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-[2rem] shadow-sm border border-slate-200">
                <button onclick="switchTab('overview')" class="tab-link active px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">grid_view</span> Overview
                </button>
                <button onclick="switchTab('inventory')" class="tab-link px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">inventory_2</span> Inventory
                </button>
                <button onclick="switchTab('orders')" class="tab-link px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">shopping_cart</span> Orders
                </button>
                <button onclick="switchTab('logistics')" class="tab-link px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">local_shipping</span> Logistics
                </button>
                <button onclick="switchTab('tenants')" class="tab-link px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">group</span> Tenants
                </button>
                <button onclick="switchTab('support')" class="tab-link px-6 py-2.5 rounded-[1.5rem] text-xs font-bold transition-all hover:bg-slate-50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">support_agent</span> Support
                </button>
            </div>
        </div>

        <?php if ($success): ?>
            <div id="status-success" class="bento-item mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700 text-sm font-semibold shadow-sm">
                <span class="material-symbols-outlined">check_circle</span>
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div id="status-error" class="bento-item mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700 text-sm font-semibold shadow-sm">
                <span class="material-symbols-outlined">error</span>
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <!-- OVERVIEW TAB -->
        <div id="tab-overview" class="tab-content active space-y-12">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-teal-200 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="p-3 rounded-2xl bg-teal-50 text-teal-600 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">history_edu</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 font-outfit"><?= $activeRentalsCount ?></span>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Active Leases</p>
                    </div>
                </div>
                <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-blue-200 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="p-3 rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">shopping_bag</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 font-outfit"><?= count($orders) ?></span>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Orders</p>
                    </div>
                </div>
                <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-emerald-200 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-emerald-600 font-outfit">$<?= e(number_format((float)($totalRevenue ?? 0), 2)) ?></span>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Revenue</p>
                    </div>
                </div>
                <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-orange-200 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="p-3 rounded-2xl bg-orange-50 text-orange-600 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">build</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 font-outfit"><?= count($maintenanceReqs) ?></span>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tickets</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Mixed View -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Orders -->
                <div class="bento-item glass-card rounded-[2.5rem] p-8 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 font-outfit">Recent Sales</h3>
                    <div class="space-y-4">
                        <?php foreach (array_slice($orders, 0, 5) as $o): ?>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-slate-100 group hover:border-blue-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                        <span class="material-symbols-outlined text-[20px]">person</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900"><?= e($o['profiles']['full_name'] ?? 'Guest') ?></p>
                                        <p class="text-[10px] text-slate-400 font-medium"><?= date('M d, H:i', strtotime($o['created_at'] ?? 'now')) ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-slate-900">$<?= number_format((float)($o['total_amount'] ?? 0), 2) ?></p>
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full"><?= e($o['payment_status'] ?? 'unknown') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recent Maintenance -->
                <div class="bento-item glass-card rounded-[2.5rem] p-8 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 font-outfit">Active Issues</h3>
                    <div class="space-y-4">
                        <?php foreach (array_slice($maintenanceReqs, 0, 5) as $m): ?>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-slate-100 group hover:border-orange-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                                        <span class="material-symbols-outlined text-[20px]">warning</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 line-clamp-1"><?= e($m['issue_description'] ?? 'No description') ?></p>
                                        <p class="text-[10px] text-slate-400 font-medium"><?= e($m['rentals']['products']['name'] ?? 'Unknown Product') ?></p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-[9px] font-bold uppercase"><?= e($m['status'] ?? 'unknown') ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- INVENTORY TAB -->
        <div id="tab-inventory" class="tab-content space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Catalog List -->
                <div class="lg:col-span-8 bento-item glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white/50">
                        <h2 class="text-xl font-bold text-slate-900 font-outfit">Catalog Inventory</h2>
                        <button onclick="window.scrollTo({top: document.getElementById('product-form').offsetTop - 100, behavior: 'smooth'})" class="px-4 py-2 rounded-xl bg-teal-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-teal-500 transition-all">Add Product</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                                    <th class="px-8 py-4">Product</th>
                                    <th class="px-6 py-4">Stock</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($products as $p): ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors">
                                        <td class="px-8 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="<?= e($p['image_url'] ?: '') ?>" class="h-10 w-10 rounded-xl object-cover border border-slate-200">
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900"><?= e($p['name']) ?></p>
                                                    <p class="text-[10px] text-slate-400 font-medium"><?= e($p['category']) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex items-center gap-2">
                                                <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                <input type="hidden" name="action" value="update_stock" />
                                                <input type="hidden" name="id" value="<?= $p['id'] ?>" />
                                                <input type="number" name="total_stock" value="<?= (int)($p['total_stock'] ?? 0) ?>"
                                                       class="w-16 bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs font-bold text-slate-700 outline-none focus:border-teal-500">
                                                <button type="submit" class="p-1 rounded-lg bg-slate-900 text-white hover:bg-teal-600 active:scale-90 transition-all">
                                                    <span class="material-symbols-outlined text-[16px]">done</span>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-slate-900">$<?= number_format((float)($p['monthly_price'] ?? 0), 2) ?></td>
                                        <td class="px-8 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button onclick='editOffering(<?= json_encode($p) ?>)' class="p-2 rounded-xl text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-all">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </button>
                                                <form action="<?= baseUrl('/admin') ?>" method="POST" onsubmit="return confirm('Archive?');">
                                                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                    <input type="hidden" name="action" value="delete_product" />
                                                    <input type="hidden" name="id" value="<?= $p['id'] ?>" />
                                                    <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Product Form -->
                <div class="lg:col-span-4" id="product-form">
                    <div class="bento-item glass-card p-8 rounded-[2.5rem] sticky top-24">
                        <h3 id="form-heading" class="text-xl font-bold text-slate-900 font-outfit mb-8">Create Offering</h3>
                        <form action="<?= baseUrl('/admin') ?>" method="POST" class="space-y-4">
                            <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                            <input type="hidden" name="action" id="product-action" value="create_product" />
                            <input type="hidden" name="id" id="product-id" value="" />

                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Name</label>
                                <input type="text" name="name" id="product-name" required class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:border-teal-500 outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Category</label>
                                <select name="category" id="product-category" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:border-teal-500 outline-none">
                                    <option value="Furniture">Furniture</option>
                                    <option value="Appliances">Appliances</option>
                                    <option value="Electronics">Electronics</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Price ($)</label>
                                    <input type="number" step="0.01" name="monthly_price" id="product-price" required class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:border-teal-500 outline-none">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Stock</label>
                                    <input type="number" name="total_stock" id="product-stock" required class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:border-teal-500 outline-none">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Image URL</label>
                                <input type="text" name="image_url" id="product-image" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:border-teal-500 outline-none">
                            </div>
                            <button type="submit" class="w-full py-4 rounded-2xl bg-teal-600 text-white text-xs font-bold uppercase tracking-widest hover:bg-teal-500 transition-all shadow-lg shadow-teal-600/20 active:scale-95">Save Product</button>
                            <button type="button" onclick="cancelEdit()" id="cancel-edit-btn" class="hidden w-full py-3 rounded-2xl bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ORDERS TAB -->
        <div id="tab-orders" class="tab-content space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Sales List -->
                <div class="lg:col-span-12 bento-item glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-white/50">
                        <h2 class="text-xl font-bold text-slate-900 font-outfit">Orders & Fulfillment</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                                    <th class="px-8 py-4">Order Details</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Payment</th>
                                    <th class="px-6 py-4">Shipping</th>
                                    <th class="px-8 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($orders as $o): ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors">
                                        <td class="px-8 py-4">
                                            <p class="text-sm font-bold text-slate-900 uppercase">#<?= substr((string)($o['id'] ?? ''), 0, 8) ?></p>
                                            <p class="text-[10px] text-slate-400 font-medium"><?= date('M d, Y H:i', strtotime($o['created_at'] ?? 'now')) ?></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-slate-900"><?= e($o['profiles']['full_name'] ?? 'Guest') ?></p>
                                            <p class="text-[10px] text-slate-400"><?= e($o['profiles']['email'] ?? 'N/A') ?></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex items-center gap-2">
                                                <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                <input type="hidden" name="action" value="update_order_status" />
                                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>" />
                                                <input type="hidden" name="shipping_status" value="<?= $o['shipping_status'] ?>" />
                                                <select name="payment_status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[10px] font-bold outline-none <?php
                                                    echo $o['payment_status'] === 'paid' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-orange-600 bg-orange-50 border-orange-100';
                                                ?>">
                                                    <option value="pending" <?= $o['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="paid" <?= $o['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                                    <option value="failed" <?= $o['payment_status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex items-center gap-2">
                                                <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                <input type="hidden" name="action" value="update_order_status" />
                                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>" />
                                                <input type="hidden" name="payment_status" value="<?= $o['payment_status'] ?>" />
                                                <select name="shipping_status" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[10px] font-bold outline-none <?php
                                                    echo $o['shipping_status'] === 'delivered' ? 'text-emerald-600 bg-emerald-50' : ($o['shipping_status'] === 'pending' ? 'text-slate-500 bg-slate-50' : 'text-blue-600 bg-blue-50');
                                                ?>">
                                                    <option value="pending" <?= $o['shipping_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="processing" <?= $o['shipping_status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                                    <option value="shipped" <?= $o['shipping_status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                    <option value="delivered" <?= $o['shipping_status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <button onclick="viewLogistics('<?= $o['id'] ?>')" class="p-2 rounded-xl text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-all">
                                                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOGISTICS TAB -->
        <div id="tab-logistics" class="tab-content space-y-8">
            <div class="bento-item glass-card rounded-[2.5rem] overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-white/50">
                    <h2 class="text-xl font-bold text-slate-900 font-outfit">Delivery Operations</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                                <th class="px-8 py-4">Delivery ID</th>
                                <th class="px-6 py-4">Destination</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Agent Notes</th>
                                <th class="px-8 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($deliveries as $d): ?>
                                <tr class="group hover:bg-slate-50/80 transition-colors">
                                    <td class="px-8 py-4">
                                        <p class="text-xs font-bold text-slate-900 uppercase">#<?= substr((string)$d['id'], 0, 8) ?></p>
                                        <p class="text-[10px] text-slate-400">Order: <?= substr((string)$d['order_id'], 0, 8) ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-slate-600 line-clamp-1"><?= e($d['delivery_address'] ?? 'N/A') ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" action="<?= baseUrl('/admin') ?>">
                                            <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                            <input type="hidden" name="action" value="update_delivery_status" />
                                            <input type="hidden" name="delivery_id" value="<?= $d['id'] ?>" />
                                            <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-100 rounded-lg px-2 py-1 text-[10px] font-bold uppercase outline-none <?php
                                                echo match($d['status']) {
                                                    'delivered' => 'text-emerald-600 bg-emerald-50',
                                                    'shipped' => 'text-blue-600 bg-blue-50',
                                                    'out_for_delivery' => 'text-purple-600 bg-purple-50',
                                                    default => 'text-slate-500 bg-slate-50'
                                                };
                                            ?>">
                                                <option value="pending" <?= $d['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="out_for_delivery" <?= $d['status'] === 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                                <option value="delivered" <?= $d['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                <option value="cancelled" <?= $d['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex items-center gap-2">
                                            <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                            <input type="hidden" name="action" value="update_delivery_status" />
                                            <input type="hidden" name="delivery_id" value="<?= $d['id'] ?>" />
                                            <input type="hidden" name="status" value="<?= $d['status'] ?>" />
                                            <input type="text" name="agent_notes" placeholder="Add note..." value="<?= e($d['agent_notes'] ?? '') ?>"
                                                   class="bg-slate-50 border border-slate-100 rounded-lg px-2 py-1 text-[10px] font-medium text-slate-600 outline-none focus:bg-white focus:border-teal-500 w-32">
                                            <button type="submit" class="p-1 rounded-lg text-slate-400 hover:text-teal-600">
                                                <span class="material-symbols-outlined text-[16px]">save</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <p class="text-[10px] text-slate-400 font-bold"><?= date('M d', strtotime($d['created_at'] ?? 'now')) ?></p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="tab-tenants" class="tab-content space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- User Profiles -->
                <div class="bento-item glass-card rounded-[2.5rem] p-8 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 font-outfit">User Accounts</h3>
                    <div class="space-y-4">
                        <?php foreach ($users as $u): ?>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/50 border border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 font-bold uppercase"><?= substr((string)($u['full_name'] ?? ''), 0, 1) ?></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900"><?= e($u['full_name'] ?? 'N/A') ?></p>
                                        <p class="text-[10px] text-slate-400"><?= e($u['email'] ?? 'N/A') ?></p>
                                    </div>
                                </div>
                                <form method="POST" action="<?= baseUrl('/admin') ?>">
                                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                    <input type="hidden" name="action" value="update_user_role" />
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>" />
                                    <select name="role" onchange="this.form.submit()" class="bg-white border border-slate-100 rounded-lg px-2 py-1 text-[9px] font-bold uppercase outline-none focus:border-teal-500">
                                        <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="vendor" <?= $u['role'] === 'vendor' ? 'selected' : '' ?>>Vendor</option>
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Rental Agreements -->
                <div class="bento-item glass-card rounded-[2.5rem] p-8 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 font-outfit">Lease Agreements</h3>
                    <div class="space-y-4">
                        <?php foreach ($rentals as $r): ?>
                            <div class="p-4 rounded-2xl bg-white/50 border border-slate-100 space-y-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs font-bold text-slate-900"><?= e($r['products']['name'] ?? 'N/A') ?></p>
                                        <p class="text-[9px] text-slate-400 font-medium">Tenant: <?= e($r['profiles']['full_name'] ?? 'Guest') ?></p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md text-[8px] font-bold uppercase tracking-wider <?php
                                        echo match($r['status'] ?? 'active') {
                                            'active' => 'bg-emerald-50 text-emerald-600',
                                            'return_requested' => 'bg-orange-50 text-orange-600',
                                            default => 'bg-slate-100 text-slate-500'
                                        };
                                    ?>"><?= e($r['status'] ?? 'active') ?></span>
                                </div>
                                <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex gap-2">
                                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                    <input type="hidden" name="action" value="update_rental_status" />
                                    <input type="hidden" name="rental_id" value="<?= $r['id'] ?>" />
                                    <select name="status" class="flex-1 bg-white border border-slate-100 rounded-lg px-2 py-1.5 text-[10px] font-bold text-slate-500 outline-none">
                                        <option value="active" <?= $r['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="return_requested" <?= $r['status'] === 'return_requested' ? 'selected' : '' ?>>Return Requested</option>
                                        <option value="return_inspection" <?= $r['status'] === 'return_inspection' ? 'selected' : '' ?>>Inspection</option>
                                        <option value="completed" <?= $r['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="closed" <?= $r['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                                    </select>
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-900 text-white hover:bg-teal-600 transition-all">
                                        <span class="material-symbols-outlined text-[14px]">save</span>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUPPORT TAB -->
        <div id="tab-support" class="tab-content space-y-8">
            <div class="bento-item glass-card rounded-[2.5rem] p-8 space-y-8">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-900 font-outfit">Maintenance Desk</h3>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[10px] font-bold border border-orange-100"><?= count($maintenanceReqs) ?> Active Tickets</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($maintenanceReqs as $mr): ?>
                        <div class="p-6 rounded-[2rem] border border-slate-100 bg-white/50 space-y-4 hover:border-teal-100 transition-all">
                            <div class="flex justify-between items-start">
                                <div class="p-2 rounded-xl bg-orange-50 text-orange-600">
                                    <span class="material-symbols-outlined text-[18px]">engineering</span>
                                </div>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">ID: <?= $mr['id'] ?></span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900"><?= e($mr['rentals']['products']['name'] ?? 'N/A') ?></p>
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-1"><?= e($mr['issue_description'] ?? 'No description') ?></p>
                            </div>
                            <div class="flex items-center gap-3 pt-2 border-t border-slate-50">
                                <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-[8px] font-bold"><?= substr((string)($mr['profiles']['full_name'] ?? ''), 0, 1) ?></div>
                                <span class="text-[10px] font-bold text-slate-600"><?= e($mr['profiles']['full_name'] ?? 'Guest') ?></span>
                            </div>
                            <form method="POST" action="<?= baseUrl('/admin') ?>" class="space-y-3 pt-2">
                                <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                <input type="hidden" name="action" value="update_maintenance" />
                                <input type="hidden" name="request_id" value="<?= $mr['id'] ?>" />
                                <select name="status" class="w-full bg-white border border-slate-100 rounded-xl px-3 py-2 text-[10px] font-bold text-slate-600 outline-none focus:border-teal-500">
                                    <?php foreach(['OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED'] as $st): ?>
                                        <option value="<?= $st ?>" <?= $mr['status'] === $st ? 'selected' : '' ?>><?= $st ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <textarea name="notes" placeholder="Update notes..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-[10px] font-medium text-slate-600 outline-none focus:bg-white transition-all"><?= e($mr['notes'] ?? '') ?></textarea>
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-teal-600 transition-all">Update Ticket</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // GSAP Entrance (fallback: content stays visible if GSAP blocked)
        if (typeof gsap !== 'undefined') {
            gsap.from('.bento-item', {
                opacity: 0,
                y: 20,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power4.out',
                clearProps: 'transform'
            });
        } else {
            document.querySelectorAll('.bento-item').forEach(el => {
                el.style.transform = 'none';
            });
        }

        // Tab Switching Logic
        window.switchTab = function(tabName) {
            // Update Tab Links
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
                if (link.innerText.toLowerCase().includes(tabName)) {
                    link.classList.add('active');
                }
            });

            // Update Content Visibility with Animation
            const activeContent = document.querySelector('.tab-content.active');
            const targetContent = document.getElementById('tab-' + tabName);

            if (activeContent === targetContent) return;

            if (typeof gsap === 'undefined') {
                activeContent.classList.remove('active');
                targetContent.classList.add('active');
                return;
            }

            gsap.to(activeContent, {
                opacity: 0,
                y: 10,
                duration: 0.3,
                onComplete: () => {
                    activeContent.classList.remove('active');
                    targetContent.classList.add('active');
                    gsap.fromTo(targetContent,
                        { opacity: 0, y: 10 },
                        { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" }
                    );
                }
            });
        };

        // Product Form Logic
        window.editOffering = function(item) {
            switchTab('inventory');
            const form = document.getElementById('product-form');
            if (typeof gsap !== 'undefined') {
                gsap.to(form, { scale: 1.02, duration: 0.2, yoyo: true, repeat: 1 });
            }

            document.getElementById('form-heading').innerText = 'Modify Subscription';
            document.getElementById('product-action').value = 'update_product';
            document.getElementById('product-id').value = item.id;
            document.getElementById('product-name').value = item.name;
            document.getElementById('product-category').value = item.category;
            document.getElementById('product-price').value = item.monthly_price;
            document.getElementById('product-stock').value = item.total_stock;
            document.getElementById('product-image').value = item.image_url;
            document.getElementById('cancel-edit-btn').classList.remove('hidden');
        };

        window.cancelEdit = function() {
            document.getElementById('form-heading').innerText = 'Create Offering';
            document.getElementById('product-action').value = 'create_product';
            document.getElementById('product-id').value = '';
            document.getElementById('product-name').value = '';
            document.getElementById('product-category').value = 'Furniture';
            document.getElementById('product-price').value = '';
            document.getElementById('product-stock').value = '';
            document.getElementById('product-image').value = '';
            document.getElementById('cancel-edit-btn').classList.add('hidden');
        };
    });
    </script>
</body>
</html>
