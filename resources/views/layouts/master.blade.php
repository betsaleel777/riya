<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.head')

<body>
    @include('layouts.partials.sidebar')
    <main class="content">
        @include('layouts.partials.header')
        @yield('content')
        @include('layouts.partials.footer')
    </main>
    @include('layouts.partials.scripts')
</body>

</html>
