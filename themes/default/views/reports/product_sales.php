<?php



$query = $_SERVER['QUERY_STRING'];
preg_match_all('!\d+!', $query, $matches);
$pm = $matches[0][0];
$currentYear = date('Y');
$currentMonth = date('m');
$pm = (int)$_GET['pm'];

$year = $currentYear;
$month = $currentMonth - $pm;

if ($month <= 0) {
    $year--;
    $month = 12 - abs($month);
}

$result = strtotime("{$year}-{$month}-01");
$result = strtotime('-1 second', strtotime('+1 month', $result));
$start_date = date('Y-m-01', $result);
$end_date = date('Y-m-t', $result);
$dateObj = DateTime::createFromFormat('!m', $month);
$monthName = $dateObj->format('F');
?>

<h3 class="box-title"><strong>Product Sales Report</strong> for <?php echo $monthName . " " . $year; ?></h3>

<!-- Add the search box here -->
<div class="form-group" style="margin-top: 10px;">
    <input type="text" id="searchBox" placeholder="Search..." class="form-control">
</div>

<div class="form-group" style="">
    <div class="box-header" style="">
        <div class="pull-left" style="display:flex;margin-top:6px;">
            <div>
                <?php $previous_pm_value = $pm + 1; ?>
                <?php echo form_open_multipart('reports/product_sales?pm=' . $previous_pm_value, 'class="validation"'); ?>
                <?= form_submit('previous', lang('PREVIOUS'), 'class="btn btn-primary"', 'style=""'); ?>
                <?= form_close(); ?>
            </div>
            <?php if ($pm != 0) : ?>
                <div>
                    <?php $next_pm_value = $pm - 1; ?>
                    <?php echo form_open_multipart('reports/product_sales?pm=' . $next_pm_value, 'class="validation"'); ?>
                    <?= form_submit('next', lang('NEXT'), 'class="btn btn-primary"', 'style=""'); ?>
                    <?= form_close(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php
                    $results = $this->reports_model->get_product_sales_report($start_date, $end_date);
                    ?>

                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                            <tr>
                                <th><?= lang("DATE"); ?></th>
                                <th><?= lang("CATEGORY"); ?></th>
                                <th><?= lang("PRODUCT CODE"); ?></th>
                                <th><?= lang("COLOR"); ?></th>
                                <th><?= lang("QTY"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $result) :
                            ?>
                                <tr>
                                 <td><?php echo date('d-m-Y', strtotime($result->date)); ?></td>
                                    <td><?php echo $result->cat_name; ?></td>
                                    <td><?php echo $result->prodcode; ?></td>
                                    <td><?php echo $result->color; ?></td>
                                    <td><?php echo $result->salescount; ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchBox").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#UTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
