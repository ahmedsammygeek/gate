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
                            <label class="col-form-label col-lg-2"> اسم المشرف 
                                <span class="text-danger">*</span>
                            </label>
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
                            <label class="col-form-label col-lg-2"> البريد الاكترونى <span class="text-danger">*</span>
                            </label>
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
                            <label class="col-form-label col-lg-2"> كلمه المرور 
                                <span class="text-danger">*</span></label>
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
                                <label class="col-form-label col-lg-2"> تاكيد كلمه المرور <span class="text-danger">*</span>
                                </label>
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

                            <div class="row mb-3">
                                <label class="col-lg-2 col-form-label pt-0">  الصلاحيات </label>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات المشرفين </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="admins.list" class="form-check-input" id="admins.list" >
                                                        <label class="form-check-label" for="admins.list"> عرض كافه المشرفين </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="admins.show" class="form-check-input" id="admins.show" >
                                                        <label class="form-check-label" for="admins.show"> عرض بيانات المشرف </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="admins.add" class="form-check-input" id="admins.add" >
                                                        <label class="form-check-label" for="admins.add"> إضافه مشرف جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="admins.delete" class="form-check-input" id="admins.delete" >
                                                        <label class="form-check-label" for="admins.delete"> حذف مشرف </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="admins.edit" class="form-check-input" id="admins.edit" >
                                                        <label class="form-check-label" for="admins.edit"> تعديل بيانات المشرف </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات المستخدمين </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="users.list" class="form-check-input" id="users.list" >
                                                        <label class="form-check-label" for="users.list"> عرض كافه المستخدمين </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="users.show" class="form-check-input" id="users.show" >
                                                        <label class="form-check-label" for="users.show"> عرض بيانات المستخدم </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="users.add" class="form-check-input" id="users.add" >
                                                        <label class="form-check-label" for="users.add"> إضافه مستخدم جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="users.delete" class="form-check-input" id="users.delete" >
                                                        <label class="form-check-label" for="users.delete"> حذف مستخدم </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="users.edit" class="form-check-input" id="users.edit" >
                                                        <label class="form-check-label" for="users.edit"> تعديل بيانات المستخدم </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الدول </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="countries.list" class="form-check-input" id="countries.list" >
                                                        <label class="form-check-label" for="countries.list"> عرض كافه الدول </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="countries.show" class="form-check-input" id="countries.show" >
                                                        <label class="form-check-label" for="countries.show"> عرض بيانات الدوله </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="countries.add" class="form-check-input" id="countries.add" >
                                                        <label class="form-check-label" for="countries.add"> إضافه دوله جديده </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="countries.delete" class="form-check-input" id="countries.delete" >
                                                        <label class="form-check-label" for="countries.delete"> حذف الدوله </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="countries.edit" class="form-check-input" id="countries.edit" >
                                                        <label class="form-check-label" for="countries.edit"> تعديل بيانات الدوله </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات التصنيفات </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="categories.list" class="form-check-input" id="categories.list" >
                                                        <label class="form-check-label" for="categories.list"> عرض كافه التصنيفات </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="categories.show" class="form-check-input" id="categories.show" >
                                                        <label class="form-check-label" for="categories.show"> عرض بيانات التصنيف </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="categories.add" class="form-check-input" id="categories.add" >
                                                        <label class="form-check-label" for="categories.add"> إضافه تصنيف جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="categories.delete" class="form-check-input" id="categories.delete" >
                                                        <label class="form-check-label" for="categories.delete"> حذف التصنيف </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="categories.edit" class="form-check-input" id="categories.edit" >
                                                        <label class="form-check-label" for="categories.edit"> تعديل بيانات التصنيف </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الجامعات </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="universities.list" class="form-check-input" id="universities.list" >
                                                        <label class="form-check-label" for="universities.list"> عرض كافه الجامعات </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="universities.show" class="form-check-input" id="universities.show" >
                                                        <label class="form-check-label" for="universities.show"> عرض بيانات الجامعه </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="universities.add" class="form-check-input" id="universities.add" >
                                                        <label class="form-check-label" for="universities.add"> إضافه جامعه جديده </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="universities.delete" class="form-check-input" id="universities.delete" >
                                                        <label class="form-check-label" for="universities.delete"> حذف الجامعه </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="universities.edit" class="form-check-input" id="universities.edit" >
                                                        <label class="form-check-label" for="universities.edit"> تعديل بيانات الجامعه </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات المدربين </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="trainers.list" class="form-check-input" id="trainers.list" >
                                                        <label class="form-check-label" for="trainers.list"> عرض كافه المدربين </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="trainers.show" class="form-check-input" id="trainers.show" >
                                                        <label class="form-check-label" for="trainers.show"> عرض بيانات المدرب </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="trainers.add" class="form-check-input" id="trainers.add" >
                                                        <label class="form-check-label" for="trainers.add"> إضافه مدرب جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="trainers.delete" class="form-check-input" id="trainers.delete" >
                                                        <label class="form-check-label" for="trainers.delete"> حذف المدرب </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="trainers.edit" class="form-check-input" id="trainers.edit" >
                                                        <label class="form-check-label" for="trainers.edit"> تعديل بيانات المدرب </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الدورات </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="courses.list" class="form-check-input" id="courses.list" >
                                                        <label class="form-check-label" for="courses.list"> عرض كافه الدورات </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="courses.show" class="form-check-input" id="courses.show" >
                                                        <label class="form-check-label" for="courses.show"> عرض بيانات الدوره </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="courses.add" class="form-check-input" id="courses.add" >
                                                        <label class="form-check-label" for="courses.add"> إضافه دوره جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="courses.delete" class="form-check-input" id="courses.delete" >
                                                        <label class="form-check-label" for="courses.delete"> حذف الدوره </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="courses.edit" class="form-check-input" id="courses.edit" >
                                                        <label class="form-check-label" for="courses.edit"> تعديل بيانات الدوره </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الوحدات </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="units.list" class="form-check-input" id="units.list" >
                                                        <label class="form-check-label" for="units.list"> عرض كافه الوحدات للدوره </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="units.show" class="form-check-input" id="units.show" >
                                                        <label class="form-check-label" for="units.show"> عرض بيانات الوحده </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="units.add" class="form-check-input" id="units.add" >
                                                        <label class="form-check-label" for="units.add"> إضافه وحده جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="units.delete" class="form-check-input" id="units.delete" >
                                                        <label class="form-check-label" for="units.delete"> حذف الوحده </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="units.edit" class="form-check-input" id="units.edit" >
                                                        <label class="form-check-label" for="units.edit"> تعديل بيانات الوحده </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الدروس </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="lessons.list" class="form-check-input" id="lessons.list" >
                                                        <label class="form-check-label" for="lessons.list"> عرض كافه دروس للدوره </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="lessons.show" class="form-check-input" id="lessons.show" >
                                                        <label class="form-check-label" for="lessons.show"> عرض بيانات الدرس </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="lessons.add" class="form-check-input" id="lessons.add" >
                                                        <label class="form-check-label" for="lessons.add"> إضافه درس جديد </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="lessons.delete" class="form-check-input" id="lessons.delete" >
                                                        <label class="form-check-label" for="lessons.delete"> حذف الدرس </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="lessons.edit" class="form-check-input" id="lessons.edit" >
                                                        <label class="form-check-label" for="lessons.edit"> تعديل بيانات الدرس </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <p class="fw-semibold"> صلاحيات الباقات </p>
                                                <div class="border p-3 rounded">
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="packages.list" class="form-check-input" id="packages.list" >
                                                        <label class="form-check-label" for="packages.list"> عرض كافه الباقات </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="packages.show" class="form-check-input" id="packages.show" >
                                                        <label class="form-check-label" for="packages.show"> عرض بيانات الباقه </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="packages.add" class="form-check-input" id="packages.add" >
                                                        <label class="form-check-label" for="packages.add"> إضافه باقه جديده </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="packages.delete" class="form-check-input" id="packages.delete" >
                                                        <label class="form-check-label" for="packages.delete"> حذف الباقه </label>
                                                    </div>
                                                    <div class="form-check text-start mb-2">
                                                        <input type="checkbox" name='permissions[]' value="packages.edit" class="form-check-input" id="packages.edit" >
                                                        <label class="form-check-label" for="packages.edit"> تعديل بيانات الباقه </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href='{{ route('board.admins.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                        <button type="submit" class="btn btn-primary ms-3">
                            إضافه <i class="ph-paper-plane-tilt ms-2"></i>
                        </button>
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
