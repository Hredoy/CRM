
<?php echo e(Form::open(array('url'=>'event','method'=>'post'))); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-md-4">

            <?php echo e(Form::label('branch_id',__('Branch'),['class'=>'form-label'])); ?>

            <select class="form-control select" name="branch_id" id="branch_id" placeholder="<?php echo e(__('Select Branch')); ?>">
                <option value=""><?php echo e(__('Select Branch')); ?></option>

                <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

        </div>
        <div class="col-md-4">

            <?php echo e(Form::label('department_id',__('Department'),['class'=>'form-label'])); ?>

            <select class="form-control " name="department_id" id="department_id"  placeholder="<?php echo e(__('Select Department')); ?>">
                <option value=""><?php echo e(__('Select Department')); ?></option>
            </select>
        </div>
        <div class="col-md-4">

            <?php echo e(Form::label('employee_id',__('Employee'),['class'=>'form-label'])); ?>

            <select class="form-control " name="employee_id" id="employee_id" placeholder="<?php echo e(__('Select Employee')); ?>" >
                <option value=""><?php echo e(__('Select Employee')); ?></option>

            </select>

        </div>
    </div>


    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('title',__('Event Title'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Event Title')))); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date',__('Event start Date'),['class'=>'form-label'])); ?>

                <?php echo e(Form::date('start_date',null,array('class'=>'form-control '))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date',__('Event End Date'),['class'=>'form-label'])); ?>

                <?php echo e(Form::date('end_date',null,array('class'=>'form-control '))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('color',__('Event Select Color'),['class'=>'form-label d-block mb-3'])); ?>

                <div class="btn-group btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label class="btn bg-info active mr-2">
                        <input type="radio" name="color" value="bg-info" autocomplete="off" checked style="display: none; ">
                    </label>
                    <label class="btn bg-warning mr-2">
                        <input type="radio" name="color" value="bg-warning" autocomplete="off" style="display: none">
                    </label>
                    <label class="btn bg-danger mr-2">
                        <input type="radio" name="color" value="bg-danger" autocomplete="off" style="display: none">
                    </label>
                    <label class="btn bg-success mr-2">
                        <input type="radio" name="color" value="bg-success" autocomplete="off" style="display: none">
                    </label>
                    <label class="btn bg-secondary mr-2">
                        <input type="radio" name="color" value="bg-secondary" autocomplete="off" style="display: none">
                    </label>
                    <label class="btn bg-primary mr-2">
                        <input type="radio" name="color" value="bg-primary" autocomplete="off" style="display: none">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description',__('Event Description'),['class'=>'form-label'])); ?>

                <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Event Description')))); ?>

            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>


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
                    var multipleCancelButton = new Choices('#employee_id', {
                        removeItemButton: true,
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>



<?php /**PATH /home2/ameltek/public_html/subdomains/work.ameltek.com/resources/views/event/create.blade.php ENDPATH**/ ?>