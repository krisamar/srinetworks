<?php

return [
    'role' => 
        [ 1 => 'Govt Employee', 2 => 'Private Sector', 3 => 'Business', 4 => 'Kooli', 5 => 'Student', 6 => 'Lawyer', 7 => 'Other'],

    'via_app' => 
        [   
            1 => 'Gpay', 
            2 => 'Phonepe', 
            3 => 'Paytm', 
            4 => 'BHIM UPI', 
            5 => 'IOB App', 
            6 => 'Indian Bank App', 
            7 => 'Yono SBI', 
            8 => 'DigiPay', 
            9 => 'Mobisafar', 
            10 => 'Dhankind',
            11 => 'Net Banking',
            12 => 'SBI Pay'
        ],
        
    'via_bank' => 
        [
            1 => 'SBI CC',
            2 => 'IOB CC',
            3 => 'INDIAN BANK',
            4 => 'SBI SB',
            5 => 'IOB SB', 
            6 => 'ICICI Bank',
            7 => 'Ravi SBI SB',
            8 => 'Ravi IOB SB',
            9 => 'Devi SBI SB'
        ],

    'aeps' => [
        1 => 'Digipay Web',
        2 => 'Dhanhind',
        3 => 'Mobisafer'
    ],

    'paid_details' => [ 0 => 'Paid', 1 => 'Not Paid'],

    'status' => [1 => 'Pending', 2 => 'Return', 3 => 'Success', 4 => 'Others'],

    'type' => [1 => 'New Application', 2 => 'Renewal', 3 => 'Pension', 4 => 'Claim', 5 => 'Life Certificate'],
    
];