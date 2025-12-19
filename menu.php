<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Dessert Shop Premium</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #F44336; /* Light red */
      --secondary-color: #3b0400; /* Dark maroon */
      --accent-color: #e0aaff;
      --bg-color: #3b0a0a;
      --card-bg: #e2d6d6;
      --text-dark: #333;
      --text-light: #e2d954;
      --shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg-color);
      margin: 0;
      padding: 40px;
      display: flex;
      gap: 30px;
      min-height: 100vh;
      box-sizing: border-box;
    }

    /* --- LEFT PANEL (MENU) --- */
    .left-panel {
      flex: 3; 
    }

    h2 {
      font-size: 40px;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 5px;
      margin-top: 0;
    }

    .subtitle {
      color: var(--text-light);
      margin-bottom: 25px;
      font-size: 18px;
    }

    .menu-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr); 
      gap: 20px;
    }

    @media (max-width: 1200px) {
        .menu-container {
            grid-template-columns: repeat(2, 1fr); 
        }
    }

    .item-card {
      background: var(--card-bg);
      border-radius: 15px;
      padding: 15px;
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      border: 1px solid transparent;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .item-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(106, 13, 173, 0.2);
      border-color: var(--accent-color);
    }

    .item-img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 12px;
    }

    .name {
      font-weight: 600;
      font-size: 16px;
      color: var(--text-dark);
      margin-bottom: 5px;
      text-align: center;
      line-height: 1.2;
    }

    .price {
      font-size: 16px;
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 12px;
    }

    /* Styled Quantity Input */
    .input-group {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
    }

    .input-box {
      width: 100%;
      padding: 8px;
      border-radius: 10px;
      border: 2px solid #eee;
      font-size: 15px;
      text-align: center;
      font-family: 'Poppins', sans-serif;
      transition: 0.2s;
      outline: none;
      /* RESTORED: Spin buttons (arrows) are now visible */
    }

    .input-box:focus {
      border-color: var(--secondary-color);
      background: #fbf6ff;
    }

    /* --- RIGHT PANEL (BILL) --- */
    .right-panel {
      flex: 1; 
      background: var(--card-bg);
      border-radius: 25px;
      padding: 25px;
      box-shadow: var(--shadow);
      height: fit-content;
      position: sticky;
      top: 162px;
      display: flex;
      flex-direction: column;
    }

    .right-panel h3 {
      margin-top: 0;
      color: #e52222;
      font-size: 22px;
      border-bottom: 2px dashed #ddd;
      padding-bottom: 15px;
      margin-bottom: 15px;
    }

    /* Live Items List Styling */
    #summary-items {
      min-height: 100px;
      max-height: 400px;
      overflow-y: auto;
      margin-bottom: 20px;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 15px;
      color: #555;
    }
    
    .summary-item strong {
      color: #333;
    }

    /* Totals Section */
    .totals-section {
      border-top: 2px dashed #ddd;
      padding-top: 15px;
    }

    .summary-line {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      font-size: 14px;
      color: #666;
    }

    .summary-total {
      display: flex;
      justify-content: space-between;
      font-size: 20px;
      font-weight: 700;
      color: var(--primary-color);
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #eee;
    }

    /* --- PROFESSIONAL TOGGLE SWITCH --- */
    .discount-wrapper {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: white;
      padding: 12px;
      border-radius: 12px;
      margin-top: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .discount-label {
      font-size: 14px;
      font-weight: 600;
      color: #444;
    }

    /* The Switch Container */
    .switch {
      position: relative;
      display: inline-block;
      width: 46px;
      height: 24px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The Slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: var(--primary-color);
    }

    input:checked + .slider:before {
      transform: translateX(22px);
    }

    /* Order Button */
    .order-btn {
      margin-top: 15px;
      width: 100%;
      padding: 15px;
      font-size: 16px;
      font-weight: 600;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: 0 10px 20px rgba(106, 13, 173, 0.3);
      letter-spacing: 1px;
    }

    .order-btn:hover {
      transform: scale(1.02);
      box-shadow: 0 15px 25px rgba(106, 13, 173, 0.4);
    }
    
    #summary-items::-webkit-scrollbar { width: 6px; }
    #summary-items::-webkit-scrollbar-track { background: #f1f1f1; }
    #summary-items::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

  </style>

</head>
<body>

<div class="left-panel">
  <div style="margin-bottom: 30px;">
    <h2>THE DESSERT SHOP</h2>
    <div class="subtitle">Select your sweet cravings below</div>
  </div>

  <?php
    $price1 = 8.00; $price2 = 9.00; $price3 = 6.00; $price4 = 3.00;
    $price5 = 5.00; $price6 = 7.00; $price7 = 4.00; $price8 = 10.00;
  ?>

  <form action="cart.php" method="post">
    <div class="menu-container">

      <div class="item-card">
        <img src="ChocolateCake.jpg" class="item-img">
        <div class="name">Chocolate Cake</div>
        <div class="price">RM<?= number_format($price1,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty1" data-price="<?= $price1 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Cheesecake.jpg" class="item-img">
        <div class="name">Cheesecake</div>
        <div class="price">RM<?= number_format($price2,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty2" data-price="<?= $price2 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Brownie.jpg" class="item-img">
        <div class="name">Brownie</div>
        <div class="price">RM<?= number_format($price3,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty3" data-price="<?= $price3 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Donut.jpg" class="item-img">
        <div class="name">Donut</div>
        <div class="price">RM<?= number_format($price4,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty4" data-price="<?= $price4 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="IceCream.jpg" class="item-img">
        <div class="name">Ice Cream</div>
        <div class="price">RM<?= number_format($price5,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty5" data-price="<?= $price5 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Waffle.jpg" class="item-img">
        <div class="name">Waffle</div>
        <div class="price">RM<?= number_format($price6,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty6" data-price="<?= $price6 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Cupcake.jpg" class="item-img">
        <div class="name">Cupcake</div>
        <div class="price">RM<?= number_format($price7,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty7" data-price="<?= $price7 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

      <div class="item-card">
        <img src="Milkshake.jpg" class="item-img">
        <div class="name">Milkshake</div>
        <div class="price">RM<?= number_format($price8,2) ?></div>
        <div class="input-group">
          <input class="input-box qty-box" type="number" name="qty8" data-price="<?= $price8 ?>" min="0" step="1" value="0" placeholder="0">
        </div>
      </div>

    </div>

    <div class="discount-wrapper" style="width: fit-content; margin-left: auto; background: transparent; box-shadow: none;">
       </div>
    
    <button class="order-btn" name="submit_button" type="submit" style="display:none;">Hidden Real Submit</button> 
    </form>
</div>


<div class="right-panel">
  <h3>ORDER SUMMARY</h3>

  <div id="summary-items">
    <div style="text-align:center; color:#aaa; margin-top:20px;">Cart is empty</div>
  </div>

  <div class="totals-section">
    <div class="summary-line"><span>Subtotal</span><span id="subtotal">RM0.00</span></div>
    
    <div class="discount-wrapper" style="margin: 10px 5px; padding: 10px 5px; box-shadow: none; border-bottom: 1px dashed #eee;">
      <span class="discount-label">Late Evening 50%</span>
      <label class="switch">
        <input type="checkbox" id="visualDiscountToggle">
        <span class="slider"></span>
      </label>
    </div>

    <div class="summary-line" style="color: #e63946;"><span>Discount</span><span id="discount">- RM0.00</span></div>
    <div class="summary-line"><span>SST (6%)</span><span id="sst">RM0.00</span></div>

    <div class="summary-total">
      <span>Total</span>
      <span id="grandtotal">RM0.00</span>
    </div>
  </div>

  <button class="order-btn" onclick="document.querySelector('form').submit()">Confirm Order</button>
</div>


<script>
// We need to link the Visual Toggle to the Real Form Data
// 1. Create a hidden input in the form
const form = document.querySelector('form');
const hiddenDiscountInput = document.createElement('input');
hiddenDiscountInput.type = 'hidden';
hiddenDiscountInput.name = 'discount';
hiddenDiscountInput.value = '0';
form.appendChild(hiddenDiscountInput);

// 2. Visual Toggle Listener
document.getElementById('visualDiscountToggle').addEventListener('change', function() {
  hiddenDiscountInput.value = this.checked ? '1' : '0';
  updateSummary();
});

// 3. Summary Logic
function updateSummary() {
  let qtyInputs = document.querySelectorAll(".qty-box");
  let summaryItems = document.getElementById("summary-items");
  let subtotal = 0;
  
  // Clear current list
  let htmlContent = "";

  qtyInputs.forEach((input) => {
    let qty = parseInt(input.value) || 0;
    let price = parseFloat(input.dataset.price);
    let amount = qty * price;

    if (qty > 0) {
      let name = input.closest('.item-card').querySelector(".name").textContent;
      
      // New HTML structure for list items
      htmlContent += `
        <div class="summary-item">
          <span><strong>${qty}x</strong> ${name}</span>
          <span>RM${amount.toFixed(2)}</span>
        </div>
      `;
    }

    subtotal += amount;
  });

  // If empty
  if (htmlContent === "") {
    summaryItems.innerHTML = '<div style="text-align:center; color:#aaa; margin-top:20px;">Cart is empty</div>';
  } else {
    summaryItems.innerHTML = htmlContent;
  }

  // Calculation Logic
  let discountApplied = document.getElementById("visualDiscountToggle").checked;
  let discount = discountApplied ? subtotal * 0.5 : 0;
  let afterDiscount = subtotal - discount;
  let sst = afterDiscount * 0.06;
  let grandTotal = afterDiscount + sst;

  // Update Text
  document.getElementById("subtotal").textContent = "RM" + subtotal.toFixed(2);
  document.getElementById("discount").textContent = "- RM" + discount.toFixed(2);
  document.getElementById("sst").textContent = "RM" + sst.toFixed(2);
  document.getElementById("grandtotal").textContent = "RM" + grandTotal.toFixed(2);
}

// --- STRICT TYPING ENFORCEMENT ---
document.querySelectorAll(".qty-box").forEach(input => {
  
  // 1. Block invalid keys on keydown (-, +, e, E, .)
  input.addEventListener("keydown", function(e) {
    // Allow: backspace, delete, tab, escape, enter, arrows
    if ([46, 8, 9, 27, 13, 38, 40, 37, 39].indexOf(e.keyCode) !== -1) {
         return;
    }
    // Allow: Ctrl+A, Ctrl+C, Ctrl+V
    if ((e.ctrlKey === true || e.metaKey === true) && (e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 86)) {
         return;
    }
    
    // BLOCK: - (minus), . (dot), + (plus), e (exponent)
    if (e.key === 'e' || e.key === 'E' || e.key === '-' || e.key === '+' || e.key === '.') {
        e.preventDefault();
    }
  });

  // 2. Update summary on input
  input.addEventListener("input", updateSummary);
});
</script>

</body>
</html>
