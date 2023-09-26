<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php
                    $results = $this->reports_model->getAllReports();

                    $total_sales = 0;
                    $total_volume = 0;

                    foreach ($results as $result) :
                        $total_sales += $result->sales; // Add to total sales
                        $total_volume += $result->volume; // Add to total volume
                    endforeach;
                    ?>

                    <!-- Display totals for sales and volume at the top -->
                      <span>Total Sales Count: <strong><?php echo $total_sales; ?></strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span>Total Volume: <strong><?php echo $total_volume; ?></strong></span>

                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                            <tr>
                                <th><?= lang("ID"); ?></th>
                                <th><?= lang("Date"); ?></th>
                                <th><?= lang("Volume"); ?></th>
                                <th><?= lang("Sales"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($results as $result) :
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $result->purchased_date; ?></td>
                                    <td><?php echo $result->volume; ?></td>
                                    <td><?php echo $result->sales ?></td>
                                </tr>
                            <?php
                            $i++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

