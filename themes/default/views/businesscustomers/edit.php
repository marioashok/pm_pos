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

                        <?php echo form_open_multipart("businesscustomers/edit/".$businesscustomer->user_id);?>
                        <div class="row">
                            <div class="col-md-6">
                                
                                 <div class="form-group">
                                    <?= lang('firstname', 'firstname'); ?>
                                    <?= form_input('firstname', $businesscustomer->firstname, 'class="form-control tip" id="firstname"  required="required"'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <?= lang('email', 'email'); ?>
                                    <?= form_input('email', $businesscustomer->email, 'class="form-control tip" id="email"  required="required"'); ?>
                                </div>
                                
                                 <div class="form-group">
                                    <?= lang('country', 'country'); ?>
                                    <?= form_input('country', $businesscustomer->country, 'class="form-control tip" id="country"  required="required"'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <?= lang('state', 'state'); ?>
                                    <?= form_input('state', $businesscustomer->state, 'class="form-control tip" id="state"  required="required"'); ?>
                                </div>
                                
                                 <div class="form-group">
                                    <?= lang('zipcode', 'zipcode'); ?>
                                    <?= form_input('zipcode', $businesscustomer->zipcode, 'class="form-control tip" id="zipcode"  required="required"'); ?>
                                </div>
                                
                                
                                
                           </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('edit_businesscustomer', lang('edit_businesscustomer'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
