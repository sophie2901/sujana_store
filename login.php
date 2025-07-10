<?php include "./header.php"; ?>

<main class="form-signin">
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form>
                                <h1 class="h3 mb-3">Sign in</h1>
                                <div class="form-floating mb-4">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                    <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                    <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                </div>
                                <div class="form-check text-start mb-3">
                                    <input class="form-check-input" type="checkbox" value="remember-me" id="checkDefault">
                                    <label class="form-check-label" for="checkDefault">
                                        Remember me
                                    </label>
                                </div>
                                <button class="btn btn-primary btn-lg w-100 py-2" type="submit">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</main>

<?php include "./footer.php"; ?>