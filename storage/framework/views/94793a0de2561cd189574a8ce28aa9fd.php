<?php $__env->startSection('title', 'Order Tracking – Aqua De Smiley'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
    <div>
        <h1><i class="fa-solid fa-clipboard-list" style="color:#38bdf8"></i> Order Tracking</h1>
        <p>Monitor and update the status of all water orders.</p>
    </div>
    <a href="<?php echo e(route('staff.orders.create')); ?>" class="btn btn-primary">
        <i class="fa-solid fa-circle-plus"></i> New Order
    </a>
</div>

<!-- Status Filter Tabs -->
<div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <?php
        $statuses = [
            'all'       => ['All',       '#94a3b8'],
            'pending'   => ['Pending',   '#fbbf24'],
            'confirmed' => ['Confirmed', '#38bdf8'],
            'completed' => ['Completed', '#34d399'],
            'cancelled' => ['Cancelled', '#f87171'],
        ];
        $current = request('status', 'all');
    ?>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('staff.orders.index', ['status' => $key])); ?>"
           style="padding:.35rem 1rem;border-radius:99px;font-size:.8rem;font-weight:600;text-decoration:none;
                  transition:all .2s;
                  <?php echo e($current === $key
                      ? "background:{$color}33;color:{$color};border:1px solid {$color}55;"
                      : 'background:rgba(255,255,255,.05);color:#94a3b8;border:1px solid rgba(255,255,255,.09);'); ?>">
            <?php echo e($label); ?>

            <span style="margin-left:.3rem;opacity:.8;">
                (<?php echo e($key === 'all' ? $counts->sum() : ($counts[$key] ?? 0)); ?>)
            </span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="table-wrap">
        <?php if($orders->isEmpty()): ?>
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <i class="fa-solid fa-box-open" style="font-size:2.5rem;margin-bottom:1rem;display:block;"></i>
            No orders found for this filter.
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Container &amp; Qty</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><span style="font-weight:700;color:#38bdf8;"><?php echo e($order->order_number); ?></span></td>
                    <td>
                        <div style="font-weight:600;"><?php echo e($order->customer->name ?? '—'); ?></div>
                        <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($order->customer->email ?? ''); ?></div>
                    </td>
                    <td>
                        <?php if($order->items && $order->items->isNotEmpty()): ?>
                            <div style="display:flex;flex-direction:column;gap:.25rem;">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.15rem .5rem;border-radius:6px;font-size:.72rem;font-weight:600;background:<?php echo e($item->serviceTypeColor()); ?>22;color:<?php echo e($item->serviceTypeColor()); ?>;border:1px solid <?php echo e($item->serviceTypeColor()); ?>44;">
                                            <i class="fa-solid <?php echo e($item->serviceTypeIcon()); ?>"></i>
                                            <?php echo e($item->serviceTypeLabel()); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:6px;font-size:.75rem;font-weight:600;background:<?php echo e($order->serviceTypeColor()); ?>22;color:<?php echo e($order->serviceTypeColor()); ?>;border:1px solid <?php echo e($order->serviceTypeColor()); ?>44;">
                                <i class="fa-solid <?php echo e($order->serviceTypeIcon()); ?>"></i>
                                <?php echo e($order->serviceTypeLabel()); ?>

                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($order->items && $order->items->isNotEmpty()): ?>
                            <div style="display:flex;flex-direction:column;gap:.25rem;">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div style="font-weight:600;display:flex;align-items:center;gap:.35rem;font-size:.82rem;">
                                        <i class="fa-solid <?php echo e($item->containerSizeIcon()); ?>" style="color:#38bdf8;font-size:.8rem;"></i>
                                        <?php echo e($item->quantity); ?> × <?php echo e($item->containerSizeShort()); ?>

                                        <span style="font-size:.72rem;color:var(--text-muted);font-weight:400;">(₱<?php echo e(number_format($item->subtotal, 2)); ?>)</span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div style="font-weight:600;display:flex;align-items:center;gap:.35rem;">
                                <i class="fa-solid <?php echo e($order->containerSizeIcon()); ?>" style="color:#38bdf8;font-size:.85rem;"></i>
                                <?php echo e($order->quantity ?? $order->gallons); ?> × <?php echo e($order->containerSizeShort()); ?>

                            </div>
                            <div style="font-size:.72rem;color:var(--text-muted);">
                                ₱<?php echo e(number_format($order->unitPrice(), 2)); ?> each
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600;">₱<?php echo e(number_format($order->total_amount,2)); ?></td>
                    <td>
                        <span class="status-badge"
                            style="background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>;border:1px solid <?php echo e($order->statusColor()); ?>55;">
                            <?php echo e($order->statusLabel()); ?>

                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:.8rem;"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                    <td>
                        <div style="display:flex;gap:.4rem;align-items:center;flex-wrap:wrap;">
                            <?php if($order->status === 'completed'): ?>
                                <select class="form-select" disabled style="padding:.3rem .6rem;font-size:.75rem;width:auto;cursor:not-allowed;background:#f1f5f9;color:#64748b;border-color:#cbd5e1;opacity:.85;pointer-events:none;" title="Order is already completed and locked">
                                    <option selected>Completed</option>
                                </select>
                            <?php else: ?>
                                <form action="<?php echo e(route('staff.orders.update', $order)); ?>" method="POST" style="display:flex;gap:.4rem;align-items:center;margin:0;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <select name="status" class="form-select" style="padding:.3rem .6rem;font-size:.75rem;width:auto;">
                                        <?php $__currentLoopData = ['pending','confirmed','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s); ?>" <?php echo e($order->status === $s ? 'selected' : ''); ?>>
                                                <?php echo e(ucwords(str_replace('_',' ',$s))); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary" style="padding:.3rem .7rem;" title="Update Status">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if($order->payment_status === 'unpaid'): ?>
                                <a href="<?php echo e(route('staff.payments.index', ['order_id' => $order->id, 'tab' => 'awaiting'])); ?>" class="btn btn-sm btn-success" style="padding:.3rem .7rem;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;" title="Go to Payment Process">
                                    <i class="fa-solid fa-peso-sign"></i> Pay
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('staff.payments.index', ['order_id' => $order->id, 'tab' => 'completed'])); ?>" style="display:inline-flex;align-items:center;gap:.3rem;padding:.3rem .6rem;border-radius:6px;font-size:.75rem;font-weight:600;background:rgba(16,185,129,.15);color:#34d399;border:1px solid rgba(16,185,129,.3);text-decoration:none;" title="View Payment in POS">
                                    <i class="fa-solid fa-circle-check"></i> Paid
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <?php if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages()): ?>
    <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
        <?php echo e($orders->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Payment Modal -->
<style>
@keyframes payModalIn {
    from { opacity:0; transform:translateY(32px) scale(.97); }
    to   { opacity:1; transform:translateY(0)   scale(1);   }
}
@keyframes payBackdropIn {
    from { opacity:0; }
    to   { opacity:1; }
}
#paymentModal.visible {
    animation: payBackdropIn .25s ease forwards;
}
#paymentModal.visible #paymentCard {
    animation: payModalIn .3s cubic-bezier(.22,.68,0,1.2) forwards;
}
</style>

<div id="paymentModal" style="
    display:none;
    position:fixed; inset:0; z-index:1000;
    justify-content:center; align-items:center;
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
">
    <div id="paymentCard" style="
        width:100%; max-width:440px;
        position:relative;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 2.25rem 2rem;
        box-shadow: 0 20px 45px -10px rgba(0,0,0,0.15), 0 1px 3px rgba(0,0,0,0.06);
    ">
        <!-- Header -->
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="
                    width:42px;height:42px;border-radius:12px;
                    background:linear-gradient(135deg,#0284c7,#0ea5e9);
                    display:flex;align-items:center;justify-content:center;
                    box-shadow:0 4px 14px rgba(2,132,199,.35);
                ">
                    <i class="fa-solid fa-cash-register" style="color:#fff;font-size:1rem;"></i>
                </div>
                <div>
                    <h2 style="margin:0;font-size:1.2rem;font-weight:800;color:#0f172a;letter-spacing:-.01em;">Process Payment</h2>
                    <p style="margin:0;color:var(--text-muted);font-size:.78rem;margin-top:.1rem;">Complete the transaction</p>
                </div>
            </div>
            <button type="button" onclick="closePaymentModal()" style="
                width:32px;height:32px;border-radius:8px;
                background:#f1f5f9;border:1px solid #e2e8f0;
                color:#64748b;font-size:1rem;cursor:pointer;
                display:flex;align-items:center;justify-content:center;
                transition:background .2s,color .2s;
            " onmouseover="this.style.background='#e2e8f0';this.style.color='#0f172a'" onmouseout="this.style.background='#f1f5f9';this.style.color='#64748b'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Divider -->
        <div style="height:1px;background:#e2e8f0;margin-bottom:1.5rem;"></div>

        <form id="paymentForm" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="action" value="pay">

            <!-- Amount Due -->
            <div style="
                background:#f0f9ff;
                border:1px solid #bae6fd;
                border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.25rem;
            ">
                <div style="font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#0369a1;margin-bottom:.35rem;">Total Amount Due</div>
                <div style="font-size:2rem;font-weight:800;color:#0284c7;line-height:1;letter-spacing:-.02em;">₱<span id="modalTotal">0.00</span></div>
            </div>

            <!-- Payment Method -->
            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.78rem;font-weight:700;color:#334155;margin-bottom:.45rem;letter-spacing:.03em;">PAYMENT METHOD</label>
                <select name="payment_method" class="form-select" style="padding:.65rem 1rem;border-radius:10px;font-weight:500;background:#ffffff;border:1px solid #cbd5e1;color:#0f172a;">
                    <option value="cash">💵 Cash</option>
                    <option value="gcash">📱 GCash</option>
                </select>
            </div>

            <!-- Amount Tendered -->
            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.78rem;font-weight:700;color:#334155;margin-bottom:.45rem;letter-spacing:.03em;">AMOUNT TENDERED (₱)</label>
                <input type="number" name="amount_tendered" class="form-input" id="amountTendered" step="0.01" min="0"
                    style="padding:.75rem 1rem;font-size:1.2rem;font-weight:700;border-radius:10px;letter-spacing:.01em;background:#ffffff;border:1px solid #cbd5e1;color:#0f172a;">
            </div>

            <!-- Change -->
            <div style="
                background:#ecfdf5;
                border:1px solid #a7f3d0;
                border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.75rem;
            ">
                <div style="font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#047857;margin-bottom:.35rem;">Change</div>
                <div style="font-size:1.6rem;font-weight:800;color:#059669;line-height:1;letter-spacing:-.02em;">₱<span id="modalChange">0.00</span></div>
            </div>

            <!-- Submit -->
            <button type="submit" style="
                width:100%;padding:1rem;font-size:1rem;font-weight:700;
                border:none;border-radius:12px;cursor:pointer;
                background:linear-gradient(135deg,#0284c7,#0ea5e9);
                color:#fff;letter-spacing:.02em;
                box-shadow:0 4px 18px rgba(2,132,199,.35);
                transition:opacity .2s,transform .15s,box-shadow .2s;
                display:flex;align-items:center;justify-content:center;gap:.6rem;
            " onmouseover="this.style.opacity='.92';this.style.boxShadow='0 6px 24px rgba(2,132,199,.45)';this.style.transform='translateY(-1px)'" onmouseout="this.style.opacity='1';this.style.boxShadow='0 4px 18px rgba(2,132,199,.35)';this.style.transform='translateY(0)'">
                <i class="fa-solid fa-check-double"></i> Confirm Payment
            </button>
        </form>
    </div>
</div>

<script>
    let currentTotal = 0;
    function openPaymentModal(orderId, total) {
        const modal = document.getElementById('paymentModal');
        modal.style.display = 'flex';
        // Small delay so display:flex applies before animation class
        requestAnimationFrame(() => modal.classList.add('visible'));
        document.getElementById('paymentForm').action = '/staff/orders/' + orderId;
        currentTotal = parseFloat(total) || 0;
        document.getElementById('modalTotal').textContent = currentTotal.toFixed(2);
        
        const input = document.getElementById('amountTendered');
        input.value = currentTotal.toFixed(2);
        input.focus();
        input.select();
        calculateChange();
    }
    
    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('visible');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }
    
    function calculateChange() {
        const input = document.getElementById('amountTendered');
        const tendered = parseFloat(input.value) || 0;
        const change = Math.max(0, tendered - currentTotal);
        document.getElementById('modalChange').textContent = change.toFixed(2);
    }
    
    document.getElementById('amountTendered').addEventListener('input', calculateChange);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\wince karl samillano\Downloads\IT-12-main\IT-12-main\resources\views/staff/orders/index.blade.php ENDPATH**/ ?>