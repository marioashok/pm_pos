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

                        <?php echo form_open_multipart("subcategories/edit/".$subcategory->id);?>
                        <div class="row">
                            <div class="col-md-6">
            
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('name', $subcategory->name, 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('category', 'category'); ?>
                                    <?php
                                    $cat[''] = lang("select")." ".lang("category");
                                    foreach($categories as $category) {
                                        $cat[$category->id] = $category->name;
                                    }
                                    ?>
                                    <?= form_dropdown('category_id', $cat, $subcategory->category_id, 'class="form-control select2 tip" id="category_id"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Discount', 'Discount'); ?>
                                    <?= form_input('discount', $subcategory->discount, 'class="form-control tip" id="discount"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Code', 'Code'); ?>
                                    <?= form_input('code', $subcategory->code, 'class="form-control tip" id="code"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Sub Cat Type Indicator', 'Sub Cat Type Indicator'); ?>
                                    <?= form_input('type_indicator', $subcategory->type_indicator, 'class="form-control tip" id="type_indicator"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('Featured Product ID', 'Featured Product ID'); ?>
                                    <?= form_input('featured_product_id', $subcategory->featured_product_id, 'class="form-control tip" id="featured_product_id"'); ?>
                                </div>
                                
                                
                                <div class="form-group">
                                    <?= lang('image', 'image'); ?>
                                    <input type="file" name="userfile" id="image">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('edit_category', lang('edit_category'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
