@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="mb-3 d-flex">
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg rounded-0 text-white ms-auto">New Product</a>
                </div >
                <div class="shadow shadow-sm">
                    <table class="table table-striped mb-3 border border-1" id=datatable>
                        <thead>
                            <tr>
                            <th scope="col" class="col-1">#</th>
                            <th scope="col" class="col-1">Thumbnail</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-confirmation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h1 class="modal-title fs-5">Delete confirmation</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <input name="id" id="record-id" type="text" hidden>
                    <button type="submit" class="btn btn-danger delete-record" data-bs-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>
    let datatable = $('#datatable').DataTable({
        "order": [4, 'desc'],
        "processing": true,
        "language": {
            processing: '<div class="spinner-border text-primary text-lg" style="width: 2.6rem; height: 2.6rem;" role="status"><span class="visually-hidden">Loading...</span></div>'
        },
        "serverSide": true,
        "searchDelay": 1200,
        "ajax": "{{ route('products.data') }}",
        "columnDefs": [
            { target:[0,1,2,3,4,5], className: 'align-middle' },
        ],
        "columns": [
            { data: 'id', name: 'id', searchable: true },
            { data: 'thumbnail', name: 'thumbnail', searchable: false, orderable: false },
            { data: 'name', name: 'name', searchable: true },
            { data: 'price', name: 'price', searchable: true},
            { data: 'created_at', name: 'created_at', searchable: false },
            { data: 'actions', name: 'actions', searchable: false, orderable: false, className: 'text-center'},
        ]
    });
    $(document).on('click','.delete-confirmation',function(){
        let id = $(this).attr('data-id');
        $('#record-id').val(id);
    });
    $(document).on('click', '.delete-record', function() {
        let id = $('#record-id').val();
        $.ajax({
            url: '/api/products/delete/' + id,
            type: 'DELETE',
            success: function (data) {
                if (data.success) {
                    datatable.ajax.reload(null, false); // no pagination reset
                }
            }
        });
    });
    
</script>
@endpush