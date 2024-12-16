<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="https://cdn.tailwindcss.com"></script>
       
    </head>
    <body>
        <form action="{{ route('shipment.store') }}" method="POST" class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
            @csrf
            <h2 class="text-2xl font-semibold text-center mb-8">Shipment Form</h2>
        
            <!-- Shipper Data -->
            <div class="mb-6">
                <label for="shipper_name" class="block text-gray-700 font-medium">Shipper Name</label>
                <input type="text" name="shipper_name" id="shipper_name" value="{{ $payload['shipper_name'] }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <div class="mb-6">
                <label for="shipper_attention_name" class="block text-gray-700 font-medium">Shipper Attention Name</label>
                <input type="text" name="shipper_attention_name" id="shipper_attention_name" value="{{ $payload['shipper_attention_name'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <div class="mb-6">
                <label for="shipper_tax_id" class="block text-gray-700 font-medium">Tax Identification Number</label>
                <input type="text" name="shipper_tax_id" id="shipper_tax_id" value="{{ $payload['shipper_tax_id'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <div class="mb-6">
                <label for="shipper_phone" class="block text-gray-700 font-medium">Phone Number</label>
                <input type="text" name="shipper_phone" id="shipper_phone" value="{{ $payload['shipper_phone'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <!-- ShipTo Data -->
            <div class="mb-6">
                <label for="ship_to_name" class="block text-gray-700 font-medium">Ship To Name</label>
                <input type="text" name="ship_to_name" id="ship_to_name" value="{{ $payload['ship_to_name'] }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <div class="mb-6">
                <label for="ship_to_attention_name" class="block text-gray-700 font-medium">Ship To Attention Name</label>
                <input type="text" name="ship_to_attention_name" id="ship_to_attention_name" value="{{ $payload['ship_to_attention_name'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <div class="mb-6">
                <label for="ship_to_phone" class="block text-gray-700 font-medium">Phone Number</label>
                <input type="text" name="ship_to_phone" id="ship_to_phone" value="{{ $payload['ship_to_phone'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <!-- Payment Information -->
            <div class="mb-6">
                <label for="payment_account_number" class="block text-gray-700 font-medium">Account Number</label>
                <input type="text" name="payment_account_number" id="payment_account_number" value="{{ $payload['payment_account_number'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        
            <!-- Package Details -->
            <div class="mb-6 space-y-4">
                @foreach($payload['packages'] as $package)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <h3 class="font-semibold text-lg mb-4">Package - {{ $loop->iteration }}</h3>
                        <div class="mb-4">
                            <label for="package_description_{{ $loop->iteration }}" class="block text-gray-700 font-medium">Package Description</label>
                            <input type="text" name="package_description[]" id="package_description_{{ $loop->iteration }}" value="{{ $package['description'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
        
                        <div class="grid grid-cols-3 gap-4">
                            <div class="mb-4">
                                <label for="package_weight_{{ $loop->iteration }}" class="block text-gray-700 font-medium">Weight (KG)</label>
                                <input type="text" name="package_weight[]" id="package_weight_{{ $loop->iteration }}" value="{{ $package['weight'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
        
                            <div class="mb-4">
                                <label for="package_length_{{ $loop->iteration }}" class="block text-gray-700 font-medium">Length (CM)</label>
                                <input type="text" name="package_length[]" id="package_length_{{ $loop->iteration }}" value="{{ $package['length'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
        
                            <div class="mb-4">
                                <label for="package_width_{{ $loop->iteration }}" class="block text-gray-700 font-medium">Width (CM)</label>
                                <input type="text" name="package_width[]" id="package_width_{{ $loop->iteration }}" value="{{ $package['width'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
        
                            <div class="mb-4">
                                <label for="package_height_{{ $loop->iteration }}" class="block text-gray-700 font-medium">Height (CM)</label>
                                <input type="text" name="package_height[]" id="package_height_{{ $loop->iteration }}" value="{{ $package['height'] }}" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit Shipment</button>
            </div>
        </form>
        <script>
            // JavaScript to dynamically add more package fields
            document.querySelector('#add-package').addEventListener('click', function() {
                const packageFields = document.querySelector('#package-fields');
                const newPackage = document.createElement('div');
                newPackage.classList.add('package', 'my-6');
                newPackage.innerHTML = `
                    <label for="package_description[]" class="block text-gray-700 font-medium">Package Description</label>
                    <input type="text" name="package_description[]" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <label for="package_weight[]" class="block text-gray-700 font-medium mt-4">Package Weight (kg)</label>
                    <input type="number" name="package_weight[]" step="0.1" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <label for="package_length[]" class="block text-gray-700 font-medium mt-4">Package Length (cm)</label>
                    <input type="number" name="package_length[]" step="1" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <label for="package_width[]" class="block text-gray-700 font-medium mt-4">Package Width (cm)</label>
                    <input type="number" name="package_width[]" step="1" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        
                    <label for="package_height[]" class="block text-gray-700 font-medium mt-4">Package Height (cm)</label>
                    <input type="number" name="package_height[]" step="1" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <hr>
                `;
                packageFields.appendChild(newPackage);
            });
        </script>
    </body>
</html>
