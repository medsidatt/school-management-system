<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('students') }}">
                <i class="bi bi-mortarboard-fill"></i> <span>Eleves</span>
            </a>
        </li><!-- End Students Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('parents') }}">
                <i class="bi bi-person-fill"></i> <span>Parents</span>
            </a>
        </li><!-- End Parents Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('teachers') }}">
                <i class="bi bi-people-fill"></i>
                <span>Professeur</span>
            </a>
        </li><!-- End Profs Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('classes') }}">
                <i class="bi bi-grid-3x3"></i>
                <span>Classes</span>
            </a>
        </li><!-- End Classes Nav -->

        <li class="nav-item">
            <a class="nav-link " href="{{ route('subjects') }}">
                <i class="bi bi-subtract"></i>
                <span>Matiers</span>
            </a>
        </li><!-- End Subjects Nav -->

    </ul>

</aside>
