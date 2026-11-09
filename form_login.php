<?php

session_start();

include("includes/head.php");

?>

<body>

    <?php include_once("includes/header.php"); ?>


    <main>

        <div class="form_content">

            <form
                action="form_login_output.php"
                method="POST">

                E-mail:
                <br>

                <input
                    type="email"
                    name="email"
                    required>

                <br>


                Senha:
                <br>

                <input
                    type="password"
                    name="password"
                    required>

                <br>


                <input
                    type="submit"
                    value="Entrar">

            </form>

        </div>

    </main>


    <?php

    include("includes/footer.php");

    ?>
    <script src="assets/scripts/script.js"></script>
</body>

</html>