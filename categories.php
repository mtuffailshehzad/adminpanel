<?php
include('partials/header.php');
if (isset($_REQUEST['category_name'])){ $category_name = $_REQUEST['category_name']; }else{ $category_name = ''; }
$sql = "SELECT * FROM tblcategory where pkcategoryid > 0";
if ($category_name != '')
{
    $sql .= " AND categoryname LIKE '%".$category_name."%'";
}
$query = mysqli_query($conn, $sql." ORDER BY categoryname");
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manage Categories</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Categories List</strong>
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
            <form class="form-group" method="GET" action="" >
                <div class="input-group mb-3 form-group">
                    <input type="text" class="form-control" name="category_name" placeholder="Search here..."aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo $category_name; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <div class="ibox-content">
                <div class="float-right">
                    <a class="btn btn-primary" href="categories_add.php">Add Category</a>
                </div>
                <table  class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
                    <thead>
                    <tr>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Sr<span class="footable-sort-indicator"></span></th>
                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable">Category Name<span class="footable-sort-indicator"></span></th>
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
                        <td class="footable-visible footable-first-column">
                            <div class="btn-group">
                                <a href="categories_edit.php?id=<?php echo $row['pkcategoryid']; ?>"><i class="fa fa-edit text-primary"></i></a>
                                <a href="categories_delete.php?id=<?php echo $row['pkcategoryid']; ?>"<i class="fa fa-trash text-danger"></i></a>

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
                            <td align="center" colspan="3">Categories not found!</td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include ('partials/footer.php');
?>
