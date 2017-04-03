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
            
                $sql_donor = "SELECT `transaction_id`,`user_id_receiver`, `amount`, `have_paid` FROM transaction_details WHERE `user_id_donor` = '{$_SESSION['u_id']}'";
                $res_donor = mysqli_query($connection,$sql_donor);
                $i = 0;
                if($res_donor)
                {
                    while($row = mysqli_fetch_assoc($res_donor)){
                        $response['tidD'][$i]['receiver'] = $row['user_id_receiver'];
                        $response['tidD'][$i]['t_id'] = $row['transaction_id'];
                        $response['tidD'][$i]['amount'] = $row['amount'];
                        $response['tidD'][$i]['paid'] = $row['have_paid']; 
                        //echo $response['transaction'][$i-1][`paid`].'</br>';
                        $i = $i+1;
                    }
                }

                $sql_receiver = "SELECT `transaction_id`, `user_id_donor`, `amount`, `have_paid` FROM transaction_details WHERE `user_id_receiver` = '{$_SESSION['u_id']}'";
                $res_receiver = mysqli_query($connection, $sql_receiver);
                $j = 0;
                if($res_receiver){
                    while($row = mysqli_fetch_assoc($res_receiver)){
                        $response['tidR'][$j]['donor'] = $row['user_id_donor'];
                        $response['tidR'][$j]['t_id'] = $row['transaction_id'];
                        $response['tidR'][$j]['amount'] = $row['amount'];
                        $response['tidR'][$j]['paid'] = $row['have_paid']; 
                        $j = $j+1;
                }
            }


                   
                
            }
        echo json_encode($response);
    

?>