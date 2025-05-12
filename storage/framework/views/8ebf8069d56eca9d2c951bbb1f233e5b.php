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
            📝 Запис на прийом
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-8 px-4 max-w-xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="mb-4 text-red-600">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>• <?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('appointments.store')); ?>" class="bg-white p-6 rounded shadow space-y-5">
            <?php echo csrf_field(); ?>

            
            <div>
                <label for="service_id" class="block font-medium text-sm text-gray-700">Послуга</label>
                <?php if(isset($service)): ?>
                    <input type="text" value="<?php echo e($service->name); ?>" disabled class="mt-1 block w-full rounded border-gray-300 bg-gray-100">
                    <input type="hidden" name="service_id" value="<?php echo e($service->id); ?>">
                <?php else: ?>
                    <select name="service_id" id="service_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Оберіть послугу</option>
                        <?php $__currentLoopData = $services ?? \App\Models\Service::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('service_id') == $item->id ? 'selected' : ''); ?>>
                                <?php echo e($item->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>
            </div>

            
            <div>
                <label for="master_id" class="block font-medium text-sm text-gray-700">Майстер</label>
                <?php if(isset($master)): ?>
                    <input type="text" value="<?php echo e($master->name); ?> — <?php echo e($master->specialty); ?>" disabled class="mt-1 block w-full rounded border-gray-300 bg-gray-100">
                    <input type="hidden" name="master_id" value="<?php echo e($master->id); ?>">
                <?php else: ?>
                    <select name="master_id" id="master_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Оберіть майстра</option>
                        <?php $__currentLoopData = $masters ?? \App\Models\Master::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('master_id') == $item->id ? 'selected' : ''); ?>>
                                <?php echo e($item->name); ?> — <?php echo e($item->specialty); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>
            </div>

            
            <div>
                <label for="date" class="block font-medium text-sm text-gray-700">Дата</label>
                <input type="date" name="date" id="date" class="mt-1 block w-full rounded border-gray-300" value="<?php echo e(old('date')); ?>" required>
            </div>

            
            <div>
                <label for="time" class="block font-medium text-sm text-gray-700">Час</label>
                <input type="time" name="time" id="time" class="mt-1 block w-full rounded border-gray-300" value="<?php echo e(old('time')); ?>" required>
            </div>

            <div class="flex justify-end pt-4">
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
                    <?php echo e(__('Записатися')); ?>

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
            </div>
        </form>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dateInput = document.querySelector('#date');
        const masterSelect = document.querySelector('#master_id');
        const serviceSelect = document.querySelector('#service_id');
        const timeSelect = document.querySelector('#time');

        async function fetchAvailableTimes() {
            const date = dateInput.value;
            const masterId = masterSelect?.value;
            const serviceId = serviceSelect?.value;

            if (!date || !masterId || !serviceId) {
                timeSelect.innerHTML = '<option value="">Оберіть дату, майстра і послугу</option>';
                return;
            }

            try {
                const response = await axios.get('/appointments/available-times', {
                    params: {
                        date: date,
                        master_id: masterId,
                        service_id: serviceId
                    }
                });

                const times = response.data;
                timeSelect.innerHTML = '';

                if (times.length === 0) {
                    timeSelect.innerHTML = '<option value="">Немає доступного часу</option>';
                } else {
                    times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeSelect.appendChild(option);
                    });
                }

            } catch (error) {
                console.error(error);
                timeSelect.innerHTML = '<option value="">Помилка завантаження часу</option>';
            }
        }

        [dateInput, masterSelect, serviceSelect].forEach(el => {
            if (el) el.addEventListener('change', fetchAvailableTimes);
        });

        // Сразу обновить, если все значения уже выбраны
        fetchAvailableTimes();
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/appointments/book.blade.php ENDPATH**/ ?>