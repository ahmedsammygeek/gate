<div class="row">
    <div class="col-md-12">
        @can('admins.add')
        <a href="{{ route('board.admins.create') }}" class="btn btn-primary mb-2" style="float: left;">  <i class="icon-plus3  me-2"></i>  إضافه مشرف جديد </a>
        @endcan
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه المشرفين</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل المشرفين">
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
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($admins))
                        <tr>
                            <th > صوره المشرف </th>
                            <th > اسم المشرف </th>
                            <th>البريد الكاترونى </th>
                            <th>رقم الجوال</th>
                            <th>السماح بدخول النظام</th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>

                        @if (count($admins))
                        @foreach ($admins as $admin)
                        <tr>
                            <td class="pe-0">
                                <div class="col-sm-6 col-lg-5">
                                    <div class="card">
                                        <div class="card-img-actions m-1">
                                            <a href="{{ Storage::url('users/'.$admin->image) }}" class="btn btn-outline-white btn-icon rounded-pill" 
                                                data-bs-popup="lightbox" data-gallery="gallery1">
                                                <img src="{{ Storage::url('users/'.$admin->image) }}" class="card-img " width="60" height="60" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('board.admins.show' , $admin ) }}" class="d-block fw-semibold">{{ $admin->name }}</a>
                                <span class="fs-sm text-muted">{{ $admin->created_at->toFormattedDateString() }}</span>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>
                                @switch($admin->is_banned )
                                @case(0)
                                <span class="badge bg-primary"> نعم </span>
                                @break
                                @case(1)
                                <span class="badge bg-danger"> لا</span>
                                @break
                                @endswitch
                            </td>


                            <td class="text-center">
                                @can('admins.show')
                                <a  href="{{ route('board.admins.show'  , $admin ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan
                                @can('admins.edit')
                                <a href="{{ route('board.admins.edit'  , $admin ) }}"  class="btn btn-sm btn-warning ">
                                    <i class="icon-database-edit2  "></i>
                                </a>                           
                                @endcan
                                @can('admins.delete')
                                <a data-item_id='{{ $admin->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
                                @endcan

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center text-danger" colspan="6"> لا يوجد بيانات  </td>
                        </tr>
                        @endif



                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $admins->links() }}
            </div>
        </div>
    </div>

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
