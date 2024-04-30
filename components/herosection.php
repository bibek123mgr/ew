<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Langar&family=Lobster&display=swap" rel="stylesheet"> -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .hero_both {
            flex-wrap: nowrap;
            display: flex;
            justify-content: space-between;
            align-items: last-baseline;
            max-width: 1280px;
            margin: 0 auto;
            height: 400px;
            padding: 0 10px;
        }

        .hero_dis_p {
            font-family: "Langar", system-ui;
            font-weight: 400;
            font-style: normal;
        }

        .welcome_logo {
            margin: 7px 0;
            font-size: 28px;
        }

        .welcome {
            color: #FF2700;
        }

        .hero_detail {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            flex: 1;
            max-width: 35%;
        }

        .hero_disc h2,
        .hero_detail h1,
        .hero_detail h1 span {
            font-family: "Langar", system-ui;
        }

        .hero_disc h2 {
            font-size: 18px;
            color: #5d0f01;

        }

        .hero_dis_p {
            text-align: justify;
            font-size: 18px;
        }

        .hero {
            height: 500px;
            background: linear-gradient(90deg, #4ca1af, #2c3e50);

        }

        .hero_btn {
            margin-top: 8px;
            height: 2rem;
            width: auto;
            padding: 3px 7px;
            border: none;
            outline: none;
            background-color: #FF2700;
        }

        .hero_btn a {
            font-size: 1rem;
            text-decoration: none;
            color: white;
        }

        .hero_image img {
            width: 100%;
        }

        .hero_image {
            display: flex;
            flex-direction: column;
            flex: 1;
            align-items: baseline;
            width: 60%;
        }

        @media screen and (min-width: 481px) and (max-width: 768px) {
            .hero_both {

                display: flex;
                flex-direction: column;
                align-items: center;
                /* justify-content: end; */
            }

            .hero_detail {
                display: flex;
                flex-direction: column;
                max-width: 80%;
                margin-top: 5rem;
            }

            .hero_image {
                width: 70%;
            }


        }

        @media screen and (min-width: 0px) and (max-width: 480px) {
            .hero_both {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: baseline;
            }

            .hero_detail {
                display: flex;
                flex-direction: column;
                max-width: 80%;
                margin-top: 5rem;
            }

            .hero_image {
                width: 100%;
            }


            .welcome_logo {
                font-size: 16px;
            }

            .hero_disc h2 {
                font-size: 14px;
            }

            .hero_dis_p {
                font-size: 10px;
            }

            .hero_btn {
                display: flex;
                justify-content: center;
                height: 1rem;
                padding: 3px;
                width: auto;
            }

            .hero_btn a {
                font-size: 10px;

            }
        }
    </style>
</head>

<body>
    <div class="hero">
        <section class="hero_both">
            <div class="hero_detail">
                <h1 class="welcome_logo">Welcome to Food<span class="welcome">Land</span>
                </h1>
                <div class="hero_disc">
                    <h2>Want a delicious meal ?</h2>
                    <p class="hero_dis_p">Explore our diverse menu and order delicious meals. Effortlessly place your
                        order, Have them
                        delivered right to your doorstep with ease.
                    </p>
                    <button class="hero_btn"><a href="#">Explore Now</a></button>
                </div>
            </div>
            <div class="hero_image">
                <img src="../assets/slide3.png" alt="Image 3">
        </section>
    </div>
</body>

</html>