<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        function image(n) {
            if (n !== null) {
                return '<div style="width:32px; margin: 0 auto;"><a href="<?=base_url();?>uploads/'+n+'" class="open-image"><img src="<?=base_url();?>uploads/thumbs/'+n+'" alt="" class="img-responsive"></a></div>';
            }
            return '';
        }

        var table = $('#retailcustData').DataTable({

            'ajax' : { url: '<?=site_url('retailcustomers/get_retailcustomers');?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3 ] } },
            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3 ] } },
            { extend: 'csvHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3 ] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': false,
            exportOptions: { columns: [ 0, 1, 2, 3 ] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "user_id"},
            { "data": "firstname"},
            { "data": "lastname"},
            { "data": "email" },
            { "data": "country","render":function(data,type,row){return row["country"].split("|").pop(); } },
            { "data": "state" },
            { "data": "city" },
            { "data": "zipcode" },
            { "data": "Actions", "searchable": false, "orderable": false }
            ]

        });

        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

    });
</script>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="retailcustData" class="table table-striped table-bordered table-condensed table-hover" style="margin-bottom:5px;">
                            <thead>
                                <tr class="active">
                                    <th><?= lang('USER ID'); ?></th>
                                    <th><?= lang('First Name'); ?></th>
                                    <th><?= lang('Last Name'); ?></th>
                                    <th><?= lang('Email'); ?></th>
                                    <th><?= lang('Country'); ?></th>
                                    <th><?= lang('State'); ?></th>
                                     <th><?= lang('City'); ?></th>
                                     <th><?= lang('Pincode'); ?></th>
                                    <th style="width:75px;"><?= lang('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

