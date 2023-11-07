@extends('board.layout.master')

@section('page_title', 'إضافه مشرف جديد')

@section('breadcrumbs')
    <a href="{{ route('board.admins.index') }}" class="breadcrumb-item"> المشرفين </a>
    <span class="breadcrumb-item active"> إضافه مشرف جديد </span>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> إضافه مشرف جديد </h5>
                </div>

                <form class="" method="POST" action="{{ route('board.admins.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="mb-4">
                            <div class="fw-bold border-bottom pb-2 mb-3"> بيانات المشرف </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> اسم المشرف <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input autocomplete="off" type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name')  is-invalid @enderror" required
                                        placeholder="اسم المشرف">
                                    @error('name')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> البريد الاكترونى <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="icon-mention"></i></span>
                                        <input autocomplete="off" type="email" name="email" value='{{ old('email') }}'
                                            class="form-control @error('email')  is-invalid @enderror" required
                                            placeholder="البريد الاكترونى">
                                    </div>
                                    @error('email')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> رقم الجوال </label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="icon-phone2 "></i></span>
                                        <input autocomplete="off" type="text" name="phone" value='{{ old('phone') }}'
                                            class="form-control @error('phone')  is-invalid @enderror"
                                            placeholder="رقم الجوال">
                                    </div>
                                    @error('phone')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> كلمه المرور <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input autocomplete="off" type="password" name="password" id="passwordInput"
                                            class="form-control" required placeholder="كلمه المرور">
                                        <span class="input-group-text" onclick="showPassword()">
                                            <i class="icon-eye2" id="passEye"></i>
                                        </span>
                                    </div>
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> تاكيد كلمه المرور <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input autocomplete="off" type="password" name="password_confirmation"
                                            class="form-control" required placeholder="تاكيد كلمه المرور"
                                            id="confirmPasswordInput">
                                        <span class="input-group-text" onclick="showConfirmedPassword()">
                                            <i class="icon-eye2" id="confirmPassEye"></i>
                                        </span>
                                        @error('password_confirmation')
                                            <p class='text-danger'> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-lg-2 col-form-label pt-0"> الصوره الشخصيه </label>
                                <div class="col-lg-10">
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-lg-2 col-form-label pt-0"> السماح بدخول النظام</label>
                                <div class="col-lg-10">
                                    <label class="form-check form-switch">
                                        <input type="checkbox" value='1' class="form-check-input" name="active">
                                        <span class="form-check-label"> نعم </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href='{{ route('board.admins.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                        <button type="submit" class="btn btn-primary ms-3"> إضافه <i
                                class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
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
