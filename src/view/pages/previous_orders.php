<?php $title = 'Athletiq | Previous Orders'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

    <!--Previous orders-->
    <div class="orders">
        <h1>
            Your Order History
        </h1>
    </div>

    <table class="orders-table">
        <div class = "table-headings">
            <thead>
                <tr>
                    <th>Date ordered</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </div>
        <div class="table-content">
            <tbody>
                <tr>
                    <td data-label="Date ordered">04/12/2025</td>
                    <td data-label="Item"><img class="order-image" src="/public/images/productImages/male_hat_visor.png"></td>
                    <td data-label="Description">
                        Athletiq Male Visor
                        <br>Size: S
                        <br>Qty: 1
                    </td>
                    <td data-label="Total">£40</td>
                    <td data-label="Status">Delivered</td>
                    <td data-label="Action"><button class="reorder-button">Re‑Order</button></td>
                </tr>
                <tr>
                    <td data-label="Date ordered">04/12/2025</td>
                    <td data-label="Item"><img class="order-image" src="/public/images/productImages/male_hoodie_zipup.png"></td>
                    <td data-label="Description">
                        Athletiq Male Hoodie
                        <br>Size: M
                        <br>Qty: 2
                    </td>
                    <td data-label="Total">£50</td>
                    <td data-label="Status">Delivered</td>
                    <td data-label="Action"><button class="reorder-button">Re‑Order</button></td>
                </tr>
            </tbody>
        </div>
        
    </table>

    <style>
        
    </style>

    <?php include __DIR__ . '/../templates/footer.php'; ?>