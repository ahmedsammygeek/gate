<div class="sidebar sidebar-main sidebar-expand-lg align-self-start">
    <div class="sidebar-content">
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto"> لوحه التحكم </h5>
                <div>
                    <button type="button"
                    class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="ph-arrows-left-right"></i>
                </button>
                <button
                type="button"class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                <i class="ph-x"></i>
            </button>
        </div>
    </div>
</div>

@php
$home = $admins = $countries = $transactions = $installments = $purchases =  $universities = $courses = $packages = $categories = $trainers = '';
switch (Request::segment(2)) {
    case 'admins':
    $admins = 'active';
    break;
    case 'countries':
    $countries = 'active';
    break;
    case 'universities':
    $universities = 'active';
    break;
    case 'courses':
    $courses = 'active';
    break;
    case 'categories':
    $categories = 'active';
    break;
    case 'trainers':
    $trainers = 'active';
    break;
    case 'installments':
    $installments = 'active';
    break;
    case 'purchases':
    $purchases = 'active';
    break;
    case 'transactions':
    $transactions = 'active';
    break;
    case 'packages':
    $packages = 'active';
    break;
    default:
    $home = 'active';
    break;
}

@endphp

<div class="sidebar-section">
    <ul class="nav nav-sidebar" data-nav-type="accordion">

        <li class="nav-item-header pt-0">
            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide"> الروابط </div>
            <i class="ph-dots-three sidebar-resize-show"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('board.index') }}" class="nav-link {{ $home }}">
                <i class="ph-house"></i>
                <span>
                    الرئيسيه
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $admins }}">
                <i class="ph-layout"></i>
                <span> المشرفين </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Admins">
                <li class="nav-item"><a href="{{ route('board.admins.index') }}" class="nav-link"> عرض كافه
                المشرفين </a></li>
                <li class="nav-item"><a href="{{ route('board.admins.create') }}" class="nav-link"> إضافه مشرف
                جديد </a></li>
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $countries }}">
                <i class="ph-note-blank"></i>
                <span> الدول </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Countries ">
                <li class="nav-item"><a href="{{ route('board.countries.index') }}" class="nav-link"> عرض كافه
                الدول </a></li>
                <li class="nav-item"><a href="{{ route('board.countries.create') }}" class="nav-link"> إضافه
                دوله جديده </a></li>

            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $categories }}">
                <i class="ph-swatches"></i>
                <span> التصنيفات </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Categories">
                <li class="nav-item"><a href="{{ route('board.categories.index') }}" class="nav-link "> عرض كافه
                التصنيفات </a></li>
                <li class="nav-item"><a href="{{ route('board.categories.create') }}" class="nav-link ">إضافه
                تصنيف جديد</a></li>
            </ul>
        </li>

        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $universities }}">
                <i class="ph-note-blank"></i>
                <span> الجامعات </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Universities">
                <li class="nav-item"><a href="{{ route('board.universities.index') }}" class="nav-link"> عرض
                كافه الجامعات </a></li>
                <li class="nav-item"><a href="{{ route('board.universities.create') }}" class="nav-link">إضافه
                جامعه جديده </a></li>
            </ul>
        </li>

        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $trainers }}">
                <i class="ph-note-blank"></i>
                <span> المدربين </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.trainers.index') }}" class="nav-link"> عرض كافه
                المدربين </a></li>
                <li class="nav-item"><a href="{{ route('board.trainers.create') }}" class="nav-link">إضافه مدرب
                جديد </a></li>
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $courses }}">
                <i class="ph-note-blank"></i>
                <span> الكورسات </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.courses.index') }}" class="nav-link"> عرض كافه
                الكورسات </a></li>
                <li class="nav-item"><a href="{{ route('board.courses.create') }}" class="nav-link">إضافه كورس
                جديد </a></li>
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $packages }}">
                <i class="ph-note-blank"></i>
                <span> الباقات </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.packages.index') }}" class="nav-link"> عرض كافه
                الباقات </a></li>
                <li class="nav-item"><a href="{{ route('board.packages.create') }}" class="nav-link">إضافه باقه
                جديد </a></li>
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $purchases }}">
                <i class="ph-shopping-cart "></i>
                <span> عمليات الشراء </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.purchases.index') }}" class="nav-link"> عرض كافه
                عمليات الشراء </a></li>
                
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $installments }}">
                <i class="ph-currency-circle-dollar "></i>
                <span> الاقساط </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.installments.index') }}" class="nav-link"> عرض كافه
                الاقساط </a></li>
                
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $transactions }}">
                <i class="ph-currency-circle-dollar "></i>
                <span> المعاملات  </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="Trainers">
                <li class="nav-item"><a href="{{ route('board.transactions.index') }}" class="nav-link"> عرض كافه
                المعاملات  </a></li>
                
            </ul>
        </li>

    </ul>
</div>


</div>

</div>
