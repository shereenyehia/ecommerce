<?php
  session_start();
   //$do = "" ;
   if(isset($_GET['do'])){
       $do = $_GET['do'];
   }else{
      $do = "manage" ;
   }
   ?>
<?php if(isset($_SESSION['USER_NAME'])):?>
<?php include "resources/includes/header.inc"?>
<?php require "config.php"?>
<?php include "resources/includes/navbar.inc"?>
<!-- Start Members CRUD page-->
<?php if($do == "manage"): ?>
<!-- Start all members page -->
<?php
    // Select All From DB
    $stmt= $con->prepare("SELECT * FROM products  WHERE price=100");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    //echo "<pre>";
    //print_r($rows);
    //echo "</pre>";
?>
<div class="container">
    <h1 class="text-center">Products</h1>
    <!-- add member button-->
    <a class="btn btn-primary" href="?do=add">
        <i class="fas fa-user-plus"></i> Add Product
    </a>
    <!--/member button-->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Product Category</th>
                <th scope="col">Price</th>
                <th scope="col">Control</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row):?>
        <tr>
    <!-- php echo => =  -->
            <th scope="row"><?= $row["product_name"]?></th>
            <td><?= $row["product_category"]?></td>
            <td><?= $row["price"]?></td>
            <td>
              <a class="btn btn-secondary" href="?do=show&product_name=<?= $row["product_name"]?>" title="show">
                <i class="fas fa-eye"></i>
              </a>
              <a class="btn btn-warning" href="" title="edit"><i class="fas fa-edit"></i></a>
              <a class="btn btn-danger" href="" title="Delete"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
<?php endforeach?>
        </tbody>
    </table>
</div>
<!--/all members page -->
<?php elseif($do == "add"):?>
<div class="container">
    <h1 class="text-center">Add product</h1>
    <form method="post" action="?do=insert">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name">
        </div>
        <div class="mb-3">
            <label class="form-label">Product Category</label>
            <input type="text" class="form-control" name="product_category">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" name="price">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php elseif($do == "insert"):?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
       $product_name   = $_POST['product_name'] ;
        $product_category   = $_POST['product_category'] ;
        $price  = $_POST['price'] ;

        $stmt= $con->prepare("INSERT INTO users (product_name,product_category,price) VALUES (? , ? , 0)");
        $stmt->execute(array($product_name , $product_category , $price));
        header('location:products.php?do=add');
    }else{
         header("location:products.php");
    }
    ?>

<?php elseif($do == "edit"):?>

<?php elseif($do == "update"):?>

<?php elseif($do == "delete"):?>

<?php elseif($do == "show"): ?>
<?php
        $product_name =  $_GET["product_name"] ;
        $stmt= $con->prepare("SELECT * FROM products WHERE product_name = ?");
        $stmt->execute(array($product_name));
        $row = $stmt->fetch();

        echo "<pre>";
        print_r($row);
        echo "</pre>";
     ?>
<a href="products.php" class="btn btn-dark">Back</a>
<?php endif?>

<?php include "resources/includes/footer.inc"?>
 <!-- End Members CRUD page-->
<?php else:?>
<?php header("location:index.php")?>
<?php endif?>
