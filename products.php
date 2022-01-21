<?php
include('partials/header.php');
if (isset($_REQUEST['category_name'])){ $category_name = $_REQUEST['category_name']; }else{ $category_name = ''; }
if (isset($_REQUEST['productname'])){ $productname = $_REQUEST['productname']; }else{ $productname = ''; }
$sql = "SELECT product.*, category.categoryname FROM tblproduct AS product
        INNER JOIN tblcategory AS category 
            ON category.pkcategoryid = product.fkcategoryid where pkproductid > 0";
if ($category_name != '')
{
    $sql.=" category.categoryname LIKE '%".$category_name."%'";
    }
if ($productname != '')
{
    $sql.=" productname LIKE '%".$productname."%'";
    }
    $query = mysqli_query($conn,   $sql." ORDER BY productname ASC");
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manage Products</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Products List</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div>
                <br>
            </div>
            <form class="form-group" role="form" method="GET" action="" >
                <div class="form-inline">
                    <input type="text" class="form-control col-5" id="category_name" name="category_name" placeholder="Search By Category Name" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo $category_name; ?>">
                    <input type="text" class="form-control col-5" id="productname" name="productname" placeholder="Search By Condition Title"aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo $productname; ?>">
                    <button class="btn btn-primary float-right col-2">Search</button>
                </div>
            </form>
            <div class="ibox-content">
                <div align="right">
                    <a class="btn btn-primary" href="products_add.php">Add Product</a>
                </div>
                <table id="myTable" class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
                    <thead>
                    <tr>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Sr<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Category Name<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Product Name<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Product Image<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Net Price<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Sale Price<span class="footable-sort-indicator"></span></th>
                        <th class="footable-visible footable-first-column footable-sortable" data-sort-ignore="true">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0){
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr class="footable-even" style="">
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span><?php echo $count; ?></td>
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                    <?php echo $row['categoryname']; ?>
                                </td>
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                    <?php echo $row['productname']; ?>
                                </td>
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                    <img src="images/<?php echo $row['productimage']; ?>">
                                </td>
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                    <?php echo $row['sealedconditionprice']; ?>
                                </td>
                                <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                    <?php echo $row['baseprice']; ?>
                                </td>
                                <td class="footable-visible footable-first-column">
                                    <div class="btn-group">
                                        <a href="products_edit.php?id=<?php echo $row['pkproductid']; ?>"><i class="fa fa-edit text-primary"></i></a>
                                        <a href="products_delete.php?id=<?php echo $row['pkproductid']; ?>"<i class="fa fa-trash text-danger"></i></a>

                                    </div>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td align="center" colspan="6">Search Data not found!</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" class="footable-visible">
                            <ul class="pagination float-right"><li class="footable-page-arrow disabled"><a data-page="first" href="#first">«</a></li><li class="footable-page-arrow disabled"><a data-page="prev" href="#prev">‹</a></li><li class="footable-page active"><a data-page="0" href="#">1</a></li><li class="footable-page"><a data-page="1" href="#">2</a></li><li class="footable-page-arrow"><a data-page="next" href="#next">›</a></li><li class="footable-page-arrow"><a data-page="last" href="#last">»</a></li></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
