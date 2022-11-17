<?php include "header.php"; ?>

<div class="main">

    <ul class="rslides">
        <li><img src="img-slideshow/1.jpg" alt="Slideshow img text - Pizza"></li>
        <li><img src="img-slideshow/2.jpg" alt="Slideshow img text - is"></li>
        <li><img src="img-slideshow/3.jpg" alt="Slideshow img text - Yummy!"></li>
    </ul>
    
    <h1>Welcome</h1>
    <p>Welcome to <b>It's Pizza&#33</b> pizza store.</p>
    
</div>

<script>
  $(function() {
    $(".rslides").responsiveSlides({
        auto: true,             // Boolean: Animate automatically, true or false
        speed: 500,            // Integer: Speed of the transition, in milliseconds
        timeout: 2000//4000          // Integer: Time between slide transitions, in milliseconds
        
      })
            });
</script>

<?php include "footer.php"; ?>