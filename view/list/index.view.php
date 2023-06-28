<?php require_once ViewDir . "/template/header.php"; ?>



<?php if (hasSession()) echo alert(showSessionMessage(), showSessionColor()); ?>


<h1 class=" text-center">Invoice Lists</h1>
<div class="d-flex justify-content-between my-3">
  <a href="<?php echo route("list-create"); ?>" class="btn btn-lg btn-primary">
    <i class=" bi bi-plus-circle"></i>
  </a>
  <form method="get">
    <div class="input-group">
      <input type="text" name="q" value="<?php if (isset($_GET["q"])) : ?> <?php echo filter($_GET["q"], true); ?> <?php endif; ?>" class="form-control" placeholder="Search...">
      <?php if (isset($_GET["q"])) : ?>
        <a href="<?php echo route("list"); ?>" class="btn btn-danger">
          <i class=" bi bi-x-circle"></i>
        </a>
      <?php endif; ?>
      <?php if (!isset($_GET["q"])) : ?>
        <button class="btn btn-primary">
          <i class=" bi bi-search"></i>
        </button>
      <?php endif; ?>
    </div>
  </form>
</div>
<table class="table table-bordered table-striped table-hover align-middle ">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th class=" text-end">Quantity</th>
      <th class=" text-end">Price</th>
      <th class=" text-end">Total</th>
      <th class=" text-center">Option</th>
      <th>Created_at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lists["data"] as $list) : ?>
      <tr>
        <td>
          <?php echo $list['id']; ?>
        </td>
        <td>
          <?php echo $list['name']; ?> 
        </td>
        <td class=" text-end">
          <?php echo $list['qty']; ?>
        </td>
        <td class=" text-end">
          <?php echo $list['price']; ?>
        </td>
        <td class=" text-end">
          <?php echo $list['total']; ?>
        </td>
        <td class=" text-center">
          <a href="<?php echo route("list-edit", ["id" => $list["id"]]); ?>" class="btn btn-sm btn-info">
            <i class="bi bi-pencil-square"></i>
          </a>
          <form action="<?php echo route("list-destroy") ?>" method="post" class=" d-inline-block" onclick="return confirm('Are you sure to delete?')">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="id" value="<?php echo $list["id"] ?>">
            <button class="btn btn-sm btn-danger ms-2">
              <i class="bi bi-trash"></i>
            </button>
          </form>
        </td>
        <td>
          <p class="mb-0">
            <i class="bi bi-calendar-day me-2"></i>
            <?php echo datetimeFormat($list['created_at']); ?>
          </p>
          <p class="mb-0">
            <i class="bi bi-clock me-2"></i>
            <?php echo datetimeFormat($list['created_at'], "g : i : s A"); ?>
          </p>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr class=" text-end fw-bold">
      <td colspan="4">Final Total</td>
      <td>
        <?php
        if ($finalTotal["total"]) {
          echo $finalTotal["total"];
        } else {
          echo "0";
        }
        ?>
      </td>
      <td colspan="2"></td>
    </tr>
  </tfoot>
</table>

<?php echo paginator($lists); ?>


<?php require_once ViewDir . "/template/footer.php"; ?>