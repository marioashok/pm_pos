<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('update_info'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">

                        <?php echo form_open_multipart("homepageslider/edit/".$homepageslider->id);?>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <?= lang('title', 'title'); ?>
                                    <?= form_input('title', $homepageslider->title, 'class="form-control tip" id="title"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('url', 'url'); ?>
                                    <?= form_input('url', $homepageslider->url, 'class="form-control tip" id="url"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('description', 'description'); ?>
                                    <?= form_input('description', $homepageslider->description, 'class="form-control tip" id="description"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('display_order', 'display_order'); ?>
                                    <?= form_input('display_order', $homepageslider->display_order, 'class="form-control tip" id="display_order"  required="required"'); ?>
                                </div>
                               
                                <div class="form-group">
                                    <?= lang('image', 'image'); ?>
                                    <input type="file" name="userfile" id="image">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('edit_homepageslider', lang('UPDATE'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
