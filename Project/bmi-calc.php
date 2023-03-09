<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/bmi.css">

    <title>Fitness and lifestyle BMI Calculator</title>
</head>

<body>
    <?php 
        include_once 'common/_navbar.php';
    ?>

    <h1 style="text-align: center" ;>BMI Calculator:</h1>

    <div class="bmi">
<!-- Recieving info from user -->
        <form method="post"> 
            HEIGHT(cm): <input type="number" name="height"><br>
            WEIGHT(kg): <input type="number" name="weight"><br>
            <input type="submit" name="submit" />
        </form>

        <div class="bmi-response">
            <?php
            if(isset($_POST['submit']))
            {
                $weight=$_POST['weight'];
                $height=$_POST['height'];
                // Injecting the user's info in the API to recieve the bmi for the specific details.
                $curl = curl_init();
                $url = 'https://body-mass-index-bmi-calculator.p.rapidapi.com/metric?weight='.$weight.'&height='.($height/100);
                
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: body-mass-index-bmi-calculator.p.rapidapi.com",
                        "X-RapidAPI-Key: a714a26822msh083aa9f1cd8119dp114cb6jsn8952ed91c19c"
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "Curl Error #:" . $err;
                } else {
                    echo $response;
                }
            }
            ?>
        </div>
    </div>

</body>

</html>