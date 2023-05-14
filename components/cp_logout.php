<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">

        <div class="row my-5">
            <form action="./scripts/sc_mudar_nome.php" method="post">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Mudar username:</label>
                    <textarea class="form-control" id="username" value="" name="username" rows="1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Alterar</button>
            </form>
        </div>

        <div class="row my-5">
            <h4>Mudar password</h4>
            <form action="./scripts/sc_mudar_password.php" method="post">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Password atual:</label>
                    <textarea class="form-control" id="password_atual" value="" name="password_atual" rows="1"></textarea>
                </div>
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Nova password:</label>
                    <textarea class="form-control" id="password_nova" value="" name="password_nova" rows="1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Alterar</button>
            </form>
        </div>

        <div class="row">
            <h4>Tem a certeza que quer sair?</h4>
            <div class="col-8">
                <a href="./scripts/sc_logout.php"><button type="submit" class="btn btn-primary">Logout</button></a>
            </div>
        </div>
    </div>
</section>