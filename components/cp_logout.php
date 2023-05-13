<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">

        <div class="row my-5">
            <form action="./scripts/sc_mudar_nome.php" method="post">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Comentar:</label>
                    <textarea class="form-control" id="username" value="" name="username" rows="1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Mudar username</button>
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