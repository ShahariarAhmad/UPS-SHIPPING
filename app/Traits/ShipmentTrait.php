<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ShipmentTrait
{
    
    public function getOAuthToken()
    {
        // Check if token exists in session and is still valid
        if (session()->has('ups_oauth_token') && session()->has('ups_token_expiry')) {
            $expiryTime = session('ups_token_expiry');
            if (now()->lessThan($expiryTime)) {
                // Return the token from the session
                return session('ups_oauth_token');
            }
        }

        // Get credentials from .env
        $clientId = env('UPS_CLIENT_ID');
        $clientSecret = env('UPS_CLIENT_SECRET');

        // Encode client_id:client_secret into base64
        $credentials = base64_encode($clientId . ':' . $clientSecret);

        // Make the request to UPS to get the OAuth2 token
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials, // Add Authorization header
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'x-merchant-id' => $clientId, // Your client ID as x-merchant-id
        ])->asForm()->post(env('UPS_TOKEN_URL'), [
            'grant_type' => 'client_credentials',
        ]);

        // Check if token was successfully retrieved
        if ($response->successful()) {
            $accessToken = $response->json()['access_token'];
            $expiresIn = (int) $response->json()['expires_in']; // Cast expires_in to an integer

            // Calculate expiry time
            $expiryTime = now()->addSeconds($expiresIn);

            // Store token and expiry in session
            session([
                'ups_oauth_token' => $accessToken,
                'ups_token_expiry' => $expiryTime,
            ]);

            return $accessToken;
        }

        // Log the full response for debugging
        Log::error('UPS OAuth2 Token Request Failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        // Return the raw error message for further investigation
        return response($response->body(), $response->status());
    }






    public function createShipment()
    {
        // Shipper Information
        $shipperName = "ShipperName";
        $shipperAttentionName = "Shipper Attention";
        $shipperTaxIdentificationNumber = "123456";
        $shipperPhoneNumber = "1234567890";
        $shipperShipperNumber = "9511F5";
        $shipperAddressLine = ["123 Shipper St"];
        $shipperCity = "Louth";
        $shipperStateProvinceCode = "ST";
        $shipperPostalCode = "LN110FU";
        $shipperCountryCode = "GB";

        // ShipTo Information
        $shipToName = "Parker Products Limited";
        $shipToAttentionName = "Receiver Attention";
        $shipToPhoneNumber = "+44 7872 379015";
        $shipToAddressLine = ["Richmond Park", "Richmond Road"];
        $shipToCity = "Louth";
        $shipToStateProvinceCode = "";  // Leave empty for UK
        $shipToPostalCode = "LN110FU";
        $shipToCountryCode = "GB";  // United Kingdom

        // Payment Information
        $shipmentChargeType = "01";
        $billShipperAccountNumber = "9511F5";

        // Service Information
        $serviceCode = "11";  // UPS Ground
        $serviceDescription = "Ground Service";


     
        // Get the OAuth2 token
        $accessToken = $this->getOAuthToken();
        // If token retrieval failed, return the error response
        if (isset($accessToken['error'])) {
            return response()->json($accessToken, 500); // Handle the token error
        }
        $package1 = [
            "Description" => "Package 00012",  
            "Packaging" => [
                "Code" => "02",  
                "Description" => "Custom Box"  
            ],
            "Dimensions" => [
                "UnitOfMeasurement" => [
                    "Code" => "CM",  
                    "Description" => "Centimeters"  
                ],
                "Length" => '10',  
                "Width" => '10',   
                "Height" => '10'   
            ],
            "PackageWeight" => [
                "UnitOfMeasurement" => [
                    "Code" => "KGS",  
                    "Description" => "Kilograms"  
                ],
                "Weight" => '5'  
            ]
        ];

        $package2 = [
            "Description" => "Package 0062",  
            "Packaging" => [
                "Code" => "02",  
                "Description" => "Custom Box"  
            ],
            "Dimensions" => [
                "UnitOfMeasurement" => [
                    "Code" => "CM",  
                    "Description" => "Centimeters"  
                ],
                "Length" => '12',  
                "Width" => '8',    
                "Height" => '6'    
            ],
            "PackageWeight" => [
                "UnitOfMeasurement" => [
                    "Code" => "KGS",  
                    "Description" => "Kilograms"  
                ],
                "Weight" => '6'  
            ]
        ];

        // Now, put all packages into an array
        $packages = [$package1, $package2];
        // When using real form data, comment out the code above and replace it with the line below to use the provided request data.
        // $packages = $request->toArray();


        // Prepare the shipment data for UPS API


        $shipmentData = [
            "ShipmentRequest" => [
                "Request" => [
                    "SubVersion" => "1801",
                    "RequestOption" => "nonvalidate",
                    "TransactionReference" => [
                        "CustomerContext" => "ShipmentRequest"
                    ]
                ],
                "Shipment" => [
                    "Description" => "Ship WS test",
                    "Shipper" => [
                        "Name" => $shipperName,
                        "AttentionName" => $shipperAttentionName,
                        "TaxIdentificationNumber" => $shipperTaxIdentificationNumber,
                        "Phone" => [
                            "Number" => $shipperPhoneNumber
                        ],
                        "ShipperNumber" => $shipperShipperNumber,
                        "Address" => [
                            "AddressLine" => $shipperAddressLine,
                            "City" => $shipperCity,
                            "StateProvinceCode" => $shipperStateProvinceCode,
                            "PostalCode" => $shipperPostalCode,
                            "CountryCode" => $shipperCountryCode
                        ]
                    ],
                    "ShipTo" => [
                        "Name" => $shipToName,
                        "AttentionName" => $shipToAttentionName,
                        "Phone" => [
                            "Number" => $shipToPhoneNumber
                        ],
                        "Address" => [
                            "AddressLine" => $shipToAddressLine,
                            "City" => $shipToCity,
                            "StateProvinceCode" => $shipToStateProvinceCode,
                            "PostalCode" => $shipToPostalCode,
                            "CountryCode" => $shipToCountryCode
                        ]
                    ],
                    "PaymentInformation" => [
                        "ShipmentCharge" => [
                            "Type" => $shipmentChargeType,
                            "BillShipper" => [
                                "AccountNumber" => $billShipperAccountNumber
                            ]
                        ]
                    ],
                    "Service" => [
                        "Code" => $serviceCode,
                        "Description" => $serviceDescription
                    ],
                    "Package" => $packages
                ]
            ]
        ];


        // Send the shipment creation request to UPS API with the OAuth token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'x-merchant-id' => env('UPS_CLIENT_ID')  // Add the merchant ID header
        ])->post(env('UPS_API_URL'), $shipmentData);

        // Check if the shipment creation was successful
        if ($response->successful()) {
            return $this->handleShipmentResponse($response->json());
        } else {

            return response()->json(['error' => 'Error creating shipment: ' . $response->body()], 500);
        }
    }


    public function handleShipmentResponse($response)
    {

        $packageResults = $response['ShipmentResponse']['ShipmentResults']['PackageResults'];

        // Store this $packageResults data into a database table column. For following best practice use a json column. As MySql and laravel both support running queries on json column 

        return $packageResults;
        // To see how to view label image of each packages visit the view file. Lable images are also downloadable
        return view('trackingNumber', compact('packageResults'));
    }
}
