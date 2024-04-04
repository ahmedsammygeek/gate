	<div class="navbar navbar-dark navbar-expand-lg navbar-static">
		<div class="container-fluid">
			<div class="d-flex d-lg-none me-2">
				<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
					<i class="ph-list"></i>
				</button>
			</div>

			<div class="navbar-brand flex-1 flex-lg-0">
				<a href="{{ route('board.index') }}" class="d-inline-flex align-items-center">
					<img src="{{ asset('board_assets/images/logo.png') }}" alt="">
				</a>
			</div>



			<ul class="nav flex-row justify-content-end order-1 order-lg-2">
				<li class="nav-item ms-lg-2">
					<a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#notifications">
						<i class="ph-bell"></i>
						<span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">{{ Auth::user()->unreadNotifications()->count() }}</span>
					</a>
				</li>

				<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
					<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
						<div class="status-indicator-container">
							<img src="{{ Storage::url('users/'.Auth::user()->image) }}" class="w-32px h-32px rounded-pill" alt="">
							<span class="status-indicator bg-success"></span>
						</div>
						<span class="d-none d-lg-inline-block mx-lg-2"> {{ Auth::user()->name }} </span>
					</a>

					<div class="dropdown-menu dropdown-menu-end">
						<a href="{{ route('board.profile') }}" class="dropdown-item">
							<i class="ph-user-circle me-2"></i>
							الملف الشخصى
						</a>
						
						<div class="dropdown-divider"></div>
						<a href="{{ route('board.profile.logout') }}" class="dropdown-item">
							<i class="ph-sign-out me-2"></i>
							تسجيل الخروج
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>