<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaiementProService
{
    public function initPayment(array $data)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://www.paiementpro.net/webservice/onlinepayment/init/curl-init.php', [
            'merchantId' => config('paiementpro.merchant_id'),
            'amount' => $data['amount'],
            'description' => $data['description'],
            'channel' => $data['channel'],
            'countryCurrencyCode' => '952',
            'referenceNumber' => $data['referenceNumber'],
            'customerEmail' => $data['email'],
            'customerFirstName' => $data['first_name'],
            'customerLastname' => $data['last_name'],
            'customerPhoneNumber' => $data['phone'],
            'notificationURL' => config('paiementpro.notification_url'),
            'returnURL' => config('paiementpro.return_url'),
            'returnContext' => json_encode($data['context']),
        ]);

        return $response->json();
    }
}