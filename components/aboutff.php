<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Features & Services</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 2rem;
        }

        .allaboutus {
            width: 100%;
            margin: 20px auto;
        }

        .aboutUS {
            max-width: 1280px;
            margin: 0 auto;
            text-align: center;
            /* Center aligning the content */
        }

        .aboutUS header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .aboutUS h1,
        .aboutUS h2 {
            color: #446688;
        }

        .aboutUS section {
            margin-bottom: 2rem;
            text-align: center;
        }

        .aboutUS section p {
            color: #666;
        }

        /* Adjusted selector for image */
        #food img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
        }

        .feature-container {
            display: flex;
            justify-content: center;
            /* Centering the sections horizontally */
            flex-wrap: wrap;
            /* Allowing content to wrap */
        }

        .left,
        .right {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            /* Equal width for left and right sections */
        }

        /* Tablet and Desktop Styles */
        @media screen and (min-width: 768px) {
            #food img {
                max-width: 100%;
                height: auto;
                max-height: 500px;
            }

            .aboutUS header {
                margin-bottom: 2rem;
            }

            .aboutUS h1 {
                margin-right: auto;
            }

            .aboutUS section {
                width: 48%;
            }
        }

        /* Mobile Styles */
        @media screen and (max-width: 767px) {
            #food img {
                max-width: 100%;
                height: auto;
                max-height: 300px;
            }

            .feature-container {
                flex-direction: column;
                align-items: center;
                /* Centering the sections vertically */
            }

            .aboutUS section {
                width: 100%;
            }

            #coffee,
            #vibe {
                order: -1;
            }

            .aboutUS section img {
                order: -1;
            }
        }
    </style>
</head>

<body>
    <div class="allaboutus">
        <div class="aboutUS">
            <div class="feature-container">
                <div class="left">
                    <section id="drinks">
                        <h2>Fancy Drinks</h2>
                        <p>Drinks, shots, cocktails — in our restaurant, you will not only eat deliciously.</p>
                    </section>
                    <section id="coffee">
                        <h2>Delicious Coffee</h2>
                        <p>Fresh coffee from the finest beans on-site and for takeaway.</p>
                    </section>
                </div>
                <section id="food">
                    <img src="../assets/about.png" alt="about img">
                </section>
                <div class="right">
                    <section id="food-section">
                        <h2>Tasty Food</h2>
                        <p>Enjoy your lunch and dinner in our restaurant! We have dishes from all over the world.</p>
                    </section>
                    <section id="vibe">
                        <h2>Unique Vibe</h2>
                        <p>Our chill-out zone will surely make you forget about your troubles.</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>

</html>