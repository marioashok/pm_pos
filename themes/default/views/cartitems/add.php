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

                        <?php echo form_open_multipart("pcolors/add", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('pcolor_code', 'pcolor_code'); ?>
                                    <?= form_input('color_code', set_value('color_code'), 'class="form-control tip" id="pcolor_code"  required="required"'); ?>
                                </div>

                        

                                <div class="form-group">
                                    <?= lang('pcolor_name', 'pcolor_name'); ?>
                                    <?= form_input('color_name', set_value('color_name'), 'class="form-control tip" id="pcolor_name"  required="required"'); ?>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('add_pcolor', lang('add_pcolor'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
