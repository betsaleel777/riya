@if ($message = Session::pull('success'))
    <!-- Notyf -->
    <script src="{{ asset('theme/vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/notification.js') }}"></script>
    <script>
        notifier('success', "{{ $message }}")
    </script>
@endif

@if ($message = Session::pull('error'))
    <!-- Notyf -->
    <script src="{{ asset('theme/vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/notification.js') }}"></script>
    <script>
        notifier('error', "{{ $message }}")
    </script>
@endif

@if ($message = Session::pull('info'))
    <!-- Notyf -->
    <script src="{{ asset('theme/vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/notification.js') }}"></script>
    <script>
        notifier('info', "{{ $message }}")
    </script>
@endif

@if ($message = Session::pull('warning'))
    <!-- Notyf -->
    <script src="{{ asset('theme/vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/notification.js') }}"></script>
    <script>
        notifier('warning', "{{ $message }}")
    </script>
@endif
