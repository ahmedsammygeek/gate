<div class="row">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه التقييمات</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل التقييمات">
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
                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($reviews))
                        <tr>
                            <th > الكورس & الدبلوم </th>
                            <th >  الطالب </th>
                            <th >  التقييم </th>
                            <th >  التعليق </th>
                           {{--  <th >  السعر </th>
                            <th> عرض داخل الصفحه الرئيسيه </th>
                            <th> قابل للشراء </th>
                            <th class="text-center" style="width: 20px;">خصائص</th> --}}
                        </tr>
                        @endif
                    </thead>
                    <tbody>

                        @if (count($reviews))
                        @foreach ($reviews as $review)
                        <tr>
                         <td>
                            @if ($review->course_id)
                            <a href="{{ route('board.courses.show' , $review->course_id ) }}"> {{ $review->course?->title }} </a>
                            @endif
                        </td>

                        <td class="text-wrap">
                            <a href="{{ route('board.users.show', $review->user) }}" class="d-block fw-semibold">
                               {{ $review->user?->name }}
                           </a>
                       </td>

                       <td>
                        @switch($review->rate)
                        @case(1)
                        @for ($i = 0; $i < $review->rate ; $i++)
                        <i class='icon-star-full2 text-danger' > </i>
                        @endfor
                        @break
                        @case(2)
                        @for ($i = 0; $i < $review->rate ; $i++)
                        <i class='icon-star-full2 text-warning' > </i>
                        @endfor
                        @break
                        @case(3)
                        @for ($i = 0; $i < $review->rate ; $i++)
                        <i class='icon-star-full2 text-info' > </i>
                        @endfor
                        @break
                        @case(4)
                        @for ($i = 0; $i < $review->rate ; $i++)
                        <i class='icon-star-full2 text-success' > </i>
                        @endfor
                        @break
                        @case(5)
                        @for ($i = 0; $i < $review->rate ; $i++)
                        <i class='icon-star-full2 text-primary' > </i>
                        @endfor
                        @break
                        @endswitch

                    </td>
                    <td> 
                        {{ $review->comment }}
                    </td>



                    <td class="text-center">

                        <a  data-item_id='{{ $review->id }}' class="btn btn-sm btn-primary approve ">
                            <i class="icon-checkmark3  "></i>
                        </a>


                        <a data-item_id='{{ $review->id }}' class="btn btn-danger btn-sm delete_item">
                            <i class="icon-trash  "></i>
                        </a>

                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center text-danger" colspan="8"> لا يوجد تقييمات للموافقه عليها حاليا...  </td>
                </tr>
                @endif



            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-end ">
        {{ $reviews->links() }}
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
         Livewire.on('itemApproved', () => {
            new Noty({
              text: 'تم الموفقه بنجاح ',
              type: 'info'
          }).show();
        })


        

        $(document).on('click', 'a.approve', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            swalInit.fire({
                title: 'تاكيد الموافقه',
                text: "هل انت متاكد من رغبتك فى الموافقه  ؟",
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
                    Livewire.emit('approveItem' , item_id );
                }
            });

        });

        $(document).on('click', 'a.delete_item', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            swalInit.fire({
                title: 'تاكيد الحذف',
                text: "هل انت متاكد من رغبتك فى تفعيل التقييم ؟ ",
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
