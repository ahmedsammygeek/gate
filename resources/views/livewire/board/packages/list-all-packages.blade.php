<div class="row">
    <div class="col-md-12">
        @can('packages.add')
        <a href="{{ route('board.packages.create') }}" class="btn btn-primary mb-2" style="float: left;"> <i
            class="icon-plus3  me-2"></i> إضافه باقه جديده </a>
            @endcan
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">عرض كافه الباقات</h5>
                </div>

                <div class="card-body">
                    <div class="d-sm-flex align-items-sm-start">
                        <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                            <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل الباقات">
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


                        <div class="dropdown ms-sm-3  mb-sm-0">
                            <select wire:model='category_id' class="form-select">
                                <option value=""> جميع التصنيفات </option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dropdown ms-sm-3  mb-sm-0">
                            <select wire:model='university_id' class="form-select">
                                <option value=""> جميع الجامعات </option>
                                @foreach ($universities as $university)
                                <option value="{{ $university->id }}"> {{ $university->title }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dropdown ms-sm-3  mb-sm-0">
                            <select wire:model='trainer_id' class="form-select">
                                <option value=""> جميع المدربين </option>
                                @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id }}"> {{ $trainer->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dropdown ms-sm-3  mb-sm-0">
                            <select wire:model='is_active' class="form-select">
                                <option value=""> جميع حالات شراء الباقات </option>
                                <option value="1"> قابل للشراء </option>
                                <option value="0"> غير قابل للشراء </option>

                            </select>
                        </div>
                        <div class="dropdown ms-sm-3  mb-sm-0">
                            <select wire:model='show_in_home' class="form-select">
                                <option value=""> جميع الباقات داخل الصفحه الرئيسيه </option>
                                <option value="1"> المعروض </option>
                                <option value="0"> غير المعروض </option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            @if (count($packages))
                            <tr>
                                <th> صوره الباقه </th>
                                <th> اسم الباقه </th>
                                <th> التصنيف </th>
                                <th> الجامعه </th>
                                <th> السعر </th>
                                <th> عرض داخل الصفحه الرئيسيه </th>
                                <th> قابل للشراء </th>
                                <th class="text-center" style="width: 20px;">خصائص</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>

                         @if (count($packages))
                         @foreach ($packages as $package)
                         <tr>
                            <td class="pe-0">
                                <div class="col-sm-6 col-lg-9">
                                    <div class="card">
                                        <div class="card-img-actions m-1">
                                            <a href="{{ Storage::url('courses/' . $package->image) }}"
                                                class="btn btn-outline-white btn-icon rounded-pill"
                                                data-bs-popup="lightbox" data-gallery="gallery1">
                                                <img src="{{ Storage::url('courses/' . $package->image) }}"
                                                class="card-img " width="60" height="60" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-wrap">
                                <a href="{{ route('board.packages.show', $package->id) }}"
                                    class="d-block fw-semibold">
                                    {{ Str::limit($package->title, 30, '.....') }}</a>
                                    <span
                                    class="fs-sm text-muted">{{ $package->created_at->toFormattedDateString() }}</span>
                                </td>
                                <td>
                                    @if ($package->category_id)
                                    <a href="{{ route('board.categories.show', $package->category_id) }}">
                                        {{ $package->category?->name }} </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($package->university_id)
                                        <a href="{{ route('board.universities.show', $package->university_id) }}">
                                            {{ $package->university?->title }} </a>
                                            @endif
                                        </td>

                                        <td>
                                            <span style="text-decoration: line-through; color: #999; margin-top: 5px;">{{ $package->price_later }}</span>
                                            <span style="font-weight: bold; margin-right: 5px;">{{ $package->getPrice() }}</span>
                                            <span style="color: #999">ر.س</span>

                                            <td>
                                                @switch($package->show_in_home)
                                                @case(1)
                                                <span class="badge bg-primary"> نعم </span>
                                                @break

                                                @case(0)
                                                <span class="badge bg-danger"> لا</span>
                                                @break
                                                @endswitch
                                            </td>

                                            <td>
                                                @switch($package->is_active)
                                                @case(1)
                                                <span class="badge bg-primary"> نعم </span>
                                                @break

                                                @case(0)
                                                <span class="badge bg-danger"> لا</span>
                                                @break
                                                @endswitch
                                            </td>


                                            <td class="text-center">
                                                @can('packages.add')
                                                <a href="{{ route('board.packages.show', $package) }}"
                                                class="btn btn-sm btn-primary  ">
                                                <i class="icon-eye  "></i>
                                            </a>
                                            @endcan
                                            @can('packages.edit')
                                            <a href="{{ route('board.packages.edit', $package) }}"
                                            class="btn btn-sm btn-warning ">
                                            <i class="icon-database-edit2  "></i>
                                        </a>
                                        @endcan
                                        @can('packages.delete')
                                        <a data-item_id='{{ $package->id }}' class="btn btn-danger btn-sm delete_item">
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
                        {{ $packages->links() }}
                    </div>
                </div>
            </div>
        </div>


        @section('scripts')
        <script src="{{ Storage::url('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
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
                        if (result.value) {
                            Livewire.emit('deleteItem', item_id);
                        }
                    });

                });

            });
        </script>
        @endsection
