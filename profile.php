<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}

include('connection.php');
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id='$user_id'";
try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo "Problem";
}

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];

} else {
    echo "Wystąpił błąd pozyskania nazwy użytkownika z bazy danych";
}

?>

<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>
    

       <!-- Container -->
    <div class="content container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Ustawienia konta</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tr data-bs-target="#updateUsername" data-bs-toggle="modal">
                            <td>Nazwa użytkownika</td>
                            <td><?php echo $username?></td>
                        </tr>
                        <tr data-bs-target="#updateEmail" data-bs-toggle="modal">
                            <td>Email</td>
                            <td><?php echo $email?></td>
                        </tr>
                        <tr data-bs-target="#updatePassword" data-bs-toggle="modal">
                            <td>Hasło</td>
                            <td>********</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    

        <!-- update username -->
        <form method="post" id="updateUsernameForm">
            <div class="modal" id="updateUsername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                    Wprowadź nową nazwę użytkownika:
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                
                            </div>
                            <div class="modal-body">

                                <!-- update username message from php file -->
                                <div id="updateUsernameMessage"></div>

                                <div class="form-group">
                                    <label for="updateUsername">Nazwa użytkownika:</label>
                                    <input class="form-control" type="text" name="updateUsername" id="username" maxlength="30" value="<?php echo $username?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                            
                                <div class="ms-auto">
                                    <input class="btn green" name="updateUsername" type="submit" value="Zmień">
                            
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

        <!-- update email -->
        <form method="post" id="updateEmailForm">
            <div class="modal" id="updateEmail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                    Wprowadź nowy email:
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                
                            </div>
                            <div class="modal-body">

                                <!-- update email message from php file -->
                                <div id="updateEmailMessage"></div>

                                <div class="form-group">
                                    <label for="updateEmail">Email:</label>
                                    <input class="form-control" type="email" name="email" id="email" maxlength="50" value="<?php echo $email?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                            
                                <div class="ms-auto">
                                    <input class="btn green" name="updateEmail" type="submit" value="Zmień">
                            
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

        <!-- update password -->
        <form method="post" id="updatePasswordForm">
            <div class="modal" id="updatePassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                    Wprowadź obecne i nowe hasło:
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                
                            </div>
                            <div class="modal-body">

                                <!-- Update password message from php file -->
                                <div id="updatePasswordMessage"></div>

                                <div class="form-group">
                                    <label class="visually-hidden-focusable" for="currentPassword">Obecne hasło:</label>
                                    <input class="form-control" type="password" name="currentPassword" id="currentPassword" maxlength="30" placeholder="Obecne hasło">
                                </div>

                                <div class="form-group">
                                    <label class="visually-hidden-focusable" for="password">Nowe hasło:</label>
                                    <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="Nowe hasło">
                                </div>

                                <div class="form-group">
                                    <label class="visually-hidden-focusable" for="password2">Potwierdź nowe hasło:</label>
                                    <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Potwierdź nowe hasło">
                                </div>



                            </div>

                                
                            <div class="modal-footer">
                            
                                <div class="ms-auto">
                                    <input class="btn green" name="updateUsername" type="submit" value="Zmień">
                            
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

    <script src="profile.js"></script>
    <?php include 'components/footer.php'; ?>
