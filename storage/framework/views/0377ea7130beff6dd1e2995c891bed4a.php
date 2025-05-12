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
        <h2 class="text-xl font-semibold text-gray-800">
            <?php echo e(__('Про нас')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-8 max-w-4xl mx-auto space-y-8">

        
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->role === 'admin'): ?>
                <div class="flex justify-end gap-4">
                    <a href="<?php echo e(route('admin.about.edit', ['section' => 'note'])); ?>"
                       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        ✏️ Редагувати примітку
                    </a>
                    <a href="<?php echo e(route('admin.about.edit', ['section' => 'info'])); ?>"
                       class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        ✏️ Редагувати інформацію
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if($note && $note->content): ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow text-center">
                <?php echo nl2br(e($note->content)); ?>

            </div>
        <?php endif; ?>

        
        <div class="bg-white p-6 rounded shadow text-gray-800 leading-relaxed">
            <?php if($info && $info->content): ?>
                <?php echo nl2br(e($info->content)); ?>

            <?php else: ?>
                <p class="text-gray-500 text-center">Інформацію про салон ще не додано.</p>
            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/about.blade.php ENDPATH**/ ?>