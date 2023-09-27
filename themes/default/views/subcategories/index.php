<br><br>
<h4 class="text-center"><a href="<?php echo site_url('subcategories?category_id=' . $this->input->get('category_id')); ?>">Subcategories</a></h4>
<style>
    .zoomed-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Ensures it's on top of other elements */
    }

  
</style>

<?php
// Get search term from the request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$category_id = $this->input->get('category_id');

// Define pagination variables
$recordsPerPage = 10; // Number of records to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Use the model method to fetch subcategories with search and pagination
$this->load->model('Subcategories_model'); // Load the model if not already loaded

// Use the model method with limit and offset
$currentResults = $this->subcategories_model->getSubcategoriesWithSearchAndPagination($category_id, $recordsPerPage, $offset, $searchTerm);

// Calculate total records count
$totalRecords = count($this->subcategories_model->getSubcategoriesWithSearch($category_id, $searchTerm));

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Add your HTML head content here -->
</head>
<body>
    <!-- Add the search box here -->
    <form method="get" action="subcategories">
        <div class="container">
        <div class="form-group" style="margin-top: 10px;">
            <input type="text" name="search" id="searchBox" placeholder="Search..." class="form-control" value="<?php echo $searchTerm; ?>">
        </div>
        </div>
        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
    </form>

    <section class="content">
        <!-- Display results here based on $currentResults -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="UTable" class="table table-bordered table-striped table-hover">
                            <thead class="cf">
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Discount</th>
                                    <th>Type Indicator</th>
                                    <th>Featured Product ID</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($currentResults as $result) : ?>
                                    <tr>
                                        <td><a href="<?php echo site_url("products?subcategory_id=$result->id&category_id=$result->category_id"); ?>"><?php echo $result->name; ?></a></td>
                                        
                                        <td style="max-width:20px">
    <a href="#" class="zoom-trigger">
        <img src="../../pos/uploads/subcategories/thumbs/<?php echo $result->image; ?>" alt="Image" class="img-thumbnail">
    </a>
</td>

                                        <td><?php echo $result->code; ?></td>
                                        <td><?php echo $result->discount; ?></td>
                                        <td><?php echo $result->type_indicator; ?></td>
                                        <td><?php echo $result->featured_product_id; ?></td>
                                        <td class="text-center">
                                             <a href="<?php echo site_url("subcategories/edit/$result->id"); ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="<?php echo site_url("subcategories/delete/$result->id"); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="text-center">
    <ul class="pagination">
        <?php if ($page > 1) : ?>
            <li>
                <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $page - 1; ?>&search=<?php echo $searchTerm; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $i; ?>&search=<?php echo $searchTerm; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages) : ?>
            <li>
                <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $page + 1; ?>&search=<?php echo $searchTerm; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>

    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $("#searchBox").on("keyup", function (event) {
            if (event.key === "Enter") {
                var searchValue = $(this).val().trim()  // Trim spaces and convert to lowercase
                $("#UTable tbody tr").each(function () {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchValue) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
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


<script>
    $(document).ready(function () {
        // Handle image zoom when clicking on the image
        $(".zoom-trigger").click(function (e) {
            e.preventDefault(); // Prevent the link from navigating

            // Create a copy of the clicked image
            var $originalImage = $(this).find("img");
            var $zoomedImage = $originalImage.clone();

            // Define the desired width and height for the zoomed image
            var zoomedWidth = $originalImage.width() * 1.5; // 50% larger than the original
            var zoomedHeight = $originalImage.height() * 1.5; // 50% larger than the original

            // Set the width and height for the zoomed image
            $zoomedImage.css({
                width: zoomedWidth + "px",
                height: zoomedHeight + "px"
            });

            // Create a div to display the zoomed image
            var $zoomedContainer = $("<div class='zoomed-image'></div>");
            $zoomedContainer.append($zoomedImage);

            // Add the zoomed image container to the body
            $("body").append($zoomedContainer);

            // Close the zoomed image when clicking anywhere on it
            $zoomedContainer.click(function () {
                $(this).remove();
            });
        });
    });
</script>

</body>
</html>
