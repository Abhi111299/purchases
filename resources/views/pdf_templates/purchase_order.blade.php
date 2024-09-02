

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        .header img {
            max-width: 200px;
            height: auto;
        }
        .header .company-details {
            text-align: right;
            font-size: 12px;
        }
        .supplier-details, .po-details, .terms {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .supplier-details th, .supplier-details td, .po-details th, .po-details td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .supplier-details th, .po-details th {
            background-color: #f2f2f2;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .total-section {
            margin-top: 20px;
        }
        .terms {
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <img src="{{ asset('images/pdflogo.png') }}" alt="ARL Logo"> <!-- Replace with actual logo path -->
        </div>
        <div class="company-details">
            <strong>Head Office - Sydney</strong><br>
            145-61 Pine Rd, Yennora NSW 2161<br>
            PO Box 462 Auburn NSW 1835<br>
            Phone: +61 2 9681 1316 & 9632 3077<br>
            <strong>Branch Office - Brisbane</strong><br>
            Unit 11 / 1378 Lytton Rd, (PO Box 7122) Hemmant QLD 4174<br>
        </div>
    </div>

    <table class="supplier-details">
        <tr>
            <th>Supplier Name</th>
            <td>{{ $supplier_name }}</td>
            <th>Purchase Order Number</th>
            <td>{{ $purchase_order_number }}</td>
        </tr>
        <tr>
            <th>Supplier Address</th>
            <td>{{ $supplier_address }}</td>
            <th>Purchase Order Date</th>
            <td>{{ $purchase_order_date }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $email }}</td>
            <th>Delivery Date</th>
            <td>{{ $delivery_date }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $phone }}</td>
            <th>Quotation Number</th>
            <td>{{ $quotation_number }}</td>
        </tr>
        <tr>
            <th>Requested By</th>
            <td>{{ $supplier_name }}</td>
            <th>Approved By</th>
            <td>{{ $supplier_name }}</td>
        </tr>
    </table>

    <table class="items-table" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Sn</th>
            <th>Item</th>
            <th>Item Description</th>
            <th>Quantity</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($consumables as $index => $consumable)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $consumable['item'] }}</td>
            <td>{{ $consumable['description'] ?? 'N/A' }}</td>
            <td>{{ $consumable['quantity'] }}</td>
            <td>${{ number_format($consumable['cost'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    <div class="total-section">
        <table class="supplier-details">
            <tr>
                <th>SUBTOTAL</th>
                <td>{{ $subtotal }}</td>
            </tr>
            <tr>
                <th>SHIPPING & HANDLING</th>
                <td>{{ $shipping }}</td>
            </tr>
            <tr>
                <th>Total without GST</th>
                <td>{{ $total_without_gst }}</td>
            </tr>
            <tr>
                <th>GST (10%)</th>
                <td>{{ $gst }}</td>
            </tr>
            <tr>
                <th>TOTAL</th>
                <td>{{ $total }}</td>
            </tr>
        </table>
    </div>

    <div class="terms">
        <p><strong>Delivery Address:</strong> [Requested By], [Address]</p>
        <h3>PURCHASE ORDER TERMS AND CONDITIONS</h3>
        <p>1. Acceptance of Terms: The supplier's acceptance of this purchase order constitutes acceptance of all terms and conditions stated herein. No terms or conditions other than those stated herein shall apply unless expressly agreed in writing by ARL Laboratory Services Australia.</p>
        <p>2. Price and Payment: The price specified in the purchase order is firm and not subject to escalation. Payment terms are as specified in the purchase order. Payment will be made within [XX] days from receipt of the invoice and satisfactory delivery of goods/services unless otherwise stated.</p>
        <p>3. Delivery: Delivery of goods/services must be completed by the date specified in the purchase order. Time is of the essence. Failure to deliver on time may result in cancellation of the order or other remedies. All deliveries must be accompanied by appropriate shipping documents including the purchase order number.</p>
        <p>4. Inspection and Acceptance: All goods/services are subject to inspection and approval by ARL Laboratory Services Australia upon delivery. If goods/services do not conform to the specifications ARL Laboratory Services Australia reserves the right to reject them and the supplier must at the buyer's option either replace the goods/services or refund the purchase price.</p>
        <p>5. Warranties: The supplier warrants that all goods/services provided will conform to the specifications, drawings, samples, or other descriptions provided by ARL Laboratory Services Australia, will be of good quality and workmanship, and will be free from defects.</p>
        <p>6. Risk of Loss: The risk of loss or damage to goods remains with the supplier until the goods are delivered to and accepted by ARL Laboratory Services Australia.</p>
        <p>7. Indemnification: The supplier shall indemnify and hold harmless ARL Laboratory Services Australia from any claims, damages, losses, or expenses arising out of or resulting from the supplier's performance of the purchase order.</p>
        <p>8. Compliance with Laws: The supplier shall comply with all applicable federal, state, and local laws, rules, and regulations including but not limited to labor laws, environmental laws, and safety regulations.</p>
        <p>9. Confidentiality: The supplier shall treat all information provided by ARL Laboratory Services Australia as confidential and shall not disclose it to any third party without ARL Laboratory Services Australia's prior written consent.</p>
        <p>10. Termination: ARL Laboratory Services Australia reserves the right to terminate the purchase order at any time for convenience with written notice to the supplier. In the event of termination, ARL Laboratory Services Australia's liability shall be limited to payment for goods/services delivered and accepted prior to the termination.</p>
        <p>11. Force Majeure: Neither party shall be liable for delays or failures in performance resulting from acts of God, strikes, acts of war, pandemics, or other causes beyond their reasonable control.</p>
        <p>12. Entire Agreement: This purchase order, together with any documents incorporated herein by reference, constitutes the entire agreement between the parties and supersedes all prior negotiations, agreements, or understandings.</p>
    </div>

</body>
</html>
