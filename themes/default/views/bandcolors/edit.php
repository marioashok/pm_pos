<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title"><?= lang('update_info'); ?></h3>
        </div>
        <div class="box-body">
          <?php echo form_open("bandcolors/edit/".$bandcolor->color_band_id);?>
          <div class="col-md-6">
          <div class="form-group">
              <label class="control-label" for="title"><?= $this->lang->line("COLOR BAND NAME"); ?></label>
              <?= form_input('color_band_name', set_value('color_band_name', $bandcolor->color_band_name), 'class="form-control input-sm" id="color_band_name"'); ?>
          </div>
          <div class="form-group">
              <label class="control-label" for="color_band_code"><?= $this->lang->line("COLOR BAND CODE"); ?></label>
              <?= form_input('color_band_code', set_value('color_band_code', $bandcolor->color_band_code), 'class="form-control input-sm" id="color_band_code"'); ?>
          </div>

          <div class="form-group">
              <?php echo form_submit('save_bandcolors', $this->lang->line("SAVE"), 'class="btn btn-primary"');?>
            </div>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
