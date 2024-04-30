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
         padding: 50px 0;
         text-align: center;
      }

      .about h4 {
         font-size: 24px;
         margin-bottom: 10px;
      }

      .about h3 {
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

      .moreabout {
         border-radius: 4px;
         height: 35px;
         border: none;
         outline: none;
         margin-top: 20px;
         background-color: #ff6347;
         padding: 5px 10px;
      }

      .moreabout a {
         color: white;
         font-size: 16px;
         text-decoration: none;
      }
   </style>
</head>

<body>
   <section class="about">
      <div class="container">
         <div class="row">
            <div class="content">
               <h3>About Us</h3>
               <h4>We make the Best fooditems in your Town</h4>
               <p>At Us Food Ordering, we take pleasure in delivering a smooth culinary experience to your home. With a
                  passion for flavor and a commitment to quality, we create a wide menu that combines various cuisines.
                  Our user-friendly interface makes ordering simple and efficient, and our devoted crew works constantly
                  to assure quick delivery. Trust Us Food Ordering for a scrumptious voyage that brings the world's best
                  cuisines to your table, making every meal a memorable experience. Choose us for a taste that goes
                  beyond borders and satisfies your culinary desires.</p>
            </div>
            <button class="moreabout"><a href="../pages/about_more_page.php">Read More</a></button>
         </div>
      </div>
   </section>

</body>

</html>