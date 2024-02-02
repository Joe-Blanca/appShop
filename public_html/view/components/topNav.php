    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">Sobre nós</a>
                    <a class="text-body mr-3" href="">Contatos</a>
                    <a class="text-body mr-3" href="">Ajuda</a>
                    <a class="text-body mr-3" href="">Dúvidas</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-user"></i> <?php if(isset($_SESSION['id_pessoa'])){echo $_SESSION['nome'];};;?></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button"><i class="fa-solid fa-gear"></i> Conta</button>
                            <hr class="hr"></hr>
                            <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#popupLogin"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                            <form method="POST">
                                <div id="btnHolder">
                                    <button type="submit" name="sair" class="btn btn-danger text-white w-100">Sair</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Nome</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Loja</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="O que você procura?">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Contato</p>
                <h5 class="m-0">016 9999-0000</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->