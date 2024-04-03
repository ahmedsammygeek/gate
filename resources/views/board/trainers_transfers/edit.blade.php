@extends('board.layout.master')

@section('page_title', 'تعديل بيانات المستخدم')

@section('breadcrumbs')
<a href="{{ route('board.users.index') }}" class="breadcrumb-item"> المستخدمين </a>
<span class="breadcrumb-item active"> تعديل بيانات المستخدم </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"> تعديل بيانات المستخدم </h5>
            </div>

            <form class="" method="POST" action="{{ route('board.users.update', $user) }}"
            enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <div class="fw-bold border-bottom pb-2 mb-3"> بيانات المستخدم </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> اسم المستخدم <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input autocomplete="off" type="text" name="name" value="{{ $user->name }}"
                            class="form-control @error('name')  is-invalid @enderror" required
                            placeholder="اسم المستخدم">
                            @error('name')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> البريد الاكترونى <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-mention "></i></span>
                                <input autocomplete="off" type="email" name="email" value='{{ $user->email }}'
                                class="form-control @error('email')  is-invalid @enderror" required
                                placeholder="البريد الاكترونى">
                            </div>
                            @error('email')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> telegram <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-mention "></i></span>
                                <input autocomplete="off" type="text" name="telegram" value='{{ $user->telegram }}'
                                class="form-control @error('telegram')  is-invalid @enderror" required
                                placeholder="البريد الاكترونى">
                            </div>
                            @error('email')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> رقم الجوال <span class="text-danger">*</span> </label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="icon-phone2 "></i></span>
                                <input autocomplete="off" type="text" name="phone" value='{{ $user->phone }}'
                                class="form-control @error('phone')  is-invalid @enderror"
                                placeholder="رقم الجوال">
                            </div>
                            @error('phone')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> الجماعه <span class="text-danger">*</span> </label>
                        <div class="col-lg-10">
                            <select name="university_id"  class="form-control" >
                                @foreach ($universities as $university)
                                <option value="{{ $university->id }}" {{ $user->university_id  == $university->id ? 'selected="selected"' : '' }} > {{ $university->title }} </option>
                                @endforeach
                            </select>
                            @error('university_id')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> نوع الدراسه <span class="text-danger">*</span> </label>
                        <div class="col-lg-10">
                            <select name="study_type"  class="form-control" >
                                <option value=""></option>
                                <option value="1" {{ $user->study_type == 1 ? 'selected="selected"' : '' }} > تخصصى</option>
                                <option value="2" {{ $user->study_type == 2 ? 'selected="selected"' : ''  }} > تحضيري</option>
                            </select>
                            @error('study_type')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> التخصص </label>
                        <div class="col-lg-10">
                            <input autocomplete="off" type="text" name="division" value="{{ $user->division }}"
                            class="form-control @error('division')  is-invalid @enderror" 
                            placeholder="التخصص">
                            @error('division')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2"> رقم الشعبه </label>
                        <div class="col-lg-10">
                            <input autocomplete="off" type="text" name="group_number" value="{{ $user->group_number }}"
                            class="form-control @error('group_number')  is-invalid @enderror" 
                            placeholder="رقم الشعبه">
                            @error('group_number')
                            <p class='text-danger'> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-2 col-form-label pt-0"> السماح بدخول النظام </label>
                        <div class="col-lg-10">
                            <label class="form-check form-switch">
                                <input type="checkbox" value='1' class="form-check-input" name="active"
                                {{ $user->is_banned == 0 ? 'checked' : '' }}>
                                <span class="form-check-label"> نعم </span>
                            </label>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href='{{ route('board.users.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                <button type="submit" class="btn btn-primary ms-3"> تعديل <i
                    class="ph-paper-plane-tilt ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>
 function showPassword() {
    var x = document.getElementById("passwordInput");
    var passEye = document.getElementById("passEye");

    if (x.type === "password") {
        x.type = "text";
        passEye.style.color = "blue";
    } else {
        x.type = "password";
                passEye.style.color = "black"; // Change the color to your desired color
            }
        }

        function showConfirmedPassword() {
            var x = document.getElementById("confirmPasswordInput");
            var passEye = document.getElementById("confirmPassEye");

            if (x.type === "password") {
                x.type = "text";
                passEye.style.color = "blue";
            } else {
                x.type = "password";
                passEye.style.color = "blue";
            }
        }
    </script>
    @endsection
