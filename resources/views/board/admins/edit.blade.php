@extends('board.layout.master')

@section('page_title', 'تعديل بيانات المشرف')

@section('breadcrumbs')
    <a href="{{ route('board.admins.index') }}" class="breadcrumb-item"> المشرفين </a>
    <span class="breadcrumb-item active"> تعديل بيانات المشرف </span>
@endsection

@section('content')
    <!-- Main charts -->
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('board.admins.index') }}" class="btn btn-primary mb-2" style="float: left;">
                عرض كافه المشرفين <i class="icon-arrow-left7"></i></a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> تعديل بيانات المشرف </h5>
                </div>

                <form class="" method="POST" action="{{ route('board.admins.update', $admin) }}"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <div class="fw-bold border-bottom pb-2 mb-3"> بيانات المشرف </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> اسم المشرف <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" name="name" value="{{ $admin->name }}"
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
                                        <span class="input-group-text"><i class="icon-mention "></i></span>
                                        <input type="email" name="email" value='{{ $admin->email }}'
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
                                        <input type="text" name="phone" value='{{ $admin->phone }}'
                                            class="form-control @error('phone')  is-invalid @enderror"
                                            placeholder="رقم الجوال">
                                    </div>
                                    @error('phone')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> كلمه المرور </label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="password" name="password" id="passwordInput" class="form-control"
                                            placeholder="كلمه المرور">
                                        <span class="input-group-text" onclick="showPassword()"> <i
                                                class="icon-eye2"></i></span>
                                        @error('password')
                                            <p class='text-danger'> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2"> تاكيد كلمه المرور </label>
                                <div class="col-lg-10">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="تاكيد كلمه المرور">
                                    @error('password_confirmation')
                                        <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-lg-2 col-form-label pt-0"> السماح بدخول النظام </label>
                                <div class="col-lg-10">
                                    <label class="form-check form-switch">
                                        <input type="checkbox" value='1' class="form-check-input" name="active"
                                            {{ $admin->is_banned == 0 ? 'checked' : '' }}>
                                        <span class="form-check-label"> نعم </span>
                                    </label>
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
                                <label class="col-lg-2 col-form-label pt-0"> الصوره الشخصيه الحاليه </label>
                                <div class="col-lg-10">
                                    <img src="{{ Storage::url('users/' . $admin->image) }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href='{{ route('board.admins.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                        <button type="submit" class="btn btn-primary ms-3"> تعديل <i
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
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
