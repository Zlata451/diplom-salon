<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <?php echo e(__('Наші майстри')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                    $daysUa = [
                        'monday' => 'Понеділок',
                        'tuesday' => 'Вівторок',
                        'wednesday' => 'Середа',
                        'thursday' => 'Четвер',
                        'friday' => 'Пʼятниця',
                        'saturday' => 'Субота',
                        'sunday' => 'Неділя',
                    ];
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $masters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        
                        <?php if($master->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $master->photo)); ?>"
                                 alt="<?php echo e($master->name); ?>"
                                 class="w-full h-60 object-cover rounded mb-4">
                        <?php else: ?>
                            <div class="w-full h-60 bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-500">
                                Фото відсутнє
                            </div>
                        <?php endif; ?>

                        
                        <h3 class="text-lg font-semibold text-indigo-700"><?php echo e($master->name); ?></h3>
                        <p class="mt-1 text-sm text-gray-600"><?php echo e($master->specialty); ?></p>

                        <?php if($master->phone): ?>
                            <p class="text-sm text-gray-500 mt-2">📞 <?php echo e($master->phone); ?></p>
                        <?php endif; ?>

                        <?php if($master->email): ?>
                            <p class="text-sm text-gray-500">✉️ <?php echo e($master->email); ?></p>
                        <?php endif; ?>

                        
                        <?php if($master->workingHours->count()): ?>
                            <div class="mt-4 text-sm text-left">
                                <p class="font-semibold text-gray-700 mb-1">🕒 Графік роботи:</p>
                                <ul class="space-y-1 text-gray-600">
                                    <?php $__currentLoopData = $master->workingHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo e($daysUa[$wh->day_of_week] ?? ucfirst($wh->day_of_week)); ?>:
                                            <?php echo e(\Carbon\Carbon::parse($wh->start_time)->format('H:i')); ?> —
                                            <?php echo e(\Carbon\Carbon::parse($wh->end_time)->format('H:i')); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <p class="mt-4 text-sm text-gray-400">Графік роботи не вказано</p>
                        <?php endif; ?>

                        
                        <a href="<?php echo e(route('appointments.bookWithMaster', ['master' => $master->id])); ?>"
                           class="mt-4 inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">
                            📝 Записатися
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 col-span-full text-center">Наразі майстрів немає 🥲</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/masters/public_index.blade.php ENDPATH**/ ?>