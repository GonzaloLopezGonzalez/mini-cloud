    <script>
        window.Laravel = {
            routes: {
                uploadAjax: '{{ route('files.uploadAjax') }}'
            },
            csrfToken: '{{ csrf_token() }}'
        };
    </script>