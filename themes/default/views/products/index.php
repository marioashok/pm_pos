<?php
$sub_category_id = $this->input->get('subcategory_id');
$category_id = $this->input->get('category_id');
?>
<h4 class="text-center"><a href="<?php echo site_url('products?subcategory_id=' . $this->input->get('subcategory_id') . '&category_id=' . $this->input->get('category_id')); ?>">Products</a></h4>
<!-- Add the search box here -->
<div class="container">
    <div class="form-group" style="margin-top: 10px;">
        <input type="text" id="searchBox" placeholder="Search..." class="form-control">
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php
                    // Define pagination variables
                    $recordsPerPage = 10; // Number of records to display per page
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $recordsPerPage;

                    // Use the model method to fetch products with search and pagination
                    $results = $this->products_model->getProductsWithSearchAndPagination($sub_category_id, $category_id, $recordsPerPage, $offset);

                    // Calculate total records count
                    $totalRecords = $this->products_model->getTotalProductCount($sub_category_id, $category_id);

                    // Calculate total pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                    ?>

                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                            <tr>
                                <th>Product ID</th>
                                <th>Product Code</th>
                                <th>Design Code</th>
                                <th>Variation</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result) : ?>
                                <tr>
                                    <td><?php echo $result->product_id; ?></td>
                                    <td><?php echo $result->gen_product_code; ?></td>
                                    <td><?php echo $result->design_code; ?></td>
                                    <td><?php echo $result->is_variation_available; ?></td>
                                    <td><?php echo $result->Quantity; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="text-center">
                        <ul class="pagination">
                            <?php if ($page > 1) : ?>
                                <li>
                                    <a href="?subcategory_id=<?php echo $sub_category_id; ?>&category_id=<?php echo $category_id; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a href="?subcategory_id=<?php echo $sub_category_id; ?>&category_id=<?php echo $category_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li>
                                    <a href="?subcategory_id=<?php echo $sub_category_id; ?>&category_id=<?php echo $category_id; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchBox").on("keyup", function (event) {
            if (event.key === "Enter") {
                var searchValue = $(this).val().trim();

                // Redirect to the first page with trimmed search query
                window.location.href = "?subcategory_id=<?php echo $sub_category_id; ?>&category_id=<?php echo $category_id; ?>&page=1&search=" + searchValue;
            }
        }).on("paste", function (event) {
            // Handle paste event to trim the input value
            setTimeout(function () {
                var searchValue = $("#searchBox").val().trim();
                $("#searchBox").val(searchValue);
            }, 0);
        });
    });
</script>
