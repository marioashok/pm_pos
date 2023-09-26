<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><?= lang('update_info'); ?></h3>
        </div>
        <div class="box-body">
          <?php echo form_open("coupons/edit/".$coupon->coupon_id);?>
          <div class="col-md-6">
              <div class="form-group">
                  <label class="control-label" for="coupon_email"><?= $this->lang->line("COUPON EMAIL"); ?></label>
                  <?= form_input('coupon_email', set_value('coupon_email', $coupon->coupon_email), 'class="form-control input-sm" id="coupon_email"'); ?>
              </div>
              <div class="form-group">
                  <label class="control-label" for="coupon_code"><?= $this->lang->line("COUPON CODE"); ?></label>
                  <?= form_input('coupon_code', set_value('coupon_code', $coupon->coupon_code), 'class="form-control input-sm" id="coupon_code"'); ?>
              </div>
               <div class="form-group">
                  <label class="control-label" for="coupon_quantity"><?= $this->lang->line("COUPON QUANTITY"); ?></label>
                  <?= form_input('coupon_quantity', set_value('coupon_quantity', $coupon->coupon_quantity), 'class="form-control input-sm" id="coupon_quantity"'); ?>
                </div>
                <div class="form-group">
                  <label class="control-label" for="coupon_range_from"><?= $this->lang->line("COUPON RANGE FROM"); ?></label>
                  <?= form_input('coupon_range_from', set_value('coupon_range_from', $coupon->coupon_range_from), 'class="form-control input-sm" id="coupon_range_from"'); ?>
                </div>
              <div class="form-group">
                  <label class="control-label" for="coupon_range_to"><?= $this->lang->line("COUPON RANGE TO"); ?></label>
                  <?= form_input('coupon_range_to', set_value('coupon_range_to', $coupon->coupon_range_to), 'class="form-control input-sm" id="coupon_range_to"'); ?>
             </div>
            <div class="form-group">
                  <label class="control-label" for="coupon_discount"><?= $this->lang->line("COUPON DISCOUNT"); ?></label>
                  <?= form_input('coupon_discount', set_value('coupon_discount', $coupon->coupon_discount), 'class="form-control input-sm" id="coupon_discount"'); ?>
            </div>
                <div class="form-group">
                      <label class="control-label" for="coupon_discount"><?= $this->lang->line("COUPON DISCOUNT AMT"); ?></label>
                      <?= form_input('coupon_discount_amt', set_value('coupon_discount_amt', $coupon->coupon_discount_amt), 'class="form-control input-sm" id="coupon_discount_amt"'); ?>
                </div>
                <div class="form-group">
                  <label class="control-label" for="coupon_free_shipping"><?= $this->lang->line("FREE SHIPPING"); ?></label>
                  <?= form_input('coupon_free_shipping', set_value('coupon_free_shipping', $coupon->coupon_free_shipping), 'class="form-control input-sm" id="coupon_free_shipping"'); ?>
                </div>

              <div class="form-group">
                  <label class="control-label" for="coupon_start_date"><?= $this->lang->line("START DATE"); ?></label>
                  <?= form_input('coupon_start_date', set_value('coupon_start_date', $coupon->coupon_start_date), 'class="form-control input-sm" id="coupon_start_date"'); ?>
            </div>

              <div class="form-group">
                  <label class="control-label" for="coupon_expiry_date"><?= $this->lang->line("EXPIRY DATE"); ?></label>
                  <?= form_input('coupon_expiry_date', set_value('coupon_expiry_date', $coupon->coupon_expiry_date), 'class="form-control input-sm" id="coupon_expiry_date"'); ?>
            </div>


          <div class="form-group">
              <?php echo form_submit('save_coupons', $this->lang->line("SAVE"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
