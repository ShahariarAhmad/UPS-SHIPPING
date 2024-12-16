<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Result</title>
</head>
<body>
    <h1>Shipment Labels</h1>
    
    @foreach ($packageResults as $package)
        <div class="package-label">
            <!-- Display Tracking Number -->
            <h3>Tracking Number: {{ $package['TrackingNumber'] }}</h3>

            <!-- Check and display Graphic Image -->
            @if (!empty($package['ShippingLabel']['GraphicImage']))
                <h4>Graphic Image (GIF format):</h4>
                <img src="data:image/gif;base64,{{ $package['ShippingLabel']['GraphicImage'] }}" alt="Shipping Label">
            @else
                <p>No Graphic Image available.</p>
            @endif

       

            <hr>
        </div>
    @endforeach
</body>
</html>
