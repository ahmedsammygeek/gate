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
$home = $admins = $countries = $transactions = $users = $installments = $purchases =  $universities = $courses = $packages = $categories = $trainers = '';
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
    case 'users':
    $users = 'active';
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

        @if(auth()->user()->hasAnyPermission(['admins.list' , 'admins.show' , 'admins.delete' , 'admins.edit' , 'admins.add' ]) )
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $admins }}">
                <i class="icon-user "></i>
                <span> المشرفين </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="المشرفين">
             @if (auth()->user()->hasAnyPermission(['admins.list' , 'admins.show' , 'admins.delete' , 'admins.edit' ]) )
             <li class="nav-item"><a href="{{ route('board.admins.index') }}" class="nav-link"> عرض كافه
             المشرفين </a></li>          
             @endif  
             @can('admins.add')
             <li class="nav-item"><a href="{{ route('board.admins.create') }}" class="nav-link"> إضافه مشرف
             جديد </a></li>
             @endcan

         </ul>
     </li>
     @endif


     @if (auth()->user()->hasAnyPermission(['countries.list' , 'countries.show' , 'countries.delete' , 'countries.edit' , 'countries.add' ]) )
     <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $countries }}">
            <i class="icon-location3 "></i>
            <span> الدول </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="الدول ">
            @if (auth()->user()->hasAnyPermission(['countries.list' , 'countries.show' , 'countries.delete' , 'countries.edit']) )
            <li class="nav-item">
                <a href="{{ route('board.countries.index') }}" class="nav-link"> 
                    عرض كافه الدول 
                </a>
            </li>
            @endif

            @can('countries.add')
            <li class="nav-item"><a href="{{ route('board.countries.create') }}" class="nav-link"> إضافه
            دوله جديده </a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if (auth()->user()->hasAnyPermission(['categories.list' , 'categories.show' , 'categories.delete' , 'categories.edit' , 'categories.add' ]) )
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $categories }}">
            <i class="ph-swatches"></i>
            <span> التصنيفات </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="التصنيفات">
            @if (auth()->user()->hasAnyPermission(['categories.list' , 'categories.show' , 'categories.delete' , 'categories.edit' ]) )
            <li class="nav-item"><a href="{{ route('board.categories.index') }}" class="nav-link "> عرض كافه
            التصنيفات </a></li>
            @endif


            @can('categories.add')
            <li class="nav-item"><a href="{{ route('board.categories.create') }}" class="nav-link ">إضافه
            تصنيف جديد</a></li>
            @endcan
        </ul>
    </li>
    @endif


    @if (auth()->user()->hasAnyPermission(['universities.list' , 'universities.show' , 'universities.delete' , 'universities.edit' , 'universities.add' ]) )
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $universities }}">
            <i class="icon-office "></i>
            <span> الجامعات </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="الجمعات">
            @if (auth()->user()->hasAnyPermission(['universities.list' , 'universities.show' , 'universities.delete' , 'universities.edit' ]) )
            <li class="nav-item"><a href="{{ route('board.universities.index') }}" class="nav-link"> عرض
            كافه الجامعات </a></li>
            @endif
            @can('universities.add')
            <li class="nav-item"><a href="{{ route('board.universities.create') }}" class="nav-link">إضافه
            جامعه جديده </a></li>
            @endcan
        </ul>
    </li>
    @endif


    @if (auth()->user()->hasAnyPermission(['trainers.list' , 'trainers.show' , 'trainers.delete' , 'trainers.edit' , 'trainers.add' ]) )
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $trainers }}">
            <i class="icon-users "></i>
            <span> المدربين </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="المدربين">
            @if (auth()->user()->hasAnyPermission(['trainers.list' , 'trainers.show' , 'trainers.delete' , 'trainers.edit']) )
            <li class="nav-item"><a href="{{ route('board.trainers.index') }}" class="nav-link"> عرض كافه
            المدربين </a></li>               
            @endif
            @can('trainers.add')
            <li class="nav-item"><a href="{{ route('board.trainers.create') }}" class="nav-link">إضافه مدرب
            جديد </a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if (auth()->user()->hasAnyPermission(['users.list' , 'users.show' , 'users.delete' , 'users.edit' ]))
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $users }}">
            <i class="icon-users4 "></i>
            <span> المستخدمين </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="المستخدمين">
            <li class="nav-item"><a href="{{ route('board.users.index') }}" class="nav-link"> عرض كافه
            المستخدمين </a></li>
        </ul>
    </li>
    @endif

    @if (auth()->user()->hasAnyPermission(['courses.list' , 'courses.show' , 'courses.delete' , 'courses.edit' , 'courses.add' ]))
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link {{ $courses }}">
            <i class="icon-typewriter "></i>
            <span> الكورسات </span>
        </a>
        <ul class="nav-group-sub collapse" data-submenu-title="الكورسات">
            @if (auth()->user()->hasAnyPermission(['courses.list' , 'courses.show' , 'courses.delete' , 'courses.edit' ]))
            <li class="nav-item"><a href="{{ route('board.courses.index') }}" class="nav-link"> عرض كافه
            الكورسات </a></li>
            @endif
            @can('courses.add')
            <li class="nav-item"><a href="{{ route('board.courses.create') }}" class="nav-link">إضافه كورس
            جديد </a></li>
            @endcan
        </ul>
    </li>
    @endif

{{-- 
        
       

       
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $packages }}">
                <i class="icon-package "></i>
                <span> الباقات </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="الباقات">
                <li class="nav-item"><a href="{{ route('board.packages.index') }}" class="nav-link"> عرض كافه
                الباقات </a></li>
                <li class="nav-item"><a href="{{ route('board.packages.create') }}" class="nav-link">إضافه باقه
                جديد </a></li>
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $purchases }}">
                <i class="icon-cart "></i>
                <span> عمليات الشراء </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="عمليات الشراء">
                <li class="nav-item"><a href="{{ route('board.purchases.index') }}" class="nav-link"> عرض كافه
                عمليات الشراء </a></li>
                
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $installments }}">
                <i class="ph-currency-circle-dollar "></i>
                <span> الاقساط </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="الاقساط">
                <li class="nav-item"><a href="{{ route('board.installments.index') }}" class="nav-link"> عرض كافه
                الاقساط </a></li>
                
            </ul>
        </li>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link {{ $transactions }}">
                <i class="icon-coin-dollar "></i>
                <span> المعاملات  </span>
            </a>
            <ul class="nav-group-sub collapse" data-submenu-title="المعاملات">
                <li class="nav-item"><a href="{{ route('board.transactions.index') }}" class="nav-link"> عرض كافه
                المعاملات  </a></li>
                
            </ul>
        </li> --}}

    </ul>
</div>


</div>

</div>
