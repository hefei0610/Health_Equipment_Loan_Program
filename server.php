<html>
    <head>
        <title>Health Equipment Loan Program</title>
    </head>

    <body>
        <h2>Health Equipment Loan Program</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="server.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Inserting Client Information </h2>
        <h3>Please enter client information </h3>
        <form method="POST" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            PHN: <input type="text" name="PHN"> <br /><br />
            Name: <input type="text" name="CName"> <br /><br />
            Address: <input type="text" name="Address"> <br /><br />
            Birthdate: <input type="text" name="Birthdate"> <br /><br />
            Height: <input type="text" name="Height"> <br /><br />
            Weight: <input type="text" name="ClientWeight"> <br /><br />
            Phone Number: <input type="text" name="PhoneNumber"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
            </form>

        <hr />

        <h2>Update Weight and Height of the Client</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            PHN: <input type="text" name="oldName"> <br /><br />
            New Height: <input type="text" name="newH"> <br /><br />
            New Weight: <input type="text" name="newW"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>
        <hr />

    
        <h2>View the Client List</h2>

        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="viewAllClientRequest" name="viewAllClientRequest">
            <input type="submit" value="View the List" name="viewAllSubmit"></p>
        </form>

        <hr />
        <h2>View Equipment By Equipment Type</h2>
        <h3>Please select an equipment type to view available equipments</h3>
        <form method="GET" action = "server.php">
            <input type="hidden" id="selectByEquipmentType" name="selectByEquipmentType">
            <input type="radio" id="wheelchair" name="equipments" value="wheelchair">
            <label for="wheelchair">Wheelchair</label><br>
            <input type="radio" id="crutches" name="equipments" value="crutches">
            <label for="crutches">Crutches</label><br>
            <input type="radio" id="hospital bed" name="equipments" value="hospital bed">
            <label for="hospital bed">Hospital bed</label><br>
            <input type="radio" id="walker" name="equipments" value="walker">
            <label for="walker">Walker</label><br>
            <input type="radio" id="bath chair" name="equipments" value="bath chair">
            <label for="bath chair">Bath Chair</label><br>
            <br>
        <input type="submit" value="Select" name="selectInput"></p>
    </form>

        <hr />

        <h2>Deleting a Donation</h2>
        <p> Please fill in donor information </p>
        <form method="POST" action="server.php"> 
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            DonorName: <input type="text" name="deleteDonorName"> <br /><br />
            DonationDate (YYYY-MM-DD): <input type="text" name="deleteDonationDate"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>
        <hr />


        <h2>Join Loan, Donation, and Client</h2>
        <p> View all clients who have made a money donation of over inputted amount and have loaned equipment</p>
        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
            Amount: <input type="text" name="amountJoin"> <br /><br />
            <input type="submit" name="joinSubmit"></p>
        </form>
        <hr />

        
        <h2>Division</h2>
        <p> View all the clients who have loaned every equipment </p>
        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionQueryRequest" name="divisionQueryRequest">
            <input type="Submit" name="divisionSubmit"></p>
        </form>

        <hr />

        <h2>Aggregation with Having</h2>
        <p> View the money donation info of clients who have made two or more donations</p>
        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="aggregationWithHavingQueryRequest" name="aggregationWithHavingQueryRequest">
            <input type="submit" name="aggregationWithHavingSubmit"></p>
        </form>
        <hr />

        <h2>Nested Aggregation with Group By</h2>
        <p> View the maximum average money donation amount between donation dates</p>
        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="nestedAggregationGroupByQueryRequest" name="nestedAggregationGroupByQueryRequest">
            <input type="submit" name="nestedAggregationGroupBySubmit"></p>
        </form>
        <hr />

        <h2>Count the number of equipment donated by equipment type</h2>
        <form method="GET" action="server.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>
        <hr />

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }


        function handleViewAllRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT PHN, Birthdate, Height, ClientWeight, PhoneNumber FROM Client");
            
            
            echo printResult($result);
            }
            

            function handleUpdateRequest() {
                global $db_conn;
                
                
                $old_name = $_POST['oldName'];
                $new_H = $_POST['newH'];
                $new_W = $_POST['newW'];
                
                
                // you need the wrap the old name and new name values with single quotations
                executePlainSQL("UPDATE Client SET Height ='" . $new_H . "' WHERE PHN='" . $old_name . "'");
                executePlainSQL("UPDATE Client SET ClientWeight ='" . $new_W . "' WHERE PHN='" . $old_name . "'");
                OCICommit($db_conn);
                }
                

        //outdated
        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_gracex1", "a74012246", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Volunteer cascade constraints");
            executePlainSQL("DROP TABLE Requisition1 cascade constraints");
            executePlainSQL("DROP TABLE Requisition2 cascade constraints");
            executePlainSQL("DROP TABLE Contains cascade constraints");
            executePlainSQL("DROP TABLE Waitlist cascade constraints");
            executePlainSQL("DROP TABLE MoneyDonation cascade constraints");
            executePlainSQL("DROP TABLE EquipmentDonation cascade constraints");
            executePlainSQL("DROP TABLE Donation cascade constraints");
            executePlainSQL("DROP TABLE Client cascade constraints");
            executePlainSQL("DROP TABLE Depot cascade constraints");
            executePlainSQL("DROP TABLE Loan cascade constraints");
            executePlainSQL("DROP TABLE Equipment cascade constraints");
            executePlainSQL("DROP TABLE HealthcareProfessional1 cascade constraints");
            executePlainSQL("DROP TABLE HealthcareProfessional2 cascade constraints");
                    

//             // Create new table
            echo "<br> creating new table <br>";

            executePlainSQL("CREATE TABLE Depot(
                DepotAddress varchar2(80) PRIMARY KEY
            )");

            executePlainSQL("CREATE TABLE Waitlist(
                WaitlistNumber integer,
                DepotAddress varchar2(80) NOT NULL,
                PRIMARY KEY (WaitlistNumber),
                FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress)
            )");

            executePlainSQL("CREATE TABLE Client(
                PHN integer PRIMARY KEY,
                CName varchar2(20),
                ClientAddress varchar2(80),
                Birthdate DATE,
                Height integer,
                ClientWeight integer,
                PhoneNumber varchar2(12),
                WaitlistPosition integer,
                WaitlistNumber integer,
                FOREIGN KEY (WaitlistNumber) REFERENCES Waitlist(WaitlistNumber)
            )");

            executePlainSQL("CREATE TABLE Loan(
                DueDate DATE,
                PHN integer,
                PRIMARY KEY(DueDate, PHN),
                FOREIGN KEY(PHN) REFERENCES Client(PHN)
            )");

            executePlainSQL("CREATE TABLE Donation(   
                DonorName varchar2(20),
                DonationDate DATE,
                DepotAddress varchar2(80) NOT NULL,
                PHN integer NOT NULL,
                PRIMARY KEY(DonorName, DonationDate),
                FOREIGN KEY(DepotAddress) REFERENCES Depot(DepotAddress),
                FOREIGN KEY (PHN) REFERENCES Client(PHN)
            )");

            executePlainSQL("CREATE TABLE EquipmentDonation( 
                DonorName varchar2(20),
                DonationDate DATE,
                EquipmentType varchar2(30),
                PRIMARY KEY(DonorName, DonationDate),
                FOREIGN KEY(DonorName, DonationDate) REFERENCES Donation(DonorName, DonationDate) ON DELETE CASCADE
            )");

            executePlainSQL("CREATE TABLE MoneyDonation( 
                DonorName varchar2(20),
                DonationDate DATE,
                Amount float,
                PRIMARY KEY(DonorName, DonationDate),
                FOREIGN KEY(DonorName, DonationDate) REFERENCES Donation(DonorName, DonationDate) ON DELETE CASCADE
                )");
                
            executePlainSQL("CREATE TABLE HealthcareProfessional1(
                HName varchar2(20),
                PhoneNumber varchar2(12),
                Hospital varchar2(40),
                PRIMARY KEY (HName, Hospital, PhoneNumber)
            )");


            executePlainSQL("CREATE TABLE HealthcareProfessional2(
                PhoneNumber varchar2(12),
                Hospital varchar2(40),
                Occupation varchar2(20),
                PRIMARY KEY (PhoneNumber, Hospital)
            )");

            executePlainSQL("CREATE TABLE Requisition1(
                PHN int,
                HName varchar2(20),
                PhoneNumber varchar2(12),
                Hospital varchar2(40),
                PRIMARY KEY (PHN),
                FOREIGN KEY(HName, PhoneNumber, Hospital) REFERENCES HealthcareProfessional1(HName, PhoneNumber, Hospital)
            )");

            executePlainSQL("CREATE TABLE Requisition2(
                FormID int,
                PhoneNumber varchar2(12),
                Hospital varchar2(40),
                PHN int,
                EquipmentType varchar2(30),
                PRIMARY KEY (FormID),
                FOREIGN KEY(PHN) REFERENCES Client(PHN),
                FOREIGN KEY(Hospital, PhoneNumber) REFERENCES HealthcareProfessional2(Hospital, PhoneNumber)
            )");



            executePlainSQL("CREATE TABLE Volunteer(
                Email varchar2(50),
                VName varchar2(20),
                DepotAddress varchar2(80) NOT NULL,
                PRIMARY KEY (Email),
                FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress)
            )");


            executePlainSQL("CREATE TABLE Equipment(
            EquipmentNumber integer,
            EquipmentType varchar2(30),
            DepotAddress varchar2(80) NOT NULL,
            WaitlistNumber integer,
            PRIMARY KEY (EquipmentNumber),
            FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress),
            FOREIGN KEY (WaitlistNumber) REFERENCES Waitlist(WaitlistNumber)
            )");


            executePlainSQL("CREATE TABLE Contains(   
                EquipmentNumber integer,
                DueDate DATE,
                PHN int,
                PRIMARY KEY (DueDate, PHN),
                FOREIGN KEY (EquipmentNumber) REFERENCES Equipment(EquipmentNumber),
                FOREIGN KEY (DueDate, PHN) REFERENCES Loan(DueDate, PHN)
            )");       

            executePlainSQL("INSERT INTO Depot(DepotAddress)
            VALUES('789 W 16th Ave')");

            executePlainSQL("INSERT
            INTO Depot(DepotAddress)
            VALUES('678 W 4th Ave')");

            executePlainSQL("INSERT
            INTO Depot(DepotAddress)
            VALUES('123 SW Marine Drive')");

            executePlainSQL("INSERT
            INTO Depot(DepotAddress)
            VALUES('456 Blanca St')");

            executePlainSQL("INSERT
            INTO Depot(DepotAddress)
            VALUES('678 Dunbar St')");


            executePlainSQL("INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(1, '678 Dunbar St')");

            executePlainSQL("INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(2, '789 W 16th Ave')");

            executePlainSQL("INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(3, '678 W 4th Ave')");

            executePlainSQL("INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(4, '123 SW Marine Drive')");

            executePlainSQL("INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(5, '456 Blanca St')");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(1, 'Grey', '4744 Tanner Street',  TO_DATE('2001-01-01', 'YYYY-MM-DD'), 180, 70, '123 456 7890', 1, 1)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(2, 'Ava', '2640  Cordova Street', TO_DATE('2002-02-02', 'YYYY-MM-DD'), 165, 55, '123 456 0987', NULL, NULL)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(3, 'Kai', '2364 Robson St', TO_DATE('2003-03-03', 'YYYY-MM-DD'), 155, 55, '123 654 7890', 1, 3)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(4, 'Liam', '2018  Hastings Street', TO_DATE('2004-04-04', 'YYYY-MM-DD'), 170, 60, '123 654 0987', NULL, NULL)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(5, 'Josh', '1769  Tolmie St', TO_DATE('2005-05-05', 'YYYY-MM-DD'), 190, 70, '123 645 7890', 1, 5)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(6, 'Mia', '233 W Windsor Rd', TO_DATE('2001-01-02', 'YYYY-MM-DD'), 160, 50, '123 645 0987', 2, 3)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(7, 'Ben', '2929 Barnet Hwy', TO_DATE('2002-02-01', 'YYYY-MM-DD'), 165, 60, '123 564 9078', NULL, NULL)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(8, 'Sam', '4154 Village Green', TO_DATE('2003-03-05', 'YYYY-MM-DD'), 180, 70, '123 564 9780', 1, 4)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(9, 'Ella', '1696 W 5th Ave', TO_DATE('2002-02-06', 'YYYY-MM-DD'), 165, 55, '123 465 7890', NULL, NULL)");

            executePlainSQL("INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(10, 'Ivy', '86 Semisch Ave', TO_DATE('2004-04-09', 'YYYY-MM-DD'), 155, 55, '123 465 0987', 1, 2)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 1)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'),'456 Blanca St', 2)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), '789 W 16th Ave', 3)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 4)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '678 W 4th Ave', 5)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 6)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'),'456 Blanca St', 7)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), '789 W 16th Ave', 8)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 9)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), '678 W 4th Ave', 10)");
            
            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ella', TO_DATE('2023-03-08', 'YYYY-MM-DD'), '678 W 4th Ave', 9)");
            
            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            Values('Mia', TO_DATE('2021-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 6)");

            executePlainSQL("INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ivy', TO_DATE('2023-03-08', 'YYYY-MM-DD'), '678 W 4th Ave', 10)");


            executePlainSQL("INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair')");

            executePlainSQL("INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches')");

            executePlainSQL("INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches')");

            executePlainSQL("INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair')");

            executePlainSQL("INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Crutches')");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            VALUES('Ivy', TO_DATE('2023-03-08', 'YYYY-MM-DD'), 800.02)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 150.00)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'), 10.50)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), 500.00)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 250.00)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), 99.99)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ella', TO_DATE('2023-03-08', 'YYYY-MM-DD'), 250.00)");

            executePlainSQL("INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Mia', TO_DATE('2021-01-01', 'YYYY-MM-DD'), 50.00)");

            executePlainSQL("INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('James', '890 123 4567', 'Vancouver General Hospital')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Robert', '890 123 7654', 'St. Paul’s Hospital')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Mary', '890 321 4567', 'Royal Columbian Hospital')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Sarah', '890 321 7654', 'Richmond Hospital')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Amy','890 231 4567', 'Surrey Memorial Hospital')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 123 4567', 'Vancouver General Hospital', 'Doctor')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 123 7654', 'St. Paul’s Hospital', 'Nurse')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 321 4567', 'Royal Columbian Hospital', 'Nurse')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 321 7654', 'Richmond Hospital', 'Doctor')");

            executePlainSQL("INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 231 4567', 'Surrey Memorial Hospital', 'Doctor')");

            executePlainSQL("INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(1,'James', '890 123 4567', 'Vancouver General Hospital')");

            executePlainSQL("INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(2, 'Mary', '890 321 4567', 'Royal Columbian Hospital')");

            executePlainSQL("INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(3, 'Sarah', '890 321 7654', 'Richmond Hospital')");

            executePlainSQL("INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(4, 'Robert', '890 123 7654', 'St. Paul’s Hospital')");

            executePlainSQL("INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(5,'Amy', '890 231 4567', 'Surrey Memorial Hospital')");

            executePlainSQL("INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(1, '890 123 4567', 'Vancouver General Hospital', 1, 'crutches')");

            executePlainSQL("INSERT
            INTO Requisition2 (FormID,PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(2,'890 321 4567', 'Royal Columbian Hospital', 2, 'wheelchair')");

            executePlainSQL("INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(3,'890 321 7654', 'Richmond Hospital', 3, 'wheelchair')");

            executePlainSQL("INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(4, '890 123 7654', 'St. Paul’s Hospital', 4, 'crutches')");

            executePlainSQL("INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(5, '890 231 4567', 'Surrey Memorial Hospital', 5, 'walker')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('tom123@gmail.com', 'Tom', '678 W 4th Ave')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('alex234@gmail.com', 'Alex', '678 W 4th Ave')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('grace345@gmail.com', 'Grace', '789 W 16th Ave')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, vName, DepotAddress)
            VALUES('olivia456@gmail.com', 'Olivia', '123 SW Marine Drive')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('florence567@gmail.com', 'Florence', '456 Blanca St')");

            executePlainSQL("INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('jerry678@gmail.com', 'Jerry', '678 Dunbar St')");



            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(1, 'wheelchair', '456 Blanca St', 5)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(2, 'crutches', '123 SW Marine Drive', 4)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(3, 'crutches', '678 W 4th Ave', 3)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(4, 'wheelchair', '789 W 16th Ave', 2)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(5, 'crutches', '678 Dunbar St', 1)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(6, 'hospital bed', '678 Dunbar St', null)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(7, 'bath chair', '123 SW Marine Drive', null)");

            executePlainSQL("INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(8, 'walker', '123 SW Marine Drive', null)");


            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(1, TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(2, TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(3, TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(4, TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(5, TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(4, TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(3, TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(2, TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(1, TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(6, TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(7, TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1)");

            executePlainSQL("INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(8, TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1)");


    
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
             global $db_conn;
             //$formID = 1;
                //Getting the values from user and insert data into the table
               $clientTuple = array (
                    ":PHN" => $_POST['PHN'],
                    ":CName" => $_POST['CName'],
                    ":Address" => $_POST['Address'],
                    ":Birthdate" => $_POST['Birthdate'],
                    ":Height" => $_POST['Height'],
                    ":ClientWeight" => $_POST['ClientWeight'],
                    ":PhoneNumber" => $_POST['PhoneNumber'],
                    ":WaitlistPosition" => NULL,
                    ":WaitlistNumber" => NULL
                );

                 $clientAllTuples = array (
                    $clientTuple
                );

                executeBoundSQL("insert into Client values(:PHN, :CName, :Address, TO_DATE(:Birthdate, 'YYYY-MM-DD'), :Height, :ClientWeight, :PhoneNumber, :WaitlistPosition, :WaitlistNumber)", $clientAllTuples);

                OCICommit($db_conn);
        }


        function handleDeleteRequest() {
            
            global $db_conn;

            $countBefore = executePlainSQL("SELECT Count(*) FROM Donation");
            $countBefore1 = executePlainSQL("SELECT Count(*) FROM MoneyDonation");
            $countBefore2 = executePlainSQL("SELECT Count(*) FROM EquipmentDonation");

            if (($rowBefore = oci_fetch_row($countBefore)) != false) {
                echo "<br> The number of tuples in Donation before deletion: " . $rowBefore[0] . "<br>";
            }
            if (($rowBefore1 = oci_fetch_row($countBefore1)) != false) {
                echo "<br> The number of tuples in MoneyDonation before deletion: " . $rowBefore1[0] . "<br>";
            }
            if (($rowBefore2 = oci_fetch_row($countBefore2)) != false) {
                echo "<br> The number of tuples in EquipmentDonation before deletion: " . $rowBefore2[0] . "<br>";
            }


            $tuple = array (
                ":DonorName" => $_POST['deleteDonorName'],
                ":DonationDate" => $_POST['deleteDonationDate'],
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("DELETE FROM Donation WHERE DonorName = :DonorName AND DonationDate = TO_DATE(:DonationDate, 'YYYY-MM-DD')", 
            $alltuples);

            $countAfter = executePlainSQL("SELECT Count(*) FROM Donation");
            $countAfter1 = executePlainSQL("SELECT Count(*) FROM MoneyDonation");
            $countAfter2 = executePlainSQL("SELECT Count(*) FROM EquipmentDonation");

                if (($rowAfter = oci_fetch_row($countAfter)) != false) {
                    echo "<br> The number of tuples in Donation after deletion : " . $rowAfter[0] . "<br>";
                }
                if (($rowAfter1 = oci_fetch_row($countAfter1)) != false) {
                    echo "<br> The number of tuples in MoneyDonation after deletion : " . $rowAfter1[0] . "<br>";
                }
                if (($rowAfter2 = oci_fetch_row($countAfter2)) != false) {
                    echo "<br> The number of tuples in EquipmentDonation after deletion : " . $rowAfter2[0] . "<br>";
                }
                

        
            OCICommit($db_conn);
		}


        function handleJoinRequest() {
            global $db_conn;

            $joinAmount = $_GET["amountJoin"]; 

            $result = executePlainSQL("SELECT DISTINCT D.DonorName FROM MoneyDonation D, Loan L, Client C WHERE C.PHN = L.PHN AND C.CName = D.DonorName AND D.Amount > $joinAmount");

            echo "<b> <br> The clients who have made a money donation over $$joinAmount and have loaned equipment are: <br> <b>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<br>" . $row[0] . "<br>";
            }
            
        }

        function handleDivisionRequest() {
            global $db_conn;

            $result2 = executePlainSQL("SELECT DISTINCT C.CName
            FROM Client C
            WHERE NOT EXISTS (
                SELECT E.EquipmentNumber
                FROM Equipment E
                WHERE NOT EXISTS (
                    SELECT T.EquipmentNumber
                    FROM Contains T
                    WHERE T.PHN = C.PHN AND T.EquipmentNumber = E.EquipmentNumber
                )
            )");

            echo "<b> <br> The clients who have loaned every equipment are: <br> <b>";
            while (($row = oci_fetch_row($result2)) != false) {
                echo "<br>" . $row[0] . "<br>";
            }
            
        }

        function handleAggregationWithHavingRequest() {
            global $db_conn;

            $result1 = executePlainSQL ("SELECT D.DonorName, COUNT(*) AS TimesDonated, SUM(D.Amount) AS TotalDonated
            FROM MoneyDonation D
            GROUP BY D.DonorName
            HAVING COUNT(*) >= 2 ");

            echo "<table>";
            echo "<tr><th>DonorName</th><th>TimesDonated</th><th>TotalDonated</th></tr>";

            while ($row = OCI_Fetch_Array($result1, OCI_BOTH)) {
                echo "<tr><th>" . $row["0"] . "</th><th>" . $row["1"] . "</th><th>"
                . $row["2"] . "</th><th>"; 
                }

            echo "</table>";
            
        }

        function handleNestedAggregationRequestGroupBy() {

            global $db_conn;

            executePlainSQL("DROP VIEW AverageMoneyDonations cascade constraints");
            
            executePlainSQL("CREATE VIEW AverageMoneyDonations(DonationDate, average) AS
	        SELECT M.DonationDate, AVG(M.amount) as average
	        From MoneyDonation M
	        Group By M.DonationDate");


            $result = executePlainSQL("SELECT MAX(average)
            From AverageMoneyDonations"
            );

            OCICommit($db_conn);

            echo "<table>";
            echo "<tr><th>Max average donation between Dates</th></tr>";


            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><th>" . $row["0"] . "</th><th>";
                }


            echo "</table>";

		}



        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT EquipmentType, Count(*) FROM EquipmentDonation GROUP BY EquipmentType");

            // $result = executePlainSQL("SELECT Count(*) FROM Client");
            // if (($row = oci_fetch_row($result)) != false) {
            //     echo "<br> The number of tuples in Client: " . $row[0] . "<br>";
            // }

            while (($row = oci_fetch_row($result)) != false) {
                echo "<br>" . $row[0] . ": " . $row[1] . "<br>";
            }
        }

        function handleSelectRequest() {
            global $db_conn;

            $selectedEquipment = $_GET["equipments"];

            $result = executePlainSQL("Select * FROM Equipment WHERE EquipmentType = '$selectedEquipment'");

            echo "<b> <br> The following equipment are available for $selectedEquipment : <br> <b>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<br> Equipment number: " . $row[0] . ", " . $row[1] . " " . "at location: " . $row[2]. "<br>";
            }
            
        }

        function printResult($result) { //prints results from a select statement
            //echo "<br>Client List:<br>";
            echo "<table>";
            echo "<tr><th>PHN</th><th>Birthdate</th><th>Height</th><th>Weight</th><th>Phone Number</th></tr>";
            
            
            //echo "<tbody>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><th>" . $row["0"] . "</th><th>" . $row["1"] . "</th><th>"
            . $row["2"] . "</th><th>" . $row["3"] . "</th><th>"
            . $row["4"] . "</th></tr>"; //or just use "echo $row[0]"
            }
            //echo "</tbody>";
            echo "</table>";
            }
            

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteSubmit', $_POST)) {
                    handleDeleteRequest();
                }

                disconnectFromDB();
            }
        }


        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            } else if (array_key_exists('selectInput', $_GET)) {
                handleSelectRequest();
            } else if (array_key_exists('viewAllSubmit', $_GET)) {
                handleViewAllRequest();
            } else if (array_key_exists('joinSubmit', $_GET)) {
                handleJoinRequest();
            } else if (array_key_exists('nestedAggregationGroupBySubmit', $_GET)) {
                handleNestedAggregationRequestGroupBy();
            } else if (array_key_exists('aggregationWithHavingSubmit', $_GET)) {
                handleAggregationWithHavingRequest();
            } else if (array_key_exists('divisionSubmit', $_GET)) {
                handleDivisionRequest();
            }

            disconnectFromDB();
        }
    }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST["deleteQueryRequest"])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectByEquipmentType']) || isset($_GET['viewAllClientRequest']) || isset($_GET['joinQueryRequest']) || isset($_GET["nestedAggregationGroupByQueryRequest"]) || isset($_GET["aggregationWithHavingQueryRequest"]) || isset($_GET["divisionQueryRequest"])) {
            handleGETRequest();
        }

        //notes: took away address depot from requisition 1 and formPriority from requisition 2
		?>
	</body>
</html>

