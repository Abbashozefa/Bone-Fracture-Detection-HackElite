<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Xray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body style="background-color:black; color:#b7b7b7;">
    <?php
    include 'partials/_header.php'
        ?>
    <!-- corousal -->
    <div id="carouselExampleControls" class="carousel slide my-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/2400x700/?hospitals" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x700/?hospital,computer" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x700/?doctor,program" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- container -->
    <!-- <h2 class="text-center">Hello Doctor</h2> -->
    <div class="container my-3">
        <h2 class="text-center">Patients list</h2>
        <div class="row">
            <?php
            include '_dbconn.php';
            $ref_table = "patients";
            $fetchdata = $database->getReference($ref_table)->getvalue();

            // loop
            if ($fetchdata > 0) {
                $i=0;
                foreach ($fetchdata as $key => $row) {
                    $id = $row['id'];
                    $name = $row['name'];
                    echo ' <div class="col-md-4 my-2">
                <div class=" card my-2" style="width: 18rem;">
                    <img src="https://source.unsplash.com/500x400/?patient,'.$name.'" class="card-img-top" alt="...">
                    <div class="card-body ">
                        <h5 class="card-title"><a style="text-decoration:none; " class="text-dark" href="patient_details.php?pid=' . $id . '">' . $id . '.'  . $name . '</a></h5>
                        <p class="card-text">Phone: ' . $row['phone'] . '<br>' . substr($row['address'], 0, 90) . '....</p>
                        <a href="http://127.0.0.1:5000?pid=id'.$id.'" class="btn btn-success">Upload X-RAY</a>
                    </div>
                </div>
            </div>';
            $i++;
            if($i==3)break;
                }
            }
            else{
                echo "NO data Found";
            }
            ?>
            <a href="patient.php" class=" btn btn-success text-center">More details </a>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>