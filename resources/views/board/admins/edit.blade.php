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
                                <input autocomplete="off" type="text" name="name" value="{{ $admin->name }}"
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
                                        <input autocomplete="off" type="email" name="email" value='{{ $admin->email }}'
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
                                        <input autocomplete="off" type="text" name="phone" value='{{ $admin->phone }}'
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
                                        <input autocomplete="off" type="password" name="password" id="passwordInput"
                                        class="form-control" placeholder="كلمه المرور">
                                        <span class="input-group-text" onclick="showPassword()"> <i
                                            class="icon-eye2" id="passEye"></i></span>
                                        </div>
                                        @error('password')
                                        <p class='text-danger'> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-2"> تاكيد كلمه المرور </label>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <input autocomplete="off" type="password" name="password_confirmation" id="confirmPasswordInput"
                                            class="form-control" placeholder="تاكيد كلمه المرور">
                                            <span class="input-group-text" onclick="showConfirmedPassword()"> <i
                                                class="icon-eye2" id="confirmPassEye"></i></span>
                                            </div>
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
                                        <label class="col-lg-2 col-form-label pt-0">  الصلاحيات </label>
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <p class="fw-semibold"> صلاحيات المشرفين </p>
                                                        <div class="border p-3 rounded">
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="admins.list" class="form-check-input" id="admins.list" {{ in_array('admins.list', $user_permissions) ? 'checked' : '' }}    >
                                                                <label class="form-check-label" for="admins.list"> عرض كافه المشرفين </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="admins.show" class="form-check-input" id="admins.show" {{ in_array('admins.show', $user_permissions) ? 'checked' : '' }}    >
                                                                <label class="form-check-label" for="admins.show"> عرض بيانات المشرف </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="admins.add" class="form-check-input" id="admins.add"  {{ in_array('admins.add', $user_permissions) ? 'checked' : '' }}   >
                                                                <label class="form-check-label" for="admins.add"> إضافه مشرف جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="admins.delete" class="form-check-input" id="admins.delete" {{ in_array('admins.delete', $user_permissions) ? 'checked' : '' }}    >
                                                                <label class="form-check-label" for="admins.delete"> حذف مشرف </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="admins.edit" class="form-check-input" id="admins.edit" {{ in_array('admins.edit', $user_permissions) ? 'checked' : '' }}    >
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
                                                                <input type="checkbox" name='permissions[]' value="users.list" class="form-check-input" id="users.list" {{ in_array('users.list', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="users.list"> عرض كافه المستخدمين </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="users.show" class="form-check-input" id="users.show" {{ in_array('users.show', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="users.show"> عرض بيانات المستخدم </label>
                                                            </div>
                                                            {{-- <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="users.add" class="form-check-input" id="users.add" {{ in_array('users.add', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="users.add"> إضافه مستخدم جديد </label>
                                                            </div> --}}
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="users.delete" class="form-check-input" id="users.delete" {{ in_array('users.delete', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="users.delete"> حذف مستخدم </label>
                                                            </div>
                                                            {{-- <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="users.edit" class="form-check-input" id="users.edit" {{ in_array('users.edit', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="users.edit"> تعديل بيانات المستخدم </label>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <p class="fw-semibold"> صلاحيات الدول </p>
                                                        <div class="border p-3 rounded">
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="countries.list" class="form-check-input" id="countries.list"  {{ in_array('countries.list', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="countries.list"> عرض كافه الدول </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="countries.show" class="form-check-input" id="countries.show"  {{ in_array('countries.show', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="countries.show"> عرض بيانات الدوله </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="countries.add" class="form-check-input" id="countries.add"  {{ in_array('countries.add', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="countries.add"> إضافه دوله جديده </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]'
                                                                value="countries.delete" class="form-check-input" id="countries.delete"  {{ in_array('countries.delete', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="countries.delete"> حذف الدوله </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="countries.edit" class="form-check-input" id="countries.edit"  {{ in_array('countries.edit', $user_permissions ) ? 'checked' : '' }} >
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
                                                                <input type="checkbox" name='permissions[]' value="categories.list" class="form-check-input" id="categories.list"  {{ in_array('categories.list', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="categories.list"> عرض كافه التصنيفات </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="categories.show" class="form-check-input" id="categories.show"  {{ in_array('categories.show', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="categories.show"> عرض بيانات التصنيف </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="categories.add" class="form-check-input" id="categories.add"  {{ in_array('categories.add', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="categories.add"> إضافه تصنيف جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="categories.delete" class="form-check-input" id="categories.delete"  {{ in_array('categories.delete', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="categories.delete"> حذف التصنيف </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="categories.edit" class="form-check-input" id="categories.edit"  {{ in_array('categories.edit', $user_permissions ) ? 'checked' : '' }} >
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
                                                                <input type="checkbox" name='permissions[]' value="universities.list" class="form-check-input" id="universities.list"   {{ in_array('universities.list', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="universities.list"> عرض كافه الجامعات </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="universities.show" class="form-check-input" id="universities.show"   {{ in_array('universities.show', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="universities.show"> عرض بيانات الجامعه </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="universities.add" class="form-check-input" id="universities.add"   {{ in_array('universities.add', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="universities.add"> إضافه جامعه جديده </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="universities.delete" class="form-check-input" id="universities.delete"   {{ in_array('universities.delete', $user_permissions ) ? 'checked' : '' }} >
                                                                <label class="form-check-label" for="universities.delete"> حذف الجامعه </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="universities.edit" class="form-check-input" id="universities.edit"  {{ in_array('universities.edit', $user_permissions ) ? 'checked' : '' }}  >
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
                                                                <input type="checkbox" name='permissions[]' value="trainers.list" class="form-check-input" id="trainers.list"   {{ in_array('trainers.list', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="trainers.list"> عرض كافه المدربين </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="trainers.show" class="form-check-input" id="trainers.show"   {{ in_array('trainers.show', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="trainers.show"> عرض بيانات المدرب </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="trainers.add" class="form-check-input" id="trainers.add"   {{ in_array('trainers.add', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="trainers.add"> إضافه مدرب جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="trainers.delete" class="form-check-input" id="trainers.delete"   {{ in_array('trainers.delete', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="trainers.delete"> حذف المدرب </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="trainers.edit" class="form-check-input" id="trainers.edit"   {{ in_array('trainers.edit', $user_permissions ) ? 'checked' : '' }}  >
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
                                                                <input type="checkbox" name='permissions[]' value="courses.list" class="form-check-input" id="courses.list"  {{ in_array('courses.list', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="courses.list"> عرض كافه الدورات </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="courses.show" class="form-check-input" id="courses.show"  {{ in_array('courses.show', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="courses.show"> عرض بيانات الدوره </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="courses.add" class="form-check-input" id="courses.add"  {{ in_array('courses.add', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="courses.add"> إضافه دوره جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="courses.delete" class="form-check-input" id="courses.delete"  {{ in_array('courses.delete', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="courses.delete"> حذف الدوره </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="courses.edit" class="form-check-input" id="courses.edit"  {{ in_array('courses.edit', $user_permissions ) ? 'checked' : '' }}  >
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
                                                                <input type="checkbox" name='permissions[]' value="units.list" class="form-check-input" id="units.list"   {{ in_array('units.list', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="units.list"> عرض كافه الوحدات للدوره </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="units.show" class="form-check-input" id="units.show"   {{ in_array('units.show', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="units.show"> عرض بيانات الوحده </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="units.add" class="form-check-input" id="units.add"   {{ in_array('units.add', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="units.add"> إضافه وحده جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="units.delete" class="form-check-input" id="units.delete"   {{ in_array('units.delete', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="units.delete"> حذف الوحده </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="units.edit" class="form-check-input" id="units.edit"  {{ in_array('units.edit', $user_permissions ) ? 'checked' : '' }}   >
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
                                                                <input type="checkbox" name='permissions[]' value="lessons.list" class="form-check-input" id="lessons.list"  {{ in_array('lessons.list', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="lessons.list"> عرض كافه دروس للدوره </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="lessons.show" class="form-check-input" id="lessons.show"  {{ in_array('lessons.show', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="lessons.show"> عرض بيانات الدرس </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="lessons.add" class="form-check-input" id="lessons.add"  {{ in_array('lessons.add', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="lessons.add"> إضافه درس جديد </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="lessons.delete" class="form-check-input" id="lessons.delete"  {{ in_array('lessons.delete', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="lessons.delete"> حذف الدرس </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="lessons.edit" class="form-check-input" id="lessons.edit"  {{ in_array('lessons.edit', $user_permissions ) ? 'checked' : '' }}  >
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
                                                                <input type="checkbox" name='permissions[]' value="packages.list" class="form-check-input" id="packages.list"  {{ in_array('packages.list', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="packages.list"> عرض كافه الباقات </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="packages.show" class="form-check-input" id="packages.show"  {{ in_array('packages.show', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="packages.show"> عرض بيانات الباقه </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="packages.add" class="form-check-input" id="packages.add"  {{ in_array('packages.add', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="packages.add"> إضافه باقه جديده </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="packages.delete" class="form-check-input" id="packages.delete"  {{ in_array('packages.delete', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="packages.delete"> حذف الباقه </label>
                                                            </div>
                                                            <div class="form-check text-start mb-2">
                                                                <input type="checkbox" name='permissions[]' value="packages.edit" class="form-check-input" id="packages.edit"  {{ in_array('packages.edit', $user_permissions ) ? 'checked' : '' }}  >
                                                                <label class="form-check-label" for="packages.edit"> تعديل بيانات الباقه </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-form-label pt-0"> الصوره الشخصيه الحاليه </label>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card">
                                                <div class="card-img-actions m-1">
                                                    <a href="{{ Storage::url('users/' . $admin->image) }}"
                                                        class="btn btn-outline-white btn-icon rounded-pill"
                                                        data-bs-popup="lightbox" data-gallery="gallery1">
                                                        <img src="{{ Storage::url('users/' . $admin->image) }}" class="avatar"
                                                        width="120" height="120" alt="">
                                                    </a>
                                                </div>
                                            </div>
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
