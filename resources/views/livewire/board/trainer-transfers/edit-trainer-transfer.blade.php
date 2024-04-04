<div class="mb-4">
    <div class="fw-bold border-bottom pb-2 mb-3"> بيانات التحويل </div>
    <div class="row mb-3">
        <label class="col-form-label col-lg-2">  المدرب <span class="text-danger">*</span>    </label>
        <div class="col-lg-10">
            <div class="input-group">
                <select name="trainer_id" wire:model='trainer_id' class='form-control' id="">
                    @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->id }}"> {{ $trainer->name }} </option>
                    @endforeach
                </select>
            </div>
            @error('trainer_id')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-lg-2">  الكورس <span class="text-danger">*</span>   </label>
        <div class="col-lg-10">
            <div class="input-group">
                <select name="course_id" wire:model='course_id' class='form-control' id="">
                    <option value=""></option>
                    @foreach ($this->courses as $course)
                    <option value="{{ $course->id }}"> {{ $course->title }} </option>
                    @endforeach
                </select>
            </div>
            @error('course_id')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-form-label col-lg-2">  نوع التحويل <span class="text-danger">*</span>    </label>
        <div class="col-lg-10">
            <div class="input-group">
                <select name="transfer_type" wire:model='transfer_type' class='form-control' id="">
                    <option value="1"> تحويل بنكى </option>
                    <option value="2"> paypal </option>
                    <option value="3"> فودافون كاش </option>
                </select>
            </div>
            @error('course_id')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-lg-2 col-form-label pt-0"> المبلغ <span class="text-danger">*</span> </label>
        <div class="col-lg-10">
            <input type="text" name="amount" wire:model='amount' class="form-control">
            @error('amount')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-lg-2 col-form-label pt-0"> تاريخ التحويل <span class="text-danger">*</span> </label>
        <div class="col-lg-10">
            <input type="date" name="transfer_date" wire:model='transfer_date' class="form-control">
            @error('transfer_date')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>



    <div class="row mb-3">
        <label class="col-lg-2 col-form-label pt-0"> الصوره التحويل </label>
        <div class="col-lg-10">
            <input type="file" name="image" class="form-control">
            @error('image')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>


    <div class="row mb-3">
        <label class="col-lg-2 col-form-label pt-0"> ملاحظات </label>
        <div class="col-lg-10">
            <input type="text" name="comments"  wire:model='comments' class="form-control">
            @error('comments')
            <p class='text-danger'> {{ $message }} </p>
            @enderror
        </div>
    </div>


</div>