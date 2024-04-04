@extends('board.layout.master')

@section('page_title', 'تعديل بيانات التحويل ')

@section('breadcrumbs')
<a href="{{ route('board.trainers_transfers.index') }}" class="breadcrumb-item"> تحويلات المدربين </a>
<span class="breadcrumb-item active"> تعديل بيانات التحويل  </span>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"> تعديل بيانات التحويل  </h5>
            </div>

            <form class="" method="POST" action="{{ route('board.trainers_transfers.update' , $trainers_transfer ) }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('PATCH')
                    @livewire('board.trainer-transfers.edit-trainer-transfer' , ['trainer_transfer' => $trainers_transfer ] )
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href='{{ route('board.trainers_transfers.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                    <button type="submit" class="btn btn-primary ms-3">
                        تعديل <i class="ph-paper-plane-tilt ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

