@extends('board.layout.master')

@section('page_title', 'إضافه تحويل جديد')

@section('breadcrumbs')
<a href="{{ route('board.trainers_transfers.index') }}" class="breadcrumb-item"> تحويلات المدربين </a>
<span class="breadcrumb-item active"> إضافه تحويل جديد </span>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"> إضافه تحويل جديد </h5>
            </div>

            <form class="" method="POST" action="{{ route('board.trainers_transfers.store') }}" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @livewire('board.trainer-transfers.add-new-trainer-transfer')
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href='{{ route('board.trainers_transfers.index') }}' class="btn btn-light" id="reset"> الغاء </a>
                    <button type="submit" class="btn btn-primary ms-3">
                        إضافه <i class="ph-paper-plane-tilt ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

