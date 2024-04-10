<!-- sign up form -->
<form method="post" id="signupForm">
    <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Zarejestruj się już dzisiaj i zacznij korzystać z naszej aplikacji!
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        
                    </div>
                    <div class="modal-body">

                        <!-- sign up message from php file -->
                        <div id="signupMessage"></div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="username" id="username" placeholder="Nazwa użytkownika" maxlength="30">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" id="email" placeholder="Adres email" maxlength="50">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Wpisz hasło" maxlength="30">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password2" id="password2" placeholder="Potwierdź hasło" maxlength="30">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="signup" type="submit" value="Zarejestruj">

                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                            Anuluj
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>

<!-- login form -->
<form method="post" id="loginForm">
    <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Logowanie:
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                    </div>
                    <div class="modal-body">

                        <!-- login message from php file -->
                        <div id="loginMessage"></div>

                        <div class="form-group">
                            <input class="form-control" type="email" name="loginEmail" id="loginEmail" placeholder="Adres email" maxlength="50">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="loginPassword" id="loginPassword" placeholder="Hasło" maxlength="30">
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="rememberme" id="rememberme">
                                Zapamiętaj mnie
                            </label>

                            <a class="float-end" style="cursor: pointer" onclick="closeAndOpenNewModal('loginModal', 'forgotModal')">
                                Nie pamiętasz hasła?
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default float-start" onclick="closeAndOpenNewModal('loginModal', 'signupModal')">
                            Zarejestruj się
                        </button>
                    
                        <div class="ms-auto">
                            <input class="btn green" name="login" type="submit" value="Zaloguj">
                    
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                                Anuluj
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


</form>

<!-- forgot password form -->
<form method="post" id="forgotPasswordForm">
    <div class="modal" id="forgotModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Nie pamiętasz hasła? Podaj swój adres email:
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        
                    </div>
                    <div class="modal-body">

                        <!-- forgot password message from php file -->
                        <div id="forgotMessage"></div>

                        <div class="form-group">
                            <input class="form-control" type="email" name="forgot-email" id="forgot-email" placeholder="Adres email" maxlength="50">
                        </div>

                    </div>
                    <div class="modal-footer">
                    
                        <div class="ms-auto">
                            <input class="btn green" name="forgotpassword" type="submit" value="Wyślij">
                    
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                                Anuluj
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


</form>
    
<script>
        function closeAndOpenNewModal(currentModalId, newModalId) {
        var currentModal = document.getElementById(currentModalId);
        var newModal = new bootstrap.Modal(document.getElementById(newModalId));

        var modalInstance = bootstrap.Modal.getInstance(currentModal);
        modalInstance.hide(); // Close the current modal

        newModal.show(); // Open the new modal
    }
</script>

<script src="index.js"></script>