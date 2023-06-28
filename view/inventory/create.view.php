<?php require_once ViewDir . "/template/header.php"; ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="rounded py-3 px-5 shadow">
        <h1 class="text-center fw-bold mb-3">Create Item</h1>
        <div class="d-flex justify-content-end mb-3">
          <a href="<?php echo route("inventory"); ?>" class="btn btn-secondary">
            Inventory
          </a>
        </div>
        <form action="<?php echo route("inventory-store"); ?>" method="post">
          <div class="row justify-content-center align-items-center">
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="text" name="name" value="<?= old("name"); ?>" id="name" placeholder="Enter item name" class="form-control form-control-sm <?php echo hasError("name") ? "is-invalid" : ""; ?>">
                <label for="name">Item Name</label>
                <?php if (hasError("name")) : ?>
                  <div class="invalid-feedback">
                    <?php echo showError("name"); ?>
                  </div>
                <?php endif; ?>
              </div>

            </div>
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="number" name="stock" value="<?= old("stock"); ?>" id="stock" placeholder="Enter stock" class="form-control form-control-sm <?php echo hasError("stock") ? "is-invalid" : ""; ?>" min="1">
                <label for="stock">Stock</label>
                <?php if (hasError("stock")) : ?>
                  <div class="invalid-feedback">
                    <?php echo showError("stock"); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="number" name="price" value="<?= old("price"); ?>" id="price" placeholder="Enter price" class="form-control form-control-sm <?php echo hasError("price") ? "is-invalid" : ""; ?>" min="1">
                <label for="price">Price</label>
                <?php if (hasError("price")) : ?>
                  <div class="invalid-feedback">
                    <?php echo showError("price"); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-lg btn-primary w-100"> Add Item</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once ViewDir . "/template/footer.php"; ?>