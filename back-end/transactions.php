<?php

        require 'authenticate.inc.php';
        $response = array();
        $response['success'] = false;
        $response['auth'] = isAuthenticated();
        $response['success'] = true;
        $response['tidD'] = array();
        $response['tidR'] = array();
        if(isset($_SESSION['u_id']))
            {
                //$response['user_name'] = $_SESSION['u_name'];
            require 'require/connection.inc.php';
            
                // $sql_donor = "SELECT `transaction_id`,`user_id_receiver`, `amount`, `have_paid` FROM transaction_details WHERE `user_id_donor` = '{$_SESSION['u_id']}'";
                
                $sql_donor = "SELECT t.transaction_id AS t_id, u.user_name AS receiver, t.amount AS amount, u.user_phone AS phone FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_receiver = u.user_id AND t.user_id_donor = '{$_SESSION['u_id']}' AND t.user_id_receiver IS NOT NULL AND t.have_paid = '1'";
                $res_donor = mysqli_query($connection,$sql_donor);
                //print_r($res_donor);
                $i = 0;
                if($res_donor)
                {
                    while($row = mysqli_fetch_assoc($res_donor)){
                        $response['tidD'][$i]['receiver'] = $row['receiver'];
                        $response['tidD'][$i]['t_id'] = $row['t_id'];
                        $response['tidD'][$i]['amount'] = $row['amount'];
                        // $response['tidD'][$i]['paid'] = $row['have_paid'];
                        $response['tidD'][$i]['phone'] = $row['phone'];    
                        $i = $i+1;
                    }
                }

                // $sql_receiver = "SELECT `transaction_id`, `user_id_donor`, `amount`, `have_paid` FROM transaction_details WHERE `user_id_receiver` = '{$_SESSION['u_id']}'";
                
                $sql_receiver = "SELECT t.transaction_id AS t_id, u.user_name AS donor, t.amount AS amount, u.user_phone AS phone  FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor = u.user_id AND t.user_id_receiver = '{$_SESSION['u_id']}' AND t.have_paid = '1'";
                $res_receiver = mysqli_query($connection, $sql_receiver);
                $j = 0;
                if($res_receiver){
                    while($row = mysqli_fetch_assoc($res_receiver)){
                        $response['tidR'][$j]['donor'] = $row['donor'];
                        $response['tidR'][$j]['t_id'] = $row['t_id'];
                        $response['tidR'][$j]['amount'] = $row['amount'];
                        // $response['tidR'][$j]['paid'] = $row['have_paid'];
                        $response['tidR'][$j]['phone'] = $row['phone']; 
                        $j = $j+1;
                }
            }


                   
                
            }
        echo json_encode($response);
    

?>