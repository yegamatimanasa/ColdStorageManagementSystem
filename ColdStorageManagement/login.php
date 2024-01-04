<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Goblin+One" />
    <title>COLD STORAGE MANAGEMENT SYSTEM</title>
</head>

<body>
    <section id="banner">
        <div class="logo">
            <a href="index.html"> <img src="./images/logo.png"> </a>
        </div>
        <ul>
            <li><a href="index.php"><i class="fa-solid fa-user-secret fa-beat"></i> Logout</a></li>


        </ul>
        <div class="grid-container">
            <div class="grid-item">
                <div class="banner-text">

                    <h1> COLD STORAGE MANAGEMENT SYSTEM </h1>
                    <p> COLD STORAGE MANAGEMENT SYSTEM is an innovative website designed for efficient and secure
                        handling of temperature-sensitive goods.
                        <span id="dots">...</span><span id="more">With robust features like real-time monitoring,
                            inventory management, and seamless user interaction, Arctic Vault ensures optimal conditions
                            for products. </span>
                    </p>
                    <button onclick="myFunction()" id="myBtn" class="button button">Read more</button>
                    <button id="myBtn" class="button button" onclick="redirectToHome()">Search for product</button>

                </div>
            </div>
            <script>
                function myFunction() {
                    var dots = document.getElementById("dots");
                    var moreText = document.getElementById("more");
                    var btnText = document.getElementById("myBtn");

                    if (dots.style.display === "none") {
                        dots.style.display = "inline";
                        btnText.innerHTML = "Read more";
                        moreText.style.display = "none";
                    } else {
                        dots.style.display = "none";
                        btnText.innerHTML = "Read less";
                        moreText.style.display = "inline";
                    }
                }
                function redirectToHome() {
        window.location.href = "home.php";
    }
            </script>
            <div class="grid-item">


            </div>
        </div>
    </section>
</body>

</html>