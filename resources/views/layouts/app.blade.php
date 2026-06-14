<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Indonesia</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col">

        @include('layouts.navbar')

        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))

<script>

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

Toast.fire({
    icon: 'success',
    title: '{{ session('success') }}'
});

</script>

@endif
@if(session('error'))

<script>

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

Toast.fire({
    icon: 'error',
    title: '{{ session('error') }}'
});

</script>

@endif

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form')
        .forEach(form => {

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: 'Yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if(result.isConfirmed){
                        form.submit();
                    }

                });

            });

        });

});

</script>
</body>
</html>         }

                });

            });

        });

});

</script>
</body>
</html>