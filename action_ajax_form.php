<?php
$access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBhOTk5OWE5M2U2N2RjMTQ2ZGQxYTM2YTc4NGM2NDY2MjBiMDg2YWZjOWNhNWQ0NDkyYzI1OTM5MWU1YjRkZjdlY2ZlZTRmODhkZGRjZTg3In0.eyJhdWQiOiI1Njk0YmE2ZC05Y2I4LTQwNzUtODcxMC1lMTM0NDY5ZTA4YjYiLCJqdGkiOiIwYTk5OTlhOTNlNjdkYzE0NmRkMWEzNmE3ODRjNjQ2NjIwYjA4NmFmYzljYTVkNDQ5MmMyNTkzOTFlNWI0ZGY3ZWNmZWU0Zjg4ZGRkY2U4NyIsImlhdCI6MTYzMzM0ODExMSwibmJmIjoxNjMzMzQ4MTExLCJleHAiOjE2MzM0MzQ1MTEsInN1YiI6Ijc0ODY1NTgiLCJhY2NvdW50X2lkIjoyOTcyODc0MSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.i7k5_AI5NuPf7betQJyjF1VS-26arpfN-5OXeg-aXxjEnEd-fTfvDZCzCDcna_ZsUd0CZirug1LmyEEx0lcZzXmhJSss4b2hyQtqUi2DaVP-QWBpMAehoYFO0tZ4_AZsOaNYDuENHVTY3T-ZcLQomaso8WEwnY7OkPIg14-TeXmy0vqDWIDrv5h3XLr8F1jM8WJepQRa6V1ZyyCgC2pzGRMI3eniE-G5HymvE_qdfPsrrcBSEWcyI1F82-12CBZ1W-2JSRCLwIC8va8fUck669PvePWHIj95WBJyZE6xcrIr0CtmfbuSAGSI3Nqyy_aagB4sweuszo0-U2TovwXS3A';
$profile ="ilkaskyrim";
$headers = [
    "Accept: application/json",
    'Authorization: Bearer ' . $access_token
];

if ($_POST['taskOption'] == 'Диагностика') {
    $price = 100;
    $enum_id = 201189;
} else {
    $price = 500;
    $enum_id = 201191;
}


$ComplexData = array(
    [
      "name"=>  $_POST["taskOption"],
      "price"=>  $price,
       "custom_fields_values" => [
      
        [
                     "field_id"=> 408593,
                     "values"=> [
                        [
                           "enum_id"=> $enum_id
                        ]
                     ]
                  ]
         ],
      "_embedded"=> [
         "contacts"=> [
            [
               'name' => $_POST["name"],
               "custom_fields_values" => [
                  [
                     "field_id" => 382619,
                     "values"=> [
                        [
                           "value"=> $_POST["email"]
                        ]
                     ]
                  ],
                  [
                     "field_id"=> 382617,
                     "values"=> [
                        [
                           "value"=> $_POST["phonenumber"]
                        ]
                     ]
                  ],
                   [
                     "field_id"=> 331259,
                     "values"=> [
                        [
                           "value"=> $_POST["city"]
                        ]
                     ]
                  ]
               ]
            ]
         ]
      ]
   ]
   );
$link = "https://". $profile . ".amocrm.ru/api/v4/leads/complex";
//$link = "https://webhook.site/d7da6433-9432-4880-8b2b-27c3014f6382";
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($ComplexData));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$Response=json_decode($out,true);
$ContactID=$Response[0]["contact_id"];
$LeadID=$Response[0]["id"];


//Определение повторная ли заявка
$RepeatLead = $Response[0]["merged"];
$linkTASK = 'https://ilkaskyrim.amocrm.ru/api/v4/tasks';
$linkNOTE = 'https://ilkaskyrim.amocrm.ru/api/v4/leads/' . $LeadID . '/notes';
date_default_timezone_set('Europe/Moscow');

if ($RepeatLead == false){

$entity = array(
    [
        'note_type'=>'common',
        'params'=> array(
            'text'=>$_POST['comment'],
        ),
    ]
);


$curl = curl_init(); //Сохраняем дескриптор сеанса cURL

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
curl_setopt($curl, CURLOPT_URL, $linkNOTE);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($entity));
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$tasks = array(
    array(
        'name' => $_POST['taskOption'],
        'text'=>'Обработать заявку',
        "entity_id"=> $LeadID,
          "entity_type"=> "leads",
        //'date_create'=>1298904164, //optional
        'duration'=>300,
        'complete_till'=> 	time()
    )
);
}
else{
$tasks = array(
    array(
        'name' => $_POST['taskOption'],
        'text'=>'Повторная заявка',
        "entity_id"=> $LeadID,
          "entity_type"=> "leads",
        //'date_create'=>1298904164, //optional
        'duration'=>900,
        'complete_till'=> 	time()
    )
);

}

$curl = curl_init(); //Сохраняем дескриптор сеанса cURL

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
curl_setopt($curl, CURLOPT_URL, $linkTASK);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($tasks));
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);



if (isset($_POST["name"]) && isset($_POST["phonenumber"]) && isset($_POST["city"]) && isset($_POST["email"]) &&
    isset($_POST["taskOption"]) && isset($_POST["comment"]))  { 

	// Формируем массив для JSON ответа
    $result = array(
    	'name' => $_POST["name"],
    	'phonenumber' => $_POST["phonenumber"],
    	'email' => $_POST["email"],
    	'city' => $_POST["city"],
    	'taskOption' => $_POST["taskOption"],
    	'comment' => $_POST["comment"],
    	'contact_id' => $ContactID,
    	'lead_id' =>$LeadID
    	
    ); 


    echo json_encode($result);
}




?>
