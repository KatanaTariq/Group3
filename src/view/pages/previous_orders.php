<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Orders</title>
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
</head>

<body>

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
                    <td data-label="Item"><img class="order-image" src="images/male_hat_visor.png"></td>
                    <td data-label="Description">
                        Athletiq male visor
                        <br>Size: S
                        <br>Qty: 1
                    </td>
                    <td data-label="Total">£40</td>
                    <td data-label="Status">Delivered</td>
                    <td data-label="Action"><button class="reorder-button">Re‑Order</button></td>
                </tr>
                <tr>
                    <td data-label="Date ordered">04/12/2025</td>
                    <td data-label="Item"><img class="order-image" src="images/male_hoodie_zipup.png"></td>
                    <td data-label="Description">
                        Athletiq male hoodie
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
        :root{
            --primary: #A8D5BA;
            --white: #fff;
            --grey: #e0e0e0;
            --black: #000;
        }

        body{
            font-family:Arial, Helvetica, sans-serif ;
        }

        .orders-table {
            align-items: center;
            background-color: var(--white);
            margin: 50px auto;
            margin-bottom: 50px;           
            border-collapse: collapse;
            box-shadow: 2px 2px 15px #c5c5c5;
            width: 80%;
        }
        .orders-table th{
            padding: 12px;
            text-align: center; 
            background: var(--primary);
            color: #fff;
        }
        .orders-table td{
            padding: 12px;
            text-align: center;
            border-bottom: 2px solid #dedede;
        }
        .orders-table tr:hover {
            background: #f0f0f0;
        }
        .order-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
        }
        .reorder-button{
            width: 100px;
            height: 30px;
            background-color: var(--primary)  ;
            color: var(--black);
            margin-top: 25px;
            margin-bottom: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            transition: all 0.3s ease ;
        }
        .reorder-button:hover{
            background: #8CCAA0;
            color: #ffffff;
        }
    </style>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    
</body>
</html>