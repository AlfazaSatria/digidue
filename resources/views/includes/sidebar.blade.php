<div class="main-sidebar">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="{{ route('home') }}"> </a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">Dashboard</li>
			<li class="">
				<a class="nav-link" href="{{ route('home') }}">
					<i class="fas fa-home"></i><span>Home</span>
				</a>
			</li>


			@if (in_array(auth()->user()->role_id, ['1','2']))
			<li class="">
				<a href="#" class="nav-link has-dropdown">
					<i class="fas fa-book"></i><span>Jadwal</span>
				</a>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show') }}">
							<i class="fas fa-calendar"></i><span>Jadwal</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.revision') }}">
							<i class="fas fa-calendar"></i><span>Pengajuan Jadwal</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROB') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROB</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROM') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROM</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROH') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROH</span>
						</a>
					</li>
				</ul>
			</li>
			@elseif(auth()->user()->role_id == 3)
			<li class="">
				<a href="#" class="nav-link has-dropdown">
					<i class="fas fa-book"></i><span>Jadwal</span>
				</a>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ultg') }}">
							<i class="fas fa-calendar"></i><span>Jadwal</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROB.ultg') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROB</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROM.ultg') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROM</span>
						</a>
					</li>
				</ul>
				<ul class="dropdown-menu">
					<li class="">
						<a class="nav-link" href="{{ route('schedule.show.ROH.ultg') }}">
							<i class="fas fa-calendar"></i><span>Jadwal ROH</span>
						</a>
					</li>
				</ul>
			</li>
			@else
			<h1>Empty</h1>
			@endif
		</ul>

	</aside>
</div>

