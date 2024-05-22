<?php
    include("db.php");
    if($_SESSION['id'] == NULL){
        header('Location: login.php');
    }

    $user = $_SESSION['user'];
    $id = $_SESSION['id'];
    $sender = $_SESSION['id'];
    $receiver = ""; 
    $conversation_id = ""; 
    $wew = ""; 
    if(isset($_POST['use'])){
        $userId = $_POST["user_id"];
        $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");
        if($result){
            $receiver = $result->fetch_assoc()['id'];
            var_dump($receiver);
            $user_ids = [$id, $receiver];
            sort($user_ids);
            function concatenate_alphabetically($id, $receiver) {
   
                if ($id < $receiver) {
                    return $id . $receiver;
                } else {
                    return $receiver . $id;
                }
            }
            $userIDs = concatenate_alphabetically($id, $receiver);
            $_SESSION['userIDs'] = $userIDs;

 
            $checkTableQuery = "SHOW TABLES LIKE '$userIDs'";
            $tableExists = mysqli_query($conn, $checkTableQuery);
            if(mysqli_num_rows($tableExists) == 0) {
                $sql = "CREATE TABLE `$userIDs` (
                    `msgs` VARCHAR(255),
                    `sender` VARCHAR(255),
                    `convo` VARCHAR(255),
                    `msg_datetime` DATETIME
                )";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "<script>alert('User Successfully Registered');</script>";
                    $wew = $userIDs;
                }
            }
            else {
                $wew = $userIDs; 
                $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$receiver'");
                $row = mysqli_fetch_assoc($result);
                if($row){
                    $_SESSION['receiver'] = $row["user"];
                }

            }
        }
    }

    if(isset($_POST['chooseuser'])){
        $userId = $_POST["chooseuser"];
        $result = mysqli_query($conn, "SELECT * FROM users WHERE user = '$userId'");
        if($result){
            $receiver = $result->fetch_assoc()['id'];

            $user_ids = [$id, $receiver];
            sort($user_ids);
            function concatenate_alphabetically($id, $receiver) {

                if ($id < $receiver) {
                    return $id . $receiver;
                } else {
                    return $receiver . $id;
                }
            }
            $userIDs = concatenate_alphabetically($id, $receiver); 
            $_SESSION['userIDs'] = $userIDs;

            $checkTableQuery = "SHOW TABLES LIKE '$userIDs'";
            $tableExists = mysqli_query($conn, $checkTableQuery);
            if(mysqli_num_rows($tableExists) == 0) {
                $sql = "CREATE TABLE `$userIDs` (
                    `msgs` VARCHAR(255),
                    `sender` VARCHAR(255),
                    `convo` VARCHAR(255),
                    `msg_datetime` DATETIME
                )";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $wew = $userIDs;
                }
            }
            else {
                $wew = $userIDs; 
            }
        }
    }
    if(isset($_SESSION['userIDs'])){
        $etona = $_SESSION['userIDs'];
    }
    if(isset($_POST['submit'])){
        $msg = $_POST['msg'];
        $messages = mysqli_query($conn, "INSERT INTO `$etona` (msgs, sender, convo) VALUES ('$msg', '$sender', '$etona')");
        
    }


    if(empty($wew)) {
        $wew = "default_table_name"; 
    }

    if(isset($etona)){
        $_SESSION['userIDs'] = $etona;
        $etona =  $_SESSION['userIDs'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        html{
            overflow: hidden;
            font-family: 'Trebuchet MS', sans-serif;
            width: 100%;
            height: 100%;

            background: #2D3250;
            --gap: 5em;
            --line: 1px;
            --color: rgba(255, 255, 255, 0.2);
            
            background-image: linear-gradient(
                -90deg,
                transparent calc(var(--gap) - var(--line)),
                var(--color) calc(var(--gap) - var(--line) + 1px),
                var(--color) var(--gap)
                ),
                linear-gradient(
                0deg,
                transparent calc(var(--gap) - var(--line)),
                var(--color) calc(var(--gap) - var(--line) + 1px),
                var(--color) var(--gap)
                );
  background-size: var(--gap) var(--gap);
        }
 
        .users::-webkit-scrollbar {
            width: 5px; 
            height: 12px; 
        }

    
        .users::-webkit-scrollbar-track {
            background: #151515;
        }

     
        .users::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }


        .users::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .sending::-webkit-scrollbar {
            width: 5px; 
            height: 12px; 
        }

 
        .sending::-webkit-scrollbar-track {
            background: #151515;
        }

        .sending::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }


        .sending::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        form input[type="text"]::placeholder {
            color: #aaa; 
        }

        form input[type="text"]:focus {
            border-color: #007bff; 
        }
        form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 20px; 
            background-color: #2c2c2c;
            color: #ddd;
            margin-right: 10px;
            outline: none;
        }
        body{
            margin: 0;
            padding: 0;
        }
        .wewe:hover{
            filter:brightness(70%);
            cursor: pointer;
        }
        #burger:hover{
            filter:brightness(70%);
            cursor: pointer;
        }
        .more:hover{
            background-color: rgba(17, 24, 39, 1)

        }

    </style>
</head>
<body>
    
    <header style="display: flex;  background-color: #172035; box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.5); justify-content: space-between; border-width: 0.5px; border-style: solid; border-color: #1f2c48; border-right: none; border-left: none; border-top: none;">
        <img src="store.png" style="height: 60px; padding-left: 20px;" alt="">
        <!-- <span style="color: #61677A;"><?php echo $_SESSION['user']; ?></span> -->
        <i style="height: 50px; color: white; font-size: 30px; margin: 20px;  margin-bottom: 0;" id="burger" class="fa-solid fa-bars"></i>
    </header>
    <!-- <a href="logout.php">Log out</a> -->
    <span style="display: flex; flex-direction: row; border-color: 192339; border-style: solid; border-top: none; border-left: none; border-right: none;">
        <h1 style="color: white; width: 21.3vw; border-style: solid; margin: 0; border-width: thin; display: flex; align-items: center; border-left: none; border-bottom: none; border-top: none; border-color: black; box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.5); background-color: rgba(17, 24, 39, 1);">&#8205;
        &#8205; 
Chats</h1>
        <h2 style="display: flex; width: 79vw; margin: 0; align-items: center; color: white; padding: 20px;  margin: 0; box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.5); background-color: rgba(17, 24, 39, 1);"><?php if(isset($_SESSION['receiver'])){
            echo $_SESSION['receiver'];
        }else{
            echo "No recipient selected";
        }; ?></h2>
    </span>
    <div class="main" style="display: flex; flex-direction: row; width: 100vw;">
        
        <div class="sendmessage" style="display:flex; flex-direction: column; width: 21vw; justify-content: center; align-items: center; background-color: rgba(17, 24, 39, 1); border-style: solid; border-width: 1px; border-top: none; border-left: none; border-bottom: none; ">
            <div class="choose">
                    <form action="" method="POST" style="display: flex; width: 20vw; flex-direction: row; justify-content: space-around;">
                        <button type="submit" style="display: none;">Choose</button>
                        <input type="text" name="chooseuser" placeholder="Search User">
                    </form>
                </div>
            <div class="users" style="width: 20vw; display: flex; flex-direction: column; height: 79vh; overflow-y: scroll;">
                <?php
                    $sql = "SELECT * FROM users";
                    $list = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($list)){
                        ?>
                        <form action="" method="POST">
                        <div class="msgholder" style="width: 18vw; display: flex; justify-content: center; align-items: center;">
                            <button type="submit" class="wewe" name="use" style="display: flex; border-radius: 10px; border-style: none; background-color: #172035; width: 100%; align-items: center; color: 61677A; padding: 10px; font-size: 20px; text-align: center; justify-content: center;" action="POST">
                             <div class="nig" style="display: flex; flex-direction: row; gap: 25px;">
                                <img src="149071.png" style="width: 30%; height: 50%; display: flex; justify-content: center; " alt="">
                                <div class="userd" style="display: flex; flex-direction: column; justify-content: flex-start;">
                                    <p style="text-align: left; color: white;"><?php echo $row["user"]?></p>
                                </div>

                             </div>
                             <div class="more" style="padding: 20px; border-radius: 40px;">
                                <i class="fa-solid fa-ellipsis" id="more"></i>
                             </div>
                        
                          
                            </button>
                            <input type="hidden" name="user_id" value="<?php echo $row["id"]; ?>">
                        </div>
                        </form>

                        <?php
                    }
                ?>
            </div>

        </div>
        <div class='messages' style="height: 86vh; background-color: #172035; margin: 0; width: 80vw; display: flex; flex-direction: column;">
            <div class="sending" id="nigga" style="height: 97vh; overflow-y: scroll; margin: 0; width: 79vw">
                    <?php
                        if(!isset($_SESSION['userIDs'])){
                            echo "<p>Please Choose a recipient<p>";
                        }
                        else{
                            $sql = "SELECT * FROM `$etona` where convo = '$etona'"; 
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)){
                                    if($row['sender'] == $id){
                                ?>
                                <div class="msghold" style="display: flex; width: 95%; justify-content: flex-end; flex-wrap: wrap;">
                                    <div class="msgholder">
                                        <p style="border-radius: 20px; background-color: blue; color: white; padding: 10px; margin-right: -50px"> <?php echo $row["msgs"]?><p>
                                    </div>
                                </div>

                                <?php
                        }
                    else{
                        ?>
                                <div class="msghold" style="display: flex; justify-content: flex-start; flex-wrap: wrap; margin-left: 30px;">
                                    <div class="msgholder">
                                        <p style="border-radius: 20px; background-color: gray; color: white; padding: 10px;"> <?php echo $row["msgs"]?><p>
                                    </div>
                                </div>

                                <?php
                    }}}
                    ?>    
            </div>
            <div class="send">
                <?php
                    if($_SESSION['userIDs']){
                        echo "<form action='' method='POST' style='display: flex; justify-content: center; align-items: center; border-style: solid; border-width: thin; border-color: black; height: 9vh; width: 100%'>
                        <div style='display: flex; width: 97%; display: flex;'>
                            <input type='text' name='msg' placeholder='Write a message...' required style='width: 80%;'>
                            <button type='submit' style='display: none;' name='submit'>Submit</button>
                        </div>
                        
                    </form>";
                    }
                    ?>
            </div>
        </div>
    <script>
        var element = document.getElementById("nigga");
        element.scrollTop = element.scrollHeight;
        var burger = document.getElementById("burger");
        function nig{
            burger
        }
    </script>
    <script src="https://kit.fontawesome.com/5289ffb745.js" crossorigin="anonymous"></script>
</body>
</html>
