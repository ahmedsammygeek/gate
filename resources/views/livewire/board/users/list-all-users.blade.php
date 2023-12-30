<div class="row">
    @if ($rows_count)
            <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه المستخدمين</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل المستخدمين">
                        <div class="form-control-feedback-icon">
                            <i class="ph-magnifying-glass"></i>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 mb-3 mb-sm-0">
                        <select wire:model='rows' class="form-select">
                            <option value="30">30 صف للعرض</option>
                            <option value="60">60 صف للعرض </option>
                            <option value="90">90 صف للعرض </option>
                            <option value="120">120 صف للعرض </option>
                            <option value="150">150 صف للعرض </option>
                        </select>
                    </div>
                </div>
                <div class="d-sm-flex align-items-sm-start mt-2">

                    <div class="dropdown ms-md-3  mb-sm-0">
                        <select wire:model='university_id' class="form-select">
                            <option value=""> جميع الجامعات </option>
                            @foreach ($universities as $university)
                            <option value="{{ $university->id }}"> {{ $university->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdown ms-md-3  mb-sm-0">
                        <select wire:model='user_type' class="form-select">
                            <option value="all"> جميع الطلاب </option>
                            <option value="active"> النشطين </option>
                            <option value="inactive"> غير النشطين </option>

                        </select>
                    </div>
                    <div class="dropdown ms-md-3  mb-sm-0">
                        <select wire:model='study_type' class="form-select">
                            <option value="all"> جميع انواع الدرسه </option>
                            <option value="1"> تخصصى </option>
                            <option value="2"> تحضيرى </option>
                        </select>
                    </div>

                    <div class="dropdown ms-md-3  mb-sm-0">
                        <select wire:model='course_id' class="form-select">
                            <option value=""> جميع مشتركى الدورات </option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}"> {{ $course->title }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown ms-md-3  mb-sm-0">
                        <select wire:model='is_paid' class="form-select">
                            <option value="all"> جميع عمليات الشراء </option>
                            <option value="0"> عمليات لم يتم دفعها بعد  </option>
                            <option value="1"> عمليات تمت الدفع بشكل جزءى </option>
                            <option value="2"> عمليات تم تسديدها بالكامل </option>
                        </select>
                    </div>


                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-reset"></i>
                            </span>
                            إعادة ضبط الفلتر
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='excelSheet' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-file-excel "></i>
                            </span>
                            Excel
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > اسم المستخدم </th>
                            <th>البريد الكاترونى </th>
                            <th>رقم الواتس</th>
                            <th>الجامعه</th>
                            <th>نوع الدراسه</th>
                            <th> التفاعل </th>
                            <th>السماح بدخول النظام</th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('board.users.show' , $user ) }}" class="d-block fw-semibold">{{ $user->name }}</a>
                                <span class="fs-sm text-muted">{{ $user->created_at->toFormattedDateString() }}</span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->university?->title }}</td>
                            <td>
                                @switch($user->study_type )
                                @case(1)
                                <span class="badge bg-primary"> تخصصى </span>
                                @break
                                @case(2)
                                <span class="badge bg-info"> تحضيرى </span>
                                @break
                                @endswitch
                            </td>

                            <td>
                                @if ($user->courses->count())
                                <span class="badge bg-primary"> مشترك </span>
                                @else
                                <span class="badge bg-warning"> غير مشترك </span>
                                @endif
                            </td>


                            <td>
                                @switch($user->is_banned )
                                @case(0)
                                <span class="badge bg-success"> نعم </span>
                                @break
                                @case(1)
                                <span class="badge bg-danger"> لا</span>
                                @break
                                @endswitch
                            </td>


                            <td class="text-center">
                                @can('users.show')
                                <a  href="{{ route('board.users.show'  , $user ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan
                                @can('users.delete')
                                <a data-item_id='{{ $user->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @else
     <div class="col-lg-12">
    <br>
    <br>
    <div class="alert alert-warning alert-dismissible fade show">
        <span class="fw-semibold"> لا يوجد مستخدمين للعرض  حاليا </span> 
    </div>
</div>
    @endif
</div>

@section('scripts')

<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>
    $(function() {

        Noty.overrideDefaults({
            theme: 'limitless',
            layout: 'topLeft',
            type: 'alert',
            timeout: 2500
        });

        const swalInit = swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light',
                denyButton: 'btn btn-light',
                input: 'form-control'
            }
        });

        Livewire.on('itemDeleted', () => {
            new Noty({
              text: 'تم الحذف بنجاح',
              type: 'info'
          }).show();
        })



        $(document).on('click', 'a.delete_item', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            swalInit.fire({
                title: 'تاكيد الحذف',
                text: "هل انت متاكد من رغبتك فى حذف العنصر ؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم',
                cancelButtonText: 'تراجع',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-success'
                }
            }).then(function(result) {
                if(result.value) {
                    Livewire.emit('deleteItem' , item_id );
                }
            });

        });

    });
</script>
@endsection
