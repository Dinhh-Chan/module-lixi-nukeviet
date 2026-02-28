<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th class="text-nowrap">#</th>
                <th class="text-nowrap">{LANG.title}</th>
                <th class="text-nowrap">{LANG.amount_type}</th>
                <th class="text-nowrap">Người tham gia</th>
                <th class="text-nowrap">{LANG.status}</th>
                <th class="text-nowrap">Thời gian</th>
                <th class="text-center text-nowrap">{GLANG.feature}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: row -->
            <tr>
                <td class="text-center">{ROW.id}</td>
                <td>
                    <a href="{ROW.url_join}" target="_blank">{ROW.title}</a>
                </td>
                <td>{ROW.amount_type_label}</td>
                <td class="text-center">{ROW.num_participants}/{ROW.num_envelopes}</td>
                <td class="text-center">{ROW.status_label}</td>
                <td>{ROW.add_time}</td>
                <td class="text-center text-nowrap">
                    <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                    <a href="{ROW.url_participants}" class="btn btn-info btn-sm"><i class="fa fa-users"></i> {LANG.participants}</a>
                    <a href="{ROW.url_export}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> {LANG.export_excel}</a>
                    <a href="javascript:void(0);" onclick="nv_module_del({ROW.id}, '{ROW.checkss}');" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> {GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: row -->
        </tbody>
    </table>
</div>
<!-- END: main -->
