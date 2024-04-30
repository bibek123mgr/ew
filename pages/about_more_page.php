<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: "Fira Sans", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;

        }

        /* About Section Styles */
        .about {
            background-color: #e7e5e5;
            padding: 50px 0;
            text-align: center;

        }

        .about h4 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .about h3 {
            text-decoration: underline;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .about p {
            text-align: justify;
            font-size: 18px;
            color: #464646;
            line-height: 1.6rem;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .about .row {
                flex-direction: column;
            }

            .about .content,
            .about .image {
                margin-bottom: 20px;
            }
        }

        .founders {
            margin: 1.5rem 0;
            padding: 20px 0;
        }

        .founders_info {
            margin-top: 30px;
            gap: 30px;
            display: flex;

        }

        .person1,
        .person2 {
            background-color: whitesmoke;
            border-radius: 7px;
            padding: 10px;

        }

        .person1 p,
        .person2 p {
            line-height: 20px;
            font-size: 14px;
            margin: 10px 0;
            text-align: justify;
        }

        .person1_img img,
        .person2 img {
            width: 100%;
            object-position: center;
            object-fit: cover;
        }

        .person1_img,
        .person2_img {
            border-radius: 50%;
            margin: 0 auto;
            height: 5rem;
            width: 5rem;
        }

        .founders h3 {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    ob_start();
    require('../components/navbar.php');
    ?>
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="content">
                    <h3>About Us</h3>
                    <h4>We make the Best fooditems in your Town</h4>
                    <p>At Us Food Ordering, we take pleasure in delivering a smooth culinary experience to your home.
                        With a
                        passion for flavor and a commitment to quality, we create a wide menu that combines various
                        cuisines.
                        Our user-friendly interface makes ordering simple and efficient, and our devoted crew works
                        constantly
                        to assure quick delivery. Trust Us Food Ordering for a scrumptious voyage that brings the
                        world's best
                        cuisines to your table, making every meal a memorable experience. Choose us for a taste that
                        goes
                        beyond borders and satisfies your culinary desires.
                    </p>
                </div>
                <?php include('../components/aboutff.php'); ?>
                <div class="founders">
                    <h3>Founder/Team Member</h3>
                    <div class="founders_info">
                        <div class='person1'>
                            <div class="person1_img">
                                <img src="../assets/founder.png" alt="">
                            </div>
                            <h1>Bibek Kumar Bakabal</h1>
                            <p> Lorem Ipsum is that a more-or-less normal distribution of letters, content here',
                                making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum'
                                will uncover many web sites still in their infancy. Various versions have evolved</p>
                        </div>
                        <div class="person2">
                            <div class="person2_img">
                                <img src="../assets/founder.png" alt="">
                            </div>
                            <h1>Santa Parsad Tharu</h1>
                            <p> Lorem Ipsum is that a more-or-less normal distribution of letters, content here',
                                making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum'
                                will uncover many web sites still in their infancy. Various versions have evolved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require('../components/footer.php') ?>

</body>

</html>