<div class="sidebar sidebar-main sidebar-expand-lg align-self-start">
	<div class="sidebar-content">
		<div class="sidebar-section">
			<div class="sidebar-section-body d-flex justify-content-center">
				<h5 class="sidebar-resize-hide flex-grow-1 my-auto"> لوحه التحكم </h5>
				<div>
					<button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
						<i class="ph-arrows-left-right"></i>
					</button>
					<button type="button"class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
						<i class="ph-x"></i>
					</button>
				</div>
			</div>
		</div>

		<div class="sidebar-section">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<li class="nav-item-header pt-0">
					<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide"> الروابط </div>
					<i class="ph-dots-three sidebar-resize-show"></i>
				</li>
				<li class="nav-item">
					<a href="{{ route('board.index') }}" class="nav-link active">
						<i class="ph-house"></i>
						<span>
							الرئيسيه
						</span>
					</a>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-layout"></i>
						<span> المشرفين </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Admins">
						<li class="nav-item"><a href="{{ route('board.admins.index') }}" class="nav-link"> عرض كافه المشرفين </a></li>
						<li class="nav-item"><a href="{{ route('board.admins.create') }}" class="nav-link"> إضافه مشرف جديد </a></li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-note-blank"></i>
						<span> الدول </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Countries ">
						<li class="nav-item"><a href="{{ route('board.countries.index') }}" class="nav-link"> عرض كافه الدول </a></li>
						<li class="nav-item"><a href="{{ route('board.countries.create') }}" class="nav-link"> إضافه دوله جديده </a></li>

					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-swatches"></i>
						<span> التصنيفات </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Categories">
						<li class="nav-item"><a href="{{ route('board.categories.index') }}" class="nav-link "> عرض كافه التصنيفات </a></li>
						<li class="nav-item"><a href="{{ route('board.categories.create') }}" class="nav-link ">إضافه تصنيف جديد</a></li>
					</ul>
				</li>

				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-note-blank"></i>
						<span> الجامعات </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Universities">
						<li class="nav-item"><a href="{{ route('board.universities.index') }}" class="nav-link"> عرض كافه الجامعات </a></li>
						<li class="nav-item"><a href="{{ route('board.universities.create') }}" class="nav-link">إضافه جامعه جديده </a></li>
					</ul>
				</li>

				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-note-blank"></i>
						<span> المدربين </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Trainers">
						<li class="nav-item"><a href="{{ route('board.trainers.index') }}" class="nav-link"> عرض كافه المدربين </a></li>
						<li class="nav-item"><a href="{{ route('board.trainers.create') }}" class="nav-link">إضافه مدرب جديد </a></li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link">
						<i class="ph-note-blank"></i>
						<span> الكورسات </span>
					</a>
					<ul class="nav-group-sub collapse" data-submenu-title="Trainers">
						<li class="nav-item"><a href="{{ route('board.courses.index') }}" class="nav-link"> عرض كافه الكورسات </a></li>
						<li class="nav-item"><a href="{{ route('board.courses.create') }}" class="nav-link">إضافه كورس جديد </a></li>
					</ul>
				</li>

			</ul>
		</div>


	</div>

</div>
