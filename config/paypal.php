<?php

return array(
    /** set your paypal credential **/
    //'client_id' =>'AZtQ6HhfAPFrjT1UWu_e4r9aq5VTBWb0Cv8atJaeNpwREwYGBxb_yRpjzL4zsUpQIqv8Wx-P7G6RFAyT',
    'client_id'=>'AcV7LfkL1em-e7-8GU-ksQqR26R_nKydJw41f87LlO7U6g7eARXJ_tt9_jwGda-3Fo0U3kDtOaVlW3ZZ',
   // 'secret' => 'EGBTNrgmjxsiCOy2d2FFkU7vXfdyjCLAtYpYXpcvarA9RmRGuOQ5GuFQyFjN6s043MNvrTSOSydPAgWj',
   'secret'=>'EJHchhO4czvLYv3sH6sLf7f_1hAGv3cbAo4zusv045GKHZjZ0FM_s2r15Be-AyIu0KQPr3AtEDmNdSsU',
    /**
     * SDK configuration
     */
    'settings' => array(
        /** 
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'live',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 1000,
       
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);