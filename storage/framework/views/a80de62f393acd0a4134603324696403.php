<?php $__env->startSection('title', 'My Orders – Aqua De Smiley'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="display:flex;align-items:center;gap:.6rem;">
            <i class="fa-solid fa-receipt" style="color:var(--accent)"></i>
            My Orders & Tracking
        </h1>
        <p>Track the live status of your water refills and new container deliveries.</p>
    </div>
    <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Place New Order
    </a>
</div>

<!-- Status Filter Tabs -->
<div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <?php
        $statuses = [
            'all'       => ['All Orders', '#94a3b8'],
            'pending'   => ['Pending',    '#fbbf24'],
            'confirmed' => ['Confirmed',  '#38bdf8'],
            'completed' => ['Completed',  '#34d399'],
            'cancelled' => ['Cancelled',  '#f87171'],
        ];
        $current = request('status', 'all');
    ?>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('customer.orders.index', ['status' => $key])); ?>"
           style="padding:.35rem 1rem;border-radius:99px;font-size:.8rem;font-weight:600;text-decoration:none;
                  transition:all .2s;
                  <?php echo e($current === $key
                      ? "background:{$color}22;color:{$color};border:1px solid {$color}66;"
                      : 'background:#ffffff;color:#64748b;border:1px solid #cbd5e1;'); ?>">
            <?php echo e($label); ?>

            <span style="margin-left:.3rem;opacity:.85;">
                (<?php echo e($key === 'all' ? $counts->sum() : ($counts[$key] ?? 0)); ?>)
            </span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="table-wrapper">
        <?php if($orders->isEmpty()): ?>
        <div style="text-align:center;padding:3.5rem 1rem;color:var(--text-muted);">
            <div style="width:64px;height:64px;border-radius:50%;background:rgba(56,189,248,.1);display:grid;place-items:center;margin:0 auto 1.25rem;font-size:1.75rem;color:var(--accent);">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 style="font-size:1.15rem;font-weight:600;color:var(--text);">No orders found</h3>
            <p style="margin-top:.4rem;font-size:.9rem;">You don't have any orders matching this filter.</p>
            <div style="margin-top:1.25rem;">
                <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Order Water Now
                </a>
            </div>
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Service Type</th>
                    <th>Container Size</th>
                    <th>Quantity</th>
                    <th>Total (₱)</th>
                    <th>Status</th>
                    <th>Date Placed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <span style="font-weight:700;color:var(--accent);letter-spacing:.02em;"><?php echo e($order->order_number); ?></span>
                    </td>
                    <td>
                        <?php if($order->items && $order->items->isNotEmpty()): ?>
                            <div style="display:flex;flex-direction:column;gap:.3rem;">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.15rem .5rem;border-radius:6px;font-size:.74rem;font-weight:600;background:<?php echo e($item->serviceTypeColor()); ?>22;color:<?php echo e($item->serviceTypeColor()); ?>;border:1px solid <?php echo e($item->serviceTypeColor()); ?>44;">
                                            <i class="fa-solid <?php echo e($item->serviceTypeIcon()); ?>"></i>
                                            <?php echo e($item->serviceTypeLabel()); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .65rem;border-radius:6px;font-size:.78rem;font-weight:600;background:<?php echo e($order->serviceTypeColor()); ?>22;color:<?php echo e($order->serviceTypeColor()); ?>;border:1px solid <?php echo e($order->serviceTypeColor()); ?>44;">
                                <i class="fa-solid <?php echo e($order->serviceTypeIcon()); ?>"></i>
                                <?php echo e($order->serviceTypeLabel()); ?>

                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($order->items && $order->items->isNotEmpty()): ?>
                            <div style="display:flex;flex-direction:column;gap:.35rem;">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div style="display:flex;align-items:center;gap:.4rem;font-size:.85rem;font-weight:600;">
                                        <i class="fa-solid <?php echo e($item->containerSizeIcon()); ?>" style="color:var(--accent);font-size:.8rem;"></i>
                                        <span><?php echo e($item->quantity); ?> × <?php echo e($item->containerSizeLabel()); ?></span>
                                        <span style="color:var(--text-muted);font-weight:400;font-size:.75rem;">(₱<?php echo e(number_format($item->subtotal, 2)); ?>)</span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div style="display:flex;align-items:center;gap:.45rem;font-weight:600;">
                                <i class="fa-solid <?php echo e($order->containerSizeIcon()); ?>" style="color:var(--accent);font-size:.85rem;"></i>
                                <span><?php echo e($order->quantity); ?> × <?php echo e($order->containerSizeLabel()); ?></span>
                            </div>
                            <div style="font-size:.75rem;color:var(--text-muted);margin-top:.15rem;">
                                ₱<?php echo e(number_format($order->unitPrice(), 2)); ?> / unit
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span style="font-weight:700;font-size:.95rem;"><?php echo e($order->totalQuantity()); ?> <?php echo e($order->totalQuantity() === 1 ? 'unit' : 'units'); ?></span>
                    </td>
                    <td>
                        <span style="font-weight:700;color:var(--accent);font-size:1.05rem;">
                            ₱<?php echo e(number_format($order->total_amount, 2)); ?>

                        </span>
                    </td>
                    <td>
                        <span class="status-badge"
                              style="display:inline-block;padding:.25rem .75rem;border-radius:99px;font-size:.78rem;font-weight:600;background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>;border:1px solid <?php echo e($order->statusColor()); ?>55;">
                            <?php echo e($order->statusLabel()); ?>

                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:.82rem;white-space:nowrap;">
                        <?php echo e($order->created_at->format('M d, Y')); ?>

                        <div style="font-size:.72rem;"><?php echo e($order->created_at->format('h:i A')); ?></div>
                    </td>
                    <td>
                        <?php if($order->status === 'pending'): ?>
                        <form action="<?php echo e(route('customer.orders.cancel', $order)); ?>" method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel Order <?php echo e($order->order_number); ?>?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-outline" style="padding:.25rem .6rem;font-size:.75rem;border-color:rgba(239,68,68,.3);color:#fca5a5;">
                                <i class="fa-solid fa-ban"></i> Cancel
                            </button>
                        </form>
                        <?php else: ?>
                        <span style="color:var(--text-muted);font-size:.8rem;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <?php if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages()): ?>
    <div style="display:flex;justify-content:flex-end;margin-top:1.25rem;">
        <?php echo e($orders->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\wince karl samillano\Downloads\IT-12-main\IT-12-main\resources\views/customer/orders/index.blade.php ENDPATH**/ ?>