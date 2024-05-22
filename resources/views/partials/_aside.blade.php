<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ (!request()->is('/')) ? 'collapsed' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ (!request()->is('students')) ? 'collapsed' : '' }}" href="{{ route('students') }}">
                <i class="bi bi-mortarboard-fill"></i> <span>Eleves</span>
            </a>
        </li><!-- End Students Nav -->


        <li class="nav-item">
            <a class="nav-link
            {{ !(str_contains(request()->url(), 'exams/quarters')
                                                   || str_contains(request()->url(), 'tests/quarters')
                                                   || str_contains(request()->url(), 'compositions/quarters')) ? 'collapsed' : ''}}"
               data-bs-target="#result-nav" data-bs-toggle="collapse" href="#"
               aria-expanded="{{ str_contains(request()->url(), 'exams/quarters')
                                                   || str_contains(request()->url(), 'tests/quarters')
                                                   || str_contains(request()->url(), 'compositions/quarters') ? 'true' : 'false'}}">
                <i class="bi bi-menu-button-wide"></i><span>Resultats</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="result-nav" class="nav-content collapse
            {{ str_contains(request()->url(), 'exams/quarters')
                                                   || str_contains(request()->url(), 'tests/quarters')
                                                   || str_contains(request()->url(), 'compositions/quarters') ? 'show active' : ''}}
            " data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link{{ !str_contains(request()->url(), 'tests/quarters') ? 'collapsed' : '' }}
                    " data-bs-target="#tests-nav" data-bs-toggle="collapse" href="#"
                       aria-expanded="{{ str_contains(request()->url(), 'tests/quarters') ? 'true' : 'false' }}">
                        <i class="bi bi-square-fill"></i><span>Devoires</span><i
                                class="bi bi-chevron-down ms-auto me-3"></i>
                    </a>
                    <ul id="tests-nav" class="nav-content collapse
                        {{ str_contains(request()->url(), 'tests/quarters') ? 'show active' : ''}}
                    ms-lg-3"
                        data-bs-parent="#result-nav">
                        <li>
                            <a href="{{ route('tests.quarters.first') }}"
                               class="{{ str_contains(request()->url(), 'tests/quarters/first-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.quarters.second') }}"
                               class="{{ str_contains(request()->url(), 'tests/quarters/second-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.quarters.third') }}"
                               class="{{ str_contains(request()->url(), 'tests/quarters/third-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 3</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Tests Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ !str_contains(request()->url(), 'exams/quarters') ? 'collapsed' : '' }}
                    " data-bs-target="#exams-nav" data-bs-toggle="collapse" href="#"
                       aria-expanded="{{ str_contains(request()->url(), 'exams/quarters') ? 'true' : 'false' }}">
                        <i class="bi bi-square-fill"></i><span>Exements</span><i
                                class="bi bi-chevron-down ms-auto me-3"></i>
                    </a>
                    <ul id="exams-nav" class="nav-content collapse
                        {{ str_contains(request()->url(), 'exams/quarters') ? 'show active' : ''}}
                    ms-lg-3"
                        data-bs-parent="#result-nav">
                        <li>
                            <a href="{{ route('exams.quarters.first') }}"
                               class="{{ str_contains(request()->url(), 'exams/quarters/first-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('exams.quarters.second') }}"
                               class="{{ str_contains(request()->url(), 'exams/quarters/second-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('exams.quarters.third') }}"
                               class="{{ str_contains(request()->url(), 'exams/quarters/third-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 3</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Exams Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ !str_contains(request()->url(), 'compositions/quarters') ? 'collapsed' : '' }}
                    " data-bs-target="#compositions-nav" data-bs-toggle="collapse" href="#"
                       aria-expanded="{{ str_contains(request()->url(), 'compositions/quarters') ? 'true' : 'false' }}">
                        <i class="bi bi-square-fill"></i><span>Compositions</span><i
                                class="bi bi-chevron-down ms-auto me-3"></i>
                    </a>
                    <ul id="compositions-nav" class="nav-content collapse
                        {{ str_contains(request()->url(), 'compositions/quarters') ? 'show active' : ''}}
                    ms-lg-3"
                        data-bs-parent="#result-nav">
                        <li>
                            <a href="{{ route('compositions.quarters.first') }}"
                               class="{{ str_contains(request()->url(), 'compositions/quarters/first-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('compositions.quarters.second') }}"
                               class="{{ str_contains(request()->url(), 'compositions/quarters/second-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('compositions.quarters.third') }}"
                               class="{{ str_contains(request()->url(), 'compositions/quarters/third-quarter') ? 'active' : ''}}">
                                <i class="bi bi-circle"></i><span>Trimestre 3</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Compositions Nav -->
            </ul>

        </li><!-- End Exams -->

        <li class="nav-item">
            <a class="nav-link {{ !(request()->is('teachers')) ? 'collapsed' : '' }}" href="{{ route('teachers') }}">
                <i class="bi bi-people-fill"></i>
                <span>Professeur</span>
            </a>
        </li><!-- End Profs Nav -->

        <li class="nav-item">
            <a class="nav-link {{ !(request()->is('classes')) ? 'collapsed' : '' }}" href="{{ route('classes') }}">
                <i class="bi bi-grid-3x3"></i>
                <span>Classes</span>
            </a>
        </li><!-- End Classes Nav -->

        <li class="nav-item">
            <a class="nav-link {{ !(request()->is('subject')) ? 'collapsed' : '' }}" href="{{ route('subjects') }}">
                <i class="bi bi-subtract"></i>
                <span>Matiers</span>
            </a>
        </li><!-- End Subjects Nav -->
    </ul>
</aside>
