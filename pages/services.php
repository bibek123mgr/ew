<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Section</title>

    <style>
        /* Styles for Services Section */
        .services-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
            text-align: center;
        }

        .service-item1,
        .service-item2,
        .service-item3,
        .service-item4 {
            padding-bottom: 40px;
            border-bottom: 1px solid rgb(163, 161, 161);
            margin-bottom: 40px;
            display: flex;
            gap: 50px;
            align-items: center;
            justify-content: space-around;
        }

        .service-image {
            width: 500px;
            height: 300px;
        }

        .service-image img {
            height: 100%;
            width: 100%;
        }

        .service-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .service-description {
            font-size: 16px;
            text-align: left;
            color: #666;
        }

        .service-description-div {
            display: flex;
            flex-direction: column;
        }

        .service-title {
            text-align: left;
        }

        /* Responsive Styling */
        @media screen and (max-width: 768px) {

            .service-item2,
            .service-item4 {
                flex-direction: column;
                text-align: center;
            }

            .service-item1,
            .service-item3 {

                flex-direction: column-reverse;
                text-align: center;
            }

            .service-image {
                margin-top: 20px;
            }
        }

        @media screen and (max-width: 500px) {
            .service-image {
                width: 300px;
                height: 200px;
            }

            .service-image img {
                height: 100%;
                width: 100%;
            }
        }

        .service {
            background-color: #e7e5e5;

        }
    </style>
</head>

<body>
    <?php
    ob_start();
    include("../connection.php");
    session_start();
    include("../components/fetchdata.php");
     include('../components/navbar.php') ?>
    <div class="service">
        <section class="services-container">
            <div class="service-item1">
                <div class="service-description-div">
                    <h3 class="service-title">Wide Menu Selection</h3>
                    <p class="service-description">Choose from a diverse range of cuisines and dishes, including
                        vegetarian,
                        vegan, and gluten-free options.</p>
                </div>
                <div class="service-image">
                    <img src="../assets/menuselection.jpg" alt="menuselection">
                </div>
            </div>

            <div class="service-item2">
                <div class="service-image">
                    <img src="../assets/delivery.jpg" alt="menuselection">
                </div>
                <div class="service-description-div">
                    <h3 class=" service-title">Fast Delivery</h3>
                    <p class="service-description">Enjoy quick and reliable delivery service to your doorstep within the
                        promised time frame.</p>
                </div>
            </div>


            <div class="service-item3">
                <div class="service-description-div">
                    <h3 class=" service-title">Quality Ingredients</h3>
                    <p class="service-description">We use only the freshest and highest quality ingredients to ensure
                        delicious and flavorful meals every time.</p>
                </div>
                <div class="service-image">
                    <img src="../assets/ingrident.jpg" alt="menuselection">
                </div>
            </div>

            <div class="service-item4">
                <div class="service-image">
                    <img src="../assets/support.jpg" alt="menuselection">
                </div>
                <div class="service-description-div">

                    <h3 class=" service-title">24/7 Customer Support</h3>
                    <p class="service-description">Our dedicated customer support team is available round-the-clock to
                        assist you with any inquiries or issues.</p>
                </div>
            </div>

        </section>
    </div>

    <?php include('../components/footer.php') ?>
</body>

</html>