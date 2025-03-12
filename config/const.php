<?php

return [
    'role' => 
        [ 1 => 'Govt Employee', 2 => 'Private Sector', 3 => 'Business', 4 => 'Kooli', 5 => 'Student', 6 => 'Lawyer', 7 => 'Other'],

    'via_app' => 
        [   
            1 => 'Gpay', 
            2 => 'Phonepe', 
            3 => 'Paytm', 
            4 => 'SMS Link Wallet', 
            5 => 'IOB App', 
            6 => 'Indian Bank App', 
            7 => 'Yono SBI', 
            8 => 'DigiPay', 
            9 => 'Mobisafar', 
            10 => 'Dhankind'
        ],
        
    'via_bank' => 
        [
            1 => 'Indian Bank',
            2 => 'IOB CC',
            3 => 'IOB SB',
            4 => 'SBI SB'
        ],

    'paid_details' => [ 0 => 'Paid', 1 => 'Not Paid'],

    'status' => [1 => 'Pending', 2 => 'Return', 3 => 'Success', 4 => 'Others'],

    'type' => [1 => 'New Application', 2 => 'Renewal', 3 => 'Pension', 4 => 'Claim'],
    
];