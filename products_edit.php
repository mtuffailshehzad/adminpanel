<?php
include('partials/header.php');
include ('dbconfig.php');
$errors    =   array();
if (isset($_REQUEST['id'])){ $id = $_REQUEST['id']; }else{ $id = ''; }
if(isset($_POST['productname'])){ $productname = $_POST['productname']; }else{ $productname = ''; }
if(isset($_POST['fkcategoryid'])){ $fkcategoryid= $_POST['fkcategoryid']; }else{ $fkcategoryid = ''; }
if(isset($_POST['sealedconditionprice'])){ $sealedconditionprice = $_POST['sealedconditionprice']; }else{ $sealedconditionprice = ''; }
if(isset($_POST['baseprice'])){ $baseprice = $_POST['baseprice']; }else{ $baseprice = ''; }
if(isset($_POST['submit'])) {
    if ($fkcategoryid == '') {
        $errors['fkcategoryid'] = 'Please Select Category id.';
    }
    if ($productname == '') {
        $errors['productname'] = 'Please enter product name.';
    }
    if ($sealedconditionprice == '') {
        $errors['sealedconditionprice'] = 'Please enter Net Price.';
    }
    if ($baseprice == '') {
        $errors['baseprice'] = 'Please enter Sale Price.';
    }
    if (count($errors) == 0) {
        $duplication = mysqli_query($conn, "select * from tblproduct where productname='" . $productname . "' AND pkproductid != " . $id);
        if (mysqli_num_rows($duplication) > 0) {
            $errors['alreadyexist'] = 'product Name already exit.';
        } else {
            $query = mysqli_query($conn, "UPDATE tblproduct SET productname = '" . $productname . "', sealedconditionprice = '" . $sealedconditionprice . "', baseprice = '" . $baseprice . "', fkcategoryid = '" . $fkcategoryid . "' WHERE pkproductid=" . $id);
            echo jsredirecturl('products.php');
            exit;
        }
    }
}
else
{
    if($id != '')
    {
        $productquery  =   mysqli_query($conn, "SELECT * FROM tblproduct WHERE pkproductid=".$id);
        if(mysqli_num_rows($productquery) > 0)
        {
            $tblproduct   =   mysqli_fetch_assoc($productquery);
            $fkcategoryid = $tblproduct['fkcategoryid'];
            $productname =   $tblproduct['productname'];
            $sealedconditionprice = $tblproduct['sealedconditionprice'];
            $baseprice = $tblproduct['baseprice'];
        }
    }
}
$category = mysqli_query($conn, "SELECT * FROM tblcategory")
?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Manage Products</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Edit Product</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <br>
    <div class="ibox-content m-b-sm border-bottom">
        <form class="m-t" role="form" method="post" action="products_edit.php?id=<?php echo $id; ?>">
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
                        <label class="col-form-label" for="productname">Product Name</label>
                        <input type="text" name="productname" id="productname" class="form-control" placeholder="Enter The Product Name" value="<?php echo $productname; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="fkcategoryid">Product Category</label>
                        <select name="fkcategoryid" id="fkcategoryid" class="form-control">
                            <option value="" class="form-control">Select Product Category</option>
                            <?php
                            if(mysqli_num_rows($category) > 0)
                            {
                                $count =   1;
                                while($row = mysqli_fetch_assoc($category))
                                {
                                    ?>
                                    <option value="<?php echo $row['pkcategoryid']; ?>" <?php if($row['pkcategoryid'] === $fkcategoryid){ echo 'selected'; } ?>><?php echo $row['categoryname']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
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