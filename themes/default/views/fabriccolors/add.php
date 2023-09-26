<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>



<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?php echo form_open_multipart("fabriccolors/add", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('COLOR NAME', 'COLOR NAME'); ?>
                                    <?= form_input('color_band_name', set_value('color_band_name'), 'class="form-control tip" id="color_band_name"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('COLOR CODE', 'COLOR CODE'); ?>
                                    <?= form_input('color_band_code', set_value('color_band_code'), 'class="form-control tip" id="color_band_code"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= form_hidden('color_band_type', '1'); ?>
                                </div>


                            </div>

                        </div>

                        <div class="form-group">

                            <?= form_submit('add_fabriccolor', lang('add_fabriccolor'), 'class="btn btn-primary"'); ?>

                        </div>

                        <?php echo form_close();?>

                    </div>

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>

    </div>

</section>

