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

                        <?php echo form_open_multipart("subcategories/add", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('name', set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>
                                 <div class="form-group">
                                    <?= lang('category', 'category'); ?>
                                    <?php
                                    $cat[''] = lang("select")." ".lang("category");
                                    foreach($categories as $category) {
                                        $cat[$category->id] = $category->name;
                                    }
                                    ?>
                                    <?= form_dropdown('category_id', $cat, set_value('category_id'), 'class="form-control select2 tip" id="category_id"  required="required" style="width:100%;"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Discount', 'Discount'); ?>
                                    <?= form_input('discount', set_value('discount'), 'class="form-control tip" id="discount"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Code', 'Code'); ?>
                                    <?= form_input('code', set_value('code'), 'class="form-control tip" id="code"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Sub Cat Type Indicator', 'Sub Cat Type Indicator'); ?>
                                    <?= form_input('type_indicator', set_value('type_indicator'), 'class="form-control tip" id="type_indicator"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Featured Product ID', 'Featured Product ID'); ?>
                                    <?= form_input('featured_product_id', set_value('featured_product_id'), 'class="form-control tip" id="featured_product_id"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('image', 'image'); ?>
                                    <input type="file" name="userfile" id="image">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('add_subcategory', lang('add_subcategory'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
