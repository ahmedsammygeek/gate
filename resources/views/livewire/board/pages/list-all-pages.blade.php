<div class="row">
    <div class="col-md-12">
        @can('pages.add')
        <a href="{{ route('board.pages.create') }}" class="btn btn-primary mb-2" style="float: left;">  <i class="icon-plus3  me-2"></i>  إضافه صفحه جديده </a>
        @endcan
    </div>



    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه صفحات الموقع</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل صفحات الموقع">
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
                        @if (count($pages))
                        <tr>
                            <th > عنوان الصفحه بالعربيه </th>
                            <th > عنوان الصفحه بالانجليزيه </th>
                            <th>حاله الصفحه</th>
                            <th>اضيف بواسطه</th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>

                        @if (count($pages))
                        @foreach ($pages as $page)
                        <tr>

                            <td>
                                <a href="{{ route('board.pages.show' , $page ) }}" class="d-block fw-semibold">{{ $page->getTranslation('title' , 'ar') }}</a>
                            </td>
                            <td>
                                <a href="{{ route('board.pages.show' , $page ) }}" class="d-block fw-semibold">{{ $page->getTranslation('title' , 'en') }}</a>
                            </td>

                            <td>
                                @switch($page->is_active)
                                @case(1)
                                <span class="badge bg-primary"> فعال </span>
                                @break
                                @case(0)
                                <span class="badge bg-danger"> غير فعال </span>
                                @break
                                @endswitch
                            </td>

                            <td> <a href="{{ route('board.admins.show' , $page->user_id ) }}"> {{ $page->user?->name }} </a> </td>


                            <td class="text-center">
                                @can('pages.show')
                                <a  href="{{ route('board.pages.show'  , $page ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan
                                @can('pages.edit')
                                <a href="{{ route('board.pages.edit'  , $page ) }}"  class="btn btn-sm btn-warning ">
                                    <i class="icon-database-edit2  "></i>
                                </a>
                                @endcan
                                @can('pages.delete')
                                <a data-item_id='{{ $page->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center text-danger" colspan="5"> لا يوجد بيانات  </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $pages->links() }}
            </div>
        </div>
    </div>

</div>

@section('scripts')
<script src="{{ Storage::url('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
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