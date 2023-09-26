<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><?= lang('update_info'); ?></h3>
        </div>
        <div class="box-body">
          <?php echo form_open("editshippingorders/edit/".$editshippingorder->purchased_id);?>

          <div class="col-md-6">

          <div class="form-group">
              <label class="control-label" for="fullname"><?= $this->lang->line("FULLNAME"); ?></label>
              <?= form_input('fullname', set_value('fullname', $editshippingorder->fullname), 'class="form-control input-sm" id="fullname"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="address1"><?= $this->lang->line("ADDRESS 1"); ?></label>
              <?= form_input('address1', set_value('address1', $editshippingorder->address1), 'class="form-control input-sm" id="address1"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="address2"><?= $this->lang->line("ADDRESS 2"); ?></label>
              <?= form_input('address2', set_value('address2', $editshippingorder->address2), 'class="form-control input-sm" id="address2"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="address3"><?= $this->lang->line("ADDRESS 3"); ?></label>
              <?= form_input('address3', set_value('address3', $editshippingorder->address3), 'class="form-control input-sm" id="address3"'); ?>
            </div>
          
            <div class="form-group">
              <label class="control-label" for="city"><?= $this->lang->line("CITY"); ?></label>
              <?= form_input('city', set_value('city', $editshippingorder->city), 'class="form-control input-sm" id="city"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="state"><?= $this->lang->line("STATE"); ?></label>
              <?= form_input('state', set_value('state', $editshippingorder->state), 'class="form-control input-sm" id="state"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="zipcode"><?= $this->lang->line("ZIPCODE"); ?></label>
              <?= form_input('zipcode', set_value('zipcode', $editshippingorder->zipcode), 'class="form-control input-sm" id="zipcode"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="country"><?= $this->lang->line("COUNTRY"); ?></label>
              <?= form_input('country', set_value('country', $editshippingorder->country), 'class="form-control input-sm" id="country"'); ?>
            </div>

            <div class="form-group">
              <label class="control-label" for="phone"><?= $this->lang->line("PHONE"); ?></label>
              <?= form_input('phone', set_value('phone', $editshippingorder->phone), 'class="form-control input-sm" id="phone"'); ?>
            </div>
            
          <div class="form-group">
              <?php echo form_submit('save_editshippingorder', $this->lang->line("save_editshippingorder"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
