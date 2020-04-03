<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="../css/dashboard.css" />
<link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1>Dashboard Ticketsystem IT Wild&Küpfer</h1>
        </div>
        <div id="leftcolumn">

            <div id="leftcolumn-box">
                <div class="block color-toz">
                <div>
                <?php
                        $servername = "localhost";
                        $username = "user";
                        $password = "password";
                        $dbname = "dbname";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT COUNT(*)FROM `ticket` WHERE `closed` = '0' AND `owner_id` IS NULL";
                        $res = $conn->query($sql);
                        $result = mysqli_fetch_array($res);                        
                        $conn->close();
                    ?>
                </div>
                    <div class="heading-box">
                      Tickets ohne Zuordnung
                    </div>
                    <div class="num"><?php echo $result[0]; ?></div>
                  </div>
                  
            </div>

            

            <div id="leftcolumn-box">
                <div class="block color-otb">
		<div>
                <?php
                        $servername = "localhost";
                        $username = "user";
                        $password = "password";
                        $dbname = "dbname";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT COUNT(*)FROM `ticket` WHERE `closed` = 0 AND `owner_id` = 3";
                        $res = $conn->query($sql);
                        $result = mysqli_fetch_array($res);                        
                        $conn->close();
                    ?>
                </div>
                    <div class="heading-box">
                        Offene Tickets Björn
                    </div>
                    <div class="num"><?php echo $result[0]; ?></div>
                  </div>
            </div>

            <div id="leftcolumn-box">
                <div class="block color-ota">
		<div>
                <?php
                        $servername = "localhost";
                        $username = "user";
                        $password = "password";
                        $dbname = "dbname";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT COUNT(*)FROM `ticket` WHERE `closed` = 0 AND `owner_id` = 2";
                        $res = $conn->query($sql);
                        $result = mysqli_fetch_array($res);                        
                        $conn->close();
                    ?>
                </div>
                    <div class="heading-box">
                        Offene Tickets Andreas
                    </div>
                    <div class="num"><?php echo $result[0]; ?></div>
                  </div>
            </div>

            <div id="leftcolumn-box">
                <div class="block color-dw">
		<div>
                <?php
                        $servername = "localhost";
                        $username = "user";
                        $password = "password";
                        $dbname = "dbname";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT COUNT(*) FROM ticket INNER JOIN ticketevent on ticket.id = ticketevent.ticket_id WHERE closed = '1' AND TIMESTAMPDIFF(DAY, NOW(), LEFT(ticketevent.date, 8)) >= -7 AND ticketevent.type LIKE 'CLOSE'";
                        $res = $conn->query($sql);
                        $result = mysqli_fetch_array($res);                        
                        $conn->close();
                    ?>
                </div>
                    <div class="heading-box">
                        ✔ Tickets - 7 Tage
                    </div>
                    <div class="num"><?php echo $result[0]; ?></div>
                  </div>
            </div>

            

            <div id="leftcolumn-box">
                <div class="block color-dm">
                <div>
                <?php
                        $servername = "localhost";
                        $username = "user";
                        $password = "password";
                        $dbname = "dbname";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT COUNT(*) FROM ticket INNER JOIN ticketevent on ticket.id = ticketevent.ticket_id WHERE closed = '1' AND TIMESTAMPDIFF(DAY, NOW(), LEFT(ticketevent.date, 8)) >= -30 AND ticketevent.type LIKE 'CLOSE'";
                        $res = $conn->query($sql);
                        $result = mysqli_fetch_array($res);                        
                        $conn->close();
                    ?>
                </div>
                    <div class="heading-box">
                        ✔ Tickets - 30 Tage
                    </div>
                    <div class="num"><?php echo $result[0]; ?></div>
                  </div>
            </div>

        </div>
        <div id="ticket-view">
           <div id="ticket-table">
            <?php
            $servername = "localhost";
            $username = "user";
            $password = "password";
            $dbname = "dbname";
            
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Set UTF-8 for Umlaute in agent names
            if (!mysqli_set_charset($conn, "utf8")) {
                printf("Error loading character set utf8: %s\n", mysqli_error($conn));
            }

            // Set localization to German for appropriate month names
            $sql_lang = "SET lc_time_names = 'de_DE'";
            $result_lang = $conn->query($sql_lang);

            // Query for ticket view
            $sql = "SELECT ticket.ticket_number, DATE_FORMAT(CONVERT(LEFT(ticket.date, 8), DATE), '%e. %M %Y') AS date_open , ticket.title, user.name AS user_name, staff.name AS staff_name FROM ticket LEFT JOIN user ON ticket.author_id = user.id LEFT JOIN staff ON ticket.owner_id = staff.id WHERE `closed` = 0 ORDER BY ticket.date DESC LIMIT 17";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Ticket Nummer</th><th>Eröffnet</th><th>Betreff</th><th>Eröffnet von</th><th>Zuständig</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["ticket_number"]. "</td><td>" . $row["date_open"]. "</td><td>" . $row["title"]. "</td><td>" . $row["user_name"]. "</td><td>" . $row["staff_name"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                //echo "0 results";
            }
            
            $conn->close();
            ?>

           </div>
       </div>
    </div>
</body>
</html>
