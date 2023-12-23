<div class="row">

   @foreach ($course_users as $course_user)
        <div class="col-xl-3 col-lg-6 mt-2">
        <div class="card card-body">
            <div class="d-flex">
                <a href="{{ route('board.users.show' , $course_user->user_id ) }}" class="me-3">
                    <img src="{{ Storage::url('users/'.$course_user->user?->image) }}" class="rounded" width="44" height="44" alt="">
                </a>

                <div class="flex-fill">
                    <div class="fw-semibold"> {{ $course_user->user?->name }} </div>
                    <span class="text-muted"> تم البدءى فى  : {{ $course_user->created_at->toFormattedDateString() }} </span> <br>
                    <span class="text-muted"> ينتهى فى  : {{ $course_user->expires_at->toFormattedDateString() }} </span>
                </div>

                <div class="ms-3 align-self-center">
                    <div class="bg-success rounded-circle p-1"></div>
                </div>
            </div>
        </div>
    </div>
   @endforeach
    
</div>