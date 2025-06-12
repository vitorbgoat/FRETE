<?php
// arquivo: calcula_frete.php

header('Content-Type: application/json');

$cep_destino = $_GET['cep'] ?? '';
$peso = $_GET['peso'] ?? 0.1; // em kg
$altura = $_GET['altura'] ?? 7; // cm
$largura = $_GET['largura'] ?? 11;
$comprimento = $_GET['comprimento'] ?? 16;

// validação básica
if (!$cep_destino) {
    echo json_encode(['error' => 'CEP não informado']);
    exit;
}

// Montar dados para a API Melhor Envio
// Exemplo: (você vai precisar adaptar conforme a documentação oficial da API Melhor Envio)

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTNjNjIxYWFjNWYxOTIxYzFlMDY3MzcxN2QwY2U3OGY4ZTgyMWJlMWI4YjI3MzNiYjQwMTllZDNjNjJhZDA4MTNiYmZkMmMzODE1YmU1ODEiLCJpYXQiOjE3NDk3NDg5OTIuMjQ2MDQ2LCJuYmYiOjE3NDk3NDg5OTIuMjQ2MDUsImV4cCI6MTc4MTI4NDk5Mi4yMjUyMiwic3ViIjoiNDAxZjJlNDgtZGQ0My00N2YxLTg0ODQtZTBkZDk5YjQ4M2NkIiwic2NvcGVzIjpbImNhcnQtcmVhZCIsImNhcnQtd3JpdGUiLCJjb21wYW5pZXMtcmVhZCIsImNvbXBhbmllcy13cml0ZSIsImNvdXBvbnMtcmVhZCIsImNvdXBvbnMtd3JpdGUiLCJub3RpZmljYXRpb25zLXJlYWQiLCJvcmRlcnMtcmVhZCIsInByb2R1Y3RzLXJlYWQiLCJwcm9kdWN0cy1kZXN0cm95IiwicHJvZHVjdHMtd3JpdGUiLCJwdXJjaGFzZXMtcmVhZCIsInNoaXBwaW5nLWNhbGN1bGF0ZSIsInNoaXBwaW5nLWNhbmNlbCIsInNoaXBwaW5nLWNoZWNrb3V0Iiwic2hpcHBpbmctY29tcGFuaWVzIiwic2hpcHBpbmctZ2VuZXJhdGUiLCJzaGlwcGluZy1wcmV2aWV3Iiwic2hpcHBpbmctcHJpbnQiLCJzaGlwcGluZy1zaGFyZSIsInNoaXBwaW5nLXRyYWNraW5nIiwiZWNvbW1lcmNlLXNoaXBwaW5nIiwidHJhbnNhY3Rpb25zLXJlYWQiLCJ1c2Vycy1yZWFkIiwidXNlcnMtd3JpdGUiLCJ3ZWJob29rcy1yZWFkIiwid2ViaG9va3Mtd3JpdGUiLCJ3ZWJob29rcy1kZWxldGUiLCJ0ZGVhbGVyLXdlYmhvb2siXX0.HhN3ufDbVuHVdtiK3_ZuXrdtiMLGIM2cPlFq6gOLpM0lrxewe18hEaS2sJcFB7dwnIr6TVw293X9Bs6BPpJk8duYcdl5RpU2-uaBBuHa7ox0y-l4EYR1F_0W5nR89B_itUuyFPzYgrcwaneq2rNYzRCka-ldBDoWbHr7y61Z_I-ELlj_8KIAQFDU6YvmI9nWvkSMlPRd9EAkZey1BSwysmK0jjNg1ZzEVU_eJVT2O-cT0s1QHN-kxFZZU1qadg7K6rAU6LGUJcaBbSDW8XPEG079W2O8cQSckbzszhoptyUaH_ZB0M3wjV4_FWyPkQZDPmX7z9IV_ojqstkuRcLuK5Zcw1lCDe-IWx0TqjzVSphP3JpQiS1vweA4xUagGs1vBl91HD8lYoicoRyZrD3DE8sNeX4_0cqNxV-xmlTnTzrcEDdaRLKLnlMnNBerEgQAnsauGCskuoOhmUkq9IKBvc4y7DCWieTYk08fgJok4pCqd_lx670-bAW3f6BS3u3MCLjbwZl9BBM6Ig-n09erIe4NA9IBelerqF5cE1C_28Dx0pDt30oG3_hKITSow9LDRP8GHyT1MSff9SZULME-OgKDvOWljEqZlzDI0Y5xt4IWrORaVbEfBESqMjXJShzTVACVVxMVo7jh2YucFixDrFIVcB36nEGHW1zCUV0f5Uk';

$data = [
    'from' => [
        'postal_code' => '13457074' // CEP de origem da loja
    ],
    'to' => [
        'postal_code' => $cep_destino
    ],
    'products' => [
        [
            'height' => $altura,
            'width' => $largura,
            'length' => $comprimento,
            'weight' => $peso  // Melhor Envio pede em gramas
        ]
    ]
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.melhorenvio.com.br/api/v2/shipment/calculate",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

echo $response;
