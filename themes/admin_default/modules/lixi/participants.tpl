<!-- BEGIN: main -->
<p><a href="{URL_EXPORT}" class="btn btn-success"><i class="fa fa-file-excel-o"></i> {LANG.export_excel}</a></p>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{LANG.fullname}</th>
                <th>{LANG.birthyear}</th>
                <th>{LANG.bank_account}</th>
                <th>{LANG.bank_name}</th>
                <th>{LANG.amount_received}</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: row -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.fullname}</td>
                <td>{ROW.birthyear}</td>
                <td>{ROW.bank_account}</td>
                <td>{ROW.bank_name}</td>
                <td>{ROW.amount_received} đ</td>
                <td>{ROW.join_time}</td>
            </tr>
            <!-- END: row -->
        </tbody>
    </table>
</div>
<!-- END: main -->
