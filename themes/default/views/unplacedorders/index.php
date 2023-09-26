<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>



<script type="text/javascript">

    $(document).ready(function() {



        var table = $('#pcolorData').DataTable({



            'ajax' : { url: '<?=site_url('unplacedorders/get_unplacedorders');?>', type: 'POST', "data": function ( d ) {

                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";

            }},

        "buttons": [

            { extend: 'copyHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },

            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },

            { extend: 'csvHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },

            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': false,

            exportOptions: { columns: [ 0, 1, 2, 3 ] } },

            { extend: 'colvis', text: 'Columns'},

            ],

            "columns": [

            { "data": "cartId", "visible": false },
            { "data": "uid", "visible": true },
            { "data": "date" },
            { "data": "order_no" },
            { "data": "product_code" },
            { "data": "useremail" },
            { "data": "fullname" },
            { "data": "country" },
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
                        <table id="pcolorData" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="max-width:30px;"><?= lang("CART ID"); ?></th>
                                    <th style="max-width:30px;"><?= lang("UID"); ?></th>
                                    <th><?= lang("Date"); ?></th>
                                    <th><?= lang("ORDER NUMBER"); ?></th>
                                    <th style="text-align:center"><?= lang("PRODUCT CODE"); ?></th>
                                    <th style="text-align:center;"><?= lang("EMAIL"); ?></th>
                                    <th style="text-align:center;"><?= lang("FULLNAME"); ?></th>
                                    <th style="text-align:center;"><?= lang("COUNTRY"); ?></th>
                                    <th style="width:65px;"><?= lang("actions"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
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