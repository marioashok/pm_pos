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
                        <?php echo form_open_multipart("homepageslider/add", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('title', 'Title'); ?>
                                    <?= form_input('title', set_value('title'), 'class="form-control tip" id="title"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('url', 'URL'); ?>
                                    <?= form_input('url', set_value('url'), 'class="form-control tip" id="url"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('description', 'Description'); ?>
                                    <?= form_input('description', set_value('description'), 'class="form-control tip" id="description"  required="required"'); ?>
                                </div>

                                <div class="form-group">

                                    <?= lang('display_order', 'display_order'); ?>

                                    <?= form_input('display_order', set_value('display_order'), 'class="form-control tip" id="display_order"  required="required"'); ?>

                                </div>

                                <div class="form-group">
                                    <?= lang('image', 'image'); ?>
                                    <input type="file" name="userfile" id="image">
                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <?= form_submit('add_homepageslider', lang('ADD'), 'class="btn btn-primary"'); ?>

                        </div>

                        <?php echo form_close();?>

                    </div>

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>

    </div>

</section>

