<div>
    @if (count($course_reviews))
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"> جميع التقييمات </h5>
        </div>

        <div class="list-group list-group-flush">

            @foreach ($course_reviews as $course_review)
            <div class="list-group-item d-flex flex-column flex-sm-row align-items-start py-3">
                <a href="#" class="d-block me-sm-3 mb-3 mb-sm-0">
                    <img src="{{ Storage::url('users/'.$course_review->user?->image) }}" class="rounded" width="44" height="44" alt="">
                </a>

                <div class="flex-fill">
                    <h6 class="mb-0">
                        <a href="{{ route('board.users.show' , $course_review->user_id ) }}">{{ $course_review->user?->name }}</a>
                    </h6>

                    <ul class="list-inline list-inline-bullet text-muted mb-2">
                        <li class="list-inline-item"><a href="#" class="text-body"> {{ $course_review->created_at }} </a></li>
                        <li class="list-inline-item">
                            @for ($i = 0; $i < $course_review->rate ; $i++)
                            <i class="ph-star fs-base text-warning"></i>
                            @endfor
                        </li>
                    </ul>

                    {{ $course_review->comment }}
                </div>

                <div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
                    <div class="form-check form-check-inline form-switch">
                        <input type="checkbox" wire:click='changeReviewStatus({{ $course_review->id }})' class="form-check-input" id="sc_li_c" {{ $course_review->is_active == 1 ? 'checked' : '' }} >
                    </div>

                </div>
                <div class="flex-shrink-0 ms-sm-3 mt-2 mt-sm-0">
                    <button class='btn btn-danger btn-sm delete_item' data-item_id="{{ $course_review->id }}" > <i class='icon-trash '>  </i>  </button>                    
                </div>
            </div>
            @endforeach

        </div>
    </div>
    @else
    <div class="col-lg-12">
        <br>
        <br>
        <div class="alert alert-warning alert-dismissible fade show">
            <span class="fw-semibold"> لا يوجد تقييمات للعرض  </span> 

        </div>
    </div>
    @endif
</div>

@section('scripts')
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
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



     $(document).on('click', 'button.delete_item', function(event) {
        event.preventDefault();
        var item_id = $(this).attr('data-item_id');
        swalInit.fire({
            title: 'تاكيد الحذف',
            text: "هل انت متاكد من رغبتك فى حذف التقييم ؟",
            icon: 'danger',
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