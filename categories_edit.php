<?php
include('partials/header.php');
$errors    =   array();
if(isset($_REQUEST['id'])) { $id = $_REQUEST['id']; }else{ $id = ''; }
if(isset($_POST['categoryname'])){ $categoryname = $_POST['categoryname']; }else{ $categoryname = ''; }
if(isset($_POST['submit'])) {
    if ($categoryname == '') {
        $errors['categoryname'] = 'Please enter category name.';
    }
    if (count($errors) == 0) {
        $duplication = mysqli_query($conn, "select * from tblcategory where categoryname = '" . $categoryname . "' AND pkcategoryid != ". $id);
        if (mysqli_num_rows($duplication) > 0) {
            $errors['exit'] = 'Category Name already exit.';
        } else {
            $query = mysqli_query($conn, "UPDATE tblcategory SET categoryname = '" . $categoryname . "' WHERE pkcategoryid=" . $id);
            echo jsredirecturl('categories.php');
            exit;
        }
    }
}
else
    {
        if($id != '')
        {
            $query  =   mysqli_query($conn, "SELECT * FROM tblcategory WHERE pkcategoryid=".$id);
            if(mysqli_num_rows($query) > 0)
            {
                $getcategory   =   mysqli_fetch_assoc($query);
                $categoryname =   $getcategory['categoryname'];
            }
        }
    }
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Manage Categories</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Category</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<br>
<div class="ibox-content m-b-sm border-bottom">
    <form class="m-t" role="form" method="post" action="categories_edit.php?id=<?php echo $id; ?>">
    <div class="form-group row">
        <div class="col-sm-12">
            <?php if (count($errors) > 0){ ?>
                <ul class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $key => $error){ ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div class="form-group">
                <label class="col-form-label" for="categoryname">Category Name</label>
                <input type="text" name="categoryname" id="categoryname" class="form-control" placeholder="Enter The Category Name" value="<?php echo $categoryname; ?>" />
                <?php if (isset($errors['categoryname']) && $errors['categoryname'] != ''){ ?>
                    <p><?php echo $errors['categoryname'];?></p>
                <?php } ?>
                <?php if (isset($errors['exist']) && $errors['exist'] != ''){ ?>
                    <p><?php echo $errors['exist'];?></p>
                <?php } ?>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <a href="categories.php" class="btn btn-danger btn-lg float-right">Cancel</a>
                <button class="btn btn-success btn-lg float-right" type="submit" name="submit">Submit</button>
            </div>
        </div>
    </div>
    </form>
</div>
<?php include('partials/footer.php') ?>
