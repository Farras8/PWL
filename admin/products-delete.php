<?php
 
 require '../config/function.php';

 $paramResultId = checkParamId('id');
 if(is_numeric($paramResultId)){

    $productId = validate($paramResultId);

    $product = getById('products', $productId);

    if($product['status'] == 200){
        $response = delete('products', $productId);
        if($response){
            redirect('products.php','Delete Product Success');
        }else{
            redirect('products.php','Delete Product Fail');
        }
    }else{
        redirect('products.php',$product['message']);
    }
 }else{
    redirect('products.php','Something Went Wrong');
 }
?>