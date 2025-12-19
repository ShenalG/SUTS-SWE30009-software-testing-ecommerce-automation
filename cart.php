<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #F44336; 
            --secondary-color: #3b0400;
            --bg-color: #3b0a0a;
            --card-bg: #e2d6d6;
            --text-dark: #333;
            --text-light: #777;
            --success: #28a745;
            --danger: #e63946;
        }

        body {
            background: var(--bg-color);
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .receipt-container {
            width: 100%;
            /* CHANGED: Much smaller width for a realistic receipt look */
            max-width: 380px; 
            background: var(--card-bg);
            border-radius: 15px;
            /* CHANGED: Reduced padding */
            padding: 30px 25px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .receipt-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .shop-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .shop-name {
            font-size: 24px; /* Smaller title */
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1.1;
        }

        .shop-details {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 5px;
        }

        /* Info Box */
        .info-box {
            background: #a62b2b1a;
            border-radius: 8px;
            padding: 8px 12px; /* Compact padding */
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 12px; /* Smaller font */
            color: #555;
        }

        .info-box strong {
            color: var(--text-dark);
            display: block;
            margin-bottom: 2px;
        }

        /* Table Styling */
        .table-header {
            display: grid;
            grid-template-columns: 2fr 0.8fr 0.6fr 1fr; /* Adjusted columns */
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            color: #888;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 2fr 0.8fr 0.6fr 1fr;
            font-size: 13px; /* Compact font */
            color: var(--text-dark);
            margin-bottom: 10px;
            align-items: center;
        }

        .item-name { font-weight: 500; font-size: 13px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .dashed-line {
            border-bottom: 1px dashed #bbb;
            margin: 15px 0;
        }

        /* Totals */
        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 13px;
            color: #555;
        }

        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px; /* Smaller total */
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #ccc;
        }

        .thank-you {
            text-align: center;
            margin-top: 25px;
            color: var(--secondary-color);
            font-weight: 500;
            font-size: 12px;
            font-style: italic;
        }

        /* Buttons */
        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px; /* Smaller button padding */
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            text-decoration: none;
        }

        .btn-print {
            background: var(--primary-color);
            color: white;
        }
        .btn-print:hover { background: #3b0400; }

        .btn-back {
            background: #fff;
            border: 1px solid #ccc;
            color: #444;
        }
        .btn-back:hover { background: #eee; }

        .status-badge {
            display: inline-block;
            background: #e6f9e9;
            color: var(--success);
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 8px;
        }

        @media print {
            body { background: white; padding: 0; }
            .receipt-container { box-shadow: none; border: none; width: 100%; max-width: 100%; }
            .actions { display: none !important; }
        }
    </style>
</head>

<body>

<div class="receipt-container">

    <div class="shop-header">
        <div class="shop-name">THE DESSERT SHOP</div>
        <div class="shop-details">Kuching, Sarawak</div>
        <div class="status-badge">PAID</div>
    </div>

    <?php
    /*
        date_default_timezone_set("Asia/Kuala_Lumpur");
        
        $price1=8.00;  $price2=9.00;  $price3=6.00;  $price4=3.00;
        $price5=5.00;  $price6=7.00;  $price7=4.00;  $price8=10.00;

        $q1 = (int)$_POST['qty1']; $q2 = (int)$_POST['qty2'];
        $q3 = (int)$_POST['qty3']; $q4 = (int)$_POST['qty4'];
        $q5 = (int)$_POST['qty5']; $q6 = (int)$_POST['qty6'];
        $q7 = (int)$_POST['qty7']; $q8 = (int)$_POST['qty8'];

        $subtotal1 = $price1*$q1;  $subtotal2 = $price2*$q2;
        $subtotal3 = $price3*$q3;  $subtotal4 = $price4*$q4;
        $subtotal5 = $price5*$q5;  $subtotal6 = $price6*$q6;
        $subtotal7 = $price7*$q7;  $subtotal8 = $price8*$q8;

        $grand_subtotal = $subtotal1 + $subtotal2 + $subtotal3 + $subtotal4 + 
                          $subtotal5 + $subtotal6 + $subtotal7 + $subtotal8;

        $discount_amount = (isset($_POST['discount']) && $_POST['discount'] == '1') ? $grand_subtotal * 0.5 : 0;
        $after_discount = $grand_subtotal - $discount_amount;
        $sst = $after_discount * 0.06;
        $total = $after_discount + $sst;
        */
    ?>

    <?php
        date_default_timezone_set("Asia/Kuala_Lumpur");
        
        $price1=8.00;  $price2=9.00;  $price3=6.00;  $price4=3.00;
        $price5=5.00;  $price6=7.00;  $price7=4.00;  $price8=10.00;

        // FIXED: Use '?? 0' (Null Coalescing Operator). 
        // This means "if the value exists, take it; otherwise, use 0".
        /*
        $q1 = (int)($_POST['qty1'] ?? 0); 
        $q2 = (int)($_POST['qty2'] ?? 0);
        $q3 = (int)($_POST['qty3'] ?? 0); 
        $q4 = (int)($_POST['qty4'] ?? 0);
        $q5 = (int)($_POST['qty5'] ?? 0); 
        $q6 = (int)($_POST['qty6'] ?? 0);
        $q7 = (int)($_POST['qty7'] ?? 0); 
        $q8 = (int)($_POST['qty8'] ?? 0);*/

        $q1 = max(0, (int)($_POST['qty1'] ?? 0)); 
        $q2 = max(0, (int)($_POST['qty2'] ?? 0));
        $q3 = max(0, (int)($_POST['qty3'] ?? 0)); 
        $q4 = max(0, (int)($_POST['qty4'] ?? 0));
        $q5 = max(0, (int)($_POST['qty5'] ?? 0)); 
        $q6 = max(0, (int)($_POST['qty6'] ?? 0));
        $q7 = max(0, (int)($_POST['qty7'] ?? 0)); 
        $q8 = max(0, (int)($_POST['qty8'] ?? 0));

        $subtotal1 = $price1*$q1;  $subtotal2 = $price2*$q2;
        $subtotal3 = $price3*$q3;  $subtotal4 = $price4*$q4;
        $subtotal5 = $price5*$q5;  $subtotal6 = $price6*$q6;
        $subtotal7 = $price7*$q7;  $subtotal8 = $price8*$q8;

        $grand_subtotal = $subtotal1 + $subtotal2 + $subtotal3 + $subtotal4 + 
                          $subtotal5 + $subtotal6 + $subtotal7 + $subtotal8;

        // Check if discount is set, otherwise default to 0
        $discount_amount = (isset($_POST['discount']) && $_POST['discount'] == '1') ? $grand_subtotal * 0.5 : 0;
        
        $after_discount = $grand_subtotal - $discount_amount;
        $sst = $after_discount * 0.06;
        $total = $after_discount + $sst;
    ?>

    <div class="info-box">
        <div><strong>Date:</strong> <?= date("d/m/Y") ?></div>
        <div><strong>Time:</strong> <?= date("H:i") ?></div>
    </div>

    <div class="table-header">
        <span>Item</span>
        <span class="text-center">Price</span>
        <span class="text-center">Qty</span>
        <span class="text-right">Amt</span>
    </div>

    <?php
    $items = [
        ["Choco Cake", $price1, $q1, $subtotal1], // Shortened names for small receipt
        ["Cheesecake", $price2, $q2, $subtotal2],
        ["Brownie", $price3, $q3, $subtotal3],
        ["Donut", $price4, $q4, $subtotal4],
        ["Ice Cream", $price5, $q5, $subtotal5],
        ["Waffle", $price6, $q6, $subtotal6],
        ["Cupcake", $price7, $q7, $subtotal7],
        ["Milkshake", $price8, $q8, $subtotal8]
    ];

    $ordered_any = false;

    foreach ($items as $it) {
        list($name, $rate, $qty, $sub) = $it;
        if ($qty > 0) {
            $ordered_any = true;
            ?>
            <div class="item-row">
                <span class="item-name"><?= $name ?></span>
                <span class="text-center"><?= number_format($rate,2) ?></span>
                <span class="text-center"><?= $qty ?></span>
                <span class="text-right"><?= number_format($sub,2) ?></span>
            </div>
            <?php
        }
    }

    if (!$ordered_any) {
        echo "<div style='text-align:center; padding:10px; color:#aaa; font-size:12px; font-style:italic;'>No items.</div>";
    }
    ?>

    <div class="dashed-line"></div>

    <div class="totals-row">
        <span>Subtotal</span>
        <strong><?= number_format($grand_subtotal,2) ?></strong>
    </div>

    <div class="totals-row">
        <span>Discount</span>
        <span style="color: var(--danger);">
            <?= $discount_amount > 0 ? "-".number_format($discount_amount,2) : "0.00" ?>
        </span>
    </div>

    <div class="totals-row">
        <span>SST (6%)</span>
        <span><?= number_format($sst,2) ?></span>
    </div>

    <div class="final-total">
        <span>Total</span>
        <span>RM <?= number_format($total, 2) ?></span>
    </div>

    <div class="thank-you">
        Thank you! Please come again.
    </div>

    <div class="actions">
        <a href="menu.php" class="btn btn-back">Back</a>
        <button class="btn btn-print" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
