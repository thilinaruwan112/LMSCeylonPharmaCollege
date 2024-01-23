<?php
require_once '../../../../include/configuration.php';
include '../../../../php_handler/function_handler.php';
include '../../php_methods/d-pad-methods.php';

$posProducts = GetPOSProductDetailsAll();
?>

<style>
    .inner-pop-content {
        max-height: 60vh;
        border-radius: 10px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 5px;
    }
</style>

<div class="inner-pop-content">

    <div class="row g-2 ">
        <?php
        if (!empty($posProducts)) {
            foreach ($posProducts as $selectedItem) {

                $productImage = $selectedItem['ImagePath'];
                $productName = $selectedItem['ProductName'];
        ?>
                <div class="col-6 col-md-6 d-flex">
                    <div class="card border-0 shadow flex-fill rounded-3 clickable">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-2">
                                    <img src="https://pos.payshia.com/uploads/product_images/<?= $productImage ?>" class="card-image w-100">
                                </div>
                                <div class="col-8 col-md-10">
                                    <h6 class="mb-0 fw-bold"><?= $productName ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

</div>