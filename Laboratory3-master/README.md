# CMPT 310 Laboratory 3

The purpose of this lab is to give you first-hand experience with DB web technologies, specifically SQL, PHP (and mysqli), and JSON. You will also be exposed to JQuery and Google Charts as they will be interacting with your programs to provide three distinct view of the database. 

```plantuml

skinparam nodesep 100
skinparam ranksep 100

left to right direction
skinparam class{
    AttributeIconSize 0
    BackgroundColor none
    ArrowColor black
    BorderColor black
    FontStyle bold
}

skinparam note{
    BorderColor black
    BackgroundColor none
}

hide circle
hide empty methods
hide empty members


entity Technician {
  <u>**EmployeeID**</u>
  **Name**
  **Title**
  Technician_EmployeeID
}

entity Model {
  <u>**ModelID**</u>
  **Name**
  **Designer**
}

entity Inspection {
  <u>**InspectionID**</u>
  **Grade**
  **Date**
  **Techinician_EmployeeID**
  **Piano_SerialNo**
}

entity Piano {
  <u>**SerialNo**</u>
  **MfgDate**
  **Model_ModelID**
}

Technician "Reports to" }o--o| "Supervises" Technician
Model "Mockup for" ||--right-o{ "Reproduces" Piano
Piano "Undergoes" }|--up--|| "Performed on\r2" Inspection
Inspection "Performed by" }o-left--|| "Performs" Technician

```


## Cloning

Start your lab by cloning this repository:

```
$> git clone https://submit.cs.kingsu.ca/PATH/TO/YOUR/REPO.git
```

**Note**: The URL for your repo can be found at https://submit.cs.kingsu.ca.


### Building
```
$> docker-compose up -d
```
**Note**: `docker-compose up` builds, (re)creates, starts, and attaches to containers for a service. The first time it is run, it takes some time to complete. 
**Be aware** you will need at least `1 GB` of disk space to download and run the web and database images of this lab.

### Writing your lab
Any and all changes must be done in the `src/html/lab3.php` file. 

### Running

To view your current work, visit:

* http://localhost:8080/orgReport.html
* http://localhost:8080/technicianReport.html
* http://localhost:8080/pianoReport.html

### Closing `docker`

```
$> docker-compose down
```


### Submission

```
$> git add src/html/lab3.php
$> git commit -m "Lab 3 Submission"
$> git push
```
