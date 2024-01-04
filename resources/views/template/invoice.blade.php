<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* styles.css */

/* Utility classes */
.bg-white {
    background-color: #fff;
}
.rounded-lg {
    border-radius: 0.5rem;
}
.shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.px-8 {
    padding-left: 2rem;
    padding-right: 2rem;
}
.py-10 {
    padding-top: 2.5rem;
    padding-bottom: 2.5rem;
}
.max-w-xl {
    max-width: 36rem;
}
.mx-auto {
    margin-left: auto;
    margin-right: auto;
}
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.justify-between {
    justify-content: space-between;
}
.mb-8 {
    margin-bottom: 2rem;
}
.text-gray-700 {
    color: #4a5568;
}
.font-semibold {
    font-weight: 600;
}
.text-lg {
    font-size: 1.125rem;
}
.text-xl {
    font-size: 1.25rem;
}
.text-sm {
    font-size: 0.875rem;
}
.font-bold {
    font-weight: 700;
}
.uppercase {
    text-transform: uppercase;
}
.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}
.border-b-2 {
    border-bottom-width: 2px;
}
.border-gray-300 {
    border-color: #e2e8f0;
}
.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}
.text-left {
    text-align: left;
}
.text-center {
    text-align: center;
}
.text-right {
    text-align: right;
}
.flex-end {
    justify-content: flex-end;
}
.font-bold {
    font-weight: 700;
}
.pt-8 {
    padding-top: 2rem;
}
/* Other Tailwind classes can be converted similarly */

    </style>
    <title>Document</title>


</head>

<body>
    <div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <img class="h-8 w-8 mr-2" src="https://tailwindflex.com/public/images/logos/favicon-32x32.png"
                    alt="Logo" />
                <div class="text-gray-700 font-semibold text-lg">Your Company Name</div>
            </div>
            <div class="text-gray-700">
                <div class="font-bold text-xl mb-2">INVOICE</div>
                <div class="text-sm">Date: 01/05/2023</div>
                <div class="text-sm">Invoice #: INV12345</div>
            </div>
        </div>
        <div class="border-b-2 border-gray-300 pb-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
            <div class="text-gray-700 mb-2">John Doe</div>
            <div class="text-gray-700 mb-2">123 Main St.</div>
            <div class="text-gray-700 mb-2">Anytown, USA 12345</div>
            <div class="text-gray-700">johndoe@example.com</div>
        </div>
        <table class="w-full text-left mb-8">
            <thead>
                <tr>
                    <th class="text-gray-700 font-bold uppercase py-2">No</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Product Name</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Price</th>
                    <th class="text-gray-700 font-bold uppercase py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceData as $data)
                    <tr>
                        <td class="py-4 text-gray-700">{{ $loop->index + 1 }} </td>
                        <td class="py-4 text-gray-700">{{ $data->productname }} </td>
                        <td class="py-4 text-gray-700">{{ $data->qty }} </td>
                        <td class="py-4 text-gray-700">$ {{ $data->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end mb-8">
            <div class="text-gray-700 mr-2">Subtotal:</div>
            <div class="text-gray-700">$425.00</div>
        </div>
        <div class="text-right mb-8">
            <div class="text-gray-700 mr-2">Tax:</div>
            <div class="text-gray-700">$25.50</div>

        </div>
        <div class="flex justify-end mb-8">
            <div class="text-gray-700 mr-2">Total:</div>
            <div class="text-gray-700 font-bold text-xl">$450.50</div>
        </div>
        <div class="border-t-2 border-gray-300 pt-8 mb-8">
            <div class="text-gray-700 mb-2">Payment is due within 30 days. Late payments are subject to fees.</div>
            <div class="text-gray-700 mb-2">Please make checks payable to Your Company Name and mail to:</div>
            <div class="text-gray-700">123 Main St., Anytown, USA 12345</div>
        </div>
    </div>
</body>

</html>
