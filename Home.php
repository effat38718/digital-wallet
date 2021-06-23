<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

    <?php

    define("filepath", "data.txt");


    $categoryErr = $phoneNumberErr = $amountErr = "";
    $category = $phoneNumber = $amount = "";
    $rechargeSuccessMessage = $sendmoneySuccessMessage = $merchantSuccessMessage = "";
    $successMessage = $errorMessage ="";
    $flag = false;

    

    if($_SERVER['REQUEST_METHOD'] === "POST"){
            $catgory = $_POST['category'];
            $phoneNumber = $_POST['phoneNumber'];
            $amount = $_POST['amount'];
            if(!empty($category) && $category != "Mobile Recharge" && $category != "Send Money" && $category != "Merchany pay"){
                $error[] = "category not valid";
            }

            if(empty($phoneNumber)) {
                $phoneNumberErr = "Phone number cannot be empty!";
                $flag = true;
            }
            if (empty($amount) || $amount > 0 || $amount == 0){
                $amountErr = "Amount is not valid!";

            }
            if(!$flag){
                $category = test_input($category);
                $phoneNumber = test_input($phoneNumber);
                $amount = test_input($amount);
                $data = $category . "," . $phoneNumber . "," . $amount;
                $result1 = write($data);
                if($result1) {
                    $successMessage = "Transaction successfull.";
                }
                else{
                    $errorMessage = "Error while saving!";
                }

            
        }
    }

    function write($content){
        $resource = fopen(filepath, "a");
        $fw = fwrite($resource, $content."
    \n");
    fclose($resource);
     return $fw;
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>
    <h1>Page 1 [Home]</h1> 
    <h2>Digital Wallet</h2> 

    <p>1. <a href="Home.php">Home</a>
        2. <a href="History.php">Transaction History</a>
    </p> 

    <h2>Fund Transfer:</h2> <br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="category">Select Category: </label>

    <select name="category" id="category">
    <option value="mobileRecharge">Mobile Recharge</option>
    <option value="sendMoney">Send Money</option>
    <option value="merchantPay">Merchant pay</option>
    </select> 
    <span style = "color : red;"><?php echo $categoryErr;?></span><br><br>

    <label for="phoneNumber">To: </label>
    <input type="text" id="phoneNumber" name="phoneNumber">
    <span style = "color : red;"><?php echo $phoneNumberErr;?></span><br><br>
    <label for="amount">Amount: </label>
    <input type="text" id="amount" name="amount">
    <span style = "color : red;"><?php echo $amountErr;?></span><br><br>

    <button type="submit" value="Submit">Submit</button>
    </form>

</body>
</html>