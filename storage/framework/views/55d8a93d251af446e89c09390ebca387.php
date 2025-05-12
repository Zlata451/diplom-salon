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
            <?php echo e(__('Запис на послугу')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-10">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <?php if($errors->any()): ?>
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('appointments.store')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Послуга</label>
                        <select name="service_id" id="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть послугу</option>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?> (<?php echo e($service->price); ?> грн)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Майстер</label>
                        <select name="master_id" id="master_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть спочатку послугу</option>
                        </select>
                    </div>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Дата</label>
                        <input type="date" name="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Час</label>
                        <input type="time" name="time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        Записатись
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const serviceSelect = document.getElementById('service_id');
        const masterSelect = document.getElementById('master_id');

        serviceSelect.addEventListener('change', async () => {
            const serviceId = serviceSelect.value;
            masterSelect.innerHTML = '<option>Завантаження...</option>';

            if (!serviceId) {
                masterSelect.innerHTML = '<option value="">Оберіть спочатку послугу</option>';
                return;
            }

            try {
                const response = await axios.get(`/api/services/${serviceId}/masters`);
                const masters = response.data;

                if (masters.length === 0) {
                    masterSelect.innerHTML = '<option value="">Немає майстрів для цієї послуги</option>';
                    return;
                }

                masterSelect.innerHTML = '<option value="">Оберіть майстра</option>';
                masters.forEach(master => {
                    const option = document.createElement('option');
                    option.value = master.id;
                    option.textContent = `${master.name} (${master.specialty})`;
                    masterSelect.appendChild(option);
                });

            } catch (error) {
                console.error('Помилка при завантаженні майстрів:', error);
                masterSelect.innerHTML = '<option value="">Помилка при завантаженні</option>';
            }
        });
    </script>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/appointments/create.blade.php ENDPATH**/ ?>