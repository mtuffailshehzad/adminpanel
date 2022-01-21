<?php
include('partials/header.php');
$errors    =   array();
if(isset($_POST['categoryid'])){ $categoryid = $_POST['categoryid']; }else{ $categoryid = ''; }
if(isset($_POST['productname'])){ $productname = $_POST['productname']; }else{ $productname = ''; }
if(isset($_POST['sealedconditionprice'])){ $sealedconditionprice = $_POST['sealedconditionprice']; }else{ $sealedconditionprice = ''; }
if(isset($_POST['baseprice'])){ $baseprice = $_POST['baseprice']; }else{ $baseprice = ''; }
$files = $_FILES['productimage'];
// print_r($files);
$filename = $files ['name'];
$filepath = $files ['tmp_name'];
$fileerror = $files ['error'];
if(isset($_POST['submit'])) {
    if ($categoryid == '') {
        $errors['fkcategoryid'] = 'Please Select Category id.';
    }
    if ($productname == '') {
        $errors['productname'] = 'Please enter product name.';
    }
    if ($files === '') {
        $errors['img'] = 'Upload product Image.';
    }
    if ($sealedconditionprice === '') {
        $errors['sealedconditionprice'] = 'Please enter Net Price.';
    }
    if ($baseprice === '') {
        $errors['baseprice'] = 'Please enter Sale Price.';
    }

    if (count($errors) === 0) {
        $duplication = mysqli_query($conn, "select * from tblproduct where productname='" . $productname . "' && fkcategoryid =".$categoryid."");
        if (mysqli_num_rows($duplication) > 0) {
            $errors['alreadyexist'] = 'Product Name or category id already exit.';
        } if($fileerror == 0) {
            $destfile = 'images/' . $filename;
            // echo"$destfile";
            move_uploaded_file($filepath, $destfile);

            $query = mysqli_query($conn, "INSERT INTO  tblproduct(productname, productimage, sealedconditionprice, baseprice, fkcategoryid) VALUE('" . $productname . "', '" . $destfile . "', '" . $sealedconditionprice . "','" . $baseprice . "', '" . $categoryid . "')");
            echo jsredirecturl('products.php');
            exit;
        }
    }
}
$category = mysqli_query($conn, "SELECT * FROM tblcategory");
?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Manage Products</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Add Product</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <br>
    <div class="ibox-content m-b-sm border-bottom">
        <form class="m-t" role="form"method="post" action="">
            <div class="form-group row">
                <div class="col-sm-12">
                    <?php if (count($errors) > 0){ ?>
                        <ul class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $key => $error){ ?>
                                <li><?php echo $error; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <br>
                    <div class="form-group">
                        <label class="col-form-label" for="productname">Product Name</label>
                        <input type="text" name="productname" id="productname" class="form-control" placeholder="Enter The Product Name" value="<?php echo $productname; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="fkcategoryid">Product Category</label>
                        <select name="categoryid" id="categoryid" class="form-control">
                            <option value="" class="form-control">Select Product Category</option>
                            <?php
                            if(mysqli_num_rows($category) > 0)
                            {
                                $count =   1;
                                while($row = mysqli_fetch_assoc($category))
                                {
                                    ?>
                                    <option value="<?php echo $row['pkcategoryid']; ?>" <?php if($row['pkcategoryid'] === $categoryid){ echo 'selected'; } ?>><?php echo $row['categoryname']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="productimage">Product Image</label>
                        <input type="file" name="productimage" id="productimage" class="form-control" placeholder="Upload The Product image" value="<?php echo $files; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="sealedconditionprice">Net Price</label>
                        <input type="text" name="sealedconditionprice" id="sealedconditionprice" class="form-control" placeholder="Enter The Net Price" value="<?php echo $sealedconditionprice; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="baseprice">Sale Price</label>
                        <input type="text" name="baseprice" id="baseprice" class="form-control" placeholder="Enter the sale Price" value="<?php echo $baseprice; ?>" />
                    </div>
                    <div class="form-group">
                        <a href="categories.php" class="btn btn-danger btn-lg float-right">Cancel</a>
                        <button class="btn btn-success btn-lg float-right" type="submit" name="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('partials/footer.php') ?>