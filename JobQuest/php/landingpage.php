<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Home</title>
</head>
<body>
    <section>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">JobQuest</label>
        <ul>
            <li><a class="active" href="#section1">Home</a></li>
            <li><a href="#section2">About Us</a></li>
            <li><a href="#section3">Contact</a></li>
            <li class="dropdown">
                <a href="view-jobs.php">Get started</a>
                <ul class="dropdown-menu">
                    <li><a href="register-admin.php">As Admin</a></li>
                    <li><a href="register-employee.php">As Employee</a></li>
                    <li><a href="register-employer.php">As Employer</a></li>
                </ul>
            </li>
        </ul>
    </nav>
   </section>

   <section>
    <!-- home section -->
   <section class="home" id="section1">

            <div class="container" style="background: url(images/home3.jpg) no-repeat; font-size: 40px;">
              <div class="content">
                 <span>Unlock your career potential with us!</span>
                 <h3>Discover your dream career</h3>
              </div>
            </div>
   </section>

   <section class="home-about" id="section2">

<div class="image">
 <img src="images/home1.jpg" alt="">
</div>

<div class="content">
 <h3>about us</h3>
 <p>we are on a mission to revolutionize the employment landscape 
    by providing a cutting-edge platform that transcends traditional 
    job search paradigms. Committed to empowering individuals at every
     stage of their career journey, we embrace diversity, inclusion, 
     and innovation as core pillars of our ethos. With a user-centric 
     focus, we strive to redefine the job search experience through 
     intuitive technology, personalized job matching algorithms, and 
     a plethora of resources to support professional growth. Our unwavering
      dedication to bridging the gap between talented individuals and 
      forward-thinking organizations drives us to continuously enhance 
      our offerings and deliver unparalleled value to our users. </p>
  <a href="#" class="btn" style="font-size: large; text-transform: capitalize">read more</a> 
</div>
</section>

<section class="footer" id="section3">

        <div class="box-container" >

          <div class="box">
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-angle-right"></i> Ask questions</a>
            <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
            <a href="#"> <i class="fas fa-angle-right"></i> Terms of use</a>
          </div>

          <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +123-456-7890</a>
            <a href="#"> <i class="fas fa-phone"></i> +349-654-8875</a>
            <a href="#"> <i class="fas fa-envelope"></i> abc@gmail.com</a>
            <a href="#"> <i class="fas fa-map"></i> Addis Ababa, Ethiopia - 123456</a>
          </div>

          <div class="box">
            <h3>Follow Us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook</a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram</a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin</a>
            <a href="#"> <i class="fab fa-whatsapp"></i> whatsapp</a>
          </div>
        </div>
      </section>
      <script src="js/script-lp.js"></script>
</body>
</html>