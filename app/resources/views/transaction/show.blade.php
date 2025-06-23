<div class="container">
    <article class="card">
        <header class="card-header">Details Data Order</header>
        <div class="card-body">
            <h6>Tanggal Dan Tujuan: <span id="fullname"></span></h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"><strong>Tanggal Pengiriman:</strong><br>
                        <p>{{ \Carbon\Carbon::parse($data->tanggal_pengiriman)->translatedFormat('d F y')
                                    .' '. \Carbon\Carbon::parse($data->mulai)->format('H:i').'/'. \Carbon\Carbon::parse($data->sampai)->format('H:i')}}</p></div>
                    <div class="col"><strong>Tujuan:</strong><br><p>{{$data->tujuan}}</p></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="detailTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Qty</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </article>
            <hr>
        </div>
    </article>
</div>

<script>
    $(document).ready(function() {
        var table = $('#detailTable').DataTable({
            paging: false,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('transaction.show.get', ['id_data_pengiriman' => $id_data_pengiriman]) }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'other_id', name: 'other_id', orderable: false },
                { data: 'qty', name: 'qty', orderable: false }
            ],
            responsive: true,
            autoWidth: false,
            language: {
                processing: "Loading Data...",
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries to show",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                zeroRecords: "No matching records found"
            }
        });
    });
</script>
