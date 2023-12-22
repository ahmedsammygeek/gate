<div class="row">
    <div class="col-md-12">
      @can('categories.add')
           <a href="{{ route('board.categories.create') }}" class="btn btn-primary mb-2" style="float: left;">  <i class="icon-plus3  me-2"></i>  إضافه تصنيف جديد </a>
      @endcan
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه التصنيفات</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل التصنيفات">
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
                        <tr>
                            <th > اسم التصنيف بالعربيه </th>
                            <th > اسم التصنيف بالانجليزيه </th>
                            <th>حاله التصنيف</th>
                            <th>اضيف بواسطه</th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                        <tr>

                            <td>
                                <a href="{{ route('board.categories.show' , $category ) }}" class="d-block fw-semibold">{{ $category->getTranslation('name' , 'ar') }}</a>
                            </td>
                            <td>
                                <a href="{{ route('board.categories.show' , $category ) }}" class="d-block fw-semibold">{{ $category->getTranslation('name' , 'en') }}</a>
                            </td>

                            <td>
                                @switch($category->is_active)
                                @case(1)
                                <span class="badge bg-primary"> فعال </span>
                                @break
                                @case(0)
                                <span class="badge bg-danger"> غير فعال </span>
                                @break
                                @endswitch
                            </td>

                            <td> <a href="{{ route('board.admins.show' , $category->user_id ) }}"> {{ $category->user?->name }} </a> </td>


                            <td class="text-center">
                                @can('categories.show')
                                    <a  href="{{ route('board.categories.show'  , $category ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan
                                @can('categories.edit')
                                    <a href="{{ route('board.categories.edit'  , $category ) }}"  class="btn btn-sm btn-warning ">
                                    <i class="icon-database-edit2  "></i>
                                </a>
                                @endcan
                                @can('categories.delete')
                                   <a data-item_id='{{ $category->id }}' class="btn btn-danger btn-sm delete_item">
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
                {{ $categories->links() }}
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