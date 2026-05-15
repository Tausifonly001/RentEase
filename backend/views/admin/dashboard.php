<?php
declare(strict_types=1);

use RentEase\Support\Csrf;


?>
<!doctype html>
<html lang="en" class="h-full bg-[#f8f9ff] text-slate-900 antialiased selection:bg-teal-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations Console — RentEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
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
        .bento-item { opacity: 0; transform: translateY(20px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</head>
<body class="flex flex-col min-h-screen custom-scrollbar">

    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <main class="flex-1 w-full mx-auto max-w-7xl px-4 py-8 md:px-8">
        <!-- Header Section -->
        <div class="bento-item mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-teal-600 text-[10px] font-bold uppercase tracking-wider border border-teal-100">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    Live Operations
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight font-outfit">Operations <span class="text-teal-600">Console</span></h1>
                <p class="text-slate-500 font-medium max-w-2xl">Manage your inventory, monitor active leases, and resolve maintenance tickets from a single unified workspace.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.scrollTo({top: document.getElementById('product-form').offsetTop - 100, behavior: 'smooth'})" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-3.5 text-xs font-bold text-white transition-all hover:bg-slate-800 hover:scale-[1.02] active:scale-95 shadow-lg">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    New Offering
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

        <!-- Quick Stats Bento Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Stat 1 -->
            <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-teal-200 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="p-3 rounded-2xl bg-teal-50 text-teal-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">history_edu</span>
                    </div>
                    <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-full">+12%</span>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-black text-slate-900 font-outfit"><?= $activeRentalsCount ?></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Active Leases</p>
                </div>
            </div>
            <!-- Stat 2 -->
            <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-blue-200 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="p-3 rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-black text-slate-900 font-outfit"><?= count($products) ?></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Catalog</p>
                </div>
            </div>
            <!-- Stat 3 -->
            <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-emerald-200 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-black text-emerald-600 font-outfit">$<?= e(number_format($totalRevenue, 2)) ?></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Revenue</p>
                </div>
            </div>
            <!-- Stat 4 -->
            <div class="bento-item glass-card p-6 rounded-[2rem] flex flex-col justify-between group hover:border-orange-200 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="p-3 rounded-2xl bg-orange-50 text-orange-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">build</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-black text-slate-900 font-outfit"><?= count($maintenanceReqs) ?></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Support Tickets</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Product Management Section (LHS) -->
            <div class="lg:col-span-8 space-y-8">
                <div class="bento-item glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white/50">
                        <h2 class="text-xl font-bold text-slate-900 font-outfit">Catalog Inventory</h2>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold"><?= count($products) ?> Items</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                                    <th class="px-8 py-4">Item details</th>
                                    <th class="px-6 py-4">Pricing</th>
                                    <th class="px-6 py-4">Stock</th>
                                    <th class="px-8 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($products as $p): ?>
                                    <?php if (!is_array($p)) continue; ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors">
                                        <td class="px-8 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="h-14 w-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 group-hover:scale-105 transition-transform">
                                                    <img src="<?= e((string)($p['image_url'] ?? '')) ?>" class="h-full w-full object-cover">
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block"><?= e((string)$p['name']) ?></span>
                                                    <span class="text-[11px] font-medium text-slate-400 block line-clamp-1"><?= e((string)($p['description'] ?? 'No description')) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-teal-600">$<?= number_format((float)$p['monthly_price'], 2) ?></span>
                                            <span class="text-[10px] text-slate-400 block">/month</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="h-1.5 w-1.5 rounded-full <?= (int)$p['total_stock'] > 0 ? 'bg-emerald-500' : 'bg-red-500' ?>"></div>
                                                <span class="text-sm font-bold text-slate-700"><?= (int)$p['total_stock'] ?></span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick='editOffering(<?= json_encode($p) ?>)' class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-teal-600 hover:border-teal-200 transition-all active:scale-90">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <form action="<?= baseUrl('/admin') ?>" method="POST" onsubmit="return confirm('Archive this offering?');">
                                                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                    <input type="hidden" name="action" value="delete_product" />
                                                    <input type="hidden" name="id" value="<?= e((string)$p['id']) ?>" />
                                                    <button type="submit" class="p-2 rounded-xl bg-white border border-slate-200 text-red-500 hover:bg-red-50 hover:border-red-200 transition-all active:scale-90">
                                                        <span class="material-symbols-outlined text-lg">delete</span>
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

                <!-- Rental Management -->
                <div class="bento-item glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white/50">
                        <h2 class="text-xl font-bold text-slate-900 font-outfit">Tenant Agreements</h2>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-500 text-[10px] font-bold">Active Management</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/50">
                                    <th class="px-8 py-4">Tenant</th>
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Control</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                <?php foreach ($rentals as $r): ?>
                                    <?php if (!is_array($r)) continue; ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors">
                                        <td class="px-8 py-4">
                                            <span class="font-bold text-slate-900 block"><?= e((string)($r['profiles']['email'] ?? 'System Tenant')) ?></span>
                                            <span class="text-[10px] text-slate-400">UID: <?= substr((string)$r['id'], 0, 8) ?></span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-slate-600"><?= e((string)($r['products']['name'] ?? 'Custom')) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?php 
                                                $rs = $r['status'] ?? 'active';
                                                echo match($rs) {
                                                    'active' => 'bg-emerald-50 text-emerald-600',
                                                    'completed', 'closed' => 'bg-blue-50 text-blue-600',
                                                    'cancelled' => 'bg-red-50 text-red-600',
                                                    'return_requested' => 'bg-orange-50 text-orange-600 border border-orange-200',
                                                    'return_inspection' => 'bg-purple-50 text-purple-600 border border-purple-200',
                                                    default => 'bg-slate-100 text-slate-600'
                                                };
                                            ?>">
                                                <?= e(ucwords(str_replace('_', ' ', (string)$rs))) ?>
                                            </span>
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <form action="<?= baseUrl('/admin') ?>" method="POST" class="inline-flex gap-2">
                                                <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                                <input type="hidden" name="action" value="update_rental" />
                                                <input type="hidden" name="rental_id" value="<?= e((string)$r['id']) ?>" />
                                                <select name="status" class="bg-white border border-slate-200 rounded-xl px-2 py-1.5 text-[11px] font-bold text-slate-600 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all">
                                                    <option value="active" <?= $rs === 'active' ? 'selected' : '' ?>>Active</option>
                                                    <option value="return_requested" <?= $rs === 'return_requested' ? 'selected' : '' ?>>Return</option>
                                                    <option value="return_inspection" <?= $rs === 'return_inspection' ? 'selected' : '' ?>>Inspection</option>
                                                    <option value="completed" <?= $rs === 'completed' ? 'selected' : '' ?>>Complete</option>
                                                    <option value="closed" <?= $rs === 'closed' ? 'selected' : '' ?>>Close</option>
                                                </select>
                                                <button type="submit" class="p-1.5 rounded-xl bg-slate-900 text-white hover:bg-teal-600 transition-all active:scale-90">
                                                    <span class="material-symbols-outlined text-sm">save</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Forms & Maintenance Section (RHS) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Product Form -->
                <div id="product-form" class="bento-item glass-card p-8 rounded-[2.5rem] sticky top-24 scroll-mt-28">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="p-2 rounded-xl bg-teal-50 text-teal-600">
                            <span class="material-symbols-outlined" id="form-icon">add_task</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 font-outfit" id="form-heading">Create Offering</h3>
                    </div>
                    
                    <form action="<?= baseUrl('/admin') ?>" method="POST" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                        <input type="hidden" name="action" id="product-action" value="create_product" />
                        <input type="hidden" name="id" id="product-id" value="" />

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Title</label>
                            <input type="text" name="name" id="product-name" required placeholder="Luxury Velvet Sofa"
                                   class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-300 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Category</label>
                            <select name="category" id="product-category" required class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm appearance-none">
                                <option value="Furniture">Furniture</option>
                                <option value="Appliances">Appliances</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Rent ($)</label>
                                <input type="number" step="0.01" name="monthly_price" id="product-price" required placeholder="59.00"
                                       class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Stock</label>
                                <input type="number" name="total_stock" id="product-stock" required placeholder="12"
                                       class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Image URL</label>
                            <input type="url" name="image_url" id="product-image" placeholder="https://..."
                                   class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Description</label>
                            <textarea name="description" id="product-desc" rows="3" placeholder="Premium features..."
                                      class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"></textarea>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 rounded-2xl bg-teal-600 hover:bg-teal-500 text-xs font-bold text-white px-6 py-4 transition-all hover:scale-[1.02] active:scale-95 shadow-lg shadow-teal-600/20">
                                Save Product
                            </button>
                            <button type="button" onclick="cancelEdit()" id="cancel-edit-btn" class="hidden rounded-2xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-600 px-6 py-4 transition-all active:scale-95">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Maintenance Tickets -->
                <div class="bento-item glass-card p-6 rounded-[2.5rem] space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-900 font-outfit">Maintenance</h3>
                        <span class="px-2.5 py-1 rounded-lg bg-orange-50 text-orange-600 text-[10px] font-bold border border-orange-100"><?= count($maintenanceReqs) ?> Tickets</span>
                    </div>
                    <div class="space-y-4">
                        <?php if (empty($maintenanceReqs)): ?>
                            <div class="py-8 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                                <span class="material-symbols-outlined text-slate-300 text-3xl">task_alt</span>
                                <p class="text-xs font-bold text-slate-400 mt-2 uppercase tracking-widest">All Clear</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($maintenanceReqs as $mr): ?>
                                <?php if (!is_array($mr)) continue; ?>
                                <div class="p-4 rounded-2xl border border-slate-100 bg-white/50 space-y-3 group hover:border-teal-100 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">#<?= $mr['rental_id'] ?></span>
                                            <p class="text-xs font-bold text-slate-900 line-clamp-1"><?= e((string)($mr['issue_description'] ?? 'No detail')) ?></p>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider <?php 
                                            echo match($mr['status'] ?? '') {
                                                'OPEN' => 'bg-red-50 text-red-600',
                                                'ASSIGNED', 'IN_PROGRESS' => 'bg-yellow-50 text-yellow-600',
                                                'RESOLVED', 'CLOSED' => 'bg-emerald-50 text-emerald-600',
                                                default => 'bg-slate-100 text-slate-600'
                                            };
                                        ?>"><?= e($mr['status'] ?? 'OPEN') ?></span>
                                    </div>
                                    <form method="POST" action="<?= baseUrl('/admin') ?>" class="flex gap-2">
                                        <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                                        <input type="hidden" name="action" value="update_maintenance">
                                        <input type="hidden" name="request_id" value="<?= e((string)$mr['id']) ?>">
                                        <select name="status" class="flex-1 bg-white border border-slate-100 rounded-lg px-2 py-1.5 text-[10px] font-bold text-slate-500 outline-none focus:border-teal-500 transition-all">
                                            <?php foreach(['OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED'] as $s): ?>
                                                <option value="<?= $s ?>" <?= (($mr['status'] ?? '') === $s) ? 'selected' : '' ?>><?= $s ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="p-1.5 rounded-lg bg-slate-900 text-white hover:bg-teal-600 transition-all active:scale-90">
                                            <span class="material-symbols-outlined text-[16px]">send</span>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // GSAP Entrance Animations
        gsap.to(".bento-item", {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "power4.out"
        });

        // Floating Form Interaction
        window.editOffering = function(item) {
            const form = document.getElementById('product-form');
            gsap.to(form, { scale: 1.02, duration: 0.2, yoyo: true, repeat: 1 });
            
            document.getElementById('form-heading').innerText = 'Modify Subscription';
            document.getElementById('form-icon').innerText = 'edit_note';
            document.getElementById('product-action').value = 'update_product';
            document.getElementById('product-id').value = item.id;
            document.getElementById('product-name').value = item.name;
            document.getElementById('product-category').value = item.category;
            document.getElementById('product-price').value = item.monthly_price;
            document.getElementById('product-stock').value = item.total_stock;
            document.getElementById('product-image').value = item.image_url;
            document.getElementById('product-desc').value = item.description || '';
            document.getElementById('cancel-edit-btn').classList.remove('hidden');
            
            window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
        };

        window.cancelEdit = function() {
            document.getElementById('form-heading').innerText = 'Create Offering';
            document.getElementById('form-icon').innerText = 'add_task';
            document.getElementById('product-action').value = 'create_product';
            document.getElementById('product-id').value = '';
            document.getElementById('product-name').value = '';
            document.getElementById('product-category').value = 'Furniture';
            document.getElementById('product-price').value = '';
            document.getElementById('product-stock').value = '';
            document.getElementById('product-image').value = '';
            document.getElementById('product-desc').value = '';
            document.getElementById('cancel-edit-btn').classList.add('hidden');
        };
    });
    </script>
</body>
</html>
