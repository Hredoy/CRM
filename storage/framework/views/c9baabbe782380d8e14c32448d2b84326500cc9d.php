<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Event')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Event')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create event')): ?>
            <a href="#" data-size="lg" data-url="<?php echo e(route('event.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Event')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Calendar')); ?></h5>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4"><?php echo e(__('Upcoming Events')); ?></h6>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100">
                        <li class="list-group-item card mb-3">
                            <div class="row align-items-center justify-content-between">
                                <div class=" align-items-center">
                                    <?php if(!$events->isEmpty()): ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $current_month_event; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="card mb-3 border shadow-none">
                                                <div class="px-3">
                                                    <div class="row align-items-center">
                                                        <div class="col ml-n2">
                                                            <h5 class="text-sm mb-0 fc-event-title-container">
                                                                <a href="#" data-size="lg" data-url="<?php echo e(route('event.edit',$event->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Event')); ?>" class="fc-event-title text-primary">
                                                                    <?php echo e($event->title); ?>

                                                                </a>
                                                            </h5><br>

                                                            <p class="card-text small text-dark mt-0">
                                                                <?php echo e(__('Start Date : ')); ?>

                                                                <?php echo e(\Auth::user()->dateFormat($event->start_date)); ?><br>
                                                                <?php echo e(__('End Date : ')); ?>

                                                                <?php echo e(\Auth::user()->dateFormat($event->end_date)); ?>

                                                            </p>

                                                        </div>
                                                        <div class="col-auto text-right">

                                                                <div class="action-btn bg-primary ms-2">
                                                                    <a href="#" data-url="<?php echo e(route('event.edit',$event->id)); ?>" data-title="<?php echo e(__('Edit Event')); ?>" data-ajax-popup="true" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>"><i class="ti ti-pencil text-white"></i></a>
                                                                </div>

                                                                <div class="action-btn bg-danger ms-2">
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['event.destroy', $event->id],'id'=>'delete-form-'.$event->id]); ?>

                                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($event->id); ?>').submit();"><i class="ti ti-trash text-white"></i></a>
                                                                    <?php echo Form::close(); ?>

                                                                </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <h6><?php echo e(__('There is no event in this month')); ?></h6>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-center">

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>

    <script type="text/javascript">


        (function () {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "<?php echo e(__('Day')); ?>",
                    timeGridWeek: "<?php echo e(__('Week')); ?>",
                    dayGridMonth: "<?php echo e(__('Month')); ?>"
                },
                themeSystem: 'bootstrap',
                initialDate: '<?php echo e($transdate); ?>',
                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events:<?php echo $arrEvents; ?>,

            });
            calendar.render();
        })();
    </script>

    <script>
        $(document).ready(function () {
            var b_id = $('#branch_id').val();
            getDepartment(b_id);
        });
        $(document).on('change', 'select[name=branch_id]', function () {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(bid) {

            $.ajax({
                url: '<?php echo e(route('event.getdepartment')); ?>',
                type: 'POST',
                data: {
                    "branch_id": bid, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $("#department_id").html('');
                    $('#department_id').append('<select class="form-control" id="department_id" name="department_id[]" ></select>');

                    // $('#department_id').empty();
                    $('#department_id').append('<option value=""><?php echo e(__('Select Department')); ?></option>');

                    $('#department_id').append('<option value="0"> <?php echo e(__('All Department')); ?> </option>');
                    $.each(data, function (key, value) {
                        $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                    });

                    // var multipleCancelButton = new Choices('#department_id', {
                    //     removeItemButton: true,
                    // });
                }
            });
        }

        $(document).on('change', '#department_id', function () {
            var department_id = $(this).val();
            getEmployee(department_id);
        });

        function getEmployee(did) {
            $.ajax({
                url: '<?php echo e(route('event.getemployee')); ?>',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {

                    $("#employee_id").html('');
                    $('#employee_id').append('<select class="form-control" id="employee_id" name="employee_id[]"  multiple></select>');

                    $('#employee_id').empty();
                    $('#employee_id').append('<option value=""><?php echo e(__('Select Employee')); ?></option>');
                    $('#employee_id').append('<option value="0"> <?php echo e(__('All Employee')); ?> </option>');

                    $.each(data, function (key, value) {
                        $('#employee_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    // var multipleCancelButton = new Choices('#employee_id', {
                    //     removeItemButton: true,
                    // });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/ameltek/public_html/subdomains/work.ameltek.com/resources/views/event/index.blade.php ENDPATH**/ ?>