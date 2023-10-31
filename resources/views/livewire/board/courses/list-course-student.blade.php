<div class="row">

    @for ($i = 0; $i < 15 ; $i++)
    <div class="col-xl-3 col-lg-6 mt-2">
        <div class="card card-body">
            <div class="d-flex">
                <a href="#" class="me-3">
                    <img src="{{ asset('board_assets/images/demo/users/face1.jpg') }}" class="rounded" width="44" height="44" alt="">
                </a>

                <div class="flex-fill">
                    <div class="fw-semibold">اسم الطالب</div>
                    <span class="text-muted"> منذ : 10-08-2023 </span>
                </div>

                <div class="ms-3 align-self-center">
                    <div class="bg-success rounded-circle p-1"></div>
                </div>
            </div>
        </div>
    </div>
    @endfor
    
</div>