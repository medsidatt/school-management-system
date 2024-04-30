<script type="text/javascript">
    $(function () {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('students') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'product_code', name: 'product_code'},
                {data: 'product_name', name: 'product_name'},
            ]
        });
    });
</script>
