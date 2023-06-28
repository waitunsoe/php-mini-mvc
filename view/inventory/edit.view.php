<?php require_once ViewDir . "/template/header.php"; ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="rounded py-3 px-5 shadow">
        <h1 class="text-center fw-bold mb-5">Edit Item</h1>


        <form action="<?php echo route("inventory-update"); ?>" method="post">
          <input type="hidden" name="_method" value="put">
          <input type="hidden" name="id" value="<?php echo $list["id"] ?>">
          <div class="row justify-content-center align-items-center">
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="text" name="name" value="<?php echo $list["name"] ?>" id="name" placeholder="Enter item name" class="form-control form-control-sm" required>
                <label for="name">Item Name</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="number" name="stock" value="<?php echo $list["stock"] ?>" id="stock" placeholder="Enter quantity" class="form-control form-control-sm" min="1" required>
                <label for="stock">Stock</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="number" name="price" value="<?php echo $list["price"] ?>" id="price" placeholder="Enter price" class="form-control form-control-sm" min="1" required>
                <label for="price">Price</label>
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-lg btn-primary w-100"> Update </button>
            </div>
          </div>
        </form>

        <div class="d-flex justify-content-end mt-4">
          <a href="<?php echo route("inventory"); ?>" class="btn btn-secondary">
            Inventory Lists
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<?php require_once ViewDir . "/template/header.php"; ?>