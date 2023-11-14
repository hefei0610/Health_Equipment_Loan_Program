drop table Depot cascade constraints;
drop table Waitlist cascade constraints;
drop table Client cascade constraints;
drop table Loan cascade constraints;
drop table Donation cascade constraints;
drop table EquipmentDonation cascade constraints;
drop table MoneyDonation cascade constraints;
drop table HealthcareProfessional1 cascade constraints;
drop table HealthcareProfessional2 cascade constraints;
drop table Requisition1 cascade constraints;
drop table Requisition2 cascade constraints;
drop table Volunteer cascade constraints;
drop table Equipment cascade constraints;
drop table Contains cascade constraints;


CREATE TABLE Depot(
    DepotAddress varchar2(80) PRIMARY KEY
);

CREATE TABLE Waitlist(
    WaitlistNumber integer,
    DepotAddress varchar2(80) NOT NULL,
    PRIMARY KEY (WaitlistNumber),
    FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress)
);

CREATE TABLE Client(
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
);

CREATE TABLE Loan(
    DueDate DATE,
    PHN integer,
    PRIMARY KEY(DueDate, PHN),
    FOREIGN KEY(PHN) REFERENCES Client(PHN)
);

CREATE TABLE Donation(   
    DonorName varchar2(20),
    DonationDate DATE,
    DepotAddress varchar2(80) NOT NULL,
    PHN integer NOT NULL,
    PRIMARY KEY(DonorName, DonationDate),
    FOREIGN KEY(DepotAddress) REFERENCES Depot(DepotAddress),
    FOREIGN KEY (PHN) REFERENCES Client(PHN)
);

CREATE TABLE EquipmentDonation( 
    DonorName varchar2(20),
    DonationDate DATE,
    EquipmentType varchar2(30),
    PRIMARY KEY(DonorName, DonationDate),
    FOREIGN KEY(DonorName, DonationDate) REFERENCES Donation(DonorName, DonationDate) ON DELETE CASCADE
);

CREATE TABLE MoneyDonation( 
    DonorName varchar2(20),
    DonationDate DATE,
    Amount float,
    PRIMARY KEY(DonorName, DonationDate),
    FOREIGN KEY(DonorName, DonationDate) REFERENCES Donation(DonorName, DonationDate) ON DELETE CASCADE
);
    
CREATE TABLE HealthcareProfessional1(
    HName varchar2(20),
    PhoneNumber varchar2(12),
    Hospital varchar2(40),
    PRIMARY KEY (HName, Hospital, PhoneNumber)
);


CREATE TABLE HealthcareProfessional2(
    PhoneNumber varchar2(12),
    Hospital varchar2(40),
    Occupation varchar2(20),
    PRIMARY KEY (PhoneNumber, Hospital)
);

CREATE TABLE Requisition1(
    PHN int,
    HName varchar2(20),
    PhoneNumber varchar2(12),
    Hospital varchar2(40),
    PRIMARY KEY (PHN),
    FOREIGN KEY(HName, PhoneNumber, Hospital) REFERENCES HealthcareProfessional1(HName, PhoneNumber, Hospital)
    -- this might not be working because HName is not a primary key on its own
);

CREATE TABLE Requisition2(
    FormID int,
    PhoneNumber varchar2(12),
    Hospital varchar2(40),
    PHN int,
    EquipmentType varchar2(30),
    PRIMARY KEY (FormID),
    FOREIGN KEY(PHN) REFERENCES Client(PHN),
    FOREIGN KEY(Hospital, PhoneNumber) REFERENCES HealthcareProfessional2(Hospital, PhoneNumber)
);



CREATE TABLE Volunteer(
    Email varchar2(50),
    VName varchar2(20),
    DepotAddress varchar2(80) NOT NULL,
    PRIMARY KEY (Email),
    FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress)
);


CREATE TABLE Equipment(
   EquipmentNumber integer,
   EquipmentType varchar2(30),
   DepotAddress varchar2(80) NOT NULL,
   WaitlistNumber integer,
   PRIMARY KEY (EquipmentNumber),
   FOREIGN KEY (DepotAddress) REFERENCES Depot(DepotAddress),
   FOREIGN KEY (WaitlistNumber) REFERENCES Waitlist(WaitlistNumber)
);


CREATE TABLE Contains(   
    EquipmentNumber integer,
    DueDate DATE,
    PHN int,
    PRIMARY KEY (DueDate, PHN),
    FOREIGN KEY (EquipmentNumber) REFERENCES Equipment(EquipmentNumber),
    FOREIGN KEY (DueDate, PHN) REFERENCES Loan(DueDate, PHN)
);     

            INSERT 
            INTO Depot(DepotAddress)
            VALUES('789 W 16th Ave');

            INSERT
            INTO Depot(DepotAddress)
            VALUES('678 W 4th Ave');

            INSERT
            INTO Depot(DepotAddress)
            VALUES('123 SW Marine Drive');

            INSERT
            INTO Depot(DepotAddress)
            VALUES('456 Blanca St');

            INSERT
            INTO Depot(DepotAddress)
            VALUES('678 Dunbar St');


            INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(1, '678 Dunbar St');

            INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(2, '789 W 16th Ave');

            INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(3, '678 W 4th Ave');

            INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(4, '123 SW Marine Drive');

            INSERT
            INTO Waitlist(WaitlistNumber, DepotAddress)
            VALUES(5, '456 Blanca St');

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(1, 'Grey', '4744 Tanner Street',  TO_DATE('2001-01-01', 'YYYY-MM-DD'), 180, 70, '123 456 7890', 1, 1);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(2, 'Ava', '2640  Cordova Street', TO_DATE('2002-02-02', 'YYYY-MM-DD'), 165, 55, '123 456 0987', NULL, NULL);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(3, 'Kai', '2364 Robson St', TO_DATE('2003-03-03', 'YYYY-MM-DD'), 155, 55, '123 654 7890', 1, 3);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(4, 'Liam', '2018  Hastings Street', TO_DATE('2004-04-04', 'YYYY-MM-DD'), 170, 60, '123 654 0987', NULL, NULL);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(5, 'Josh', '1769  Tolmie St', TO_DATE('2005-05-05', 'YYYY-MM-DD'), 190, 70, '123 645 7890', 1, 5);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(6, 'Mia', '233 W Windsor Rd', TO_DATE('2001-01-02', 'YYYY-MM-DD'), 160, 50, '123 645 0987', 2, 3);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(7, 'Ben', '2929 Barnet Hwy', TO_DATE('2002-02-01', 'YYYY-MM-DD'), 165, 60, '123 564 9078', NULL, NULL);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(8, 'Sam', '4154 Village Green', TO_DATE('2003-03-05', 'YYYY-MM-DD'), 180, 70, '123 564 9780', 1, 4);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(9, 'Ella', '1696 W 5th Ave', TO_DATE('2002-02-06', 'YYYY-MM-DD'), 165, 55, '123 465 7890', NULL, NULL);

            INSERT
            INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
            VALUES(10, 'Ivy', '86 Semisch Ave', TO_DATE('2004-04-09', 'YYYY-MM-DD'), 155, 55, '123 465 0987', 1, 2);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 1);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'),'456 Blanca St', 2);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), '789 W 16th Ave', 3);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 4);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '678 W 4th Ave', 5);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 6);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'),'456 Blanca St', 7);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), '789 W 16th Ave', 8);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 9);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), '678 W 4th Ave', 10);
            
            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ella', TO_DATE('2023-03-08', 'YYYY-MM-DD'), '678 W 4th Ave', 9);
            
            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            Values('Mia', TO_DATE('2021-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 6);

            INSERT
            INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
            VALUES('Ivy', TO_DATE('2023-03-08', 'YYYY-MM-DD'), '678 W 4th Ave', 10);


            INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair');

            INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches');

            INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches');

            INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair');

            INSERT
            INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
            VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Crutches');

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 150.00);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'), 10.50);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), 500.00);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 250.00);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), 99.99);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            VALUES('Ivy', TO_DATE('2023-03-08', 'YYYY-MM-DD'), 800.02);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Ella', TO_DATE('2023-03-08', 'YYYY-MM-DD'), 250.00);

            INSERT
            INTO MoneyDonation(DonorName, DonationDate, Amount)
            Values('Mia', TO_DATE('2021-01-01', 'YYYY-MM-DD'), 50.00);

            INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('James', '890 123 4567', 'Vancouver General Hospital');

            INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Robert', '890 123 7654', 'St. Paul’s Hospital');

            INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Mary', '890 321 4567', 'Royal Columbian Hospital');

            INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Sarah', '890 321 7654', 'Richmond Hospital');

            INSERT
            INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
            VALUES('Amy','890 231 4567', 'Surrey Memorial Hospital');

            INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 123 4567', 'Vancouver General Hospital', 'Doctor');

            INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 123 7654', 'St. Paul’s Hospital', 'Nurse');

            INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 321 4567', 'Royal Columbian Hospital', 'Nurse');

            INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 321 7654', 'Richmond Hospital', 'Doctor');

            INSERT
            INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
            VALUES('890 231 4567', 'Surrey Memorial Hospital', 'Doctor');

            INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(1,'James', '890 123 4567', 'Vancouver General Hospital');

            INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(2, 'Mary', '890 321 4567', 'Royal Columbian Hospital');

            INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(3, 'Sarah', '890 321 7654', 'Richmond Hospital');

            INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(4, 'Robert', '890 123 7654', 'St. Paul’s Hospital');

            INSERT
            INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
            VALUES(5,'Amy', '890 231 4567', 'Surrey Memorial Hospital');

            INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(1, '890 123 4567', 'Vancouver General Hospital', 1, 'crutches');

            INSERT
            INTO Requisition2 (FormID,PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(2,'890 321 4567', 'Royal Columbian Hospital', 2, 'wheelchair');

            INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(3,'890 321 7654', 'Richmond Hospital', 3, 'wheelchair');

            INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(4, '890 123 7654', 'St. Paul’s Hospital', 4, 'crutches');

            INSERT
            INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
            VALUES(5, '890 231 4567', 'Surrey Memorial Hospital', 5, 'walker');

            INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('tom123@gmail.com', 'Tom', '678 W 4th Ave');

            INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('alex234@gmail.com', 'Alex', '678 W 4th Ave');

            INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('grace345@gmail.com', 'Grace', '789 W 16th Ave');

            INSERT
            INTO Volunteer(Email, vName, DepotAddress)
            VALUES('olivia456@gmail.com', 'Olivia', '123 SW Marine Drive');

            INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('florence567@gmail.com', 'Florence', '456 Blanca St');

            INSERT
            INTO Volunteer(Email, VName, DepotAddress)
            VALUES('jerry678@gmail.com', 'Jerry', '678 Dunbar St');



            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(1, 'wheelchair', '456 Blanca St', 5);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(2, 'crutches', '123 SW Marine Drive', 4);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(3, 'crutches', '678 W 4th Ave', 3);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(4, 'wheelchair', '789 W 16th Ave', 2);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(5, 'crutches', '678 Dunbar St', 1);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(6, 'hospital bed', '678 Dunbar St', null);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(7, 'bath chair', '123 SW Marine Drive', null);

            INSERT
            INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
            VALUES(8, 'walker', '123 SW Marine Drive', null);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1);

               INSERT
            INTO Loan(DueDate, PHN)
            VALUES(TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9);


            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(1, TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(2, TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(3, TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(4, TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(5, TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(4, TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(3, TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(2, TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(1, TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(6, TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(7, TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1);

            INSERT
            INTO Contains(EquipmentNumber, DueDate, PHN)
            VALUES(8, TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1);



            
            Commit;



--             INSERT
-- INTO Depot(DepotAddress)
-- VALUES('789 W 16th Ave');

-- INSERT
-- INTO Depot(DepotAddress)
-- VALUES('678 W 4th Ave');

-- INSERT
-- INTO Depot(DepotAddress)
-- VALUES('123 SW Marine Drive');

-- INSERT
-- INTO Depot(DepotAddress)
-- VALUES('456 Blanca St');

-- INSERT
-- INTO Depot(DepotAddress)
-- VALUES('678 Dunbar St');


-- INSERT
-- INTO Waitlist(WaitlistNumber, DepotAddress)
-- VALUES(1, '678 Dunbar St');

-- INSERT
-- INTO Waitlist(WaitlistNumber, DepotAddress)
-- VALUES(2, '789 W 16th Ave');

-- INSERT
-- INTO Waitlist(WaitlistNumber, DepotAddress)
-- VALUES(3, '678 W 4th Ave');

-- INSERT
-- INTO Waitlist(WaitlistNumber, DepotAddress)
-- VALUES(4, '123 SW Marine Drive');

-- INSERT
-- INTO Waitlist(WaitlistNumber, DepotAddress)
-- VALUES(5, '456 Blanca St');

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(1, 'Grey', '4744 Tanner Street',  TO_DATE('2001-01-01', 'YYYY-MM-DD'), 180, 70, '123 456 7890', 1, 1);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(2, 'Ava', '2640  Cordova Street', TO_DATE('2002-02-02', 'YYYY-MM-DD'), 165, 55, '123 456 0987', NULL, NULL);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(3, 'Kai', '2364 Robson St', TO_DATE('2003-03-03', 'YYYY-MM-DD'), 155, 55, '123 654 7890', 1, 3);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(4, 'Liam', '2018  Hastings Street', TO_DATE('2004-04-04', 'YYYY-MM-DD'), 170, 60, '123 654 0987', NULL, NULL);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(5, 'Josh', '1769  Tolmie St', TO_DATE('2005-05-05', 'YYYY-MM-DD'), 190, 70, '123 645 7890', 1, 5);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(6, 'Mia', '233 W Windsor Rd', TO_DATE('2001-01-02', 'YYYY-MM-DD'), 160, 50, '123 645 0987', 2, 3);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(7, 'Ben', '2929 Barnet Hwy', TO_DATE('2002-02-01', 'YYYY-MM-DD'), 165, 60, '123 564 9078', NULL, NULL);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(8, 'Sam', '4154 Village Green', TO_DATE('2003-03-05', 'YYYY-MM-DD'), 180, 70, '123 564 9780', 1, 4);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(9, 'Ella', '1696 W 5th Ave', TO_DATE('2002-02-06', 'YYYY-MM-DD'), 165, 55, '123 465 7890', NULL, NULL);

-- INSERT
-- INTO Client(PHN, CName, ClientAddress, Birthdate, Height, ClientWeight, PhoneNumber, WaitlistPosition, WaitlistNumber)
-- VALUES(10, 'Ivy', '86 Semisch Ave', TO_DATE('2004-04-09', 'YYYY-MM-DD'), 155, 55, '123 465 0987', 1, 2);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 1);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'),'456 Blanca St', 2);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), '789 W 16th Ave', 3);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 4);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '678 W 4th Ave', 5);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '789 W 16th Ave', 6);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'),'456 Blanca St', 7);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), '789 W 16th Ave', 8);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), '456 Blanca St', 9);

-- INSERT
-- INTO Donation(DonorName, DonationDate, DepotAddress, PHN)
-- VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), '678 W 4th Ave', 10);


-- INSERT
-- INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
-- VALUES('Grey', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair');

-- INSERT
-- INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
-- VALUES('Ava', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches');

-- INSERT
-- INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
-- VALUES('Kai', TO_DATE('2023-02-02', 'YYYY-MM-DD'), 'Crutches');

-- INSERT
-- INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
-- VALUES('Liam', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Wheel chair');

-- INSERT
-- INTO EquipmentDonation(DonorName, DonationDate, EquipmentType)
-- VALUES('Josh', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'Crutches');

-- INSERT
-- INTO MoneyDonation(DonorName, DonationDate, Amount)
-- Values('Mia', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 150.00);

-- INSERT
-- INTO MoneyDonation(DonorName, DonationDate, Amount)
-- Values('Ben', TO_DATE('2023-01-07', 'YYYY-MM-DD'), 10.50);

-- INSERT
-- INTO MoneyDonation(DonorName, DonationDate, Amount)
-- Values('Sam', TO_DATE('2023-04-02', 'YYYY-MM-DD'), 500.00);

-- INSERT
-- INTO MoneyDonation(DonorName, DonationDate, Amount)
-- Values('Ella', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 250.00);

-- INSERT
-- INTO MoneyDonation(DonorName, DonationDate, Amount)
-- VALUES('Ivy', TO_DATE('2023-04-05', 'YYYY-MM-DD'), 99.99);

-- INSERT
-- INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
-- VALUES('James', '890 123 4567', 'Vancouver General Hospital');

-- INSERT
-- INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
-- VALUES('Robert', '890 123 7654', 'St. Paul’s Hospital');

-- INSERT
-- INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
-- VALUES('Mary', '890 321 4567', 'Royal Columbian Hospital');

-- INSERT
-- INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
-- VALUES('Sarah', '890 321 7654', 'Richmond Hospital');

-- INSERT
-- INTO HealthcareProfessional1(HName, PhoneNumber, Hospital)
-- VALUES('Amy','890 231 4567', 'Surrey Memorial Hospital');

-- INSERT
-- INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
-- VALUES('890 123 4567', 'Vancouver General Hospital', 'Doctor');

-- INSERT
-- INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
-- VALUES('890 123 7654', 'St. Paul’s Hospital', 'Nurse');

-- INSERT
-- INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
-- VALUES('890 321 4567', 'Royal Columbian Hospital', 'Nurse');

-- INSERT
-- INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
-- VALUES('890 321 7654', 'Richmond Hospital', 'Doctor');

-- INSERT
-- INTO HealthcareProfessional2(PhoneNumber, Hospital, Occupation)
-- VALUES('890 231 4567', 'Surrey Memorial Hospital', 'Doctor');

-- INSERT
-- INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
-- VALUES(1,'James', '890 123 4567', 'Vancouver General Hospital');

-- INSERT
-- INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
-- VALUES(2, 'Mary', '890 321 4567', 'Royal Columbian Hospital');

-- INSERT
-- INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
-- VALUES(3, 'Sarah', '890 321 7654', 'Richmond Hospital');

-- INSERT
-- INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
-- VALUES(4, 'Robert', '890 123 7654', 'St. Paul’s Hospital');

-- INSERT
-- INTO Requisition1 (PHN, HName, PhoneNumber, Hospital)
-- VALUES(5,'Amy', '890 231 4567', 'Surrey Memorial Hospital');

-- INSERT
-- INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
-- VALUES(1,'890 123 4567', 'Vancouver General Hospital', 1, 'crutches');

-- INSERT
-- INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
-- VALUES(2,'890 321 4567', 'Royal Columbian Hospital', 2, 'wheelchair');

-- INSERT
-- INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
-- VALUES(3, '890 321 7654', 'Richmond Hospital', 3, 'wheelchair');

-- INSERT
-- INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
-- VALUES(4, '890 123 7654', 'St. Paul’s Hospital', 4, 'crutches');

-- INSERT
-- INTO Requisition2 (FormID, PhoneNumber, Hospital, PHN, EquipmentType)
-- VALUES(5, '890 231 4567', 'Surrey Memorial Hospital', 5, 'walker');

-- INSERT
-- INTO Volunteer(Email, VName, DepotAddress)
-- VALUES('tom123@gmail.com', 'Tom', '678 W 4th Ave');

-- INSERT
-- INTO Volunteer(Email, VName, DepotAddress)
-- VALUES('alex234@gmail.com', 'Alex', '678 W 4th Ave');

-- INSERT
-- INTO Volunteer(Email, VName, DepotAddress)
-- VALUES('grace345@gmail.com', 'Grace', '789 W 16th Ave');

-- INSERT
-- INTO Volunteer(Email, vName, DepotAddress)
-- VALUES('olivia456@gmail.com', 'Olivia', '123 SW Marine Drive');

-- INSERT
-- INTO Volunteer(Email, VName, DepotAddress)
-- VALUES('florence567@gmail.com', 'Florence', '456 Blanca St');

-- INSERT
-- INTO Volunteer(Email, VName, DepotAddress)
-- VALUES('jerry678@gmail.com', 'Jerry', '678 Dunbar St');


-- INSERT
-- INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
-- VALUES(1, 'Wheel chair', '456 Blanca St', 5);

-- INSERT
-- INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
-- VALUES(2, 'Crutches', '123 SW Marine Drive', 4);

-- INSERT
-- INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
-- VALUES(3, 'Crutches', '678 W 4th Ave', 3);

-- INSERT
-- INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
-- VALUES(4, 'Wheel chair', '789 W 16th Ave', 2);

-- INSERT
-- INTO Equipment(EquipmentNumber, EquipmentType, DepotAddress, WaitlistNumber)
-- VALUES(5, 'Crutches', '678 Dunbar St', 1);



-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(1, TO_DATE('2024-01-01', 'YYYY-MM-DD'), 9);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(2, TO_DATE('2024-02-02', 'YYYY-MM-DD'), 7);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(3, TO_DATE('2024-03-03', 'YYYY-MM-DD'), 3);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(4, TO_DATE('2024-04-04', 'YYYY-MM-DD'), 2);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(5, TO_DATE('2024-05-05', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(4, TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(3, TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(2, TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(1, TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(6, TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(7, TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Contains(EquipmentNumber, DueDate, PHN)
-- VALUES(8, TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2021-05-15', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2018-03-05', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2020-02-22', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2022-12-03', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2022-06-26', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2023-09-30', 'YYYY-MM-DD'), 1);

-- INSERT
-- INTO Loan(DueDate, PHN)
-- VALUES(TO_DATE('2019-04-18', 'YYYY-MM-DD'), 1);

-- Commit; 
